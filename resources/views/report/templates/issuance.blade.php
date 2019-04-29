<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>{{ $data->OrderNumber }}</title>
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
            text-align: start;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 3px;
            padding-top: 13px;
            padding-bottom: 0px;
            border-top: 1px solid Black;
            border-bottom: 1px solid Black
        }

        .s3- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: end;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 8px;
            padding-top: 13px;
            padding-bottom: 0px;
            border-top: 1px solid Black;
            border-bottom: 1px solid Black
        }

        .s4- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: center;
            word-wrap: break-word;
            padding-left: 2px;
            padding-right: 2px;
            padding-top: 13px;
            padding-bottom: 0px;
            border-top: 1px solid Black;
            border-bottom: 1px solid Black
        }

        .s5- {
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

        .s6- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: start;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 8px;
            padding-top: 0px;
            padding-bottom: 0px
        }

        .s7- {
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

        .s8- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: start;
            padding-left: 0px;
            padding-right: 0px;
            padding-top: 0px;
            padding-bottom: 0px;
            border-top: 1px solid Black
        }

        .s9- {
            font-family: "Verdana";
            font-size: 10pt;
            color: Black;
            text-align: start;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 3px;
            padding-top: 6px;
            padding-bottom: 0px
        }

        .s10- {
            font-family: "Arial";
            font-size: 10pt;
            color: Black;
            text-align: start;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 3px;
            padding-top: 0px;
            padding-bottom: 0px;
            border-bottom: 1px solid Black
        }

        .s11- {
            font-family: "Tahoma";
            font-size: 16pt;
            color: Black;
            text-align: center;
            word-wrap: break-word;
            padding-left: 2px;
            padding-right: 2px;
            padding-top: 0px;
            padding-bottom: 0px
        }

        .s12- {
            font-family: "Tahoma";
            font-size: 16pt;
            color: Black;
            text-align: start;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 3px;
            padding-top: 0px;
            padding-bottom: 0px
        }

        .s13- {
            font-family: "Tahoma";
            font-size: 16pt;
            color: Black;
            text-align: start;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 2px;
            padding-top: 0px;
            padding-bottom: 0px
        }

        .s14- {
            font-family: "Tahoma";
            font-size: 10pt;
            color: Navy;
            text-align: start;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 3px;
            padding-top: 3px;
            padding-bottom: 0px
        }

        .s15- {
            font-family: "Tahoma";
            font-size: 10pt;
            color: Navy;
            text-align: start;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 3px;
            padding-top: 4px;
            padding-bottom: 0px
        }

        .s16- {
            font-family: "Tahoma";
            font-size: 10pt;
            color: Black;
            text-align: start;
            word-wrap: break-word;
            padding-left: 2px;
            padding-right: 3px;
            padding-top: 3px;
            padding-bottom: 0px
        }

        .s17- {
            font-family: "Tahoma";
            font-size: 10pt;
            color: Black;
            text-align: start;
            word-wrap: break-word;
            padding-left: 2px;
            padding-right: 3px;
            padding-top: 4px;
            padding-bottom: 0px
        }

        .s18- {
            font-family: "Tahoma";
            font-size: 10pt;
            color: Navy;
            text-align: start;
            word-wrap: break-word;
            padding-left: 2px;
            padding-right: 3px;
            padding-top: 3px;
            padding-bottom: 0px
        }

        .s19- {
            font-family: "Tahoma";
            font-size: 10pt;
            color: Navy;
            text-align: start;
            word-wrap: break-word;
            padding-left: 2px;
            padding-right: 3px;
            padding-top: 4px;
            padding-bottom: 0px
        }

        .s20- {
            font-family: "Tahoma";
            font-size: 10pt;
            color: Black;
            text-align: start;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 3px;
            padding-top: 3px;
            padding-bottom: 0px
        }

        .s21- {
            font-family: "Tahoma";
            font-size: 10pt;
            color: Black;
            text-align: start;
            word-wrap: break-word;
            padding-left: 3px;
            padding-right: 3px;
            padding-top: 4px;
            padding-bottom: 0px
        }
        /*]]>*/
    </style>
