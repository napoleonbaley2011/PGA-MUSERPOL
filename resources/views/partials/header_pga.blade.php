<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            margin: 30px;
        }

        html {
            margin: 5pt 15pt 15pt 15pt;
        }
    </style>
</head>

<body class="w-100">
    <table class="uppercase">
        <tr>
            <th class="w-20 text-left no-paddings no-margins align-middle">
                <div class="text-left">
                    <img src="{{ public_path('/img/logo.png') }}" class="w-90">
                </div>
            </th>
            <th class="w-60 align-top">
                <div class="leading-tight m-b-10 text-xs">
                    <div>MUTUAL DE SERVICIOS AL POLICÍA "MUSERPOL"</div>
                    <div>{{ $direction }}</div>
                    <div>{{ $unity }}</div>
                </div>
            </th>
            <th class="w-20 no-paddings no-margins align-top">
                <table class="table-code no-paddings no-margins text-xxxs uppercase">
                    @if (isset($table))
                    @if (count($table) > 0)
                    <tbody>
                        @foreach ($table as $row)
                        <tr>
                            <td class="text-center bg-grey-darker text-white">{{ $row[0] }}</td>
                            <td>{{ $row[1] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endif
                    @endif
                </table>
            </th>
        </tr>
    </table>
    <hr class="m-b-10" style="margin-top: 0; padding-top: 0;">
</body>

</html>