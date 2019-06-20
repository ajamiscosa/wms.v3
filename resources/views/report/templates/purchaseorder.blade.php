<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>{{ $data->PurchaseOrderNumber }}</title>
    <meta charset="UTF-8" />
    <style type="text/css">
        div.html-root>ol,
        div.html-root>ul,
        div.html-root>p {
            margin-top: 0px;
        }

        .sheet .error {
            border: 1px solid red;
            color: red;
        }
        /* interactive page */

        .interactive-page .sheet {
            margin: 10px;
        }
        /* print preview page */

        .print-page {
            background-color: #ccc;
        }

        .print-page > .sheet {
            /* centers the DIV horizontally */
            margin-left: auto;
            margin-right: auto;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .sheet .layer {
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0px;
            top: 0px;
        }

        .sheet .action {
            cursor: pointer;
        }

        .sheet div.action:hover {
            border: 1px solid #ddd;
            /*
	-moz-box-shadow: 1px 1px 3px #888 inset
	-webkit-box-shadow: 1px 1px 3px #888 inset
	box-shadow: 1px 1px 3px #888 inset
	z-index: 99
	*/
        }

        .sheet {
            position: relative;
            text-rendering: geometricPrecision;
        }

        .sheet {
            background-color: White
        }

        .s0- {
            padding-left: 0px;
            padding-right: 0px;
            padding-top: 0px;
            padding-bottom: 0px
        }

        .s1- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: start;
            padding-left: 0px;
            padding-right: 0px;
            padding-top: 0px;
            padding-bottom: 0px
        }

        .s2- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: center;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 2px;
            padding-top: 4px;
            padding-bottom: 0px;
            border-left: 1px solid Black;
            border-top: 1px solid Black;
            border-bottom: 1px solid Black
        }

        .s3- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: center;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 2px;
            padding-top: 4px;
            padding-bottom: 0px;
            border-left: 1px solid Black;
            border-top: 1px solid Black;
            border-right: 1px solid Black;
            border-bottom: 1px solid Black
        }

        .s4- {
            font-family: "Times New Roman";
            font-size: 12pt;
            color: Black;
            font-weight: bold;
            text-align: center;
            padding-left: 0px;
            padding-right: 0px;
            padding-top: 0px;
            padding-bottom: 0px;
            border-left: 1px solid Black;
            border-bottom: 1px solid Black
        }

        .s5- {
            font-family: "Times New Roman";
            font-size: 12pt;
            color: Black;
            font-weight: bold;
            text-align: center;
            position: absolute;
            word-wrap: normal;
            white-space: nowrap
        }

        .s6- {
            font-family: "Times New Roman";
            font-size: 11pt;
            color: Black;
            font-weight: bold;
            text-align: center;
            word-wrap: normal
        }

        .s7- {
            font-family: "Times New Roman";
            font-size: 12pt;
            color: Black;
            font-weight: bold;
            text-align: center;
            padding-left: 0px;
            padding-right: 0px;
            padding-top: 0px;
            padding-bottom: 0px;
            border-left: 1px solid Black;
            border-right: 1px solid Black;
            border-bottom: 1px solid Black
        }

        .s8- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: start;
            padding-left: 0px;
            padding-right: 0px;
            padding-top: 0px;
            padding-bottom: 0px;
            border-left: 1px solid Black;
            border-top: 1px solid Black;
            border-right: 1px solid Black;
            border-bottom: 1px solid Black
        }

        .s9- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: center;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 3px;
            padding-top: 4px;
            padding-bottom: 0px;
            border-right: 1px solid Black;
            border-bottom: 1px solid Black
        }

        .s10- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: center;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 2px;
            padding-top: 4px;
            padding-bottom: 0px;
            border-right: 1px solid Black;
            border-bottom: 1px solid Black
        }

        .s11- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: center;
            word-wrap: break-word;
            padding-left: 2px;
            padding-right: 3px;
            padding-top: 4px;
            padding-bottom: 0px;
            border-right: 1px solid Black;
            border-bottom: 1px solid Black
        }

        .s12- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: center;
            word-wrap: break-word;
            padding-left: 2px;
            padding-right: 2px;
            padding-top: 4px;
            padding-bottom: 0px;
            border-bottom: 1px solid Black
        }

        .s13- {
            font-family: "Times New Roman";
            font-size: 12pt;
            color: Black;
            font-weight: bold;
            text-align: center;
            padding-left: 0px;
            padding-right: 0px;
            padding-top: 0px;
            padding-bottom: 0px;
            border-right: 1px solid Black
        }

        .s14- {
            font-family: "Times New Roman";
            font-size: 12pt;
            color: Black;
            font-weight: bold;
            text-align: start;
            padding-left: 8px;
            padding-right: 0px;
            padding-top: 0px;
            padding-bottom: 0px;
            border-right: 1px solid Black
        }

        .s15- {
            font-family: "Times New Roman";
            font-size: 12pt;
            color: Black;
            font-weight: bold;
            text-align: start;
            position: absolute;
            word-wrap: normal;
            white-space: nowrap
        }

        .s16- {
            font-family: "Times New Roman";
            font-size: 11pt;
            color: Black;
            font-weight: bold;
            text-align: start;
            word-wrap: normal
        }

        .s17- {
            font-family: "Times New Roman";
            font-size: 12pt;
            color: Black;
            font-weight: bold;
            text-align: end;
            padding-left: 0px;
            padding-right: 8px;
            padding-top: 0px;
            padding-bottom: 0px;
            border-right: 1px solid Black
        }

        .s18- {
            font-family: "Times New Roman";
            font-size: 12pt;
            color: Black;
            font-weight: bold;
            text-align: end;
            position: absolute;
            word-wrap: normal;
            white-space: nowrap
        }

        .s19- {
            font-family: "Times New Roman";
            font-size: 12pt;
            color: Black;
            font-weight: bold;
            text-align: end;
            word-wrap: normal
        }

        .s20- {
            font-family: "Times New Roman";
            font-size: 12pt;
            color: Black;
            font-weight: bold;
            text-align: end;
            padding-left: 0px;
            padding-right: 7px;
            padding-top: 0px;
            padding-bottom: 0px;
            border-right: 1px solid Black
        }

        .s21- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: start;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 3px;
            padding-top: 0px;
            padding-bottom: 0px;
            border-right: 1px solid Black
        }

        .s22- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: start;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 2px;
            padding-top: 0px;
            padding-bottom: 0px;
            border-right: 1px solid Black
        }

        .s23- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: start;
            word-wrap: break-word;
            padding-left: 2px;
            padding-right: 3px;
            padding-top: 0px;
            padding-bottom: 0px;
            border-right: 1px solid Black
        }

        .s24- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: start;
            word-wrap: break-word;
            padding-left: 2px;
            padding-right: 2px;
            padding-top: 0px;
            padding-bottom: 0px
        }

        .s25- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: start;
            position: absolute;
            word-wrap: normal;
            white-space: nowrap
        }

        .s26- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: start;
            word-wrap: normal
        }

        .s27- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: start;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 3px;
            padding-top: 4px;
            padding-bottom: 0px
        }

        .s28- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: start;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 3px;
            padding-top: 4px;
            padding-bottom: 0px;
            border-right: 1px solid Black
        }

        .s29- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: start;
            word-wrap: break-word;
            padding-left: 2px;
            padding-right: 2px;
            padding-top: 4px;
            padding-bottom: 0px
        }

        .s30- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: start;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 2px;
            padding-top: 0px;
            padding-bottom: 0px
        }

        .s31- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: start;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 3px;
            padding-top: 0px;
            padding-bottom: 0px
        }

        .s32- {
            font-family: "Times New Roman";
            font-size: 12pt;
            color: Black;
            font-weight: bold;
            text-align: start;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 3px;
            padding-top: 1px;
            padding-bottom: 0px
        }

        .s33- {
            font-family: "Times New Roman";
            font-size: 12pt;
            color: Black;
            font-weight: bold;
            text-align: start;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 3px;
            padding-top: 1px;
            padding-bottom: 0px;
            border-right: 1px solid Black
        }

        .s34- {
            font-family: "Times New Roman";
            font-size: 12pt;
            color: Black;
            font-weight: bold;
            text-align: center;
            word-wrap: break-word;
            padding-left: 2px;
            padding-right: 2px;
            padding-top: 1px;
            padding-bottom: 0px
        }

        .s35- {
            font-family: "Times New Roman";
            font-size: 12pt;
            color: Black;
            font-weight: bold;
            text-align: center;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 2px;
            padding-top: 1px;
            padding-bottom: 0px
        }

        .s36- {
            font-family: "Arial";
            font-size: 8pt;
            color: Black;
            text-align: start;
            padding-left: 3px;
            padding-right: 2px;
            padding-top: 0px;
            padding-bottom: 0px
        }

        .s37- {
            font-family: "Arial";
            font-size: 8pt;
            color: Black;
            text-align: start;
            position: absolute;
            word-wrap: normal;
            white-space: nowrap
        }

        .s38- {
            font-family: "Arial";
            font-size: 8pt;
            color: Black;
            text-align: start;
            word-wrap: normal
        }

        .s39- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: start;
            padding-left: 0px;
            padding-right: 0px;
            padding-top: 0px;
            padding-bottom: 0px;
            border-left: 1px solid Black;
            border-right: 1px solid Black;
            border-bottom: 1px solid Black
        }

        .s40- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            font-weight: bold;
            text-align: center;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 3px;
            padding-top: 11px;
            padding-bottom: 0px;
            border-left: 1px solid Black;
            border-bottom: 1px solid Black
        }

        .s41- {
            font-family: "Times New Roman";
            font-size: 12pt;
            color: Black;
            font-weight: bold;
            text-align: end;
            padding-left: 0px;
            padding-right: 19px;
            padding-top: 0px;
            padding-bottom: 0px;
            border-right: 1px solid Black;
            border-bottom: 1px solid Black
        }

        .s42- {
            font-family: "Arial Black";
            font-size: 18pt;
            color: Black;
            font-weight: bold;
            text-align: start;
            padding-left: 0px;
            padding-right: 0px;
            padding-top: 0px;
            padding-bottom: 0px
        }

        .s43- {
            font-family: "Arial Black";
            font-size: 18pt;
            color: Black;
            font-weight: bold;
            text-align: start;
            position: absolute;
            word-wrap: normal;
            white-space: nowrap
        }

        .s44- {
            font-family: "Arial Black";
            font-size: 18pt;
            color: Black;
            font-weight: bold;
            text-align: start;
            word-wrap: normal
        }

        .s45- {
            font-family: "Times New Roman";
            font-size: 16pt;
            color: Black;
            font-weight: bold;
            text-align: start;
            padding-left: 0px;
            padding-right: 0px;
            padding-top: 0px;
            padding-bottom: 0px
        }

        .s46- {
            font-family: "Times New Roman";
            font-size: 16pt;
            color: Black;
            font-weight: bold;
            text-align: start;
            position: absolute;
            word-wrap: normal;
            white-space: nowrap
        }

        .s47- {
            font-family: "Times New Roman";
            font-size: 16pt;
            color: Black;
            font-weight: bold;
            text-align: start;
            word-wrap: normal
        }

        .s48- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            font-weight: bold;
            text-align: start;
            padding-left: 0px;
            padding-right: 0px;
            padding-top: 0px;
            padding-bottom: 0px
        }

        .s49- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            font-weight: bold;
            text-align: start;
            position: absolute;
            word-wrap: normal;
            white-space: nowrap
        }

        .s50- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            font-weight: bold;
            text-align: start;
            word-wrap: normal
        }

        .s51- {
            font-family: "Times New Roman";
            font-size: 10pt;
            color: Black;
            text-align: start;
            padding-left: 0px;
            padding-right: 0px;
            padding-top: 0px;
            padding-bottom: 0px
        }

        .s52- {
            font-family: "Times New Roman";
            font-size: 10pt;
            color: Black;
            text-align: start;
            position: absolute;
            word-wrap: normal;
            white-space: nowrap
        }

        .s53- {
            font-family: "Times New Roman";
            font-size: 10pt;
            color: Black;
            text-align: start;
            word-wrap: normal
        }

        .s54- {
            font-family: "Arial";
            font-size: 12pt;
            color: Black;
            font-weight: bold;
            text-align: start;
            padding-left: 0px;
            padding-right: 0px;
            padding-top: 0px;
            padding-bottom: 0px
        }

        .s55- {
            font-family: "Arial";
            font-size: 12pt;
            color: Black;
            font-weight: bold;
            text-align: start;
            position: absolute;
            word-wrap: normal;
            white-space: nowrap
        }

        .s56- {
            font-family: "Arial";
            font-size: 12pt;
            color: Black;
            font-weight: bold;
            text-align: start;
            word-wrap: normal
        }

        .s57- {
            font-family: "Times New Roman";
            font-size: 12pt;
            color: Black;
            font-weight: bold;
            text-align: start;
            padding-left: 0px;
            padding-right: 0px;
            padding-top: 0px;
            padding-bottom: 0px
        }
        /*]]>*/
        .crsheet .error
        {
            border: 1px solid red;
            color: red;
        }
        /* interactive page */
        .interactive-page .crsheet
        {
            margin: 10px;
        }
        /* print preview page */
        .cprint-page
        {
            background-color: #ccc;
        }
        .cprint-page > .crsheet
        {
            margin-left: auto;
            margin-right: auto;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .crsheet .crlayer
        {
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0px;
            top: 0px;
        }
        .crsheet .craction
        {
            cursor: pointer;
        }
        .crsheet div.craction:hover
        {
            border: 1px solid #ddd;
        }
        .crsheet
        {
            position: relative;
            text-rendering: geometricPrecision;
        }
        .crsheet {background-color:White}
        .cr0- {padding-left:0px;padding-right:0px;padding-top:0px;padding-bottom:0px}
        .cr1- {font-family:Arial;font-size:10pt;color:Black;text-align:start;padding-left:0px;padding-right:0px;padding-top:0px;padding-bottom:0px;border-left:1px solid Black;border-top:1px solid Black;border-right:1px solid Black;border-bottom:1px solid Black}
        .cr2- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:center;word-wrap:break-word;padding-left:3px;padding-right:2px;padding-top:1px;padding-bottom:0px;border-right:1px solid Black;border-bottom:1px solid Black}
        .cr3- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:2px;padding-top:1px;padding-bottom:0px;border-right:1px solid Black;border-bottom:1px solid Black}
        .cr4- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:2px;padding-top:1px;padding-bottom:0px;border-bottom:1px solid Black}
        .cr5- {font-family:Arial;font-size:9pt;color:Black;text-align:center;word-wrap:break-word;padding-left:3px;padding-right:2px;padding-top:0px;padding-bottom:0px;border-right:1px solid Black;}
        .cr6- {font-family:Arial;font-size:9pt;color:Black;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:2px;padding-top:0px;padding-bottom:0px;border-right:1px solid Black;}
        .cr7- {font-family:Arial;font-size:10pt;color:Black;text-align:center;word-wrap:break-word;padding-left:3px;padding-right:2px;padding-top:0px;padding-bottom:0px;border-right:1px solid Black;border-bottom:1px solid Black}
        .cr8- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:center;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:1px;padding-bottom:0px;border-right:1px solid Black;border-bottom:1px solid Black}
        .cr9- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:center;word-wrap:break-word;padding-left:2px;padding-right:2px;padding-top:1px;padding-bottom:0px;border-right:1px solid Black;border-bottom:1px solid Black}
        .cr10- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:center;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-right:1px solid Black;border-bottom:1px solid Black}
        .cr11- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:2px;padding-right:2px;padding-top:1px;padding-bottom:0px;border-bottom:1px solid Black}
        .cr12- {font-family:Arial;font-size:9pt;color:Black;text-align:center;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-right:1px solid Black;}
        .cr13- {font-family:Arial;font-size:9pt;color:Black;text-align:center;word-wrap:break-word;padding-left:2px;padding-right:2px;padding-top:0px;padding-bottom:0px;border-right:1px solid Black;}
        .cr14- {font-family:Arial;font-size:9pt;color:Black;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-right:1px solid Black;}
        .cr15- {font-family:Arial;font-size:10pt;color:Black;text-align:start;padding-left:0px;padding-right:0px;padding-top:0px;padding-bottom:0px}
        .cr16- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px}
        .cr17- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px}
        .cr18- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-left:1px solid Black;border-top:1px solid Black;border-right:1px solid Black;border-bottom:1px solid Black}
        .cr19- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-left:1px solid Black;border-right:1px solid Black;border-bottom:1px solid Black}
        .cr20- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:2px;padding-right:3px;padding-top:0px;padding-bottom:0px}
        .cr21- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:2px;padding-right:3px;padding-top:0px;padding-bottom:0px}
        .cr22- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:2px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-left:1px solid Black;border-top:1px solid Black;border-right:1px solid Black;border-bottom:1px solid Black}
        .cr23- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:2px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-left:1px solid Black;border-right:1px solid Black;border-bottom:1px solid Black}
        .cr24- {font-family:Arial;font-size:12pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px}
        .cr25- {font-family:Arial;font-size:12pt;color:Black;text-align:start;word-wrap:break-word;padding-left:2px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-bottom:1px solid Black}
        .cr26- {font-family:Arial;font-size:9pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:2px;padding-bottom:0px}
        .cr27- {font-family:Arial;font-size:14pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px}
        .cr28- {font-family:Arial;font-size:12pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:2px;padding-top:5px;padding-bottom:0px}
        .cr29- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:2px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-bottom:1px solid Black}
        .cr30- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-bottom:1px solid Black}
        .cr31- {font-family:Arial;font-size:12pt;color:Black;font-weight:bold;text-align:center;padding-left:3px;padding-right:2px;padding-top:0px;padding-bottom:0px;border-left:1px solid Black;border-top:1px solid Black;border-right:1px solid Black;border-bottom:1px solid Black}
        .cr32- {font-family:Arial;font-size:12pt;color:Black;font-weight:bold;text-align:center;position:absolute;word-wrap:normal;white-space:nowrap}
        .cr33- {font-family:Arial;font-size:12pt;color:Black;font-weight:bold;text-align:center;word-wrap:normal}
        .cr34- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:2px;padding-top:0px;padding-bottom:0px}
        .cr35- {font-family:Arial;font-size:10pt;color:Black;text-align:center;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px}
        .cr36- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:2px;padding-top:0px;padding-bottom:0px}
        .cr37- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:8px;padding-right:2px;padding-top:0px;padding-bottom:0px;border-bottom:1px solid Black}
        .cr38- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:8px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-bottom:1px solid Black}

    </style>
