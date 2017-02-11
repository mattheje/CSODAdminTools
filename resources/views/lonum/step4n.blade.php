@extends('app')

@section('additionalCss')
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.tabpane.min.css" rel="stylesheet"/>
    <style type="text/css">

    </style>
    <script type="text/javascript">

        function validateCourseWizardForm() {
            var val = $('input[id=act]').val();
            if(val == 0 || val == '' || val == undefined) {
                alert("Please Select an Action.");
                return false;
            } //end if
            return true;
        } //end validateCourseWizardForm

    </script>
@stop

@section('content')
    {!! Form::open(['action' => 'LoNumController@step4n', 'method' => 'post', 'id' => 'frmCsodCourseWizardStep4n',
                    'name' => 'frmCsodCourseWizardStep4n', 'onsubmit' => 'return validateCourseWizardForm();', 'class' => 'form-horizontal']) !!}
    <div class="row col-md-12">
        <div class="panel panel-blue-cap" style="max-width: 300px;">
            <div class="panel-heading" style="padding-top: 4px; padding-bottom: 1px; padding-left: 2px; padding-right: 2px; background-image: linear-gradient(to bottom, #fff 0px, #e5e5e5 100%);  min-height: 30px; max-height: 30px;">
                <h1><span class='icon icon-add'></span> CSOD Course Data Wizard :</h1>
            </div>
        </div>
        <hr style="width: 100%; margin-top: -21px; margin-bottom: 5px;" />
    </div>
    <div class="row col-md-12">
        <div class="col-md-3 col-md-push-9" style="padding-left: 1px;">
            <div class="panel-shadow-description" style="max-width: 400px;">
                Instructions:
                <div class="instructionblock">
                    <div class="n-dlg-wizard in" role="dialog" id="myWizardDialog" aria-labelledby="myModalDlgLabel-subhead" aria-hidden="true" tabindex="-1" style="display: block; padding-right: 17px;">
                        <div class="navbar">
                            <div class="navbar-inner">
                                <ul class="nav nav-pills">
                                    <li class="passed" style="width: calc(25% - 13.3333px);"><a href="#" data-toggle="tab" aria-expanded="true"><span>1</span></a></li>
                                    <li class="passed" style="width: calc(25% - 13.3333px);"><a href="#" data-toggle="tab" aria-expanded="true"><span>2</span></a></li>
                                    <li class="passed" style="width: calc(25% - 13.3333px);"><a href="#" data-toggle="tab" aria-expanded="true"><span>3</span></a></li>
                                    <li class="active" style="width: calc(25% - 13.3333px);"><a href="#" data-toggle="tab" aria-expanded="true"><span>4</span></a></li>
                                    <li class=""><a href="#" data-toggle="tab" aria-expanded="false"><span>5</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <br />Please confirm that this is the LO/Course Number that you want to use, or release it and try another creation method:<br/>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-md-pull-3" style="padding-left: 1px;">
            <div class="panel panel-shadow" style="max-width: 800px">
                <div class="panel-heading">
                    <strong>Step 4:  Confirm and Save LO/Course Number</strong>
                </div>
                <div class="panel-body">
                    <div class="panel-section">

                        <div class="form-group">
                            <div class="alert center-block" style="margin-left: 20px; margin-right: 20px;">
                                <span class="icon icon-info"></span>
                                <span>The raw course number generated (without version) is: <strong>{{ $course_no_raw }}</strong></span>
                                <br /><br />
                                <span>The course number to be used in CSOD (with version) is: <strong>{{ $course_no }}</strong></span>
                                <br /><br />
                                <span>The version is: <strong>{{ $version }}</strong></span>
                                <br /><br />
                                <span>Please choose what to do with this course number by clicking the correct action button below.</span>
                                <br /><br />
                                <span>This course number will be locked for 48-hours if no action is taken.</span>
                                <br/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">&nbsp;</div>
                            <div class="row text-center">
                                <span>
                                    <button id="LoNumBtn4" class="btn btn-defaultBlue btn-standard" type="submit" onclick="javascript: $('input[id=act]').val(4);"><span class='icon icon-back'></span>Release &amp; Start Over</button>
                                    <button id="LoNumBtn3" class="btn btn-defaultBlue btn-standard" type="submit" onclick="javascript: $('input[id=act]').val(3);"><span class='icon icon-back'></span>Release &amp; Use Manual Tool</button>
                                    <button id="LoNumBtn2" class="btn btn-defaultBlue btn-standard" type="submit" onclick="javascript: $('input[id=act]').val(2);">Release &amp; Try Next Number <span class='icon icon-next'></span></button>
                                    <button id="LoNumBtn1" class="btn btn-defaultBlue btn-standard" type="submit" onclick="javascript: $('input[id=act]').val(1);">Continue <span class='icon icon-next'></span></button>
                                </span>
                            </div>
                            <div class="row">&nbsp;</div>
                            <div class="row">
                                @if(trim($msg) !== '')
                                    <div class="alert center-block" style="margin-left: 20px; margin-right: 20px;">
                                        <span class="icon icon-info"></span>{{ $msg }}
                                    </div>
                                @endif
                                @include('errors.list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! Form::hidden('id', $id, array('id' => 'id')) !!}
    {!! Form::hidden('go', '1', array('id' => 'go')) !!}
    {!! Form::hidden('act', '0', array('id' => 'act')) !!}
    {!! Form::hidden('method', $method, array('id' => 'method')) !!}
    {!! Form::hidden('type', $type, array('id' => 'type')) !!}
    {!! Form::hidden('delv_type', $delv_type, array('id' => 'delv_type')) !!}
    {!! Form::hidden('catdiv_id', $catdiv_id, array('id' => 'catdiv_id')) !!}
    {!! Form::hidden('course_no', $course_no, array('id' => 'course_no')) !!}
    {!! Form::hidden('course_no_raw', $course_no_raw, array('id' => 'course_no_raw')) !!}
    {!! Form::hidden('version', $version, array('id' => 'version')) !!}
    @if(is_array($excld))
        @foreach($excld as $excluded)
            {!! Form::hidden('excld[]', $excluded) !!}
        @endforeach
    @elseif(trim($excld) != '')
        {!! Form::hidden('excld[]', $excld) !!}
    @endif
    {!! Form::close() !!}

@stop

@section('additionalJs')
@stop

