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
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.tooltip.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.min.css" rel="stylesheet"/>
    @yield('additionalCss')
    <title>{{ env('APP_NAME_FULL') }}</title>
</head>
<body class="demo-body-content" style="overflow: auto; padding: 2px;">
    @yield('content')
    @yield('additionalJs')
</body>
</html>