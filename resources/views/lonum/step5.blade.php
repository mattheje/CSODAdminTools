@extends('app')

@section('additionalCss')
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.tabpane.min.css" rel="stylesheet"/>
    <style type="text/css">

    </style>
    <script type="text/javascript">
        function validateCourseWizardForm() {
            var val = $('#course_title').val();
            if(val == '' || val == undefined || val.length < 5) {
                alert("Please Enter a Valid LO/Course Title, The CSOD LO/Course Number will be Automatically Added at the Beginning.");
                return false;
            } //end if

            val=$('input[id=delv_type]').val();
            if(val == '' || val == undefined || val <= 0) {
                val=$('#delv_type option:selected').val();
                if(val == '' || val == undefined || val <= 0) {
                    alert("Please Select this LO/Course's Delivery Method.");
                    return false;
                } //end if
            } //end if

            val=$('input[id=catdiv_id]').val();
            if(val == '' || val == undefined || val <= 0) {
                val=$('#catdiv_id option:selected').val();
                if(val == '' || val == undefined || val <= 0) {
                    alert("Please Select this LO/Course's Catalog Division.");
                    return false;
                } //end if
            } //end if

            val=$('#course_duration').val();
            if(val == '' || val == undefined || !isNumeric(val) || val <= 0) {
                alert("Please Enter a Valid LO/Course Duration.");
                return false;
            } //end if

            val=$('#course_level option:selected').val();
            if(val == '' || val == undefined || val <= 0) {
                alert("Please Select a Valid LO/Course Level.");
                return false;
            } //end if

            return true;
        } //end validateCourseWizardForm

        function isNumeric(n) {
            return !isNaN(parseFloat(n)) && isFinite(n);
        } //end isNumeric
    </script>

@stop

@section('content')
    {!! Form::open(['action' => 'LoNumController@step5', 'method' => 'post', 'id' => 'frmCsodCourseWizardStep5',
                    'name' => 'frmCsodCourseWizardStep5', 'onsubmit' => 'return validateCourseWizardForm();', 'class' => 'form-horizontal']) !!}
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
                                    <li class="passed" style="width: calc(25% - 13.3333px);"><a href="#" data-toggle="tab" aria-expanded="true"><span>4</span></a></li>
                                    <li class="active"><a href="#" data-toggle="tab" aria-expanded="true"><span>5</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <br />Please select enter the course title and the relevant course information in the form below and save:<br/>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-md-pull-3" style="padding-left: 1px;">
            <div class="panel panel-shadow" style="max-width: 800px">
                <div class="panel-heading">
                    <strong>Step 5:  Enter Course Title and Course Data Information</strong>
                </div>
                <div class="panel-body">
                    <div class="panel-section">
                        <div class="form-group has-feedback">
                            <div class="row">
                                <label class="col-md-4 control-label-sm text-left" style="text-align: right; white-space: nowrap;">Existing LO/Course Number or Title:</label>
                                <div class="col-md-8 input-required">
                                    {!! Form::text('scourse_no', $scourse_no, ['id'=>'scourse_no', 'size'=>'20', 'style'=>'text-transform: uppercase', 'class' => 'form-control n-inputfield n-inputfield-small']) !!}
                                    <a class="form-control-feedback form-control-feedback-small"><span class="icon icon-mandatory"></span></a>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 control-label-sm text-left" style="text-align: right; white-space: nowrap;"></label>
                                <div class="col-md-8 input-required">
                                    (Please Omit the Version Number Suffix.  EG:  TMG10001W)
                                </div>
                            </div>
                            <div class="row">&nbsp;</div>
                            <div class="row text-center">
                                <span>
                                    <button id="Cancel" class="btn btn-defaultBlue btn-standard" type="button" onclick="history.go(-1);"><span class='icon icon-back'></span> Prev</button> &nbsp;
                                    <button id="LoNumBtn" class="btn btn-defaultBlue btn-standard" type="button" onclick="showCourseNumberLookupTableByFilters($('#scourse_no').val(), 0, 'courseslisttable');"><span class='icon icon-search'></span> Search LO/Course</button>
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
    {!! Form::hidden('act', $act, array('id' => 'act')) !!}
    {!! Form::hidden('course_no_selected', $course_no_selected, array('id' => 'course_no_selected')) !!}
    {!! Form::hidden('version_selected', $version_selected, array('id' => 'version_selected')) !!}
    {!! Form::close() !!}

@stop

@section('additionalJs')

    <script type="text/javascript">

        $(document).ready(function() {
            if($('#scourse_no').length) {
                $('#scourse_no').focus();
                $('#scourse_no').select();
            } //end if
            val = $('input[id=course_no_selected]').val();
            if(val != '' && val != undefined && val.length >= 3) {
                $('#searchcnform').hide();
                $('#selectnewversionno').show();
            } else {
                if($('input[id=version_requested]').length && $('input[id=version_requested]').val() != '') {
                    showCourseNumberLookupTableByFilters($('#scourse_no').val(), 0, 'courseslisttable');
                    $('input[id=version_requested]').val('');
                } //end if
            }//end if
        });

    </script>
@stop