</head>

<body class="print-page">
<div class="sheet page1" id="capture" style="padding-left:38px;padding-right:38px;padding-top:38px;padding-bottom:38px;width:739px;height:979px;">
    <div class="layer">
        <div title="" class="PurchaseOrder s0-" style="position:absolute;overflow:hidden;left:38px;top:265px;width:740px;height:666px;"></div>
        <div title="" class="Group s0-" style="position:absolute;overflow:hidden;left:38px;top:265px;width:740px;height:666px;"></div>
        <div title="" class="reportHeaderSection1 s0-" style="position:absolute;overflow:hidden;left:38px;top:265px;width:740px;height:80px;"></div>
        <div title="" class="table2 s1-" style="position:absolute;overflow:hidden;left:38px;top:285px;width:738px;height:46px;"></div>
        <div title="" class="textBox11 s2-" style="position:absolute;overflow:hidden;left:38px;top:285px;width:154px;height:18px;">
            <div style="position:absolute;top:4px;white-space:pre;left:39px;">Delivery Date</div>
        </div>
        <div title="" class="textBox13 s2-" style="position:absolute;overflow:hidden;left:197px;top:285px;width:320px;height:18px;">
            <div style="position:absolute;top:4px;white-space:pre;left:81px;">Charge No. / Requested By</div>
        </div>
        <div title="" class="textBox15 s3-" style="position:absolute;overflow:hidden;left:522px;top:285px;width:248px;height:18px;">
            <div style="position:absolute;top:4px;white-space:pre;left:108px;">Terms</div>
        </div>
        <div title="" class="txtDeliveryDate s4-" style="position:absolute;overflow:hidden;left:38px;top:308px;width:159px;height:23px;">
            <div class="s5-" style="top:2px;left:54px;"><span class="s6-">{{ $data->DeliveryDate }}</span></div>
        </div>
        <div title="" class="txtChargeNo s4-" style="display: table; position:absolute;overflow:hidden;left:197px;top:308px;width:325px;height:23px; text-align: center !important;">
            <div style="display: table-cell; height: 100%; vertical-align: middle !important;"><span class="s6-">{{ $data->ChargeNo }}</span></div>
        </div>
        <div title="" class="txtTerms s7-" style="position:absolute;overflow:hidden;left:522px;top:308px;width:253px;height:23px;">
            <div class="s5-" style="top:2px;left:99px;"><span class="s6-">{{ $data->Terms }}</span></div>
        </div>
        <div title="" class="detail s0-" style="position:absolute;overflow:hidden;left:38px;top:345px;width:740px;height:300px;"></div>
        <div title="" class="table1 s8-" style="position:absolute;overflow:hidden;left:38px;top:345px;width:737px;height:298px;"></div>
        <div title="" class="textBox7 s9-" style="position:absolute;overflow:hidden;left:38px;top:345px;width:69px;height:19px;">
            <div style="position:absolute;top:4px;white-space:pre;left:12px;">Quantity</div>
        </div>
        <div title="" class="textBox9 s10-" style="position:absolute;overflow:hidden;left:113px;top:345px;width:60px;height:19px;">
            <div style="position:absolute;top:4px;white-space:pre;left:11px;">UOM</div>
        </div>
        <div title="" class="textBox1 s9-" style="position:absolute;overflow:hidden;left:178px;top:345px;width:298px;height:19px;">
            <div style="position:absolute;top:4px;white-space:pre;left:101px;">Description</div>
        </div>
        <div title="" class="textBox3 s11-" style="position:absolute;overflow:hidden;left:483px;top:345px;width:133px;height:19px;">
            <div style="position:absolute;top:4px;white-space:pre;left:57px;">Unit Cost</div>
        </div>
        <div title="" class="textBox5 s12-" style="position:absolute;overflow:hidden;left:615px;top:345px;width:157px;height:19px;">
            <div style="position:absolute;top:4px;white-space:pre;left:51px;">Extension</div>
        </div>


        @php($x = 368)
        @foreach($data->OrderItems as $orderItem )
            @php($lineItem = $orderItem->LineItem())
            @php($purchaseRequest = $orderItem->Requisition())
            @php($product = $lineItem->Product())
            @php($uom = $product->UOM())
            @php($quote = $orderItem->SelectedQuote())

            <div title="" class="htmlTextBox2 s13-" style="position:absolute;overflow:hidden;left:38px;top:{{$x}}px;width:75px;height:24px;display: table; ">
                <div class="s5-" style="top:3px;display: table-cell; height: 100%; vertical-align: middle !important;"><span class="s6-">{{ $lineItem->Quantity }}</span></div>
            </div>
            <div title="" class="htmlTextBox13 s13-" style="position:absolute;overflow:hidden;left:113px;top:{{$x}}px;width:65px;height:24px;">
                <div class="s5-" style="top:3px;left:2px;"><span class="s6-">{{ $uom->Abbreviation }}</span></div>
            </div>
            <div title="" class="htmlTextBox14 s14-" style="position:absolute;overflow:hidden;left:178px;top:{{$x}}px;width:296px;height:24px;">
                <div class="s15-" style="top:3px;left:3px;"><span class="s16-">{{ $product->Description }}</span></div>
            </div>
            <div title="" class="htmlTextBox15 s17-" style="position:absolute;overflow:hidden;left:483px;top:{{$x}}px;width:130px;height:24px;">
                <div class="s18-" style="top:3px;right:8px;"><span class="s19-">{{ $quote->Amount }}</span></div>
            </div>
            <div title="" class="htmlTextBox16 s20-" style="position:absolute;overflow:hidden;left:615px;top:{{$x}}px;width:154px;height:24px;">
                <div class="s18-" style="top:3px;right:8px;"><span class="s19-">{{ number_format($quote->Amount * $lineItem->Quantity,2,'.',',') }}</span></div>
            </div>


            @php($x+=24)
        @endforeach


        <div title="" class="htmlTextBox2 s13-" style="position:absolute;overflow:hidden;left:38px;top:{{$x}}px;width:75px;height:24px;">
            <div class="s5-" style="top:3px;display: table-cell; height: 100%; vertical-align: middle !important;"><span class="s6-">&nbsp;</span></div>
        </div>
        <div title="" class="htmlTextBox13 s13-" style="position:absolute;overflow:hidden;left:113px;top:{{$x}}px;width:65px;height:24px;">
            <div class="s5-" style="top:3px;left:2px;"><span class="s6-"></span></div>
        </div>
        <div title="" class="htmlTextBox14 s14-" style="position:absolute;overflow:hidden;left:178px;top:{{$x}}px;width:296px;height:24px;">
            <div class="s15-" style="top:3px;left:3px;"><span class="s16-">X X X NOTHING FOLLOWS X X X</span></div>
        </div>
        <div title="" class="htmlTextBox15 s17-" style="position:absolute;overflow:hidden;left:485px;top:{{$x}}px;width:128px;height:24px;">
            <div class="s18-" style="top:3px;right:8px;"><span class="s19-">&nbsp;</span></div>
        </div>
        <div title="" class="htmlTextBox16 s20-" style="position:absolute;overflow:hidden;left:615px;top:{{$x}}px;width:154px;height:24px;">
            <div class="s18-" style="top:3px;right:8px;"><span class="s19-">&nbsp;</span></div>
        </div>




        <div title="" class="textBox49 s21-" style="position:absolute;overflow:hidden;left:38px;top:392px;width:69px;height:19px;"></div>
        <div title="" class="textBox50 s22-" style="position:absolute;overflow:hidden;left:125px;top:392px;width:48px;height:19px;"></div>
        <div title="" class="textBox51 s21-" style="position:absolute;overflow:hidden;left:178px;top:392px;width:298px;height:19px;"></div>
        <div title="" class="textBox52 s23-" style="position:absolute;overflow:hidden;left:485px;top:392px;width:131px;height:19px;"></div>
        <div title="" class="textBox53 s24-" style="position:absolute;overflow:hidden;left:615px;top:392px;width:157px;height:19px;"></div>

        <div title="" class="textBox44 s21-" style="position:absolute;overflow:hidden;left:38px;top:411px;width:69px;height:20px;"></div>
        <div title="" class="textBox45 s22-" style="position:absolute;overflow:hidden;left:125px;top:411px;width:48px;height:20px;"></div>
        <div title="" class="textBox46 s21-" style="position:absolute;overflow:hidden;left:178px;top:411px;width:298px;height:20px;"></div>
        <div title="" class="textBox47 s23-" style="position:absolute;overflow:hidden;left:485px;top:411px;width:131px;height:20px;"></div>
        <div title="" class="textBox48 s24-" style="position:absolute;overflow:hidden;left:615px;top:411px;width:157px;height:20px;"></div>

        <div title="" class="textBox39 s21-" style="position:absolute;overflow:hidden;left:38px;top:431px;width:69px;height:19px;"></div>
        <div title="" class="textBox40 s22-" style="position:absolute;overflow:hidden;left:125px;top:431px;width:48px;height:19px;"></div>
        <div title="" class="textBox41 s21-" style="position:absolute;overflow:hidden;left:178px;top:431px;width:298px;height:19px;"></div>
        <div title="" class="textBox42 s23-" style="position:absolute;overflow:hidden;left:485px;top:431px;width:131px;height:19px;"></div>
        <div title="" class="textBox43 s24-" style="position:absolute;overflow:hidden;left:615px;top:431px;width:157px;height:19px;"></div>

        <div title="" class="textBox96 s21-" style="position:absolute;overflow:hidden;left:38px;top:450px;width:69px;height:20px;"></div>
        <div title="" class="textBox97 s22-" style="position:absolute;overflow:hidden;left:125px;top:450px;width:48px;height:20px;"></div>
        <div title="" class="textBox98 s21-" style="position:absolute;overflow:hidden;left:178px;top:450px;width:298px;height:20px;"></div>
        <div title="" class="textBox99 s23-" style="position:absolute;overflow:hidden;left:485px;top:450px;width:131px;height:20px;"></div>
        <div title="" class="textBox100 s24-" style="position:absolute;overflow:hidden;left:615px;top:450px;width:157px;height:20px;"></div>

        <div title="" class="textBox91 s21-" style="position:absolute;overflow:hidden;left:38px;top:470px;width:69px;height:19px;"></div>
        <div title="" class="textBox92 s22-" style="position:absolute;overflow:hidden;left:125px;top:470px;width:48px;height:19px;"></div>
        <div title="" class="textBox93 s21-" style="position:absolute;overflow:hidden;left:178px;top:470px;width:298px;height:19px;"></div>
        <div title="" class="textBox94 s23-" style="position:absolute;overflow:hidden;left:485px;top:470px;width:131px;height:19px;"></div>
        <div title="" class="textBox95 s24-" style="position:absolute;overflow:hidden;left:615px;top:470px;width:157px;height:19px;"></div>

        <div title="" class="textBox86 s21-" style="position:absolute;overflow:hidden;left:38px;top:489px;width:69px;height:19px;"></div>
        <div title="" class="textBox87 s22-" style="position:absolute;overflow:hidden;left:125px;top:489px;width:48px;height:19px;"></div>
        <div title="" class="textBox88 s21-" style="position:absolute;overflow:hidden;left:178px;top:489px;width:298px;height:19px;"></div>
        <div title="" class="textBox89 s23-" style="position:absolute;overflow:hidden;left:485px;top:489px;width:131px;height:19px;"></div>
        <div title="" class="textBox90 s24-" style="position:absolute;overflow:hidden;left:615px;top:489px;width:157px;height:19px;"></div>

        <div title="" class="textBox81 s21-" style="position:absolute;overflow:hidden;left:38px;top:508px;width:69px;height:19px;"></div>
        <div title="" class="textBox82 s22-" style="position:absolute;overflow:hidden;left:125px;top:508px;width:48px;height:19px;"></div>
        <div title="" class="textBox83 s21-" style="position:absolute;overflow:hidden;left:178px;top:508px;width:298px;height:19px;"></div>
        <div title="" class="textBox84 s23-" style="position:absolute;overflow:hidden;left:485px;top:508px;width:131px;height:19px;"></div>
        <div title="" class="textBox85 s24-" style="position:absolute;overflow:hidden;left:615px;top:508px;width:157px;height:19px;"></div>

        <div title="" class="textBox71 s21-" style="position:absolute;overflow:hidden;left:38px;top:527px;width:69px;height:19px;"></div>
        <div title="" class="textBox77 s22-" style="position:absolute;overflow:hidden;left:125px;top:527px;width:48px;height:19px;"></div>
        <div title="" class="textBox78 s21-" style="position:absolute;overflow:hidden;left:178px;top:527px;width:298px;height:19px;"></div>
        <div title="" class="textBox79 s23-" style="position:absolute;overflow:hidden;left:485px;top:527px;width:131px;height:19px;"></div>
        <div title="" class="textBox80 s24-" style="position:absolute;overflow:hidden;left:615px;top:527px;width:157px;height:19px;"></div>

        <div title="" class="textBox34 s21-" style="position:absolute;overflow:hidden;left:38px;top:546px;width:69px;height:20px;"></div>
        <div title="" class="textBox35 s22-" style="position:absolute;overflow:hidden;left:125px;top:546px;width:48px;height:20px;"></div>
        <div title="" class="textBox36 s21-" style="position:absolute;overflow:hidden;left:178px;top:546px;width:298px;height:20px;"></div>
        <div title="" class="textBox37 s23-" style="position:absolute;overflow:hidden;left:485px;top:546px;width:131px;height:20px;"></div>
        <div title="" class="textBox38 s24-" style="position:absolute;overflow:hidden;left:615px;top:546px;width:157px;height:20px;"></div>

        <div title="" class="textBox29 s21-" style="position:absolute;overflow:hidden;left:38px;top:566px;width:69px;height:20px;"></div>
        <div title="" class="textBox30 s22-" style="position:absolute;overflow:hidden;left:125px;top:566px;width:48px;height:20px;"></div>
        <div title="" class="textBox31 s21-" style="position:absolute;overflow:hidden;left:178px;top:566px;width:298px;height:20px;"></div>
        <div title="" class="textBox32 s23-" style="position:absolute;overflow:hidden;left:485px;top:566px;width:131px;height:20px;"></div>
        <div title="" class="textBox33 s24-" style="position:absolute;overflow:hidden;left:615px;top:566px;width:157px;height:20px;"></div>

        <div title="" class="textBox12 s21-" style="position:absolute;overflow:hidden;left:38px;top:586px;width:69px;height:19px;"></div>
        <div title="" class="textBox14 s22-" style="position:absolute;overflow:hidden;left:125px;top:586px;width:48px;height:19px;"></div>
        <div title="" class="textBox16 s21-" style="position:absolute;overflow:hidden;left:178px;top:586px;width:298px;height:19px;"></div>
        <div title="" class="textBox27 s23-" style="position:absolute;overflow:hidden;left:485px;top:586px;width:131px;height:19px;"></div>
        <div title="" class="textBox28 s24-" style="position:absolute;overflow:hidden;left:615px;top:586px;width:157px;height:19px;"></div>

        <div title="" class="textBox17 s21-" style="position:absolute;overflow:hidden;left:38px;top:605px;width:69px;height:20px;"></div>
        <div title="" class="textBox18 s22-" style="position:absolute;overflow:hidden;left:125px;top:605px;width:48px;height:20px;"></div>
        <div title="" class="textBox19 s21-" style="position:absolute;overflow:hidden;left:178px;top:605px;width:298px;height:20px;"></div>
        <div title="" class="textBox20 s23-" style="position:absolute;overflow:hidden;left:485px;top:605px;width:131px;height:20px;"></div>
        <div title="" class="textBox21 s24-" style="position:absolute;overflow:hidden;left:615px;top:605px;width:157px;height:20px;"></div>

        <div title="" class="textBox22 s21-" style="position:absolute;overflow:hidden;left:38px;top:625px;width:69px;height:19px;"></div>
        <div title="" class="textBox23 s22-" style="position:absolute;overflow:hidden;left:125px;top:625px;width:48px;height:19px;"></div>
        <div title="" class="textBox24 s21-" style="position:absolute;overflow:hidden;left:178px;top:625px;width:298px;height:19px;"></div>
        <div title="" class="textBox25 s23-" style="position:absolute;overflow:hidden;left:485px;top:625px;width:131px;height:19px;"></div>
        <div title="" class="textBox26 s24-" style="position:absolute;overflow:hidden;left:615px;top:625px;width:157px;height:19px;"></div>

        <div title="" class="reportFooterSection1 s0-" style="position:absolute;overflow:hidden;left:38px;top:645px;width:740px;height:286px;"></div>
        <div title="" class="htmlTextBox20 s1-" style="position:absolute;overflow:hidden;left:38px;top:683px;width:738px;height:16px;">
            <div class="s25-" style="top:0px;left:0px;"><span class="s26-">NOTE</span></div>
        </div>
        <div title="" class="htmlTextBox21 s1-" style="position:absolute;overflow:hidden;left:38px;top:699px;width:738px;height:15px;">
            <div class="s25-" style="top:0px;left:0px;"><span class="s26-">1. Please indicate PO No. on the Invoice and attach copy of the PO upon delivery.</span></div>
        </div>
        <div title="" class="htmlTextBox22 s1-" style="position:absolute;overflow:hidden;left:38px;top:714px;width:738px;height:16px;">
            <div class="s25-" style="top:0px;left:0px;"><span class="s26-">2. Supplier inspection/audit by Performance Metals and its clients maybe done when necessary.</span></div>
        </div>
        <div title="" class="htmlTextBox23 s1-" style="position:absolute;overflow:hidden;left:38px;top:730px;width:738px;height:16px;">
            <div class="s25-" style="top:0px;left:0px;"><span class="s26-">3. We disclaim responsibility for orders or alteration to orders not made out on this form and duly signed.</span></div>
        </div>
        <div title="" class="htmlTextBox24 s1-" style="position:absolute;overflow:hidden;left:38px;top:746px;width:738px;height:15px;">
            <div class="s25-" style="top:0px;left:0px;"><span class="s26-">4. This purchase order is subject to Terms and Conditions of Purchase. Please refer to our website www.prsmetals.com</span></div>
        </div>
        <div title="" class="htmlTextBox25 s1-" style="position:absolute;overflow:hidden;left:38px;top:761px;width:738px;height:16px;">
            <div class="s25-" style="top:0px;left:0px;"><span class="s26-">5. Please acknowledge receipt of this PO by sending an e-mail to: PerformanceMetals.Purchasing@ii-vi.com</span></div>
        </div>
        <div title="" class="table4 s8-" style="position:absolute;overflow:hidden;left:38px;top:809px;width:737px;height:103px;"></div>
        <div title="" class="textBox54 s27-" style="position:absolute;overflow:hidden;left:38px;top:809px;width:186px;height:19px;">
            <div style="position:absolute;top:4px;white-space:pre;left:3px;">&nbsp;&nbsp;&nbsp;Prepared by:</div>
        </div>
        <div title="" class="textBox68 s28-" style="position:absolute;overflow:hidden;left:230px;top:809px;width:186px;height:19px;">
            <div style="position:absolute;top:4px;white-space:pre;left:3px;">Checked by:</div>
        </div>
        <div title="" class="textBox58 s29-" style="position:absolute;overflow:hidden;left:422px;top:809px;width:187px;height:19px;">
            <div style="position:absolute;top:4px;white-space:pre;left:3px;"> Approved By:</div>
        </div>
        <div title="" class="textBox65 s30-" style="position:absolute;overflow:hidden;left:613px;top:809px;width:158px;height:23px;"></div>
        <div title="" class="textBox56 s31-" style="position:absolute;overflow:hidden;left:38px;top:832px;width:186px;height:23px;"></div>
        <div title="" class="textBox59 s21-" style="position:absolute;overflow:hidden;left:230px;top:832px;width:186px;height:23px;"></div>
        <div title="" class="textBox61 s24-" style="position:absolute;overflow:hidden;left:422px;top:832px;width:187px;height:23px;"></div>
        <div title="" class="textBox66 s30-" style="position:absolute;overflow:hidden;left:613px;top:832px;width:158px;height:23px;"></div>
        <div title="" class="textBox72 s31-" style="position:absolute;overflow:hidden;left:38px;top:855px;width:186px;height:20px;"></div>
        <div title="" class="textBox73 s21-" style="position:absolute;overflow:hidden;left:230px;top:855px;width:186px;height:20px;"></div>
        <div title="" class="textBox74 s24-" style="position:absolute;overflow:hidden;left:422px;top:855px;width:187px;height:20px;"></div>
        <div title="" class="textBox75 s30-" style="position:absolute;overflow:hidden;left:613px;top:855px;width:158px;height:20px;"></div>
        <div title="" class="textBox60 s32-" style="position:absolute;overflow:hidden;left:38px;top:875px;width:186px;height:18px;">
            <div style="position:absolute;top:2px;white-space:pre;left:3px;">&nbsp;&nbsp;&nbsp;&nbsp;{{ $data->PurchasingManager }}</div>
        </div>
        <div title="" class="textBox76 s33-" style="position:absolute;overflow:hidden;left:230px;top:875px;width:186px;height:18px;">
            <div style="position:absolute;top:2px;white-space:pre;left:3px;">{{ $data->OperationsManager }}</div>
        </div>
        <div title="" class="textBox70 s34-" style="position:absolute;overflow:hidden;left:422px;top:875px;width:187px;height:18px;">
            <div style="position:absolute;top:2px;white-space:pre;left:61px;">{{ $data->PlantManager }}</div>
        </div>
        <div title="" class="textBox69 s35-" style="position:absolute;overflow:hidden;left:613px;top:875px;width:158px;height:18px;">
            <div style="position:absolute;top:2px;white-space:pre;left:57px;">{{ $data->GeneralManager }}</div>
        </div>
        <div title="" class="textBox62 s31-" style="position:absolute;overflow:hidden;left:38px;top:894px;width:186px;height:19px;"></div>
        <div title="" class="textBox63 s21-" style="position:absolute;overflow:hidden;left:230px;top:894px;width:186px;height:19px;"></div>
        <div title="" class="textBox64 s24-" style="position:absolute;overflow:hidden;left:422px;top:894px;width:187px;height:19px;"></div>
        <div title="" class="textBox67 s30-" style="position:absolute;overflow:hidden;left:613px;top:894px;width:158px;height:19px;"></div>
        <div title="" class="htmlTextBox26 s36-" style="position:absolute;overflow:hidden;left:38px;top:913px;width:388px;height:15px;">
            <div class="s37-" style="top:0px;left:3px;"><span class="s38-">Form Control No.: PMD-FO0101-02-001_8.4</span></div>
        </div>
        <div title="" class="table3 s39-" style="position:absolute;overflow:hidden;left:401px;top:645px;width:374px;height:38px;"></div>
        <div title="" class="textBox55 s40-" style="position:absolute;overflow:hidden;left:401px;top:645px;width:87px;height:27px;">
            <div style="position:absolute;top:12px;white-space:pre;left:24px;">TOTAL</div>
        </div>
        <div title="" class="txtCurrency s4-" style="position:absolute;overflow:hidden;left:494px;top:645px;width:96px;height:38px;">
            <div class="s5-" style="top:10px;left:31px;"><span class="s6-">{{ $data->Currency }}</span></div>
        </div>
        <div title="" class="txtTotalAmount s41-" style="position:absolute;overflow:hidden;left:590px;top:645px;width:167px;height:38px;">
            <div class="s18-" style="top:10px;right:19px;"><span class="s19-">{{ number_format($data->Total,2,'.',',') }}</span></div>
        </div>
        <div title="" class="pageHeaderSection1 s0-" style="position:absolute;overflow:hidden;left:38px;top:38px;width:740px;height:227px;"></div>
        <div title="" class="pictureBox1 s0-" style="position:absolute;overflow:hidden;left:38px;top:43px;width:352px;height:56px;"><img alt="" src="data:image/png;base64,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" style="position:absolute;text-align:left;top:0px;left:1px;width:350px;height:56px;" /></div>
        <div title="" class="htmlTextBox1 s42-" style="position:absolute;overflow:hidden;left:511px;top:38px;width:208px;height:29px;">
            <div class="s43-" style="top:0px;left:0px;"><span class="s44-">Purchase Order</span></div>
        </div>
        <div title="" class="txtPONumber s45-" style="position:absolute;overflow:hidden;left:515px;top:67px;width:196px;height:24px;">
            <div class="s46-" style="top:0px;left:0px;"><span class="s47-">{{ $data->PurchaseOrderNumber }}</span></div>
        </div>
        <div title="" class="htmlTextBox3 s48-" style="position:absolute;overflow:hidden;left:38px;top:126px;width:46px;height:16px;">
            <div class="s49-" style="top:0px;left:0px;"><span class="s50-">To:</span></div>
        </div>
        <div title="" class="htmlTextBox5 s48-" style="position:absolute;overflow:hidden;left:38px;top:157px;width:88px;height:16px;">
            <div class="s49-" style="top:0px;left:0px;"><span class="s50-">Address:</span></div>
        </div>
        <div title="" class="htmlTextBox4 s48-" style="position:absolute;overflow:hidden;left:511px;top:126px;width:113px;height:16px;">
            <div class="s49-" style="top:0px;left:0px;"><span class="s50-">Date Issued:</span></div>
        </div>
        <div title="" class="htmlTextBox6 s48-" style="position:absolute;overflow:hidden;left:459px;top:157px;width:261px;height:22px;">
            <div class="s49-" style="top:3px;left:0px;"><span class="s50-">Delivery and Billing Address:</span></div>
        </div>
        <div title="" class="htmlTextBox7 s51-" style="position:absolute;overflow:hidden;left:459px;top:179px;width:261px;height:15px;">
            <div class="s52-" style="top:0px;left:0px;"><span class="s53-">II-VI Performance Metals, Inc.</span></div>
        </div>
        <div title="" class="htmlTextBox8 s51-" style="position:absolute;overflow:hidden;left:459px;top:194px;width:261px;height:17px;">
            <div class="s52-" style="top:1px;left:0px;"><span class="s53-">Blk 1, Phase 2, Cavite Economic Zone</span></div>
        </div>
        <div title="" class="htmlTextBox9 s51-" style="position:absolute;overflow:hidden;left:459px;top:211px;width:261px;height:16px;">
            <div class="s52-" style="top:0px;left:0px;"><span class="s53-">Rosario, Cavite 4106 Philippines</span></div>
        </div>
        <div title="" class="htmlTextBox10 s51-" style="position:absolute;overflow:hidden;left:459px;top:227px;width:261px;height:15px;">
            <div class="s52-" style="top:0px;left:0px;"><span class="s53-">Phone: +632-784-4000, +63464371931</span></div>
        </div>
        <div title="" class="htmlTextBox11 s51-" style="position:absolute;overflow:hidden;left:459px;top:242px;width:317px;height:17px;">
            <div class="s52-" style="top:1px;left:0px;"><span class="s53-">Email: PerformanceMetals.Purchasing.pH@ii-vi.com</span></div>
        </div>
        <div title="" class="htmlTextBox12 s48-" style="position:absolute;overflow:hidden;left:38px;top:249px;width:88px;height:15px;">
            <div class="s49-" style="top:0px;left:0px;"><span class="s50-">Vendor ID:</span></div>
        </div>
        <div title="" class="txtVendorID s54-" style="position:absolute;overflow:hidden;left:126px;top:246px;width:87px;height:18px;">
            <div class="s55-" style="top:0px;left:0px;"><span class="s56-">{{ $data->VendorID }}</span></div>
        </div>

        @php($x = 157)
        @php($i = 1)
        @foreach($data->Address as $line)
            <div title="" class="txtAddressLine{{$i}} s1-" style="position:absolute;overflow:hidden;left:126px;top:{{$x}}px;width:264px;height:16px;">
                <div class="s25-" style="top:0px;left:0px;"><span class="s26-">{{ $line }}</span></div>
            </div>
            @php($x+=16)
            @php($i++)
        @endforeach


        <div title="" class="txtVendorName s57-" style="position:absolute;overflow:hidden;left:126px;top:123px;width:264px;height:19px;">
            <div class="s15-" style="top:0px;left:0px;"><span class="s16-">{{ $data->VendorName }}</span></div>
        </div>
        <div title="" class="txtDateIssued s57-" style="position:absolute;overflow:hidden;left:633px;top:123px;width:87px;height:19px;">
            <div class="s15-" style="top:0px;left:0px;"><span class="s16-">{{ $data->DateIssued }}</span></div>
        </div>
        <div title="" class="pageFooterSection1 s0-" style="position:absolute;overflow:hidden;left:38px;top:1013px;width:740px;height:5px;"></div>
    </div>
    <div title="" style="position:absolute;left:38px;top:38px;width:0px;height:979px;"></div>
    <div title="" style="position:absolute;left:777px;top:38px;width:0px;height:979px;"></div>
    <div title="" style="position:absolute;left:38px;top:38px;width:739px;height:0px;"></div>
    <div title="" style="position:absolute;left:38px;top:1017px;width:739px;height:0px;"></div>
