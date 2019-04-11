<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Canvass Report - {{ $data->OrderNumber }}</title>
    <meta charset="UTF-8" />
    <style type="text/css">
        html { margin: 0px;
            page-break-inside: auto;
        }

        div.html-root>ol, div.html-root>ul, div.html-root>p
        {
            margin-top: 0px;
        }
        .sheet .error
        {
            border: 1px solid red;
            color: red;
        }
        /* interactive page */
        .interactive-page .sheet
        {
            margin: 10px;
        }
        /* print preview page */
        .print-page
        {
            background-color: #ccc;
        }
        .print-page > .sheet
        {
            margin-left: auto;
            margin-right: auto;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .sheet .layer
        {
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0px;
            top: 0px;
        }
        .sheet .action
        {
            cursor: pointer;
        }
        .sheet div.action:hover
        {
            border: 1px solid #ddd;
        }
        .sheet
        {
            position: relative;
            text-rendering: geometricPrecision;
        }
        .sheet {background-color:White}
        .s0- {padding-left:0px;padding-right:0px;padding-top:0px;padding-bottom:0px}
        .s1- {font-family:Arial;font-size:10pt;color:Black;text-align:start;padding-left:0px;padding-right:0px;padding-top:0px;padding-bottom:0px;border-left:1px solid Black;border-top:1px solid Black;border-right:1px solid Black;border-bottom:1px solid Black}
        .s2- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:center;word-wrap:break-word;padding-left:3px;padding-right:2px;padding-top:1px;padding-bottom:0px;border-right:1px solid Black;border-bottom:1px solid Black}
        .s3- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:2px;padding-top:1px;padding-bottom:0px;border-right:1px solid Black;border-bottom:1px solid Black}
        .s4- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:2px;padding-top:1px;padding-bottom:0px;border-bottom:1px solid Black}
        .s5- {font-family:Arial;font-size:9pt;color:Black;text-align:center;word-wrap:break-word;padding-left:3px;padding-right:2px;padding-top:0px;padding-bottom:0px;border-right:1px solid Black;}
        .s6- {font-family:Arial;font-size:9pt;color:Black;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:2px;padding-top:0px;padding-bottom:0px;border-right:1px solid Black;}
        .s7- {font-family:Arial;font-size:10pt;color:Black;text-align:center;word-wrap:break-word;padding-left:3px;padding-right:2px;padding-top:0px;padding-bottom:0px;border-right:1px solid Black;border-bottom:1px solid Black}
        .s8- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:center;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:1px;padding-bottom:0px;border-right:1px solid Black;border-bottom:1px solid Black}
        .s9- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:center;word-wrap:break-word;padding-left:2px;padding-right:2px;padding-top:1px;padding-bottom:0px;border-right:1px solid Black;border-bottom:1px solid Black}
        .s10- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:center;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-right:1px solid Black;border-bottom:1px solid Black}
        .s11- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:2px;padding-right:2px;padding-top:1px;padding-bottom:0px;border-bottom:1px solid Black}
        .s12- {font-family:Arial;font-size:9pt;color:Black;text-align:center;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-right:1px solid Black;}
        .s13- {font-family:Arial;font-size:9pt;color:Black;text-align:center;word-wrap:break-word;padding-left:2px;padding-right:2px;padding-top:0px;padding-bottom:0px;border-right:1px solid Black;}
        .s14- {font-family:Arial;font-size:9pt;color:Black;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-right:1px solid Black;}
        .s15- {font-family:Arial;font-size:10pt;color:Black;text-align:start;padding-left:0px;padding-right:0px;padding-top:0px;padding-bottom:0px}
        .s16- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px}
        .s17- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px}
        .s18- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-left:1px solid Black;border-top:1px solid Black;border-right:1px solid Black;border-bottom:1px solid Black}
        .s19- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-left:1px solid Black;border-right:1px solid Black;border-bottom:1px solid Black}
        .s20- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:2px;padding-right:3px;padding-top:0px;padding-bottom:0px}
        .s21- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:2px;padding-right:3px;padding-top:0px;padding-bottom:0px}
        .s22- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:2px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-left:1px solid Black;border-top:1px solid Black;border-right:1px solid Black;border-bottom:1px solid Black}
        .s23- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:2px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-left:1px solid Black;border-right:1px solid Black;border-bottom:1px solid Black}
        .s24- {font-family:Arial;font-size:12pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px}
        .s25- {font-family:Arial;font-size:12pt;color:Black;text-align:start;word-wrap:break-word;padding-left:2px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-bottom:1px solid Black}
        .s26- {font-family:Arial;font-size:9pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:2px;padding-bottom:0px}
        .s27- {font-family:Arial;font-size:14pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px}
        .s28- {font-family:Arial;font-size:12pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:2px;padding-top:5px;padding-bottom:0px}
        .s29- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:2px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-bottom:1px solid Black}
        .s30- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-bottom:1px solid Black}
        .s31- {font-family:Arial;font-size:12pt;color:Black;font-weight:bold;text-align:center;padding-left:3px;padding-right:2px;padding-top:0px;padding-bottom:0px;border-left:1px solid Black;border-top:1px solid Black;border-right:1px solid Black;border-bottom:1px solid Black}
        .s32- {font-family:Arial;font-size:12pt;color:Black;font-weight:bold;text-align:center;position:absolute;word-wrap:normal;white-space:nowrap}
        .s33- {font-family:Arial;font-size:12pt;color:Black;font-weight:bold;text-align:center;word-wrap:normal}
        .s34- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:2px;padding-top:0px;padding-bottom:0px}
        .s35- {font-family:Arial;font-size:10pt;color:Black;text-align:center;word-wrap:break-word;padding-left:3px;padding-right:3px;padding-top:0px;padding-bottom:0px}
        .s36- {font-family:Arial;font-size:10pt;color:Black;font-weight:bold;text-align:start;word-wrap:break-word;padding-left:3px;padding-right:2px;padding-top:0px;padding-bottom:0px}
        .s37- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:8px;padding-right:2px;padding-top:0px;padding-bottom:0px;border-bottom:1px solid Black}
        .s38- {font-family:Arial;font-size:10pt;color:Black;text-align:start;word-wrap:break-word;padding-left:8px;padding-right:3px;padding-top:0px;padding-bottom:0px;border-bottom:1px solid Black}

        /*]]>*/
    </style>
