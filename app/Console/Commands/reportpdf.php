<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Nesk\Puphpeteer\Puppeteer;
use PDF;

class reportpdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportpdf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a PDF version of the SSAT Score Report';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $puppeteer = new Puppeteer();
        $browser = $puppeteer->launch();
        $html = $this->_generate_report()->render();
        $page = $browser->newPage();
        // $page->setContent($html, ['timeout' => 300000, 'waitUntil' => 'networkidle']);
        $page->goto('http://localhost', ['timeout' => 300000, 'waitUntil' => 'networkidle2']);
        // $page->setContent('<h1>TEST</h1>');

        $APP_DIR = dirname(dirname(dirname(__FILE__)));
        $filename = $APP_DIR.'/hn.pdf';
        $pdf = $page->pdf(['path' => $filename, 'format' => 'A4']);

        // $view = $this->_generate_report();
        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($view->render());
        // $pdf->save('hd.pdf');

        // $APP_DIR = dirname(dirname(dirname(__FILE__)));
        // $filename = $APP_DIR.'/hn.pdf';
        // $reportDataStr = file_get_contents($APP_DIR.'/data.json');
        // require($APP_DIR.'/Libraries/helpers.php');

        // PDF::loadView('reports.score', json_decode($reportDataStr, true))->save($filename);
    }

    private function _generate_report()
    {
        $APP_DIR = dirname(dirname(dirname(__FILE__)));
        $reportDataStr = file_get_contents($APP_DIR.'/data.json');
        require($APP_DIR.'/Libraries/helpers.php');

        return view('reports.score', json_decode($reportDataStr, true));
    }
}
