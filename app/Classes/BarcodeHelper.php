<?php

namespace App\Classes;

use \CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use \CodeItNow\BarcodeBundle\Utils\QrCode;
use \Faker\Provider\Barcode;

class BarcodeHelper {
    public static function GenerateBarcodeDataFromString($string, $includeLabel = 0) {

        $barcode = new BarcodeGenerator();
        if($includeLabel) {
            $barcode->setFontSize(12);
        } else {
            $barcode->setFontSize(0);
        }
        $barcode->setText($string);
        $barcode->setType(BarcodeGenerator::Code39Extended);
        $barcode->setScale(2);
        $barcode->setThickness(20);
        $barcode->setNoLengthLimit(false);
        $code = $barcode->generate();
        return $code;
    }

    public static function GenerateQRDataFromString($string, $includeLabel = 0) {

        $qrcode = new QrCode();

        $qrcode
        ->setText($string)
        ->setSize(72)
        ->setPadding(10)
        ->setErrorCorrection('high')
        ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
        ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
        ->setLabelFontSize(12)
        ->setImageType(QrCode::IMAGE_TYPE_PNG);

        if($includeLabel) {
            $qrcode->setLabelFontSize(9)
                ->setLabel($string);
        } else {
            $qrcode->setLabelFontSize(0)
                ->setLabel(null);
        }


        return '<img src="data:'.$qrcode->getContentType().';base64,'.$qrcode->generate().'" />';
    }

    public static function GenerateBarcodeImageFromString($string, $includeLabel = 0) {

        return '<img src="data:image/png;base64,'.BarcodeHelper::GenerateBarcodeDataFromString($string, $includeLabel).'" />';
    }

    public static function GenerateQrImageFromString($string, $includeLabel = 0) {

        return BarcodeHelper::GenerateQRDataFromString($string,$includeLabel);
    }
}