<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

class AdminBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('author', 'like', '%' . $request->search . '%')
                    ->orWhere('ISBN', 'like', '%' . $request->search . '%')
                    ->orWhere('publisher', 'like', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->filled('category') && $request->category !== '') {
            $query->where('category', $request->category);
        }

        // Year published filter
        if ($request->filled('year_published') && $request->year_published !== '') {
            $query->where('year_published', $request->year_published);
        }

        $books = $query->paginate(10)->appends($request->query());

        // Get distinct categories and years for filter dropdowns
        $categories = Book::select('category')->distinct()->whereNotNull('category')->orderBy('category')->pluck('category');
        $years = Book::select('year_published')->distinct()->whereNotNull('year_published')->orderByDesc('year_published')->pluck('year_published');

        return view('admin.books.index', compact('books', 'categories', 'years'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year_published' => 'required|integer|min:1000|max:' . date('Y'),
            'ISBN' => 'required|string|unique:books,ISBN',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|url',
        ]);

        Book::create($request->all());

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year_published' => 'required|integer|min:1000|max:' . date('Y'),
            'ISBN' => 'required|string|unique:books,ISBN,' . $book->id,
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|url',
        ]);

        $book->update($request->all());

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus!');
    }

    /**
     * Export books data to CSV format
     */
    public function exportCsv()
    {
        $books = Book::select('id', 'title', 'category', 'description')->get();

        $csvContent = "id,title,category,description\n";

        foreach ($books as $book) {
            // Escape special characters properly for CSV
            $csvContent .= $book->id . ',"' .
                           str_replace('"', '""', $book->title ?? '') . '","' .
                           str_replace('"', '""', $book->category ?? '') . '","' .
                           str_replace('"', '""', $book->description ?? '') . "\"\n";
        }

        $filename = 'books_export_' . date('Y-m-d_H-i-s') . '.csv';

        // Create response with CSV content directly
        return response($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ]);
    }

    /**
     * Train the recommendation system by sending CSV to FastAPI
     */
    public function trainRecommendationSystem(Request $request)
    {
        try {
            // Generate CSV file
            $books = Book::select('id', 'title', 'category', 'description')->get();

            if ($books->isEmpty()) {
                return back()->with('error', 'Tidak ada data buku untuk melatih sistem rekomendasi.');
            }

            $csvContent = "id,title,category,description\n";

            foreach ($books as $book) {
                // Escape special characters properly for CSV
                $csvContent .= $book->id . ',"' .
                               str_replace('"', '""', $book->title ?? '') . '","' .
                               str_replace('"', '""', $book->category ?? '') . '","' .
                               str_replace('"', '""', $book->description ?? '') . "\"\n";
            }

            $filename = 'books_training_' . date('Y-m-d_H-i-s') . '.csv';

            // Create temporary file in storage/app directory (not public)
            $tempPath = storage_path('app/' . $filename);

            // Write CSV content to temporary file
            file_put_contents($tempPath, $csvContent);

            // Get FastAPI endpoint URL from config
            $fastApiUrl = config('app.fastapi_url') . '/sync/train';

            // Send to FastAPI endpoint with standard timeout for fast AI training
            $response = Http::timeout(300) // 5 minutes timeout - sufficient for fast training
                ->connectTimeout(30) // 30 seconds connection timeout
                ->retry(2, 2000) // Retry 2 times with 2 second delay
                ->attach(
                    'file',
                    fopen($tempPath, 'r'),
                    'books.csv',
                    ['Content-Type' => 'text/csv']
                )
                ->post($fastApiUrl);

            // Clean up temporary file
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }

            if ($response->successful()) {
                $responseData = $response->json();
                $message = $responseData['message'] ?? 'Sistem rekomendasi berhasil diperbarui.';
                return back()->with('success', $message);
            } else {
                $errorMessage = 'Gagal memperbarui sistem rekomendasi. ';
                if ($response->status() === 422) {
                    $errorData = $response->json();
                    $errorMessage .= $errorData['error'] ?? 'Format data tidak valid.';
                } elseif ($response->status() === 0) {
                    $errorMessage = 'Tidak dapat terhubung ke server FastAPI. Silakan periksa: 1) URL endpoint benar, 2) Server FastAPI berjalan, 3) Koneksi internet stabil.';
                } else {
                    $errorMessage .= 'HTTP Status: ' . $response->status() . '. Silakan coba lagi atau hubungi administrator.';
                }
                return back()->with('error', $errorMessage);
            }

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // Clean up temporary file
            if (isset($tempPath) && file_exists($tempPath)) {
                unlink($tempPath);
            }

            $errorMsg = 'Koneksi timeout ke FastAPI server. ';
            $errorMsg .= 'Kemungkinan penyebab: 1) Proses training membutuhkan waktu lebih lama dari yang diperkirakan, ';
            $errorMsg .= '2) Masalah koneksi jaringan, ';
            $errorMsg .= '3) Server FastAPI tidak merespons. ';
            $errorMsg .= 'Silakan coba lagi atau hubungi administrator.';

            return back()->with('error', $errorMsg);

        } catch (\Exception $e) {
            // Clean up file if error occurs
            if (isset($tempPath) && file_exists($tempPath)) {
                unlink($tempPath);
            }

            Log::error('Training error: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat melatih sistem rekomendasi: ' . $e->getMessage());
        }
    }

    /**
     * Test FastAPI connectivity
     */
    public function testFastApiConnection()
    {
        try {
            $fastApiUrl = config('app.fastapi_url') . '/sync/train';

            // Try different approaches to test connectivity

            // Method 1: Try to test the actual training endpoint with OPTIONS request
            try {
                $response = Http::timeout(10)->withOptions(['http_errors' => false])->withHeaders([
                    'Accept' => 'application/json',
                ])->get($fastApiUrl);

                // Check various success conditions
                if ($response->successful()) {
                    return back()->with('success', 'Koneksi ke FastAPI berhasil! Server merespons dengan status: ' . $response->status());
                } elseif ($response->status() === 405) {
                    // Method not allowed is actually good - server exists and endpoint exists
                    return back()->with('success', 'Koneksi ke FastAPI berhasil! Endpoint tersedia (Method not allowed normal untuk GET pada POST endpoint).');
                } elseif ($response->status() === 422) {
                    // Unprocessable entity - server exists, endpoint exists, just missing data
                    return back()->with('success', 'Koneksi ke FastAPI berhasil! Endpoint tersedia dan siap menerima data.');
                } elseif ($response->status() === 404) {
                    return back()->with('error', 'FastAPI server ditemukan, tapi endpoint /sync/train tidak tersedia. Periksa URL endpoint atau pastikan FastAPI server memiliki endpoint yang benar.');
                } else {
                    return back()->with('warning', 'FastAPI server merespons dengan status: ' . $response->status() . '. Server aktif tapi mungkin ada masalah konfigurasi.');
                }
            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                // Try to ping the base URL
                $baseUrl = parse_url($fastApiUrl);
                $baseUrl = $baseUrl['scheme'] . '://' . $baseUrl['host'] . (isset($baseUrl['port']) ? ':' . $baseUrl['port'] : '');

                try {
                    $baseResponse = Http::timeout(10)->get($baseUrl);
                    if ($baseResponse->successful()) {
                        return back()->with('warning', 'Server FastAPI aktif di ' . $baseUrl . ', tapi endpoint /sync/train tidak dapat diakses. Periksa konfigurasi endpoint.');
                    }
                } catch (\Exception $baseError) {
                    // Server completely unreachable
                }

                return back()->with('error', 'Tidak dapat terhubung ke FastAPI server. Kemungkinan: 1) Server tidak berjalan, 2) URL salah, 3) Koneksi internet bermasalah. Error: ' . $e->getMessage());
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Error saat test koneksi: ' . $e->getMessage());
        }
    }
}