</div>

@php($counter=1)
@php($xOrderItems = $data->OrderItems);
@foreach($data->OrderItems as $orderItem)
    @php
    $counter++;
    $pr = $orderItem->Requisition();
    if(!isset($prev)) {
        $prev = $orderItem->Requisition();
    }
    else {
        if($prev->OrderNumber == $purchaseRequest->OrderNumber) {
            continue;
        }
    }
    if($pr) {

        $user = App\User::where('ID','=',$pr->Requester)->first();

        $department = $pr->Department()->Name;
        $purpose = $pr->Purpose;
        $date = $pr->Date;
        $orderNumber = $pr->OrderNumber;

        $requester = $user->Person()->AbbreviatedName();
        $orderedBy = $user->Username; // nag order

        $checkedBy = App\Role::FindUserWithRole("PurchasingManager")->Username; // Purchasing Manager
        $approvedBy = App\Role::FindUserWithRole("PlantManager")->Username;; // Plant Manager

        $timeRequested = $pr->Date->format('h:i:s A -');
        $dateRequested = $pr->Date->format('n/j/Y');


        $c = collect($pr->OrderItems());
        $timeChecked_raw = $c->sortBy('created_at', SORT_REGULAR, true)->first();

        $timeChecked = $timeChecked_raw->created_at->format('h:i:s A -');
        $dateChecked = $timeChecked_raw->created_at->format('n/j/Y');

        $dto = new \App\Classes\DTO\DTO();
        $dto->Department = $department;
        $dto->Requester = $requester;
        $dto->Purpose = $purpose;
        $dto->Date = $date->format('n/j/Y');
        $dto->OrderNumber = $orderNumber;
        $dto->OrderedBy = sprintf("%s / %s", $orderedBy, $timeRequested);
        $dto->DateRequested = $dateRequested;
        $dto->CheckedBy = sprintf("%s / %s", $checkedBy, $timeChecked);
        $dto->DateChecked = $dateChecked;
        $dto->Page = "page{$counter}";
        $dto->LineItems = $pr->LineItems();
        $dto->PurchaseOrderNumber = $data->PurchaseOrderNumber;
        if($pr->Status == 'A') {
            $timeApproved = $pr->updated_at->format('h:i:s A -');
            $dateApproved = $pr->updated_at->format('n/j/Y');
            $dto->ApprovedBy = sprintf("%s / %s", $approvedBy, $timeApproved);
            $dto->DateApproved = $dateApproved;
        }
        else {
            $dto->ApprovedBy = "";
            $dto->DateApproved = "";
        }

        $data = $dto;
        // return view('report.templates.canvassreport',['data'=>$dto]);

//                $pdf = \PDF::loadView('report.templates.canvassreport',['data'=>$dto]);
//                $pdf->setPaper('letter','landscape');
//                return $pdf->download('testinvoice.pdf');

    } else {
        $data = new \App\Classes\DTO\DTO();
        $data->Title = "Purchase Request $purchaseRequest";
        $data->Class = "Purchase Request";
        $data->Description = "We cannot not find the $data->Class in the database.";
        return response()
            ->view('errors.404',['data'=>$data]
                ,404);
    }

    @endphp
    
    <div class="crsheet {{$data->Page??'page1'}}" id="capture2" style="padding-left:38px;padding-right:38px;padding-top:38px;padding-bottom:38px;width:979px;height:739px;">
        <div class="crlayer">
            <div title="" class="CanvassReport cr0-" style="position:absolute;overflow:hidden;left:38px;top:182px;width:980px;height:580px;"></div>
            <div title="" class="Group cr0-" style="position:absolute;overflow:hidden;left:38px;top:182px;width:980px;height:580px;"></div>
            <div title="" class="detail cr0-" style="position:absolute;overflow:hidden;left:38px;top:182px;width:980px;height:316px;"></div>
            <div title="" class="table1 cr1-" style="position:absolute;overflow:hidden;left:38px;top:182px;width:502px;height:316px;"></div>
    
            <div title="" class="textBox12 cr2-" style="position:absolute;overflow:hidden;left:38px;top:182px;width:52px;height:18px;">
                <div style="position:absolute;top:1px;white-space:pre;left:17px;">Qty</div>
            </div>
            <div title="" class="textBox20 cr2-" style="position:absolute;overflow:hidden;left:95px;top:182px;width:52px;height:18px;">
                <div style="position:absolute;top:1px;white-space:pre;left:16px;">Unit</div>
            </div>
            <div title="" class="textBox18 cr3-" style="position:absolute;overflow:hidden;left:152px;top:182px;width:101px;height:18px;">
                <div style="position:absolute;top:1px;white-space:pre;left:3px;">Inventory Code</div>
            </div>
            <div title="" class="textBox14 cr2-" style="position:absolute;overflow:hidden;left:258px;top:182px;width:74px;height:18px;">
                <div style="position:absolute;top:1px;white-space:pre;left:12px;">GL Code</div>
            </div>
            <div title="" class="textBox16 cr4-" style="position:absolute;overflow:hidden;left:337px;top:182px;width:199px;height:18px;">
                <div style="position:absolute;top:1px;white-space:pre;left:3px;">Description</div>
            </div>
    
            @php($counter=0)
            @php($y=200)
    
            @foreach($data->LineItems as $lineItem)
                @php($orderItem = $lineItem->OrderItem())
                @php($product = $lineItem->Product())
                @php($quote = $orderItem->SelectedQuote())
                @if($counter<9)
                    <div title="" class="cr5-" style="position:absolute;overflow:hidden;left:38px;top:{{$y}}px;width:52px;height:30px; border-bottom: 1px solid black;">
                        {{ $lineItem->Quantity }}
                    </div>
                    <div title="" class="cr5-" style="position:absolute;overflow:hidden;left:95px;top:{{$y}}px;width:52px;height:30px; border-bottom: 1px solid black;">
                        {{ $product->UOM()->Abbreviation }}
                    </div>
                    <div title="" class="cr6-" style="position:absolute;overflow:hidden;left:152px;top:{{$y}}px;width:101px;height:30px; border-bottom: 1px solid black;">
                        {{ $product->UniqueID }}
                    </div>
                    <div title="" class="cr6-" style="position:absolute;overflow:hidden;left:258px;top:{{$y}}px;width:74px;height:30px; border-bottom: 1px solid black;">
                        {{ $product->getGeneralLedger()->Code }}
                    </div>
                    <div title="" class="cr6-" style="position:absolute;overflow:hidden;left:337px;top:{{$y}}px;width:199px;height:30px; border-bottom: 1px solid black;">
                        {{ $product->Description }}
                    </div>
                    @php($y+=30)
                @else
                    <div title="" class="cr5-" style="position:absolute;overflow:hidden;left:38px;top:{{$y}}px;width:52px;height:30px;">
                        {{ $lineItem->Quantity }}
                    </div>
                    <div title="" class="cr5-" style="position:absolute;overflow:hidden;left:95px;top:{{$y}}px;width:52px;height:30px;">
                        {{ $product->UOM()->Abbreviation }}
                    </div>
                    <div title="" class="cr6-" style="position:absolute;overflow:hidden;left:152px;top:{{$y}}px;width:101px;height:30px;">
                        {{ $product->UniqueID }}
                    </div>
                    <div title="" class="cr6-" style="position:absolute;overflow:hidden;left:258px;top:{{$y}}px;width:74px;height:30px;">
                        {{ $product->getGeneralLedger()->Code }}
                    </div>
                    <div title="" class="cr6-" style="position:absolute;overflow:hidden;left:337px;top:{{$y}}px;width:199px;height:30px;">
                        {{ $product->Description }}
                    </div>
                @endif
                @php($counter++)
            @endforeach
    
    
            @for($i=$counter;$i<10;$i++)
                @if($i<9)
                    <div title="" class="cr5-" style="position:absolute;overflow:hidden;left:38px;top:{{$y}}px;width:52px;height:30px; border-bottom: 1px solid black;"></div>
                    <div title="" class="cr5-" style="position:absolute;overflow:hidden;left:95px;top:{{$y}}px;width:52px;height:30px; border-bottom: 1px solid black;"></div>
                    <div title="" class="cr6-" style="position:absolute;overflow:hidden;left:152px;top:{{$y}}px;width:101px;height:30px; border-bottom: 1px solid black;"></div>
                    <div title="" class="cr6-" style="position:absolute;overflow:hidden;left:258px;top:{{$y}}px;width:74px;height:30px; border-bottom: 1px solid black;"></div>
                    <div title="" class="cr6-" style="position:absolute;overflow:hidden;left:337px;top:{{$y}}px;width:199px;height:30px; border-bottom: 1px solid black;"></div>
                    @php($y+=30)
                @else
                    <div title="" class="cr5-" style="position:absolute;overflow:hidden;left:38px;top:{{$y}}px;width:52px;height:30px;"></div>
                    <div title="" class="cr5-" style="position:absolute;overflow:hidden;left:95px;top:{{$y}}px;width:52px;height:30px;"></div>
                    <div title="" class="cr6-" style="position:absolute;overflow:hidden;left:152px;top:{{$y}}px;width:101px;height:30px;"></div>
                    <div title="" class="cr6-" style="position:absolute;overflow:hidden;left:258px;top:{{$y}}px;width:74px;height:30px;"></div>
                    <div title="" class="cr6-" style="position:absolute;overflow:hidden;left:337px;top:{{$y}}px;width:199px;height:30px;"></div>
                @endif
            @endfor
    
    
    
    
    
            <div title="" class="table2 cr1-" style="position:absolute;overflow:hidden;left:560px;top:182px;width:446px;height:316px;"></div>
            <div title="" class="textBox117 cr2-" style="position:absolute;overflow:hidden;left:560px;top:182px;width:71px;height:18px;">
                <div style="position:absolute;top:1px;white-space:pre;left:5px;">SUPPLIER</div>
            </div>
            <div title="" class="textBox118 cr8-" style="position:absolute;overflow:hidden;left:636px;top:182px;width:67px;height:18px;">
                <div style="position:absolute;top:1px;white-space:pre;left:16px;">PRICE</div>
            </div>
            <div title="" class="textBox119 cr9-" style="position:absolute;overflow:hidden;left:709px;top:182px;width:64px;height:18px;">
                <div style="position:absolute;top:1px;white-space:pre;left:16px;">DATE</div>
            </div>
            <div title="" class="textBox120 cr10-" style="position:absolute;overflow:hidden;left:777px;top:182px;width:143px;height:19px;"></div>
            <div title="" class="textBox121 cr11-" style="position:absolute;overflow:hidden;left:926px;top:182px;width:77px;height:18px;">
                <div style="position:absolute;top:1px;white-space:pre;left:3px;">Amount</div>
            </div>
    
    
            @php($counter=0)
            @php($y=200)
    
            @foreach($data->LineItems as $lineItem)
                @php($orderItem = $lineItem->OrderItem())
                @php($product = $lineItem->Product())
                @php($quote = $orderItem->SelectedQuote())
                @if($counter<9)
                    <div title="" class="cr5-" style="position:absolute;overflow:hidden;left:560px;top:{{$y}}px;width:71px;height:30px; border-bottom: 1px solid black;">
                        {{ $quote->Supplier()->Code }}
                    </div>
                    <div title="" class="cr12-" style="position:absolute;overflow:hidden;left:636px;top:{{$y}}px;width:67px;height:30px; border-bottom: 1px solid black;">
                        {{ number_format($quote->Amount,2,'.',',') }}
                    </div>
                    <div title="" class="cr13-" style="position:absolute;overflow:hidden;left:709px;top:{{$y}}px;width:64px;height:30px; border-bottom: 1px solid black;">
                        {{ $orderItem->created_at->format('n/d/Y') }}
                    </div>
                    <div title="" class="cr14-" style="position:absolute;overflow:hidden;left:777px;top:{{$y}}px;width:143px;height:30px; border-bottom: 1px solid black;"></div>
                    <div title="" class="cr13-" style="position:absolute;overflow:hidden;left:926px;top:{{$y}}px;width:77px;height:30px; border-bottom: 1px solid black;">
                        {{ number_format($lineItem->Quantity * $quote->Amount,2,'.',',') }}
                    </div>
                    @php($y+=30)
                @else
                    <div title="" class="cr5-" style="position:absolute;overflow:hidden;left:560px;top:{{$y}}px;width:71px;height:30px;">
                        {{ $quote->Supplier()->Code }}
                    </div>
                    <div title="" class="cr12-" style="position:absolute;overflow:hidden;left:636px;top:{{$y}}px;width:67px;height:30px;">
                        {{ number_format($quote->Amount,2,'.',',') }}
                    </div>
                    <div title="" class="cr13-" style="position:absolute;overflow:hidden;left:709px;top:{{$y}}px;width:64px;height:30px;">
                        {{ $orderItem->created_at->format('n/d/Y') }}
                    </div>
                    <div title="" class="cr14-" style="position:absolute;overflow:hidden;left:777px;top:{{$y}}px;width:143px;height:30px;"></div>
                    <div title="" class="cr13-" style="position:absolute;overflow:hidden;left:926px;top:{{$y}}px;width:77px;height:30px;">
                        {{ number_format($lineItem->Quantity * $quote->Amount,2,'.',',') }}
                    </div>
                @endif
                @php($counter++)
            @endforeach
    
    
            @for($i=$counter;$i<10;$i++)
                @if($i<9)
                    <div title="" class="cr5-" style="position:absolute;overflow:hidden;left:560px;top:{{$y}}px;width:71px;height:30px; border-bottom: 1px solid black;"></div>
                    <div title="" class="cr12-" style="position:absolute;overflow:hidden;left:636px;top:{{$y}}px;width:67px;height:30px; border-bottom: 1px solid black;"></div>
                    <div title="" class="cr13-" style="position:absolute;overflow:hidden;left:709px;top:{{$y}}px;width:64px;height:30px; border-bottom: 1px solid black;"></div>
                    <div title="" class="cr14-" style="position:absolute;overflow:hidden;left:777px;top:{{$y}}px;width:143px;height:30px; border-bottom: 1px solid black;"></div>
                    <div title="" class="cr13-" style="position:absolute;overflow:hidden;left:926px;top:{{$y}}px;width:77px;height:30px; border-bottom: 1px solid black;"></div>
                    @php($y+=30)
                @else
                    <div title="" class="cr5-" style="position:absolute;overflow:hidden;left:560px;top:{{$y}}px;width:71px;height:30px;"></div>
                    <div title="" class="cr12-" style="position:absolute;overflow:hidden;left:636px;top:{{$y}}px;width:67px;height:30px;"></div>
                    <div title="" class="cr13-" style="position:absolute;overflow:hidden;left:709px;top:{{$y}}px;width:64px;height:30px;"></div>
                    <div title="" class="cr14-" style="position:absolute;overflow:hidden;left:777px;top:{{$y}}px;width:143px;height:30px;"></div>
                    <div title="" class="cr13-" style="position:absolute;overflow:hidden;left:926px;top:{{$y}}px;width:77px;height:30px;"></div>
                @endif
            @endfor
            
            
            <div title="" class="reportFooterSection1 cr0-" style="position:absolute;overflow:hidden;left:38px;top:498px;width:980px;height:264px;"></div>
            <div title="" class="table3 cr15-" style="position:absolute;overflow:hidden;left:39px;top:511px;width:321px;height:142px;"></div>
            <div title="" class="textBox115 cr16-" style="position:absolute;overflow:hidden;left:39px;top:511px;width:315px;height:23px;">
                <div style="position:absolute;top:0px;white-space:pre;left:3px;">Remarks:</div>
            </div>
            <div title="" class="textBox123 cr17-" style="position:absolute;overflow:hidden;left:39px;top:534px;width:315px;height:23px;"></div>
            <div title="" class="textBox124 cr18-" style="position:absolute;overflow:hidden;left:39px;top:557px;width:314px;height:18px;">{{ $data->Purpose }}</div>
            <div title="" class="textBox125 cr19-" style="position:absolute;overflow:hidden;left:39px;top:576px;width:314px;height:19px;"></div>
            <div title="" class="textBox127 cr19-" style="position:absolute;overflow:hidden;left:39px;top:595px;width:314px;height:20px;"></div>
            <div title="" class="textBox128 cr19-" style="position:absolute;overflow:hidden;left:39px;top:615px;width:314px;height:19px;"></div>
            <div title="" class="textBox126 cr19-" style="position:absolute;overflow:hidden;left:39px;top:634px;width:314px;height:19px;"></div>
            <div title="" class="table4 cr15-" style="position:absolute;overflow:hidden;left:547px;top:511px;width:293px;height:142px;"></div>
            <div title="" class="textBox135 cr20-" style="position:absolute;overflow:hidden;left:547px;top:511px;width:288px;height:23px;">
                <div style="position:absolute;top:0px;white-space:pre;left:3px;">Purchasing Remarks:</div>
            </div>
            <div title="" class="textBox129 cr21-" style="position:absolute;overflow:hidden;left:547px;top:534px;width:288px;height:23px;"></div>
            <div title="" class="textBox130 cr22-" style="position:absolute;overflow:hidden;left:547px;top:557px;width:287px;height:18px;"></div>
            <div title="" class="textBox131 cr23-" style="position:absolute;overflow:hidden;left:547px;top:576px;width:287px;height:19px;"></div>
            <div title="" class="textBox133 cr23-" style="position:absolute;overflow:hidden;left:547px;top:595px;width:287px;height:20px;"></div>
            <div title="" class="textBox134 cr23-" style="position:absolute;overflow:hidden;left:547px;top:615px;width:287px;height:19px;"></div>
            <div title="" class="textBox132 cr23-" style="position:absolute;overflow:hidden;left:547px;top:634px;width:287px;height:19px;"></div>
            <div title="" class="textBox137 cr24-" style="position:absolute;overflow:hidden;left:843px;top:552px;width:55px;height:19px;">
                <div style="position:absolute;top:0px;white-space:pre;left:3px;">TOTAL</div>
            </div>
            <div title="" class="txtTotal cr25-" style="position:absolute;overflow:hidden;left:927px;top:552px;width:86px;height:19px;">
                <div style="position:absolute;top:0px;white-space:pre;left:3px;"> </div>
            </div>
            <div title="" class="txtDiscount cr25-" style="position:absolute;overflow:hidden;left:927px;top:578px;width:85px;height:18px;">
                <div style="position:absolute;top:0px;white-space:pre;left:3px;"> </div>
            </div>
            <div title="" class="textBox139 cr26-" style="position:absolute;overflow:hidden;left:843px;top:578px;width:78px;height:16px;">
                <div style="position:absolute;top:2px;white-space:pre;left:3px;">% DISCOUNT</div>
            </div>
            <div title="" class="textBox140 cr26-" style="position:absolute;overflow:hidden;left:843px;top:604px;width:78px;height:16px;">
                <div style="position:absolute;top:2px;white-space:pre;left:3px;">NET TOTAL</div>
            </div>
            <div title="" class="txtNetTotal cr25-" style="position:absolute;overflow:hidden;left:927px;top:604px;width:86px;height:18px;">
                <div style="position:absolute;top:0px;white-space:pre;left:3px;"> </div>
            </div>
            <div title="" class="textBox142 cr27-" style="position:absolute;overflow:hidden;left:843px;top:645px;width:70px;height:21px;">
                <div style="position:absolute;top:0px;white-space:pre;left:3px;">P.R. No.</div>
            </div>
            <div title="" class="txtPRNumber cr28-" style="position:absolute;overflow:hidden;left:919px;top:642px;width:91px;height:23px;">
                <div style="position:absolute;top:5px;white-space:pre;left:3px;">{{ $data->OrderNumber }}</div>
            </div>
            <div title="" class="table5 cr15-" style="position:absolute;overflow:hidden;left:50px;top:670px;width:166px;height:82px;"></div>
            <div title="" class="textBox144 cr21-" style="position:absolute;overflow:hidden;left:50px;top:670px;width:161px;height:23px;">
                <div style="position:absolute;top:0px;white-space:pre;left:3px;">Ordered By:</div>
            </div>
            <div title="" class="textBox145 cr21-" style="position:absolute;overflow:hidden;left:50px;top:693px;width:161px;height:21px;"></div>
            <div title="" class="txtOrderedBy cr21-" style="position:absolute;overflow:hidden;left:50px;top:714px;width:161px;height:19px;">
                <div style="position:absolute;top:0px;white-space:pre;left:3px;">{{ $data->OrderedBy }}</div>
            </div>
            <div title="" class="txtOrderedByDate cr29-" style="position:absolute;overflow:hidden;left:50px;top:733px;width:161px;height:19px;">{{ $data->DateRequested }}</div>
            <div title="" class="table6 cr15-" style="position:absolute;overflow:hidden;left:258px;top:670px;width:167px;height:82px;"></div>
            <div title="" class="textBox151 cr17-" style="position:absolute;overflow:hidden;left:258px;top:670px;width:161px;height:23px;">
                <div style="position:absolute;top:0px;white-space:pre;left:3px;">Checked By:</div>
            </div>
            <div title="" class="textBox148 cr17-" style="position:absolute;overflow:hidden;left:258px;top:693px;width:161px;height:21px;"></div>
            <div title="" class="txtCheckedBy cr17-" style="position:absolute;overflow:hidden;left:258px;top:714px;width:161px;height:19px;">{{ $data->CheckedBy }}</div>
            <div title="" class="txtCheckedByDate cr30-" style="position:absolute;overflow:hidden;left:258px;top:733px;width:161px;height:19px;">{{ $data->DateChecked }}</div>
            <div title="" class="table7 cr15-" style="position:absolute;overflow:hidden;left:462px;top:670px;width:166px;height:82px;"></div>
            <div title="" class="textBox155 cr21-" style="position:absolute;overflow:hidden;left:462px;top:670px;width:161px;height:23px;">
                <div style="position:absolute;top:0px;white-space:pre;left:3px;">Approved By:</div>
            </div>
            <div title="" class="textBox152 cr21-" style="position:absolute;overflow:hidden;left:462px;top:693px;width:161px;height:21px;"></div>
            <div title="" class="txtApprovedBy cr21-" style="position:absolute;overflow:hidden;left:462px;top:714px;width:161px;height:19px;">{{ $data->ApprovedBy }}</div>
            <div title="" class="txtApprovedByDate cr29-" style="position:absolute;overflow:hidden;left:462px;top:733px;width:161px;height:19px;">{{ $data->DateApproved }}</div>
            <div title="" class="pageHeaderSection1 cr0-" style="position:absolute;overflow:hidden;left:38px;top:38px;width:980px;height:144px;"></div>
            <div title="" class="pictureBox1 cr0-" style="position:absolute;overflow:hidden;left:401px;top:39px;width:254px;height:46px;"><img alt="" src="data:image/png;base64,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" style="position:absolute;text-align:left;top:2px;left:0px;width:255px;height:41px;" /></div>
            <div title="" class="htmlTextBox1 cr31-" style="position:absolute;overflow:hidden;left:303px;top:91px;width:443px;height:22px;">
                <div class="cr32-" style="top:2px;left:43px;"><span class="cr33-">PURCHASE REQUISITION / CANVASS REPORT</span></div>
            </div>
            <div title="" class="textBox1 cr20-" style="position:absolute;overflow:hidden;left:365px;top:116px;width:35px;height:16px;">
                <div style="position:absolute;top:0px;white-space:pre;left:3px;">Date:</div>
            </div>
            <div title="" class="txtDate cr30-" style="position:absolute;overflow:hidden;left:405px;top:116px;width:96px;height:16px;">
                <div style="position:absolute;top:0px;white-space:pre;left:3px;">{{ $data->Date }}</div>
            </div>
            <div title="" class="textBox3 cr34-" style="position:absolute;overflow:hidden;left:818px;top:84px;width:192px;height:15px;">
                <div style="position:absolute;top:0px;white-space:pre;left:3px;">Form Control No. WHS-00-2006</div>
            </div>
            <div title="" class="textBox4 cr29-" style="position:absolute;overflow:hidden;left:846px;top:66px;width:166px;height:16px;">
                <div style="position:absolute;top:0px;white-space:pre;left:3px;"> </div>
            </div>
            <div title="" class="textBox5 cr35-" style="position:absolute;overflow:hidden;left:877px;top:39px;width:128px;height:16px;">
                <div style="position:absolute;top:0px;white-space:pre;left:5px;">CANVASS REPORT</div>
            </div>
            <div title="" class="textBox7 cr36-" style="position:absolute;overflow:hidden;left:38px;top:116px;width:97px;height:16px;">
                <div style="position:absolute;top:0px;white-space:pre;left:3px;">Department:</div>
            </div>
            <div title="" class="txtDepartment cr37-" style="position:absolute;overflow:hidden;left:140px;top:116px;width:92px;height:16px;">
                <div style="position:absolute;top:0px;white-space:pre;left:8px;">{{ $data->Department }}</div>
            </div>
            <div title="" class="textBox8 cr36-" style="position:absolute;overflow:hidden;left:38px;top:133px;width:97px;height:15px;">
                <div style="position:absolute;top:0px;white-space:pre;left:3px;">Requested By:</div>
            </div>
            <div title="" class="textBox9 cr36-" style="position:absolute;overflow:hidden;left:38px;top:150px;width:97px;height:16px;">
                <div style="position:absolute;top:0px;white-space:pre;left:3px;">Purpose:</div>
            </div>
            <div title="" class="txtRequestedBy cr37-" style="position:absolute;overflow:hidden;left:140px;top:133px;width:92px;height:15px;">
                <div style="position:absolute;top:0px;white-space:pre;left:8px;">{{ $data->Requester }}</div>
            </div>
            <div title="" class="txtPurpose cr38-" style="position:absolute;overflow:hidden;left:140px;top:150px;width:194px;height:16px;">
                <div style="position:absolute;top:0px;white-space:pre;left:8px;">{{ $data->Purpose }}</div>
            </div>
        </div>
        <div title="" style="position:absolute;left:38px;top:38px;width:0px;height:739px;"></div>
        <div title="" style="position:absolute;left:1017px;top:38px;width:0px;height:739px;"></div>
        <div title="" style="position:absolute;left:38px;top:38px;width:979px;height:0px;"></div>
        <div title="" style="position:absolute;left:38px;top:777px;width:979px;height:0px;"></div>
    </div>
