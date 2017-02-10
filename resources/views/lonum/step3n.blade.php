@extends('app')

@section('additionalCss')
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.tabpane.min.css" rel="stylesheet"/>
    <style type="text/css">

    </style>
    <script type="text/javascript">

        function validateCourseWizardForm() {
            var val = $('input[name=delv_type]:checked').val();
            if(val == undefined) {
                alert("Please Select a LO/Course Delivery Method.");
                return false;
            } //end if

            val=$('#catdiv_id option:selected').val();

            if(val == '' || val == undefined || val <= 0 ) {
                alert("Please Select this LO/Course's Catalog Division.");
                return false;
            } //end if

            return true;
        } //end validateCourseWizardForm

    </script>
@stop

@section('content')
    {!! Form::open(['action' => 'LoNumController@step3n', 'method' => 'post', 'id' => 'frmCsodCourseWizardStep3n',
                    'name' => 'frmCsodCourseWizardStep3n', 'onsubmit' => 'return validateCourseWizardForm();', 'class' => 'form-horizontal']) !!}
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
                                    <li class="passed" style="width: calc(25% - 13.3333px);" class=""><a href="#" data-toggle="tab" aria-expanded="true"><span>2</span></a></li>
                                    <li class="active" style="width: calc(25% - 13.3333px);" class=""><a href="#" data-toggle="tab" aria-expanded="true"><span>3</span></a></li>
                                    <li style="width: calc(25% - 13.3333px);" class=""><a href="#" data-toggle="tab" aria-expanded="false"><span>4</span></a></li>
                                    <li class=""><a href="#" data-toggle="tab" aria-expanded="false"><span>5</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <br />Please select the delivery method and catalog division to be used for this LO/Course<br />
                </div>
            </div>
        </div>
        <div class="col-md-9 col-md-pull-3" style="padding-left: 1px;">
            <div class="panel panel-shadow" style="max-width: 800px">
                <div class="panel-heading">
                    <strong>Step 3:  Select Delivery Method and Catalog Division</strong>
                </div>
                <div class="panel-body">
                    <div class="panel-section">
                        @if($type=='C')
                            <div class="row">
                                <label class="col-sm-4 control-label text-left" style="text-align: right;">Delivery Method:</label>
                                <div class="col-sm-8">
                                    <div class="radio">
                                        {{ Form::radio('delv_type', '', ($delv_type == ''), ['id'=> 'delv_type', 'class'=>'n-radio-btn']) }}
                                        <label id="TA_form_Optionselection" for="delv_type" style="text-wrap: none;">Instructor-led Event (Course)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-8">
                                    <div class="radio">
                                        {{ Form::radio('delv_type', 'V', ($delv_type == 'V'), ['id'=> 'delv_typeV', 'class'=>'n-radio-btn']) }}
                                        <label id="TA_form_Optionselection" for="delv_typeV" style="text-wrap: none;">Virtual Event (Course)</label>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <label class="col-sm-4 control-label text-left" style="text-align: right;">Delivery Method: <span class="icon icon-mandatory"></span></label>
                                <div class="col-sm-8">
                                    <div class="radio">
                                        {{ Form::radio('delv_type', 'W', ($delv_type == 'W'), ['id'=> 'delv_typeW', 'class'=>'n-radio-btn']) }}
                                        <label id="TA_form_Optionselection" for="delv_typeW" style="text-wrap: none;">Online Class (Web-based Training)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-8">
                                    <div class="radio">
                                        {{ Form::radio('delv_type', 'T', ($delv_type == 'T'), ['id'=> 'delv_typeT', 'class'=>'n-radio-btn']) }}
                                        <label id="TA_form_Optionselection" for="delv_typeT" style="text-wrap: none;">Test</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-8">
                                    <div class="radio">
                                        {{ Form::radio('delv_type', 'E', ($delv_type == 'E'), ['id'=> 'delv_typeE', 'class'=>'n-radio-btn']) }}
                                        <label id="TA_form_Optionselection" for="delv_typeE" style="text-wrap: none;">Exam</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-8">
                                    <div class="radio">
                                        {{ Form::radio('delv_type', 'A', ($delv_type == 'A'), ['id'=> 'delv_typeA', 'class'=>'n-radio-btn']) }}
                                        <label id="TA_form_Optionselection" for="delv_typeA" style="text-wrap: none;">Assessment</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-8">
                                    <div class="radio">
                                        {{ Form::radio('delv_type', 'S', ($delv_type == 'S'), ['id'=> 'delv_typeS', 'class'=>'n-radio-btn']) }}
                                        <label id="TA_form_Optionselection" for="delv_typeS" style="text-wrap: none;">Survey</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-8">
                                    <div class="radio">
                                        {{ Form::radio('delv_type', 'K', ($delv_type == 'K'), ['id'=> 'delv_typeK', 'class'=>'n-radio-btn']) }}
                                        <label id="TA_form_Optionselection" for="delv_typeK" style="text-wrap: none;">Curriculum (formerly Package)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-8">
                                    <div class="radio">
                                        {{ Form::radio('delv_type', 'D', ($delv_type == 'D'), ['id'=> 'delv_typeD', 'class'=>'n-radio-btn']) }}
                                        <label id="TA_form_Optionselection" for="delv_typeD" style="text-wrap: none;">Video</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 control-label"></label>
                                <div class="col-sm-8">
                                    <div class="radio">
                                        {{ Form::radio('delv_type', 'M', ($delv_type == 'M'), ['id'=> 'delv_typeM', 'class'=>'n-radio-btn']) }}
                                        <label id="TA_form_Optionselection" for="delv_typeM" style="text-wrap: none;">Material</label>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <div class="row">&nbsp;</div>
                        </div>
                        <div class="form-group has-feedback">
                            <div class="row">
                                <label class="col-md-4 control-label-sm text-left" style="text-align: right; white-space: nowrap;">Catalog Division: <span class="icon icon-mandatory"></span></label>
                                <div class="col-md-8 input-required">
                                    <select id="catdiv_id" name="catdiv_id" class="">
                                        <option value="">Please select this course's catalog division</option>
                                        @foreach($catdivs as $catdiv)
                                            <option value="{{  $catdiv->id }}" {{  (isset($catdiv_id) && $catdiv_id == $catdiv->id) ? 'selected="selected' : '' }}>{{ $catdiv->division_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
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
    {!! Form::hidden('method', $method, array('id' => 'method')) !!}
    {!! Form::hidden('type', $type, array('id' => 'type')) !!}
    {!! Form::close() !!}

@stop

@section('additionalJs')
@stop

