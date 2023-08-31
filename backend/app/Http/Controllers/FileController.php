<?php

namespace App\Http\Controllers;

use App\Models\File;

class FileController extends Controller
{
    public function index()
    {
        $files = File::withCount([
            'rows as valid_rows_count' => function ($query) {
                $query->where('is_valid', 1);
            },
            'rows as invalid_rows_count' => function ($query) {
                $query->where('is_valid', 0);
            }
        ])->get();

        return response()->json($files);
    }
}