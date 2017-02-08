@extends('app')

@section('additionalCss')
    <style type="text/css">

    </style>
@stop

@section('content')
    {!! Form::open(['action' => 'LoNumController@step2n', 'method' => 'post', 'id' => 'loNumForm', 'onsubmit' =>'return validateCourseWizardForm();', 'class' => 'form-horizontal']) !!}
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
                    This wizard will guide you through new course number and data creation for CSOD<br/><br/>Please select how you would like to create a new course:<br/><br/>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-md-pull-3" style="padding-left: 1px;">
            <div class="panel panel-shadow" style="max-width: 800px">
                <div class="panel-heading">
                    <strong>Step 2:  Select Creation Method</strong>
                </div>
                <div class="panel-body">
                    <div class="panel-section">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-4 control-label text-left" style="text-align: right;">Create:</label>
                                <div class="col-sm-8">
                                    <div class="radio">
                                        {{ Form::radio('method', 'N', ($method == 'N'), ['id'=> 'methodN', 'class'=>'n-radio-btn']) }}
                                        <label id="TA_form_Optionselection" for="methodN" style="text-wrap: none;">A New Course Using The Course Number Generator</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-8">
                                    <div class="radio">
                                        {{ Form::radio('method', 'M', ($method == 'M'), ['id'=> 'methodM', 'class'=>'n-radio-btn']) }}
                                        <label id="TA_form_Optionselection" for="methodM" style="text-wrap: none;">A New Course Using Manual Course Number Input</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-8">
                                    <div class="radio">
                                        {{ Form::radio('method', 'V', ($method == 'V'), ['id'=> 'methodV', 'class'=>'n-radio-btn']) }}
                                        <label id="TA_form_Optionselection" for="methodV" style="text-wrap: none;">A New Version of an Existing Course Number</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">&nbsp;</div>
                            <div class="row text-center">
                                <span>
                                    <button id="Cancel" class="btn btn-defaultBlue btn-standard" type="button" onclick="">Back</button> &nbsp;
                                    <button id="LoNumBtn" class="btn btn-defaultBlue btn-standard" type="submit">Next</button>
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
    {!! Form::close() !!}

@stop

@section('additionalJs')
    <script type="text/javascript">

        function validateCourseWizardForm() {
            if(!($('input[name=method]:checked').val() != '')) {
                alert("Please Select a New Course/LO Number Creation Method.");
                return false;
            } //end if
            return true;
        } //end validateCourseWizardForm

    </script>
@stop

