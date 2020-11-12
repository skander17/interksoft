<?php
namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Contracts\Container\BindingResolutionException;

class ReportService
{
    private static array $data = [];
    private static array $index = [];
    private static string $title = '';
    private static string $username = '';
    private static string $date = '';
    private static string $orientation = "portrait";
    public static ?ReportService $report = null;
    public static string $currentUrl = '';

    /**
     * @return ReportService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function report(){
        if (! self::$report instanceof ReportService){
            self::$report = new self();
            self::$username = app()->make('request')->user()->name;
            self::$currentUrl = env('APP_URL');
            self::$date = date("d-m-Y h:i:s a", ( time() - (4*60*60) ));
        }
        return self::$report;
    }

    /**
     * @param $html
     * @return void
     */
    public function render($html)
    {
        $html = self::getHtml($html);
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        $pdf = new DOMPDF($options);

        $pdf->setPaper("Letter", self::$orientation);
        $pdf->loadHtml($html);
        $pdf->render();

        $canvas = $pdf->getCanvas();
        $footer = $canvas->open_object();

        $w = $canvas->get_width();

        $h = $canvas->get_height();

        $canvas->page_text($w - 60, $h - 28, "Página {PAGE_NUM} de {PAGE_COUNT}", $pdf->getFontMetrics()->getFont("helvetica", "bold"), 6);
        $canvas->page_text($w - 590, $h - 28, "", $pdf->getFontMetrics()->getFont("helvetica", "bold"), 6);

        $canvas->close_object();
        $canvas->add_object($footer, "all");
        $pdf->stream('report.pdf', array('Attachment' => 0));
    }

    /**
     * @param $html
     * @return false|string
     */
    public function getHtml($html = 'automatic')
    {
        $data = [];
        $data['index'] = self::$index;
        $data['data'] = self::$data;
        $data['title'] = self::$title;
        $data['username'] = self::$username;
        $data['date'] = self::$date;
        return view("reports.${html}",$data);
    }


    /**
     * @param array $data
     * @return ReportService
     */
    public function setData(array $data)
    {
        self::$data = $data;
        return self::$report;
    }

    /**
     * @param array $index
     * @return ReportService
     */
    public function setIndex(array $index)
    {
        self::$index = $index;
        return self::$report;

    }

    /**
     * @param mixed $title
     * @return ReportService
     */
    public function setTitle($title)
    {
        self::$title = $title;
        return self::$report;

    }

    /**
     * @param mixed $username
     * @return ReportService
     */
    public function setUsername($username)
    {
        self::$username = $username;
        return self::$report;

    }

    /**
     * @param mixed $current_url
     * @return ReportService
     */
    public function setCurrentUrl($current_url)
    {
        self::$currentUrl = $current_url;
        return self::$report;

    }

    /**
     * @param mixed $date
     * @return ReportService
     */
    public function setDate($date)
    {
        self::$date = $date;
        return self::$report;

    }

    /**
     * @param string $orientation
     * @return ReportService
     */
    public function setOrientation(string $orientation)
    {
        self::$orientation = $orientation;
        return self::$report;

    }

    /**
     * @param mixed $report
     * @return ReportService
     */
    public function setReport($report)
    {
        self::$report = $report;
        return self::$report;

    }
}
