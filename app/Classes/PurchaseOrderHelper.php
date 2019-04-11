<?php
/**
 * Created by PhpStorm.
 * User: ajamiscosa
 * Date: 21/05/2018
 * Time: 10:12 AM
 */

namespace App\Classes;


use App\StatusLog;

class PurchaseOrderHelper {

    public static function ParseLog(StatusLog $log) {
        $transactionType = "Purchase Order";
        switch($log->LogType) {
            case 'D': return sprintf("%s drafted by %s.", $transactionType, $log->By()->Person()->Name());
            case 'P': return sprintf("%s filed by %s.", $transactionType, $log->By()->Person()->Name());
            case '1': return sprintf("Approved by Purchasing Manager [%s].", $log->By()->Person()->Name());
            case '2': return sprintf("Approved by Operations Director [%s].", $log->By()->Person()->Name());
            case '3': return sprintf("Approved by Plant Manager [%s].", $log->By()->Person()->Name());
            case 'A': return sprintf("Approved by General Manager [%s].", $log->By()->Person()->Name());
            case 'R': return sprintf("Approval for %s has been rejected by %s.", $transactionType, $log->By()->Person()->Name());
            case 'Z': return sprintf('Purchase Order has been fulfilled');
        }
    }
}