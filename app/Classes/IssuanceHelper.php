<?php
/**
 * Created by PhpStorm.
 * User: ajamiscosa
 * Date: 21/05/2018
 * Time: 10:12 AM
 */

namespace App\Classes;


use App\StatusLog;

class IssuanceHelper {
    public static function ParseLog(StatusLog $log) {
        $transactionType = $log->TransactionType=='IR'?"Issuance":"Purchase";
        switch($log->LogType) {
            case 'N': return sprintf("%s Request filed by %s.", $transactionType, $log->By()->Person()->Name());
            case '1': return sprintf("Initial Approval granted by %s.", $log->By()->Person()->Name());
            case 'Q': return sprintf("Initial Approval granted by %s.", $log->By()->Person()->Name());
            case '2': return sprintf("Second Approval granted by %s.", $log->By()->Person()->Name());
            case 'A': return sprintf("Final Approval granted by %s.", $log->By()->Person()->Name());
            case 'V': return sprintf("%s Request has been voided by %s.", $transactionType, $log->By()->Person()->Name());
            case 'U': return sprintf('Detail/s has been updated by %s', $log->By()->Person()->Name());
            case 'X': return sprintf('Request cancelled by system due to unreceived item/s.');
            case 'I': return sprintf('Items partially issued by %s', $log->By()->Person()->Name());
            case 'C': return sprintf('Issuance completed by %s', $log->By()->Person()->Name());
        }
    }


    public static function ParseStatus($status) {
        switch($status) {
            case 'N': return 'Awaiting First Approval';
            case '1': return 'Awaiting Final Approval';
            case 'A': return 'Approved';
            case 'V': return 'Void';
            case 'X': return 'Expired/Cancelled';
            case 'C': return 'Completed';
        }
    }


    public static function ParsePurchaseOrderStatus($status) {
        switch($status) {
            case 'D': return 'Draft';
            case 'P': return 'Pending Purchasing Manager\'s Approval';
            case '1': return 'Pending Operations Manager\'s Approval';
            case '2': return 'Pending Plant Manager\'s Approval';
            case '3': return 'Pending General Manager\'s Approval';
            case 'A': return 'Approved';
            case 'R': return 'Rejected';
            case 'Z': return 'Completed';
        }

        //D-Draft
        //P-Pending
        //1-Purchasing
        //2-Operations
        //3-Plant
        //A-Leadership
        //R-Rejected
        //Z-Completed
    }
}