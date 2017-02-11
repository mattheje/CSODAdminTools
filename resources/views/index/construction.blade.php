<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.basic.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.alert.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.tooltip.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.buttons.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.inputfield.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.login.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.links.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.panel.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/css/demo.css" rel="stylesheet"/>
    <title>Under Construction</title>
    <style>
        html {
            width: 100%;
            background-color: #ffffff;
        }
    </style>
</head>
<body class="demo-body-content" style="background:transparent;">
<div class="n-login-wrapper">
    <hr>
    <div class="n-login n-login-legal-copy">
        <div class="n-login-logo">
            <img src="{{ URL::to('/') }}/wulfdist/img/logo.png" width="110" height="19" alt="Nokia logo"/>
        </div>
        <div id='TA_login_legalcopy' class="panel panel-shadow panel-blue-cap">
            <div class="panel-body">
                <div class="n-login-panel-fields">
                    <img src="{{ URL::to('/') }}/img/underconstruct.jpg" alt="Under Construction"/>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="small n-login-copyright">
    &copy; {{ date("Y") }} Nokia. All rights reserved.
</div>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.min.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/bootstrap.min.js"></script>
</body>
</html>