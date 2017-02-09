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
                                    {!! Form::text('rcourse_no', $rcourse_no, ['id'=>'rcourse_no', 'size'=>'20', 'style'=>'text-transform: uppercase', 'class' => 'form-control n-inputfield n-inputfield-small']) !!}
                                    <a class="form-control-feedback form-control-feedback-small"><span class="icon icon-mandatory"></span></a>
                                </div>
                            </div>
                            @if($go == 1 && strlen($rcourse_no) > 3)
                            <div class="row">&nbsp;</div>
                            <div class="row">
                                @if($valid == true)
                                    <div class="alert center-block">
                                        <span class="icon icon-info"></span>
                                        <font color="green">Congratulations</font></strong>, the LO/Course Number <strong><?php echo $rcourse_no; ?></strong> (Version 1.0) is available and can be reserved.
                                        @if(is_array($messages) && count($messages) > 0)
                                            <strong>However, the following <font color="orange">warning(s)</font> apply:</strong><br/>
                                            <ul>
                                                @foreach ($messages as $message)
                                                    <li>{{ $message }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                @else
                                    <div class="alert center-block">
                                        <span class="icon icon-info"></span>
                                        Sorry, <strong><font color='red'><?php echo $rcourse_no; ?></font></strong> (Version: 1.0) is <strong><font color='red'>not available</font></strong>.  Please try another course number and check again.
                                        @if(is_array($messages) && count($messages) > 0)
                                            <strong>The reason:</strong><br/>
                                            <ul>
                                                @foreach ($messages as $message)
                                                    <li>{{ $message }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            @endif

                            <div class="row">&nbsp;</div>
                            <div class="row text-center">
                                <span>
                                    @if($valid == true)
                                        <button id="Cancel" class="btn btn-defaultBlue btn-standard" type="button" onclick="history.go(-1);">Prev</button> &nbsp;
                                        <button id="LoNumBtn" class="btn btn-defaultBlue btn-standard" type="submit">Check Course Number Availability</button>
                                    @else
                                        <button id="LoNumBtn4" class="btn btn-defaultBlue btn-standard" onclick="$('input[id=act]').val(4);" type="submit">Release &amp; Check Another Course Number</button>
                                        <button id="LoNumBtn3" class="btn btn-defaultBlue btn-standard" onclick="$('input[id=act]').val(3);" type="submit">Release &amp; Start Over</button>
                                        <button id="LoNumBtn2" class="btn btn-defaultBlue btn-standard" onclick="$('input[id=act]').val(2);" type="submit">Release &amp; Use Course/LO Number Generator</button>
                                        <button id="LoNumBtn1" class="btn btn-defaultBlue btn-standard" onclick="$('input[id=act]').val(1);" type="submit">Reserve &amp; Continue</button>
                                    @endif
                                </span>
                            </div>

                            <div class="row">&nbsp;</div>
                            <div class="row">
                                @if(trim($msg) !== '')
                                    <div class="alert center-block">
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
    {!! Form::hidden('course_no_raw', $course_no_raw, array('id' => 'course_no_raw')) !!}
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

