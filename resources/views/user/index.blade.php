@extends('app')

@section('additionalCss')
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
@stop

@section('content')
    <div class="row col-md-12">
        <div class="panel panel-blue-cap" style="max-width: 300px;">
            <div class="panel-heading" style="padding-top: 4px; padding-bottom: 1px; padding-left: 2px; padding-right: 2px; background-image: linear-gradient(to bottom, #fff 0px, #e5e5e5 100%);  min-height: 30px; max-height: 30px;">
                <h1><span class='icon icon-profile'></span> User Administration :</h1>
            </div>
        </div>
        <hr style="width: 100%; margin-top: -21px; margin-bottom: 5px;" />
    </div>
    <div class="row col-md-12">
        <div class="col-md-3 col-md-push-9">
            <div class="panel-shadow-description" style="max-width: 400px;">
                Instructions:
                <div class="instructionblock">Please search for a user to import, edit, or disable.<br />(Note:  User data is supplied via LDAP, and basic user information can not be updated in this system, but must be updated in the corporate HR systems that feed LDAP.)</div>
            </div>
        </div>
        <div class="col-md-9 col-md-pull-3">
            <div class="panel panel-shadow" style="max-width: 800px">
                <div class="panel-heading">
                    <strong>User Search</strong>
                </div>
                <div class="panel-body">
                    <div class="col-md-12 text-center panel-section">
                        {!! Form::open(['action' => 'UserController@index', 'method' => 'post', 'id'=>'srchUserForm', 'class' => 'form-horizontal']) !!}
                            <div class="form-group has-feedback">
                                <div class="col-md-12">
                                    <label class="col-md-4 control-label-sm" style="white-space: nowrap;">Last Name:</label>
                                    <div class="col-md-8 input-required">
                                        {!! Form::text('srchName', $srchName, ['class' => 'form-control n-inputfield n-inputfield-small']) !!}
                                        <a class="form-control-feedback form-control-feedback-small"><span class="icon icon-mandatory"></span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="col-md-12">
                                    <label class="col-md-4 control-label-sm" style="white-space: nowrap;">CSL or NSN Intra Name:</label>
                                    <div class="col-md-8 input-required">
                                        {!! Form::text('srchCsl', $srchCsl, ['class' => 'form-control n-inputfield n-inputfield-small']) !!}
                                        <a class="form-control-feedback form-control-feedback-small"><span class="icon icon-mandatory"></span></a>
                                    </div>
                                </div>
                            </div>
                            <button id="srchUserBtn" class="btn btn-defaultBlue btn-standard center-block" type="submit" disabled="true">Search For User</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row col-md-12">
        <div>
            <table class="n-table n-table-standard n-table-striped n-table-cell-hover n-table-paging n-drilldown-table" style="min-width: 1100px;">
                <thead>
                <tr>
                    <th class="text-right">ID:</th>
                    <th>Last Name:</th>
                    <th>First Name:</th>
                    <th>CSL/NSN Intra:</th>
                    <th>CSOD UserID:</th>
                    <th>E-Mail:</th>
                    <th>Country:</th>
                    <th>Permissions:</th>
                    <th>Actions:</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="text-right">1</td>
                    <td>JENSEN</td>
                    <td>Matthew</td>
                    <td>6054123</td>
                    <td>mattheje</td>
                    <td><a href="mailto:matthew.jensen@nokia.com">matthew.jensen@nokia.com</a></td>
                    <td>US</td>
                    <td>8</td>
                    <td class="n-drillDown-item" data-target-selector="#item1" NOWRAP><a href="#">Edit</a> &nbsp; <a href="#">De-Activate</a></td>
                </tr>
                <tr>
                    <td colspan="9">
                        <div>
                            <div class="n-drillDown-collapsed" id="item1">
                                <div class="n-drillDown-arrowContainer">
                                    <div class="n-drillDown-arrow"></div>
                                </div>
                                <div class="n-drillDown-content">
                                    <div class="n-drillDown-inner">Permission Details Here #1</div>
                                    <span class="icon icon-close-rounded"></span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-right">2</td>
                    <td>THIELE</td>
                    <td>Shawn</td>
                    <td>6053423</td>
                    <td>sjthiele</td>
                    <td><a href="mailto:matthew.jensen@nokia.com">sjthiele@nokia.com</a></td>
                    <td>US</td>
                    <td>3</td>
                    <td class="n-drillDown-item" data-target-selector="#item2" NOWRAP><a href="#">Edit</a> &nbsp; <a href="#">Activate</a></td>
                </tr>
                <tr>
                    <td colspan="9">
                        <div>
                            <div class="n-drillDown-collapsed" id="item2">
                                <div class="n-drillDown-arrowContainer">
                                    <div class="n-drillDown-arrow"></div>
                                </div>
                                <div class="n-drillDown-content">
                                    <div class="n-drillDown-inner">Permission Details Here #2</div>
                                    <span class="icon icon-close-rounded"></span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="9">
                            <div class="n-table-total">
                                <button id="TA-tableWithPaging-previousPage" class="btn btn-icon" type="button">
                                    <span class="icon icon-back"></span>
                                </button>
                            </div>
                            <div class="n-table-pagenum">
                                Display Records 1 - 2 of 2
                            </div>
                            <div class="n-table-pageselect">
                                <button id="TA-tableWithPaging-afterPage" class="btn btn-icon" type="button">
                                    <span class="icon icon-next"></span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>
@stop

@section('additionalJs')
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/fuelux.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.mousewheel.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.mCustomScrollbar.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/assets/js/require.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/assets/js/require-config.js"></script>
    <script type="text/javascript">
        require(['wulf/inputfield']);
        require(['wulf/drilldown']);

        $('#srchUserForm input').blur(function() {
            var valid = false;
            $('#srchUserForm input').each(function() {
                if ($(this).val() && $(this).attr('name') != '_token') {
                    valid = true;
                    return;
                }
            });

            if(valid) {
                $('#srchUserBtn').removeAttr('disabled');
                $('.form-control-feedback').hide();
            } else {
                $('#srchUserBtn').attr('disabled', 'disabled');
                $('.form-control-feedback').show();
            }//end if
        });

    </script>
@stop

