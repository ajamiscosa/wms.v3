<?php
/**
 * Created by PhpStorm.
 * User: DEVFINITY
 * Date: 11/20/2018
 * Time: 7:31 PM
 */

namespace App\Classes;


use Illuminate\Http\Response;

class ReportHelper {
    public static function export($fileName, $columns, $data) {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $callback = function() use ($data, $columns)
        {
            $file = fopen('php://output', 'w+');
            fputcsv($file, $columns);

            foreach($data as $review) {
                fputcsv($file, $review);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public static function exportExcel($fileName, $columns, $data) {
        $headers = array(
            "Content-type" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $callback = function() use ($data, $columns)
        {
            $file = fopen('php://output', 'w+');
            fputcsv($file, $columns);

            foreach($data as $review) {
                fputcsv($file, $review);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public static function exportFile($fileName, $columns, $data) {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

            $file = fopen('php://output', 'w+');
            fputcsv($file, $columns);

            foreach($data as $review) {
                fputcsv($file, $review);
            }
            
            response($file)
                ->withHeaders($headers);

                fclose($file);
    }
}