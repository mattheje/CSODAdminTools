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
    <link href="{{ URL::to('/') }}/assets/css/demo.css" rel="stylesheet"/>
    <title>{{ env('APP_NAME_FULL') }} Login</title>
    <style>
        html {
            background: url({{ URL::to('/') }}/img/loginbkgr{{ rand (1,4) }}.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            box-shadow: 0 0 60px 60px white inset;
            width: 100%;
        }
    </style>
    <script type="text/javascript">
        if (top.location.href != self.location.href)
            top.location.href = "{{ URL::action('LoginController@index', ['msg' => 'Session Timed Out']) }}";
    </script>
</head>
<body class="demo-body-content" style="background:transparent;">
<div class="n-login-wrapper">
    <hr>
    <div class="n-login n-login-legal-copy">
        <div class="n-login-logo">
            <img src="{{ URL::to('/') }}/wulfdist/img/logo.png" width="110" height="19" alt="Nokia logo"/>
        </div>
        <div id='TA_login_legalcopy' class="panel panel-shadow panel-blue-cap">
            <h1 class="n-login-title">{{ env('APP_NAME_FULL') }} <span class="n-product-name-blue"></span></h1>
            <div class="panel-body">
                <h2 class="n-login-title-version-light">Version {{ env('APP_VERSION') }}</h2>

                <div class="n-login-panel-fields">
                    {!! Form::open(['action' => 'LoginController@login', 'method' => 'post', 'class' => 'form-horizontal']) !!}
                        <div class="form-group n-login-textfields">
                            <div class="col-sm-6 input-required">
                                <input name="username" type="text"  class="form-control n-inputfield"
                                       id="applicationLoginUsername"
                                       placeholder="CSL or NSN Intra Account Name" value="{{$defaultUsername}}"
                                       data-toggle="tooltip_un" data-placement="top" title="Former ALU users should enter their CSL, Existing Nokia users should enter their NSN Intra Account Name">
                                <a class="form-control-feedback">
                                    <span class="icon icon-mandatory"></span></a>
                            </div>
                            <div class="col-sm-6 input-required">
                                <input name="password" type="password"  class="form-control n-inputfield"
                                       id="applicationLoginPassword"
                                       placeholder="Password">
                                <a class="form-control-feedback form-control-feedback">
                                    <span class="icon icon-mandatory"></span></a>
                            </div>
                        </div>
                        <div class="n-login-action">
                            <div class="n-login-forget-password">
                                <a id='TA_login_forgetpassword' href="#">Forgot password</a><span class="icon icon-breadcrumb"></span>
                            </div>
                            <button type="submit" class="btn btn-defaultBlue btn-standard n-login-button"
                                    id="applicationLoginButton"
                                    disabled="true">Log In
                            </button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            @if(trim(Request::get('msg')) !== '')
            <div class="alert alert-error">
                <span class="icon icon-error"></span>{{Request::get('msg')}}
            </div>
            @endif
            @include('errors.list')
            <div class="n-login-legal-copy-text">
                You are about to access a private system. This system is for the use of authorized users only. All connections are logged.
            </div>
        </div>
    </div>
</div>

<div class="small n-login-copyright">
    &copy; {{ date("Y") }} Nokia. All rights reserved.
</div>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.min.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/fuelux.min.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/components/keyboard/keyboard-core.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/components/inputfield.js"></script>
<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip_un"]').tooltip({container: 'body', delay:300});
    });

    $(document).ready(function () {
        if (top.location.href != self.location.href)
            top.location.href = "{{ URL::action('LoginController@index', ['msg' => 'Session Timed Out']) }}";
    });

</script>
</body>
</html>