<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="{{ URL::to('/') }}/wulfdist/css/jqx.base.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.splitter.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/assets/css/demo.css" rel="stylesheet"/>
    <title>{{ env('APP_NAME_FULL') }} Main Content</title>
</head>
<body style="background: white; overflow: hidden;">
<div id="demoExampleSplitterVertical" class="n-splitter">
    <iframe class="demo-example-menu-box" id="menu"></iframe>
    <iframe class="demo-example-content-box" name="content" id="content" style="min-width: 250px;"
            src="{{ URL::action('IndexController@dashboard', []) }}"></iframe>
</div>

<script type="text/javascript" src="{{ URL::to('/') }}/assets/js/require.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/assets/js/require-config.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.min.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jqxcore.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jqxsplitter.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        'use strict';
        var $content = $('#content');
        var panels = [{size: 260, collapsible: false}, {collapsible: false}];
        $('#demoExampleSplitterVertical').jqxSplitter({orientation: "vertical", width: "100%", height: "100%", panels: panels});
        $(window).resize(function () {
            $('#demoExampleSplitterVertical').jqxSplitter('refresh');
        });
        $('#menu').attr('src', '{{ URL::action('IndexController@menu', []) }}');

        window.contentIframe = $content;

    });

</script>
</body>
</html>