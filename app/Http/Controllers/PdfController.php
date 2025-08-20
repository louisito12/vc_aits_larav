<?php

namespace App\Http\Controllers;

use App\Exports\simple_arr;
use Illuminate\Http\Request;
use Omaralalwi\Gpdf\Facade\Gpdf as GpdfFacade;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;


class PdfController extends Controller
{


    public function bp_pdf_view()
    {

        $html = view('pdf.bp')->render();
        $pdfContent = GpdfFacade::generate($html);
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="invoice.pdf"',
        ]);
    }
    public function bmi_pdf_view()
    {

        $html = view('pdf.bmi')->render();
        $pdfContent = GpdfFacade::generate($html);
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="invoice.pdf"',
        ]);
    }

    public function oximeter_pdf_view()
    {

        $html = view('pdf.oximeter')->render();
        $pdfContent = GpdfFacade::generate($html);
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="invoice.pdf"',
        ]);

    }
    public function text_excel()
    {
        $data = [
            ['data' => 1, 'data2' => 4]
        ];

        return (new simple_arr($data))->download('users.xlsx');
    }

}
