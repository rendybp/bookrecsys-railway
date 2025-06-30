<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BooksImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Book([
            'title' => $row['title'],
            'author' => $row['author'],
            'publisher' => $row['publisher'],
            'year_published' => empty($row['year_published']) ? null : (int) $row['year_published'],
            'ISBN' => $row['isbn'],
            'category' => $row['category'],
            'description' => $row['description'],
            'image' => $row['image'],
        ]);
    }
}
