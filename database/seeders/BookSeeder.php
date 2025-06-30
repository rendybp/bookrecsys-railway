<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Imports\BooksImport;
use Maatwebsite\Excel\Facades\Excel;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Excel::import(new BooksImport, database_path('data/books_datasets.xlsx'));
    }
}
