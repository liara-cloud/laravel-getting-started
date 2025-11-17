<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

class PdfController extends Controller
{
    public function showForm()
    {
        return view('home');
    }

    public function generatePdf(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $url = $request->input('url');

        $pdf = Browsershot::url($url)
            ->setOption('browserWSEndpoint', env('REMOTE_CHROME_WSS'))
            ->format('A4')
            ->showBackground()
            ->pdf();

        return response($pdf, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="webpage.pdf"');
    }
}