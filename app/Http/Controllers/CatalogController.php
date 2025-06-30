<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        // Ambil daftar kategori unik langsung dari tabel books
        $categories = Book::select('category')->distinct()->pluck('category');

        // Ambil daftar tahun unik dari kolom year_published
        $years = Book::select('year_published')->distinct()->orderByDesc('year_published')->pluck('year_published');

        // Jika menggunakan rekomendasi FastAPI
        if ($request->filled('search_rekom')) {
            $fastApiUrl = config('app.fastapi_url') . '/recommend';
            $response = Http::post($fastApiUrl, [
                'keyword' => $request->search_rekom,
                'top' => 20
            ]);

            if ($response->successful()) {
                $recommendations = collect($response->json()['rekomendasi']);
                $titles = $recommendations->pluck('title');

                // Ambil buku dari database yang judulnya sesuai rekomendasi
                $booksCollection = Book::whereIn('title', $titles)->get();

                // Urutkan sesuai urutan dari API
                $booksSorted = $titles->map(function ($title) use ($booksCollection) {
                    return $booksCollection->firstWhere('title', $title);
                })->filter();

                // Buat map skor
                $similarityMap = $recommendations->mapWithKeys(function ($item) {
                    return [$item['title'] => $item['skor']];
                })->toArray();

                // Manual Pagination
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = 12;
                $pagedBooks = new LengthAwarePaginator(
                    $booksSorted->slice(($currentPage - 1) * $perPage, $perPage)->values(),
                    $booksSorted->count(),
                    $perPage,
                    $currentPage,
                    ['path' => url()->current(), 'query' => $request->query()]
                );

                return view('book.index', [
                    'books' => $pagedBooks,
                    'categories' => $categories,
                    'years' => $years,
                    'similarityMap' => $similarityMap,
                    'searchRekom' => $request->search_rekom
                ]);
            } else {
                return back()->with('error', 'Gagal memuat hasil rekomendasi.');
            }
        }
        // Filter standar

        $query = Book::query();

        // Filter: Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('author', 'like', '%' . $request->search . '%')
                    ->orWhere('isbn', 'like', '%' . $request->search . '%')
                    ->orWhere('publisher', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter: Category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter: Year
        if ($request->filled('year')) {
            $query->where('year_published', $request->year);
        }

        // Paginate results and keep filters in the query string
        $books = $query->paginate(12)->appends($request->query());

        return view('book.index', compact('books', 'categories', 'years'));
    }

    public function show(Book $book)
    {
        return view('book.show', compact('book'));
    }
}
