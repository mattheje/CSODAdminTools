@extends('app')

@section('additionalCss')
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.tabpane.min.css" rel="stylesheet"/>
    <style type="text/css">

    </style>
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

@section('content')
    {!! Form::open(['action' => 'LoNumController@step1', 'method' => 'post', 'id' => 'frmCsodCourseWizardStep1',
                    'name' => 'frmCsodCourseWizardStep1', 'onsubmit' => 'return validateCourseWizardForm();', 'class' => 'form-horizontal']) !!}
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
                                    <li class="active" style="width: calc(25% - 13.3333px);"><a href="#" data-toggle="tab" aria-expanded="true"><span>1</span></a></li>
                                    <li style="width: calc(25% - 13.3333px);" class=""><a href="#" data-toggle="tab" aria-expanded="false"><span>2</span></a></li>
                                    <li style="width: calc(25% - 13.3333px);" class=""><a href="#" data-toggle="tab" aria-expanded="false"><span>3</span></a></li>
                                    <li style="width: calc(25% - 13.3333px);" class=""><a href="#" data-toggle="tab" aria-expanded="false"><span>4</span></a></li>
                                    <li class=""><a href="#" data-toggle="tab" aria-expanded="false"><span>5</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <br />This wizard will guide you through new course number and data creation for CSOD<br/><br/>Please select how you would like to create a new course:<br/><br/>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-md-pull-3" style="padding-left: 1px;">
            <div class="panel panel-shadow" style="max-width: 800px">
                <div class="panel-heading">
                    <strong>Step 1:  Select Creation Method</strong>
                </div>
                <div class="panel-body">
                    <div class="panel-section">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-4 control-label text-left" style="text-align: right;">Create:</label>
                                <div class="col-sm-8">
                                    <div class="radio">
                                        {{ Form::radio('method', 'N', ($method == 'N'), ['id'=> 'methodN', 'class'=>'n-radio-btn']) }}
                                        <label id="TA_form_Optionselection" for="methodN" style="text-wrap: none;">A New LO/Course Using The Course Number Generator</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-8">
                                    <div class="radio">
                                        {{ Form::radio('method', 'M', ($method == 'M'), ['id'=> 'methodM', 'class'=>'n-radio-btn']) }}
                                        <label id="TA_form_Optionselection" for="methodM" style="text-wrap: none;">A New LO/Course Using Manual Course Number Input</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-8">
                                    <div class="radio">
                                        {{ Form::radio('method', 'V', ($method == 'V'), ['id'=> 'methodV', 'class'=>'n-radio-btn']) }}
                                        <label id="TA_form_Optionselection" for="methodV" style="text-wrap: none;">A New Version of an Existing LO/Course Number</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">&nbsp;</div>
                            <div class="row text-center">
                                <span>
                                    <button id="Cancel" class="btn btn-defaultBlue btn-standard" type="button" onclick="history.go(-1);"><span class='icon icon-back'></span> Back</button> &nbsp;
                                    <button id="LoNumBtn" class="btn btn-defaultBlue btn-standard" type="submit">Next <span class='icon icon-next'></span></button>
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
    {!! Form::close() !!}

@stop

@section('additionalJs')
@stop

