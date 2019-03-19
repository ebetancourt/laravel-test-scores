<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nesk\Puphpeteer\Puppeteer;
use PDF;

class ReportController extends Controller
{
    /**
     * displays SAT report in HTML
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->_generate_report();
    }

    /**
     * in-browser version of PDF SAT report
     *
     * @return \Illuminate\Http\Response
     */
    public function report()
    {
        $puppeteer = new Puppeteer([
            'executable_path' => '/Users/elliot/.nvm/versions/node/v10.14.1/bin/node',
        ]);
        $browser = $puppeteer->launch();
        $html = $this->_generate_report()->render();
        $page = $browser->newPage();
        $page->setContent($html, ['timeout' => 300000, 'waitUntil' => 'networkidle']);
        // $page->setContent('<h1>TEST</h1>');

        $APP_DIR = dirname(dirname(dirname(__FILE__)));
        $filename = $APP_DIR.'/hn.pdf';
        $pdf = $page->pdf(['path' => $filename, 'format' => 'A4']);
        return response()->stream(
            function() use ($filename) {
                $stream = Storage::readStream($fileName);
                fpassthru($stream);
                if (is_resource($stream)) {
                    fclose($stream);
                }
            },
            200,
            [
                'Content-Type' => 'application/pdf',
            ]);

        // $view = $this->_generate_report();
        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($view->render());
        // return $pdf->stream();
    }

    private function _generate_report()
    {
        $APP_DIR = dirname(dirname(dirname(__FILE__)));
        $reportDataStr = file_get_contents($APP_DIR.'/data.json');
        require($APP_DIR.'/Libraries/helpers.php');

        return view('reports.score', json_decode($reportDataStr, true));
    }
}
