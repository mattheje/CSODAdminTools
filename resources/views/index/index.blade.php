<!DOCTYPE html>
<html lang="en" style="height: 100%; width: 100%;">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.basic.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.alert.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.tooltip.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.buttons.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.inputfield.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.search.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.dropdowns.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.navigation.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.links.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.panel.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.footer.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/assets/css/demo.css" rel="stylesheet"/>
    <title>{{ env('APP_NAME_FULL') }}</title>

</head>
<body class="menu-body demo-body-content-upper" style="background:transparent; overflow: hidden; padding: 0; width: 100%;">
<nav class="n-banner nokia_banner_normal" data-visual-break="false">

    <div class="n-banner-1st-filler-white"></div>
    <div class="n-banner-1st-filler-blue"></div>
    <div class="n-banner-2nd-filler-blue hidden-xs hidden-on-blue-detached" style=""></div>
    <div class="n-banner-2nd-filler-gray hidden-xs"></div>


    <div class="container-fluid">

        <div class="n-banner-header">
            <button class="n-banner-toggle collapsed" data-target="#n-banner-collapse" data-toggle="collapse" type="button">
            <span class="sr-only">
              Toggle navigation
            </span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="n-banner-brand" href="{{ URL::to('/') }}" style="background: rgba(0, 0, 0, 0) url('{{ URL::to('/') }}/img/hm.btn.png') no-repeat scroll 0 center; padding-left: 45px; ">
                {{ env('APP_NAME_FULL') }}
            </a>
        </div>

        <div class="collapse n-banner-collapse" id="n-banner-collapse">

            <div class="row n-banner-1st">

                <div class="n-banner-right n-banner-logo-img hidden-xs">
                    <img alt="Nokia" src="{{ URL::to('/') }}/wulfdist/img/logo.png">
                </div>

                <div class="n-banner-right n-banner-1st-gray-to-white hidden-xs">
                    <div class="gray-mask"></div>
                    <div class="white-mask"></div>
                    <div class="gray-corner"></div>
                    <div class="white-corner"></div>
                </div>

                <ul class="n-banner-right n-banner-nav n-banner-controls">
                    <li>
                        <a id="TA_banner_username" href="#">
                            <i class="icon icon-profile"></i>
                            {{ Session::get('fullname') }}
                        </a>
                    </li>
                    <li class="hidden-xs">
                        <p>
                            |
                        </p>
                    </li>
                    <li>
                        <a id="TA_banner_logout" href="{{ URL::action('LoginController@logout', []) }}">
                            <i class="icon icon-actions-menu"></i>
                            Log Out
                        </a>
                    </li>
                </ul>

                <div class="n-banner-right n-banner-1st-blue-to-gray hidden-xs">
                    <div class="blue-mask"></div>
                    <div class="gray-mask"></div>
                    <div class="blue-corner"></div>
                    <div class="gray-corner"></div>
                </div>

            </div>

            <div class="row n-banner-2nd">

                <div class="n-banner-right n-banner-links-collapse dropdown">
                    <a href="#" class="n-banner-dropdown-toggle n-banner-links-collapse-dropdown-toggle show-on-blue-detached" data-toggle="dropdown" aria-expanded="false" role="button" style="display: none;">
                        <span class="icon icon-dropdown-menu"></span>
                    </a>
                    <ul class="nav n-banner-nav n-banner-links">
                        <li>
                            <a href="mailto:{{ env('NOKIA_LNG_ADMIN_EMAIL')  }}">
                                    <span>
                                        <i class="icon icon-message"></i>
                                        <span>Contact Us</span>
                                    </span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="n-banner-2nd-gray-to-blue hidden-xs hidden-on-blue-detached" style="">

                </div>
            </div>

        </div>

    </div>
</nav>

<div class="demo-main-content" style="width: 100%; padding-top: 1px; padding-bottom: 1px;">
    <iframe name="main-content" id="main_content" src="{{ URL::action('IndexController@maincontent', ['msg'=>$msg]) }}"></iframe>
</div>

<div class="n-footer-bordered" style="height: 30px; line-height: 30px;">
    <div class="n-footer-left">
        <div class="demo-version">
            <small>Version: {{  env('APP_VERSION') }}</small>
        </div>
    </div>
    <div class="n-footer-right">
        <div class="n-footer-copyright">
            &copy; {{ date("Y") }} Nokia. All rights reserved.
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.min.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/wulf.min.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/assets/js/require.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/assets/js/require-config.js"></script>
<script type="text/javascript">
    require(['wulf/inputfield']);

</script>
</body>
</html>