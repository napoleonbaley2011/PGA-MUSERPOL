<?php

use \Milon\Barcode\DNS2D;

$max_requests = 10;

$dns = new DNS2D();
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>PLATAFORMA VIRTUAL ADMINISTRATIVA - MUSERPOL </title>
    <link rel="stylesheet" href="{{ public_path("/css/material-request.min.css") }}" media="all" />
    <style>
        @page {
            size: letter;
            margin: 1.5cm;
        }

        .scissors-rule {
            display: block;
            text-align: center;
            overflow: hidden;
            white-space: nowrap;
            margin-top: 6px;
            margin-bottom: 17px;
        }

        .scissors-rule>span {
            position: relative;
            display: inline-block;
        }

        .scissors-rule>span:before,
        .scissors-rule>span:after {
            content: "";
            position: absolute;
            top: 50%;
            width: 9999px;
            height: 1px;
            background: white;
            border-top: 1px dashed black;
        }

        .scissors-rule>span:before {
            right: 100%;
            margin-right: 5px;
        }

        .scissors-rule>span:after {
            left: 100%;
            margin-left: 5px;
        }

        .border-left-white {
            border-left: 1px solid white;
        }

        .p-l-5 {
            padding-left: 5px;
        }
    </style>
</head>

<body style="border: 0; border-radius: 0;">
    <table class="w-100 uppercase">
        <tr>
            <th class="w-25 text-left no-paddings no-margins align-middle">
                <div class="text-left">
                    <img src="{{ public_path("/img/logo.png") }}" class="w-40">
                </div>
            </th>
            <th class="w-50 align-top">
                <div class="font-hairline leading-tight text-xs">
                    <div>MUTUAL DE SERVICIOS AL POLICÍA "MUSERPOL"</div>
                    <div>DIRECCIÓN DE ASUNTOS ADMINISTRATIVOS</div>
                    <div>UNIDAD ADMINISTRATIVA</div>
                </div>
            </th>
            <th class="w-25 no-padding no-margins align-top">
                <table class="table-code no-padding no-margins text-xxxs uppercase">
                    <tbody>
                        <tr>
                            <td class="text-center bg-grey-darker text-white">Fecha</td>
                            <td class="text-center text-xxs"> {{ $date }} </td>
                        </tr>
                    </tbody>
                </table>
            </th>
        </tr>
    </table>
    <hr class="m-b-10" style="margin-top: 0; padding-top: 0;">
    <div class="block">
        <div class="leading-tight text-sm text-center m-b-10">{{ $title }}</div>
        <div class="leading-tight text-sm text-center m-b-10">{{ $date_on }} a {{ $date_end }}</div>
        <table class="table-code w-100 m-b-10 uppercase text-xs">
            <tbody>
                <tr>
                    <td class="w-10 text-center bg-grey-darker text-white">Nombre</td>
                    <td class="w-90 p-l-5">{{ $employee }}</td>
                </tr>
                <tr>
                    <td class="w-10 text-center bg-grey-darker text-white">Cargo</td>
                    <td class="w-90 p-l-5">{{ $position }}</td>
                </tr>
            </tbody>
        </table>

        <table class="table-info w-100 m-b-10 uppercase text-xs">
            <thead>
                <tr>
                    <th class="text-center bg-grey-darker text-white">DETALLE DEL MATERIAL</th>
                    <th class="text-center bg-grey-darker text-white border-left-white">CANT. SOLICITADA</th>
                    <th class="text-center bg-grey-darker text-white border-left-white">CANT. ENTREGADA</th>
                    <th class="text-center bg-grey-darker text-white border-left-white">UNIDAD DE MEDIDA</th>
                    <th class="text-center bg-grey-darker text-white border-left-white">COSTO TOTAL</th>
                </tr>
            </thead>
            <tbody class="table-striped">
                @foreach ($result['materials'] as $material)
                <tr>
                    <td class="text-center">{{ $material['name_material'] }}</td>
                    <td class="text-center border-left-white">{{ $material['amount_requested'] }}</td>
                    <td class="text-center border-left-white">{{ $material['delivered_quantity'] }}</td>
                    <td class="text-center border-left-white">{{ $material['unit_material'] }}</td>
                    <td class="text-center border-left-white">{{ ($material['delivered_quantity'] *$material['cost'])}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <table>
        <tr>
            <td class="text-xxxs" align="left">
                @if (env("APP_ENV") == "production")
                PLATAFORMA VIRTUAL ADMINISTRATIVA
                @else
                VERSIÓN DE PRUEBAS
                @endif
            </td>
            <td class="child" align="right">
                <img src="data:image/png;base64, {{ $dns->getBarcodePNG(bcrypt($date . ' ' . gethostname() . ' ' . env('APP_URL')), 'PDF417') }}" alt="BARCODE!!!" style="height: 22px; width: 125px;" />
            </td>
        </tr>
    </table>
</body>

</html>