@extends('app')

@section('additionalCss')
    <style type="text/css">

    </style>
@stop

@section('content')
    {!! Form::open(['action' => 'LoNumController@step2m', 'method' => 'post', 'id' => 'loNumForm', 'onsubmit' =>'return validateCourseWizardForm();', 'class' => 'form-horizontal']) !!}
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
                    Please enter the LO/Course Number that you would like to request.  This LO/Course Number will be checked for validity and uniqueness.  It may already be taken and another LO/Course Number will have to be chosen.  Please click the 'Check Course Number Availability' button after entering the requested LO/Course Number. <br/><br/>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-md-pull-3" style="padding-left: 1px;">
            <div class="panel panel-shadow" style="max-width: 800px">
                <div class="panel-heading">
                    <strong>Step 2:  Manually Enter Requested LO/Course Number</strong>
                </div>
                <div class="panel-body">
                    <div class="panel-section">
                        <div class="form-group has-feedback">
                            <div class="row">
                                <label class="col-md-4 control-label-sm text-left" style="text-align: right; white-space: nowrap;">Requested LO/Course Number:</label>
                                <div class="col-md-8 input-required">
                                    {!! Form::text('rcourse_no', $rcourse_no, ['size'=>'20', 'style'=>'text-transform: uppercase', 'class' => 'form-control n-inputfield n-inputfield-small']) !!}
                                    <a class="form-control-feedback form-control-feedback-small"><span class="icon icon-mandatory"></span></a>
                                </div>
                            </div>
                            <div class="row">&nbsp;</div>
                            <div class="row text-center">
                                <span>
                                    <button id="Cancel" class="btn btn-defaultBlue btn-standard" type="button" onclick="">Prev</button> &nbsp;
                                    <button id="LoNumBtn" class="btn btn-defaultBlue btn-standard" type="submit">Check Course Number Availability</button>
                                </span>
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
    {!! Form::close() !!}

@stop

@section('additionalJs')
    <script type="text/javascript">

        $(document).ready(function() {
            if($('#rcourse_no').length) {
                $('#rcourse_no').focus();
                $('#rcourse_no').select();
            } //end if
        });

        function validateCourseWizardForm() {
            var val = $('#rcourse_no').val();
            if(val == '' || val == undefined || val.length < 3 ) {
                alert("Please Enter a Valid Course Number.");
                $('#rcourse_no').focus();
                $('#rcourse_no').select();
                return false;
            } //end if
            return true;
        } //end validateCourseWizardForm

    </script>
@stop