@endforeach


<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/html2canvas.min.js') }}"></script>
<script src="{{ asset('js/jspdf.min.js') }}"></script>
<script>
/// FINALLY WORKING PDF CODE. AYOS NA.
$(document).ready(function(){

    disableScroll();

    var doc = new jsPDF('p', 'in', [8.5, 11]);
    html2canvas($('#capture'),{
        onrendered: function (canvas) {
            var imgData = canvas.toDataURL(
                'image/png');
            doc.addImage(imgData, 'PNG', 0, 0, 0, 0);
            doc.addPage(11, 8.5);
            // doc.save('{{ $data->PurchaseOrderNumber }}.pdf');
        }
    });

    @php($x=2)
    @foreach($xOrderItems as $orderItem)
        @php
            $purchaseRequest = $orderItem->Requisition();
            if(!isset($prevOrder)) {
                $prevOrder = $purchaseRequest;
            }
            else {
                if($prevOrder->OrderNumber == $purchaseRequest->OrderNumber) {
                    continue;
                }
            }
        @endphp
        html2canvas($('#capture'+{{$x}}),{
            onrendered: function (canvas) {
                var imgData = canvas.toDataURL(
                    'image/png');
                doc.addImage(imgData, 'PNG', 0, 0, 0, 0, null,null, -90); 
                // img, 'JPEG', adjustedX, adjustedY, adjustedWidth, adjustedHeight, null, -90
                doc.save('{{ $data->PurchaseOrderNumber }}.pdf');
            }
        });
        @php($x++)
    @endforeach
    
    
    enableScroll();
});

// left: 37, up: 38, right: 39, down: 40,
// spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
var keys = {37: 1, 38: 1, 39: 1, 40: 1};

function preventDefault(e) {
  e = e || window.event;
  if (e.preventDefault)
      e.preventDefault();
  e.returnValue = false;  
}

function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
        preventDefault(e);
        return false;
    }
}

function disableScroll() {
  if (window.addEventListener) // older FF
      window.addEventListener('DOMMouseScroll', preventDefault, false);
  document.addEventListener('wheel', preventDefault, {passive: false}); // Disable scrolling in Chrome
  window.onwheel = preventDefault; // modern standard
  window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
  window.ontouchmove  = preventDefault; // mobile
  document.onkeydown  = preventDefaultForScrollKeys;
}

function enableScroll() {
    if (window.removeEventListener)
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
    document.removeEventListener('wheel', preventDefault, {passive: false}); // Enable scrolling in Chrome
    window.onmousewheel = document.onmousewheel = null; 
    window.onwheel = null; 
    window.ontouchmove = null;  
    document.onkeydown = null;  
}
</script>
</body>

</html>