</head>

<body class="print-page">
<div class="sheet page1" id="capture" style="padding-left:38px;padding-right:38px;padding-top:38px;padding-bottom:38px;width:739px;height:979px;">
    <div class="layer">
        <div title="" class="IssuanceReport s0-" style="position:absolute;overflow:hidden;left:38px;top:261px;width:740px;height:657px;"></div>
        <div title="" class="Group s0-" style="position:absolute;overflow:hidden;left:38px;top:261px;width:740px;height:657px;"></div>
        <div title="" class="detail s0-" style="position:absolute;overflow:hidden;left:38px;top:261px;width:740px;height:605px;"></div>
        <div title="" class="table1 s1-" style="position:absolute;overflow:hidden;left:38px;top:261px;width:740px;height:425px;"></div>
        <div title="" class="textBox3 s2-" style="position:absolute;overflow:hidden;left:38px;top:261px;width:117px;height:27px;">
            <div style="position:absolute;top:13px;white-space:pre;left:3px;">CODE</div>
        </div>
        <div title="" class="textBox7 s3-" style="position:absolute;overflow:hidden;left:161px;top:261px;width:112px;height:27px;">
            <div style="position:absolute;top:13px;white-space:pre;right:8px;">QUANTITY</div>
        </div>
        <div title="" class="textBox11 s4-" style="position:absolute;overflow:hidden;left:284px;top:261px;width:118px;height:27px;">
            <div style="position:absolute;top:13px;white-space:pre;left:46px;">UNIT</div>
        </div>
        <div title="" class="textBox13 s2-" style="position:absolute;overflow:hidden;left:406px;top:261px;width:366px;height:27px;">
            <div style="position:absolute;top:13px;white-space:pre;left:3px;">D E S C R I P T I O N</div>
        </div>



        @php($counter=0)
        @php($y=302)

        @foreach($data->LineItems as $lineItem)
            @if($counter<19)
                <div title="" class="textBox21 s5-" style="position:absolute;overflow:hidden;left:38px;top:{{$y}}px;width:117px;height:20px;">{{ $lineItem->UniqueID }}</div>
                <div title="" class="textBox22 s6-" style="position:absolute;overflow:hidden;left:161px;top:{{$y}}px;width:112px;height:20px; text-align: right;">{{ $lineItem->Quantity }}</div>
                <div title="" class="textBox23 s7-" style="position:absolute;overflow:hidden;left:284px;top:{{$y}}px;width:118px;height:20px; text-align: center;">{{ $lineItem->UOM }}</div>
                <div title="" class="textBox24 s5-" style="position:absolute;overflow:hidden;left:406px;top:{{$y}}px;width:366px;height:20px;">{{ $lineItem->Description }}</div>
                @php($y+=20)
            @else
                <div title="" class="textBox21 s5-" style="position:absolute;overflow:hidden;left:38px;top:{{$y}}px;width:117px;height:20px;">{{ $lineItem->UniqueID }}</div>
                <div title="" class="textBox22 s6-" style="position:absolute;overflow:hidden;left:161px;top:{{$y}}px;width:112px;height:20px; text-align: right;">{{ $lineItem->Quantity }}</div>
                <div title="" class="textBox23 s7-" style="position:absolute;overflow:hidden;left:284px;top:{{$y}}px;width:118px;height:20px; text-align: center;">{{ $lineItem->UOM }}</div>
                <div title="" class="textBox24 s5-" style="position:absolute;overflow:hidden;left:406px;top:{{$y}}px;width:366px;height:20px;">{{ $lineItem->Description }}</div>
            @endif
            @php($counter++)
        @endforeach


        {{--@for($i=$counter;$i<10;$i++)--}}
            {{--@if($i<9)--}}
                {{--<div title="" class="s5-" style="position:absolute;overflow:hidden;left:560px;top:{{$y}}px;width:71px;height:30px; border-bottom: 1px solid black;"></div>--}}
                {{--<div title="" class="s12-" style="position:absolute;overflow:hidden;left:636px;top:{{$y}}px;width:67px;height:30px; border-bottom: 1px solid black;"></div>--}}
                {{--<div title="" class="s13-" style="position:absolute;overflow:hidden;left:709px;top:{{$y}}px;width:64px;height:30px; border-bottom: 1px solid black;"></div>--}}
                {{--<div title="" class="s14-" style="position:absolute;overflow:hidden;left:777px;top:{{$y}}px;width:143px;height:30px; border-bottom: 1px solid black;"></div>--}}
                {{--<div title="" class="s13-" style="position:absolute;overflow:hidden;left:926px;top:{{$y}}px;width:77px;height:30px; border-bottom: 1px solid black;"></div>--}}
                {{--@php($y+=30)--}}
            {{--@else--}}
                {{--<div title="" class="s5-" style="position:absolute;overflow:hidden;left:560px;top:{{$y}}px;width:71px;height:30px;"></div>--}}
                {{--<div title="" class="s12-" style="position:absolute;overflow:hidden;left:636px;top:{{$y}}px;width:67px;height:30px;"></div>--}}
                {{--<div title="" class="s13-" style="position:absolute;overflow:hidden;left:709px;top:{{$y}}px;width:64px;height:30px;"></div>--}}
                {{--<div title="" class="s14-" style="position:absolute;overflow:hidden;left:777px;top:{{$y}}px;width:143px;height:30px;"></div>--}}
                {{--<div title="" class="s13-" style="position:absolute;overflow:hidden;left:926px;top:{{$y}}px;width:77px;height:30px;"></div>--}}
            {{--@endif--}}
        {{--@endfor--}}


        {{--<div title="" class="textBox21 s5-" style="position:absolute;overflow:hidden;left:38px;top:302px;width:117px;height:20px;"></div>--}}
        {{--<div title="" class="textBox22 s6-" style="position:absolute;overflow:hidden;left:161px;top:302px;width:112px;height:20px;"></div>--}}
        {{--<div title="" class="textBox23 s7-" style="position:absolute;overflow:hidden;left:284px;top:302px;width:118px;height:20px;"></div>--}}
        {{--<div title="" class="textBox24 s5-" style="position:absolute;overflow:hidden;left:406px;top:302px;width:366px;height:20px;"></div>--}}

        {{--<div title="" class="textBox29 s5-" style="position:absolute;overflow:hidden;left:38px;top:322px;width:117px;height:19px;"></div>--}}
        {{--<div title="" class="textBox30 s6-" style="position:absolute;overflow:hidden;left:161px;top:322px;width:112px;height:19px;"></div>--}}
        {{--<div title="" class="textBox31 s7-" style="position:absolute;overflow:hidden;left:284px;top:322px;width:118px;height:19px;"></div>--}}
        {{--<div title="" class="textBox32 s5-" style="position:absolute;overflow:hidden;left:406px;top:322px;width:366px;height:19px;"></div>--}}

        {{--<div title="" class="textBox45 s5-" style="position:absolute;overflow:hidden;left:38px;top:341px;width:117px;height:19px;"></div>--}}
        {{--<div title="" class="textBox46 s6-" style="position:absolute;overflow:hidden;left:161px;top:341px;width:112px;height:19px;"></div>--}}
        {{--<div title="" class="textBox47 s7-" style="position:absolute;overflow:hidden;left:284px;top:341px;width:118px;height:19px;"></div>--}}
        {{--<div title="" class="textBox48 s5-" style="position:absolute;overflow:hidden;left:406px;top:341px;width:366px;height:19px;"></div>--}}

        {{--<div title="" class="textBox77 s5-" style="position:absolute;overflow:hidden;left:38px;top:360px;width:117px;height:19px;"></div>--}}
        {{--<div title="" class="textBox78 s6-" style="position:absolute;overflow:hidden;left:161px;top:360px;width:112px;height:19px;"></div>--}}
        {{--<div title="" class="textBox79 s7-" style="position:absolute;overflow:hidden;left:284px;top:360px;width:118px;height:19px;"></div>--}}
        {{--<div title="" class="textBox80 s5-" style="position:absolute;overflow:hidden;left:406px;top:360px;width:366px;height:19px;"></div>--}}

        {{--<div title="" class="textBox89 s5-" style="position:absolute;overflow:hidden;left:38px;top:379px;width:117px;height:19px;"></div>--}}
        {{--<div title="" class="textBox90 s6-" style="position:absolute;overflow:hidden;left:161px;top:379px;width:112px;height:19px;"></div>--}}
        {{--<div title="" class="textBox91 s7-" style="position:absolute;overflow:hidden;left:284px;top:379px;width:118px;height:19px;"></div>--}}
        {{--<div title="" class="textBox92 s5-" style="position:absolute;overflow:hidden;left:406px;top:379px;width:366px;height:19px;"></div>--}}

        {{--<div title="" class="textBox85 s5-" style="position:absolute;overflow:hidden;left:38px;top:398px;width:117px;height:20px;"></div>--}}
        {{--<div title="" class="textBox86 s6-" style="position:absolute;overflow:hidden;left:161px;top:398px;width:112px;height:20px;"></div>--}}
        {{--<div title="" class="textBox87 s7-" style="position:absolute;overflow:hidden;left:284px;top:398px;width:118px;height:20px;"></div>--}}
        {{--<div title="" class="textBox88 s5-" style="position:absolute;overflow:hidden;left:406px;top:398px;width:366px;height:20px;"></div>--}}

        {{--<div title="" class="textBox81 s5-" style="position:absolute;overflow:hidden;left:38px;top:418px;width:117px;height:19px;"></div>--}}
        {{--<div title="" class="textBox82 s6-" style="position:absolute;overflow:hidden;left:161px;top:418px;width:112px;height:19px;"></div>--}}
        {{--<div title="" class="textBox83 s7-" style="position:absolute;overflow:hidden;left:284px;top:418px;width:118px;height:19px;"></div>--}}
        {{--<div title="" class="textBox84 s5-" style="position:absolute;overflow:hidden;left:406px;top:418px;width:366px;height:19px;"></div>--}}

        {{--<div title="" class="textBox73 s5-" style="position:absolute;overflow:hidden;left:38px;top:437px;width:117px;height:19px;"></div>--}}
        {{--<div title="" class="textBox74 s6-" style="position:absolute;overflow:hidden;left:161px;top:437px;width:112px;height:19px;"></div>--}}
        {{--<div title="" class="textBox75 s7-" style="position:absolute;overflow:hidden;left:284px;top:437px;width:118px;height:19px;"></div>--}}
        {{--<div title="" class="textBox76 s5-" style="position:absolute;overflow:hidden;left:406px;top:437px;width:366px;height:19px;"></div>--}}

        {{--<div title="" class="textBox69 s5-" style="position:absolute;overflow:hidden;left:38px;top:456px;width:117px;height:19px;"></div>--}}
        {{--<div title="" class="textBox70 s6-" style="position:absolute;overflow:hidden;left:161px;top:456px;width:112px;height:19px;"></div>--}}
        {{--<div title="" class="textBox71 s7-" style="position:absolute;overflow:hidden;left:284px;top:456px;width:118px;height:19px;"></div>--}}
        {{--<div title="" class="textBox72 s5-" style="position:absolute;overflow:hidden;left:406px;top:456px;width:366px;height:19px;"></div>--}}

        {{--<div title="" class="textBox65 s5-" style="position:absolute;overflow:hidden;left:38px;top:475px;width:117px;height:19px;"></div>--}}
        {{--<div title="" class="textBox66 s6-" style="position:absolute;overflow:hidden;left:161px;top:475px;width:112px;height:19px;"></div>--}}
        {{--<div title="" class="textBox67 s7-" style="position:absolute;overflow:hidden;left:284px;top:475px;width:118px;height:19px;"></div>--}}
        {{--<div title="" class="textBox68 s5-" style="position:absolute;overflow:hidden;left:406px;top:475px;width:366px;height:19px;"></div>--}}

        {{--<div title="" class="textBox61 s5-" style="position:absolute;overflow:hidden;left:38px;top:494px;width:117px;height:20px;"></div>--}}
        {{--<div title="" class="textBox62 s6-" style="position:absolute;overflow:hidden;left:161px;top:494px;width:112px;height:20px;"></div>--}}
        {{--<div title="" class="textBox63 s7-" style="position:absolute;overflow:hidden;left:284px;top:494px;width:118px;height:20px;"></div>--}}
        {{--<div title="" class="textBox64 s5-" style="position:absolute;overflow:hidden;left:406px;top:494px;width:366px;height:20px;"></div>--}}

        {{--<div title="" class="textBox57 s5-" style="position:absolute;overflow:hidden;left:38px;top:514px;width:117px;height:19px;"></div>--}}
        {{--<div title="" class="textBox58 s6-" style="position:absolute;overflow:hidden;left:161px;top:514px;width:112px;height:19px;"></div>--}}
        {{--<div title="" class="textBox59 s7-" style="position:absolute;overflow:hidden;left:284px;top:514px;width:118px;height:19px;"></div>--}}
        {{--<div title="" class="textBox60 s5-" style="position:absolute;overflow:hidden;left:406px;top:514px;width:366px;height:19px;"></div>--}}

        {{--<div title="" class="textBox53 s5-" style="position:absolute;overflow:hidden;left:38px;top:533px;width:117px;height:19px;"></div>--}}
        {{--<div title="" class="textBox54 s6-" style="position:absolute;overflow:hidden;left:161px;top:533px;width:112px;height:19px;"></div>--}}
        {{--<div title="" class="textBox55 s7-" style="position:absolute;overflow:hidden;left:284px;top:533px;width:118px;height:19px;"></div>--}}
        {{--<div title="" class="textBox56 s5-" style="position:absolute;overflow:hidden;left:406px;top:533px;width:366px;height:19px;"></div>--}}

        {{--<div title="" class="textBox41 s5-" style="position:absolute;overflow:hidden;left:38px;top:552px;width:117px;height:19px;"></div>--}}
        {{--<div title="" class="textBox42 s6-" style="position:absolute;overflow:hidden;left:161px;top:552px;width:112px;height:19px;"></div>--}}
        {{--<div title="" class="textBox43 s7-" style="position:absolute;overflow:hidden;left:284px;top:552px;width:118px;height:19px;"></div>--}}
        {{--<div title="" class="textBox44 s5-" style="position:absolute;overflow:hidden;left:406px;top:552px;width:366px;height:19px;"></div>--}}

        {{--<div title="" class="textBox49 s5-" style="position:absolute;overflow:hidden;left:38px;top:571px;width:117px;height:19px;"></div>--}}
        {{--<div title="" class="textBox50 s6-" style="position:absolute;overflow:hidden;left:161px;top:571px;width:112px;height:19px;"></div>--}}
        {{--<div title="" class="textBox51 s7-" style="position:absolute;overflow:hidden;left:284px;top:571px;width:118px;height:19px;"></div>--}}
        {{--<div title="" class="textBox52 s5-" style="position:absolute;overflow:hidden;left:406px;top:571px;width:366px;height:19px;"></div>--}}

        {{--<div title="" class="textBox37 s5-" style="position:absolute;overflow:hidden;left:38px;top:590px;width:117px;height:20px;"></div>--}}
        {{--<div title="" class="textBox38 s6-" style="position:absolute;overflow:hidden;left:161px;top:590px;width:112px;height:20px;"></div>--}}
        {{--<div title="" class="textBox39 s7-" style="position:absolute;overflow:hidden;left:284px;top:590px;width:118px;height:20px;"></div>--}}
        {{--<div title="" class="textBox40 s5-" style="position:absolute;overflow:hidden;left:406px;top:590px;width:366px;height:20px;"></div>--}}

        {{--<div title="" class="textBox33 s5-" style="position:absolute;overflow:hidden;left:38px;top:610px;width:117px;height:19px;"></div>--}}
        {{--<div title="" class="textBox34 s6-" style="position:absolute;overflow:hidden;left:161px;top:610px;width:112px;height:19px;"></div>--}}
        {{--<div title="" class="textBox35 s7-" style="position:absolute;overflow:hidden;left:284px;top:610px;width:118px;height:19px;"></div>--}}
        {{--<div title="" class="textBox36 s5-" style="position:absolute;overflow:hidden;left:406px;top:610px;width:366px;height:19px;"></div>--}}

        {{--<div title="" class="textBox6 s5-" style="position:absolute;overflow:hidden;left:38px;top:629px;width:117px;height:19px;"></div>--}}
        {{--<div title="" class="textBox8 s6-" style="position:absolute;overflow:hidden;left:161px;top:629px;width:112px;height:19px;"></div>--}}
        {{--<div title="" class="textBox12 s7-" style="position:absolute;overflow:hidden;left:284px;top:629px;width:118px;height:19px;"></div>--}}
        {{--<div title="" class="textBox14 s5-" style="position:absolute;overflow:hidden;left:406px;top:629px;width:366px;height:19px;"></div>--}}

        {{--<div title="" class="textBox25 s5-" style="position:absolute;overflow:hidden;left:38px;top:648px;width:117px;height:19px;"></div>--}}
        {{--<div title="" class="textBox26 s6-" style="position:absolute;overflow:hidden;left:161px;top:648px;width:112px;height:19px;"></div>--}}
        {{--<div title="" class="textBox27 s7-" style="position:absolute;overflow:hidden;left:284px;top:648px;width:118px;height:19px;"></div>--}}
        {{--<div title="" class="textBox28 s5-" style="position:absolute;overflow:hidden;left:406px;top:648px;width:366px;height:19px;"></div>--}}

        {{--<div title="" class="textBox93 s5-" style="position:absolute;overflow:hidden;left:38px;top:667px;width:117px;height:19px;"></div>--}}
        {{--<div title="" class="textBox94 s6-" style="position:absolute;overflow:hidden;left:161px;top:667px;width:112px;height:19px;"></div>--}}
        {{--<div title="" class="textBox95 s7-" style="position:absolute;overflow:hidden;left:284px;top:667px;width:118px;height:19px;"></div>--}}
        {{--<div title="" class="textBox96 s5-" style="position:absolute;overflow:hidden;left:406px;top:667px;width:366px;height:19px;"></div>--}}

        <div title="" class="reportFooterSection1 s0-" style="position:absolute;overflow:hidden;left:38px;top:866px;width:740px;height:52px;"></div>
        <div title="" class="table2 s8-" style="position:absolute;overflow:hidden;left:38px;top:867px;width:740px;height:51px;"></div>
        <div title="" class="textBox15 s9-" style="position:absolute;overflow:hidden;left:38px;top:867px;width:318px;height:16px;">
            <div style="position:absolute;top:5px;white-space:pre;left:3px;">ISSUED BY:</div>
        </div>
        <div title="" class="textBox17 s7-" style="position:absolute;overflow:hidden;left:362px;top:867px;width:88px;height:22px;"></div>
        <div title="" class="textBox19 s9-" style="position:absolute;overflow:hidden;left:454px;top:867px;width:318px;height:16px;">
            <div style="position:absolute;top:5px;white-space:pre;left:3px;">RECEIVED BY:</div>
        </div>
        <div title="" class="textBox16 s10-" style="position:absolute;overflow:hidden;left:38px;top:889px;width:318px;height:29px;"></div>
        <div title="" class="textBox18 s7-" style="position:absolute;overflow:hidden;left:362px;top:889px;width:88px;height:29px;"></div>
        <div title="" class="textBox20 s10-" style="position:absolute;overflow:hidden;left:454px;top:889px;width:318px;height:29px;"></div>
        <div title="" class="pageHeaderSection1 s0-" style="position:absolute;overflow:hidden;left:38px;top:38px;width:740px;height:223px;"></div>
        <div title="" class="pictureBox1 s0-" style="position:absolute;overflow:hidden;left:38px;top:38px;width:416px;height:110px;"><img alt="" src="data:image/png;base64,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" style="position:absolute;text-align:left;top:22px;left:0px;width:416px;height:67px;" /></div>
        <div title="" class="textBox1 s11-" style="position:absolute;overflow:hidden;left:239px;top:163px;width:120px;height:26px;">
            <div style="position:absolute;top:0px;white-space:pre;left:9px;">ISSUE SLIP</div>
        </div>
        <div title="" class="textBox2 s12-" style="position:absolute;overflow:hidden;left:507px;top:163px;width:62px;height:26px;">
            <div style="position:absolute;top:0px;white-space:pre;left:3px;">IS No.</div>
        </div>
        <div title="" class="txtIssuanceNo s13-" style="position:absolute;overflow:hidden;left:575px;top:163px;width:180px;height:23px;">{{ $data->OrderNumber }}</div>
        <div title="" class="textBox5 s14-" style="position:absolute;overflow:hidden;left:38px;top:208px;width:161px;height:19px;">
            <div style="position:absolute;top:3px;white-space:pre;left:3px;">DEPARTMENT</div>
        </div>
        <div title="" class="textBox4 s15-" style="position:absolute;overflow:hidden;left:38px;top:230px;width:161px;height:19px;">
            <div style="position:absolute;top:3px;white-space:pre;left:3px;">REQUISITION SLIP NO.</div>
        </div>
        <div title="" class="txtDepartment s16-" style="position:absolute;overflow:hidden;left:205px;top:208px;width:203px;height:19px;">
            <div style="position:absolute;top:3px;white-space:pre;left:3px;">{{ $data->Department }}</div>
        </div>
        <div title="" class="txtRequisitionNo s17-" style="position:absolute;overflow:hidden;left:205px;top:230px;width:203px;height:19px;">
            <div style="position:absolute;top:3px;white-space:pre;left:3px;">{{ $data->IssuanceNo }}</div>
        </div>
        <div title="" class="textBox10 s18-" style="position:absolute;overflow:hidden;left:428px;top:208px;width:108px;height:19px;">
            <div style="position:absolute;top:3px;white-space:pre;left:3px;">DATE</div>
        </div>
        <div title="" class="textBox9 s19-" style="position:absolute;overflow:hidden;left:428px;top:230px;width:108px;height:19px;">
            <div style="position:absolute;top:3px;white-space:pre;left:3px;">TIME</div>
        </div>
        <div title="" class="txtDate s20-" style="position:absolute;overflow:hidden;left:541px;top:208px;width:202px;height:19px;">
            <div style="position:absolute;top:3px;white-space:pre;left:3px;">{{ $data->Date }}</div>
        </div>
        <div title="" class="txtTime s21-" style="position:absolute;overflow:hidden;left:541px;top:230px;width:202px;height:19px;">
            <div style="position:absolute;top:3px;white-space:pre;left:3px;">{{ $data->Time }}</div>
        </div>
    </div>
    <div title="" style="position:absolute;left:38px;top:38px;width:0px;height:979px;"></div>
    <div title="" style="position:absolute;left:777px;top:38px;width:0px;height:979px;"></div>
    <div title="" style="position:absolute;left:38px;top:38px;width:739px;height:0px;"></div>
    <div title="" style="position:absolute;left:38px;top:1017px;width:739px;height:0px;"></div>
</div>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/html2canvas.min.js') }}"></script>
<script src="{{ asset('js/jspdf.min.js') }}"></script>
<script>
/// FINALLY WORKING PDF CODE. AYOS NA.
$(document).ready(function(){

    html2canvas($('#capture'),{

        onrendered: function (canvas) {
            var imgData = canvas.toDataURL(
                'image/png');
            var doc = new jsPDF('p', 'in', [8.5, 11]);
            doc.addImage(imgData, 'PNG', 0, 0);
            doc.save('{{ $data->OrderNumber }}.pdf');
        }
    });
});
</script>
</body>

</html>