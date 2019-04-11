<?php

namespace App\Classes;

class InventoryLogHelper {
    public static function parseLogType($logType) {
        switch($logType) {
            case 'O': return "Outbound";
            case 'I': return "Inbound";
            case 'R': return "Adjustment";
            default: return "Invalid";
        }
    }

    public static function parseTransactionType($type) {
        switch($type){
            case 'IR': return "Issuance";
            case 'RR': return "Received Order";
            case 'SA': return "Stock Adjustment";
            case 'IO': return "Item Obsoletion";
        }
    }
}