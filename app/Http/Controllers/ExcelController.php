<?php

namespace App\Http\Controllers;

use App\Imports\BatchColumn;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function view_excel()
    {
        return view('excel');
    }

    public function handleUpload(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        $import = new BatchColumn();

        // Import the file
        Excel::import($import, $request->file('file'));

        // Get the extracted column values
        $values = $import->columnValues;

        // Pass them to view (or do whatever you want: save to DB etc.)
        return view('excel.upload_result', ['values' => $values]);
    }
}
