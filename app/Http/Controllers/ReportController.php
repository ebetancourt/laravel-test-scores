<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * displays SAT report in HTML
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $APP_DIR = dirname(dirname(dirname(__FILE__)));
        $reportDataStr = file_get_contents($APP_DIR.'/data.json');
        require($APP_DIR.'/Libraries/helpers.php');

        return view('reports.score', json_decode($reportDataStr, true));
    }
}