</head>
<body class="print-page">
<div class="sheet page1" style="padding-left:38px;padding-right:38px;padding-top:38px;padding-bottom:38px;width:979px;height:739px;">
    <div class="layer">
        <div title="" class="CanvassReport s0-" style="position:absolute;overflow:hidden;left:38px;top:182px;width:980px;height:580px;"></div>
        <div title="" class="Group s0-" style="position:absolute;overflow:hidden;left:38px;top:182px;width:980px;height:580px;"></div>
        <div title="" class="detail s0-" style="position:absolute;overflow:hidden;left:38px;top:182px;width:980px;height:316px;"></div>
        <div title="" class="table1 s1-" style="position:absolute;overflow:hidden;left:38px;top:182px;width:502px;height:316px;"></div>

        <div title="" class="textBox12 s2-" style="position:absolute;overflow:hidden;left:38px;top:182px;width:52px;height:18px;">
            <div style="position:absolute;top:1px;white-space:pre;left:17px;">Qty</div>
        </div>
        <div title="" class="textBox20 s2-" style="position:absolute;overflow:hidden;left:95px;top:182px;width:52px;height:18px;">
            <div style="position:absolute;top:1px;white-space:pre;left:16px;">Unit</div>
        </div>
        <div title="" class="textBox18 s3-" style="position:absolute;overflow:hidden;left:152px;top:182px;width:101px;height:18px;">
            <div style="position:absolute;top:1px;white-space:pre;left:3px;">Inventory Code</div>
        </div>
        <div title="" class="textBox14 s2-" style="position:absolute;overflow:hidden;left:258px;top:182px;width:74px;height:18px;">
            <div style="position:absolute;top:1px;white-space:pre;left:12px;">GL Code</div>
        </div>
        <div title="" class="textBox16 s4-" style="position:absolute;overflow:hidden;left:337px;top:182px;width:199px;height:18px;">
            <div style="position:absolute;top:1px;white-space:pre;left:3px;">Description</div>
        </div>

        @php($counter=0)
        @php($y=200)

        @foreach($data->LineItems as $lineItem)
            @php($orderItem = $lineItem->OrderItem())
            @php($product = $lineItem->Product())
            @php($quote = $orderItem->SelectedQuote())
            @if($counter<9)
                <div title="" class="s5-" style="position:absolute;overflow:hidden;left:38px;top:{{$y}}px;width:52px;height:30px; border-bottom: 1px solid black;">
                    {{ $lineItem->Quantity }}
                </div>
                <div title="" class="s5-" style="position:absolute;overflow:hidden;left:95px;top:{{$y}}px;width:52px;height:30px; border-bottom: 1px solid black;">
                    {{ $product->UOM()->Abbreviation }}
                </div>
                <div title="" class="s6-" style="position:absolute;overflow:hidden;left:152px;top:{{$y}}px;width:101px;height:30px; border-bottom: 1px solid black;">
                    {{ $product->UniqueID }}
                </div>
                <div title="" class="s6-" style="position:absolute;overflow:hidden;left:258px;top:{{$y}}px;width:74px;height:30px; border-bottom: 1px solid black;">
                    {{ $product->getGeneralLedger()->Code }}
                </div>
                <div title="" class="s6-" style="position:absolute;overflow:hidden;left:337px;top:{{$y}}px;width:199px;height:30px; border-bottom: 1px solid black;">
                    {{ $product->Description }}
                </div>
                @php($y+=30)
            @else
                <div title="" class="s5-" style="position:absolute;overflow:hidden;left:38px;top:{{$y}}px;width:52px;height:30px;">
                    {{ $lineItem->Quantity }}
                </div>
                <div title="" class="s5-" style="position:absolute;overflow:hidden;left:95px;top:{{$y}}px;width:52px;height:30px;">
                    {{ $product->UOM()->Abbreviation }}
                </div>
                <div title="" class="s6-" style="position:absolute;overflow:hidden;left:152px;top:{{$y}}px;width:101px;height:30px;">
                    {{ $product->UniqueID }}
                </div>
                <div title="" class="s6-" style="position:absolute;overflow:hidden;left:258px;top:{{$y}}px;width:74px;height:30px;">
                    {{ $product->getGeneralLedger()->Code }}
                </div>
                <div title="" class="s6-" style="position:absolute;overflow:hidden;left:337px;top:{{$y}}px;width:199px;height:30px;">
                    {{ $product->Description }}
                </div>
            @endif
            @php($counter++)
        @endforeach


        @for($i=$counter;$i<10;$i++)
            @if($i<9)
                <div title="" class="s5-" style="position:absolute;overflow:hidden;left:38px;top:{{$y}}px;width:52px;height:30px; border-bottom: 1px solid black;"></div>
                <div title="" class="s5-" style="position:absolute;overflow:hidden;left:95px;top:{{$y}}px;width:52px;height:30px; border-bottom: 1px solid black;"></div>
                <div title="" class="s6-" style="position:absolute;overflow:hidden;left:152px;top:{{$y}}px;width:101px;height:30px; border-bottom: 1px solid black;"></div>
                <div title="" class="s6-" style="position:absolute;overflow:hidden;left:258px;top:{{$y}}px;width:74px;height:30px; border-bottom: 1px solid black;"></div>
                <div title="" class="s6-" style="position:absolute;overflow:hidden;left:337px;top:{{$y}}px;width:199px;height:30px; border-bottom: 1px solid black;"></div>
                @php($y+=30)
            @else
                <div title="" class="s5-" style="position:absolute;overflow:hidden;left:38px;top:{{$y}}px;width:52px;height:30px;"></div>
                <div title="" class="s5-" style="position:absolute;overflow:hidden;left:95px;top:{{$y}}px;width:52px;height:30px;"></div>
                <div title="" class="s6-" style="position:absolute;overflow:hidden;left:152px;top:{{$y}}px;width:101px;height:30px;"></div>
                <div title="" class="s6-" style="position:absolute;overflow:hidden;left:258px;top:{{$y}}px;width:74px;height:30px;"></div>
                <div title="" class="s6-" style="position:absolute;overflow:hidden;left:337px;top:{{$y}}px;width:199px;height:30px;"></div>
            @endif
        @endfor





        <div title="" class="table2 s1-" style="position:absolute;overflow:hidden;left:560px;top:182px;width:446px;height:316px;"></div>
        <div title="" class="textBox117 s2-" style="position:absolute;overflow:hidden;left:560px;top:182px;width:71px;height:18px;">
            <div style="position:absolute;top:1px;white-space:pre;left:5px;">SUPPLIER</div>
        </div>
        <div title="" class="textBox118 s8-" style="position:absolute;overflow:hidden;left:636px;top:182px;width:67px;height:18px;">
            <div style="position:absolute;top:1px;white-space:pre;left:16px;">PRICE</div>
        </div>
        <div title="" class="textBox119 s9-" style="position:absolute;overflow:hidden;left:709px;top:182px;width:64px;height:18px;">
            <div style="position:absolute;top:1px;white-space:pre;left:16px;">DATE</div>
        </div>
        <div title="" class="textBox120 s10-" style="position:absolute;overflow:hidden;left:777px;top:182px;width:143px;height:19px;"></div>
        <div title="" class="textBox121 s11-" style="position:absolute;overflow:hidden;left:926px;top:182px;width:77px;height:18px;">
            <div style="position:absolute;top:1px;white-space:pre;left:3px;">Amount</div>
        </div>


        @php($counter=0)
        @php($y=200)

        @foreach($data->LineItems as $lineItem)
            @php($orderItem = $lineItem->OrderItem())
            @php($product = $lineItem->Product())
            @php($quote = $orderItem->SelectedQuote())
            @if($counter<9)
                <div title="" class="s5-" style="position:absolute;overflow:hidden;left:560px;top:{{$y}}px;width:71px;height:30px; border-bottom: 1px solid black;">
                    {{ $quote->Supplier()->Code }}
                </div>
                <div title="" class="s12-" style="position:absolute;overflow:hidden;left:636px;top:{{$y}}px;width:67px;height:30px; border-bottom: 1px solid black;">
                    {{ number_format($quote->Amount,2,'.',',') }}
                </div>
                <div title="" class="s13-" style="position:absolute;overflow:hidden;left:709px;top:{{$y}}px;width:64px;height:30px; border-bottom: 1px solid black;">
                    {{ $orderItem->created_at->format('n/d/Y') }}
                </div>
                <div title="" class="s14-" style="position:absolute;overflow:hidden;left:777px;top:{{$y}}px;width:143px;height:30px; border-bottom: 1px solid black;"></div>
                <div title="" class="s13-" style="position:absolute;overflow:hidden;left:926px;top:{{$y}}px;width:77px;height:30px; border-bottom: 1px solid black;">
                    {{ number_format($lineItem->Quantity * $quote->Amount,2,'.',',') }}
                </div>
                @php($y+=30)
            @else
                <div title="" class="s5-" style="position:absolute;overflow:hidden;left:560px;top:{{$y}}px;width:71px;height:30px;">
                    {{ $quote->Supplier()->Code }}
                </div>
                <div title="" class="s12-" style="position:absolute;overflow:hidden;left:636px;top:{{$y}}px;width:67px;height:30px;">
                    {{ number_format($quote->Amount,2,'.',',') }}
                </div>
                <div title="" class="s13-" style="position:absolute;overflow:hidden;left:709px;top:{{$y}}px;width:64px;height:30px;">
                    {{ $orderItem->created_at->format('n/d/Y') }}
                </div>
                <div title="" class="s14-" style="position:absolute;overflow:hidden;left:777px;top:{{$y}}px;width:143px;height:30px;"></div>
                <div title="" class="s13-" style="position:absolute;overflow:hidden;left:926px;top:{{$y}}px;width:77px;height:30px;">
                    {{ number_format($lineItem->Quantity * $quote->Amount,2,'.',',') }}
                </div>
            @endif
            @php($counter++)
        @endforeach


        @for($i=$counter;$i<10;$i++)
            @if($i<9)
                <div title="" class="s5-" style="position:absolute;overflow:hidden;left:560px;top:{{$y}}px;width:71px;height:30px; border-bottom: 1px solid black;"></div>
                <div title="" class="s12-" style="position:absolute;overflow:hidden;left:636px;top:{{$y}}px;width:67px;height:30px; border-bottom: 1px solid black;"></div>
                <div title="" class="s13-" style="position:absolute;overflow:hidden;left:709px;top:{{$y}}px;width:64px;height:30px; border-bottom: 1px solid black;"></div>
                <div title="" class="s14-" style="position:absolute;overflow:hidden;left:777px;top:{{$y}}px;width:143px;height:30px; border-bottom: 1px solid black;"></div>
                <div title="" class="s13-" style="position:absolute;overflow:hidden;left:926px;top:{{$y}}px;width:77px;height:30px; border-bottom: 1px solid black;"></div>
                @php($y+=30)
            @else
                <div title="" class="s5-" style="position:absolute;overflow:hidden;left:560px;top:{{$y}}px;width:71px;height:30px;"></div>
                <div title="" class="s12-" style="position:absolute;overflow:hidden;left:636px;top:{{$y}}px;width:67px;height:30px;"></div>
                <div title="" class="s13-" style="position:absolute;overflow:hidden;left:709px;top:{{$y}}px;width:64px;height:30px;"></div>
                <div title="" class="s14-" style="position:absolute;overflow:hidden;left:777px;top:{{$y}}px;width:143px;height:30px;"></div>
                <div title="" class="s13-" style="position:absolute;overflow:hidden;left:926px;top:{{$y}}px;width:77px;height:30px;"></div>
            @endif
        @endfor
        
        
        <div title="" class="reportFooterSection1 s0-" style="position:absolute;overflow:hidden;left:38px;top:498px;width:980px;height:264px;"></div>
        <div title="" class="table3 s15-" style="position:absolute;overflow:hidden;left:39px;top:511px;width:321px;height:142px;"></div>
        <div title="" class="textBox115 s16-" style="position:absolute;overflow:hidden;left:39px;top:511px;width:315px;height:23px;">
            <div style="position:absolute;top:0px;white-space:pre;left:3px;">Remarks:</div>
        </div>
        <div title="" class="textBox123 s17-" style="position:absolute;overflow:hidden;left:39px;top:534px;width:315px;height:23px;"></div>
        <div title="" class="textBox124 s18-" style="position:absolute;overflow:hidden;left:39px;top:557px;width:314px;height:18px;">{{ $data->Purpose }}</div>
        <div title="" class="textBox125 s19-" style="position:absolute;overflow:hidden;left:39px;top:576px;width:314px;height:19px;"></div>
        <div title="" class="textBox127 s19-" style="position:absolute;overflow:hidden;left:39px;top:595px;width:314px;height:20px;"></div>
        <div title="" class="textBox128 s19-" style="position:absolute;overflow:hidden;left:39px;top:615px;width:314px;height:19px;"></div>
        <div title="" class="textBox126 s19-" style="position:absolute;overflow:hidden;left:39px;top:634px;width:314px;height:19px;"></div>
        <div title="" class="table4 s15-" style="position:absolute;overflow:hidden;left:547px;top:511px;width:293px;height:142px;"></div>
        <div title="" class="textBox135 s20-" style="position:absolute;overflow:hidden;left:547px;top:511px;width:288px;height:23px;">
            <div style="position:absolute;top:0px;white-space:pre;left:3px;">Purchasing Remarks:</div>
        </div>
        <div title="" class="textBox129 s21-" style="position:absolute;overflow:hidden;left:547px;top:534px;width:288px;height:23px;"></div>
        <div title="" class="textBox130 s22-" style="position:absolute;overflow:hidden;left:547px;top:557px;width:287px;height:18px;"></div>
        <div title="" class="textBox131 s23-" style="position:absolute;overflow:hidden;left:547px;top:576px;width:287px;height:19px;"></div>
        <div title="" class="textBox133 s23-" style="position:absolute;overflow:hidden;left:547px;top:595px;width:287px;height:20px;"></div>
        <div title="" class="textBox134 s23-" style="position:absolute;overflow:hidden;left:547px;top:615px;width:287px;height:19px;"></div>
        <div title="" class="textBox132 s23-" style="position:absolute;overflow:hidden;left:547px;top:634px;width:287px;height:19px;"></div>
        <div title="" class="textBox137 s24-" style="position:absolute;overflow:hidden;left:843px;top:552px;width:55px;height:19px;">
            <div style="position:absolute;top:0px;white-space:pre;left:3px;">TOTAL</div>
        </div>
        <div title="" class="txtTotal s25-" style="position:absolute;overflow:hidden;left:927px;top:552px;width:86px;height:19px;">
            <div style="position:absolute;top:0px;white-space:pre;left:3px;"> </div>
        </div>
        <div title="" class="txtDiscount s25-" style="position:absolute;overflow:hidden;left:927px;top:578px;width:85px;height:18px;">
            <div style="position:absolute;top:0px;white-space:pre;left:3px;"> </div>
        </div>
        <div title="" class="textBox139 s26-" style="position:absolute;overflow:hidden;left:843px;top:578px;width:78px;height:16px;">
            <div style="position:absolute;top:2px;white-space:pre;left:3px;">% DISCOUNT</div>
        </div>
        <div title="" class="textBox140 s26-" style="position:absolute;overflow:hidden;left:843px;top:604px;width:78px;height:16px;">
            <div style="position:absolute;top:2px;white-space:pre;left:3px;">NET TOTAL</div>
        </div>
        <div title="" class="txtNetTotal s25-" style="position:absolute;overflow:hidden;left:927px;top:604px;width:86px;height:18px;">
            <div style="position:absolute;top:0px;white-space:pre;left:3px;"> </div>
        </div>
        <div title="" class="textBox142 s27-" style="position:absolute;overflow:hidden;left:843px;top:645px;width:70px;height:21px;">
            <div style="position:absolute;top:0px;white-space:pre;left:3px;">P.R. No.</div>
        </div>
        <div title="" class="txtPRNumber s28-" style="position:absolute;overflow:hidden;left:919px;top:642px;width:91px;height:23px;">
            <div style="position:absolute;top:5px;white-space:pre;left:3px;">{{ $data->OrderNumber }}</div>
        </div>
        <div title="" class="table5 s15-" style="position:absolute;overflow:hidden;left:50px;top:670px;width:166px;height:82px;"></div>
        <div title="" class="textBox144 s21-" style="position:absolute;overflow:hidden;left:50px;top:670px;width:161px;height:23px;">
            <div style="position:absolute;top:0px;white-space:pre;left:3px;">Ordered By:</div>
        </div>
        <div title="" class="textBox145 s21-" style="position:absolute;overflow:hidden;left:50px;top:693px;width:161px;height:21px;"></div>
        <div title="" class="txtOrderedBy s21-" style="position:absolute;overflow:hidden;left:50px;top:714px;width:161px;height:19px;">
            <div style="position:absolute;top:0px;white-space:pre;left:3px;">{{ $data->OrderedBy }}</div>
        </div>
        <div title="" class="txtOrderedByDate s29-" style="position:absolute;overflow:hidden;left:50px;top:733px;width:161px;height:19px;">{{ $data->DateRequested }}</div>
        <div title="" class="table6 s15-" style="position:absolute;overflow:hidden;left:258px;top:670px;width:167px;height:82px;"></div>
        <div title="" class="textBox151 s17-" style="position:absolute;overflow:hidden;left:258px;top:670px;width:161px;height:23px;">
            <div style="position:absolute;top:0px;white-space:pre;left:3px;">Checked By:</div>
        </div>
        <div title="" class="textBox148 s17-" style="position:absolute;overflow:hidden;left:258px;top:693px;width:161px;height:21px;"></div>
        <div title="" class="txtCheckedBy s17-" style="position:absolute;overflow:hidden;left:258px;top:714px;width:161px;height:19px;">{{ $data->CheckedBy }}</div>
        <div title="" class="txtCheckedByDate s30-" style="position:absolute;overflow:hidden;left:258px;top:733px;width:161px;height:19px;">{{ $data->DateChecked }}</div>
        <div title="" class="table7 s15-" style="position:absolute;overflow:hidden;left:462px;top:670px;width:166px;height:82px;"></div>
        <div title="" class="textBox155 s21-" style="position:absolute;overflow:hidden;left:462px;top:670px;width:161px;height:23px;">
            <div style="position:absolute;top:0px;white-space:pre;left:3px;">Approved By:</div>
        </div>
        <div title="" class="textBox152 s21-" style="position:absolute;overflow:hidden;left:462px;top:693px;width:161px;height:21px;"></div>
        <div title="" class="txtApprovedBy s21-" style="position:absolute;overflow:hidden;left:462px;top:714px;width:161px;height:19px;">{{ $data->ApprovedBy }}</div>
        <div title="" class="txtApprovedByDate s29-" style="position:absolute;overflow:hidden;left:462px;top:733px;width:161px;height:19px;">{{ $data->DateApproved }}</div>
        <div title="" class="pageHeaderSection1 s0-" style="position:absolute;overflow:hidden;left:38px;top:38px;width:980px;height:144px;"></div>
        <div title="" class="pictureBox1 s0-" style="position:absolute;overflow:hidden;left:401px;top:39px;width:254px;height:46px;"><img alt="" src="data:image/png;base64,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" style="position:absolute;text-align:left;top:2px;left:0px;width:255px;height:41px;" /></div>
        <div title="" class="htmlTextBox1 s31-" style="position:absolute;overflow:hidden;left:303px;top:91px;width:443px;height:22px;">
            <div class="s32-" style="top:2px;left:43px;"><span class="s33-">PURCHASE REQUISITION / CANVASS REPORT</span></div>
        </div>
        <div title="" class="textBox1 s20-" style="position:absolute;overflow:hidden;left:365px;top:116px;width:35px;height:16px;">
            <div style="position:absolute;top:0px;white-space:pre;left:3px;">Date:</div>
        </div>
        <div title="" class="txtDate s30-" style="position:absolute;overflow:hidden;left:405px;top:116px;width:96px;height:16px;">
            <div style="position:absolute;top:0px;white-space:pre;left:3px;">{{ $data->Date }}</div>
        </div>
        <div title="" class="textBox3 s34-" style="position:absolute;overflow:hidden;left:818px;top:84px;width:192px;height:15px;">
            <div style="position:absolute;top:0px;white-space:pre;left:3px;">Form Control No. WHS-00-2006</div>
        </div>
        <div title="" class="textBox4 s29-" style="position:absolute;overflow:hidden;left:846px;top:66px;width:166px;height:16px;">
            <div style="position:absolute;top:0px;white-space:pre;left:3px;"> </div>
        </div>
        <div title="" class="textBox5 s35-" style="position:absolute;overflow:hidden;left:877px;top:39px;width:128px;height:16px;">
            <div style="position:absolute;top:0px;white-space:pre;left:5px;">CANVASS REPORT</div>
        </div>
        <div title="" class="textBox7 s36-" style="position:absolute;overflow:hidden;left:38px;top:116px;width:97px;height:16px;">
            <div style="position:absolute;top:0px;white-space:pre;left:3px;">Department:</div>
        </div>
        <div title="" class="txtDepartment s37-" style="position:absolute;overflow:hidden;left:140px;top:116px;width:92px;height:16px;">
            <div style="position:absolute;top:0px;white-space:pre;left:8px;">{{ $data->Department }}</div>
        </div>
        <div title="" class="textBox8 s36-" style="position:absolute;overflow:hidden;left:38px;top:133px;width:97px;height:15px;">
            <div style="position:absolute;top:0px;white-space:pre;left:3px;">Requested By:</div>
        </div>
        <div title="" class="textBox9 s36-" style="position:absolute;overflow:hidden;left:38px;top:150px;width:97px;height:16px;">
            <div style="position:absolute;top:0px;white-space:pre;left:3px;">Purpose:</div>
        </div>
        <div title="" class="txtRequestedBy s37-" style="position:absolute;overflow:hidden;left:140px;top:133px;width:92px;height:15px;">
            <div style="position:absolute;top:0px;white-space:pre;left:8px;">{{ $data->Requester }}</div>
        </div>
        <div title="" class="txtPurpose s38-" style="position:absolute;overflow:hidden;left:140px;top:150px;width:194px;height:16px;">
            <div style="position:absolute;top:0px;white-space:pre;left:8px;">{{ $data->Purpose }}</div>
        </div>
    </div>
    <div title="" style="position:absolute;left:38px;top:38px;width:0px;height:739px;"></div>
    <div title="" style="position:absolute;left:1017px;top:38px;width:0px;height:739px;"></div>
    <div title="" style="position:absolute;left:38px;top:38px;width:979px;height:0px;"></div>
    <div title="" style="position:absolute;left:38px;top:777px;width:979px;height:0px;"></div>
</div>
</body>
</html>