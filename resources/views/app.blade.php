<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.basic.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.buttons.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.combobox.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.dropdowns.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.inputfield.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.panel.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.table-normal.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.drilldown.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.links.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.alert.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.dialog.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.tooltip.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.min.css" rel="stylesheet"/>
    <style type="text/css">
        body {
            overflow: hidden; background: url('{{ URL::to('/') }}/img/contentbkgr1.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        .instructionblock {
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            border-radius: 4px;
            color: #1b1b1b;
            display: block;
            font-size: 12.5px;
            line-height: 1.42857;
            margin: 0 0 10px;
            padding: 9px;
        }
    </style>
    @yield('additionalCss')
    <title>{{ env('APP_NAME_FULL') }}</title>
</head>
<body class="demo-body-content" style="overflow: auto; padding: 2px;">

    @yield('content')

    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/fuelux.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.mousewheel.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.mCustomScrollbar.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/components/keyboard/keyboard-core.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/components/inputfield.js"></script>
    @yield('additionalJs')
</body>
</html>