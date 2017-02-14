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
            <div class="panel panel-shadow" style="max-width: 830px;">
                <div class="panel-heading">
                    <strong>Step 5:  Enter Course Title and Course Data Information</strong>
                </div>
                <div class="panel-body">
                    <div class="panel-section">
                        <div class="form-group has-feedback">
                            <div class="row">
                                <label class="col-md-4 control-label-sm text-left" style="text-align: right; white-space: nowrap;">CSOD LO/Course Number:</label>
                                <div class="col-md-8 input-required">
                                    {!! Form::text('course_no_display', $course_no, ['id'=>'course_no_display', 'size'=>'20', 'style'=>'text-transform: uppercase', 'class' => 'form-control n-inputfield n-inputfield-small', 'disabled'=>'disabled']) !!}
                                    <a class="form-control-feedback form-control-feedback-small"></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <div class="row">
                                <label class="col-md-4 control-label-sm text-left" style="text-align: right; white-space: nowrap;">LO/Course Number (Minus Version):</label>
                                <div class="col-md-8 input-required">
                                    {!! Form::text('course_no_raw_display', $course_no_raw, ['id'=>'course_no_raw_display', 'size'=>'20', 'style'=>'text-transform: uppercase', 'class' => 'form-control n-inputfield n-inputfield-small', 'disabled'=>'disabled']) !!}
                                    <a class="form-control-feedback form-control-feedback-small"></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <div class="row">
                                <label class="col-md-4 control-label-sm text-left" style="text-align: right; white-space: nowrap;">Version:</label>
                                <div class="col-md-8 input-required">
                                    {!! Form::text('version_display', $version, ['id'=>'version_display', 'size'=>'20', 'style'=>'text-transform: uppercase', 'class' => 'form-control n-inputfield n-inputfield-small', 'disabled'=>'disabled']) !!}
                                    <a class="form-control-feedback form-control-feedback-small"></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <div class="row">
                                <label class="col-md-4 control-label-sm text-left" style="text-align: right; white-space: nowrap;">LO/Course Title:</label>
                                <div class="col-md-8 input-required">
                                    {!! Form::text('course_title', $course_title, ['id'=>'course_title', 'maxlength'=>(500 - (strlen($course_no) + 3)), 'class' => 'form-control n-inputfield n-inputfield-small', $disable_all]) !!}
                                    <a class="form-control-feedback form-control-feedback-small"><span class="icon icon-mandatory"></span></a>(The CSOD LO/Course Number will be automatically added at the end of the course title with a pipe. Please omit here.)
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <div class="row">
                                <label class="col-md-4 control-label-sm text-left" style="text-align: right; white-space: nowrap;">Delivery Method:</label>
                                <div class="col-md-8 input-required">
                                    <select id="delv_type" name="delv_type" <?php //if(strlen(trim($delv_type))==1 && stripos('IVWTEASKDM',trim($delv_type)) >= 0 && $method != 'M') echo 'disabled'; ?> {{ $disable_all }} >
                                        <option value="" <?php if($method != 'M' && $method != 'V') echo ' disabled="disabled"'; ?>>Please Select the Delivery Method</option>
                                        <option value="I" <?php if($delv_type=='') echo 'selected="selected"'; elseif($method != 'M' && $method != 'V') echo ' disabled="disabled"'; ?>>Instructor-led Event (Course)</option>
                                        <option value="V" <?php if($delv_type=='V') echo 'selected="selected"'; elseif($method != 'M' && $method != 'V') echo ' disabled="disabled"'; ?>>Virtual event (Course)</option>
                                        <option value="W" <?php if($delv_type=='W') echo 'selected="selected"'; elseif($method != 'M' && $method != 'V') echo ' disabled="disabled"'; ?>>Online Class (Web-based training)</option>
                                        <option value="T" <?php if($delv_type=='T') echo 'selected="selected"'; elseif($method != 'M' && $method != 'V') echo ' disabled="disabled"'; ?>>Test</option>
                                        <option value="E" <?php if($delv_type=='E') echo 'selected="selected"'; elseif($method != 'M' && $method != 'V') echo ' disabled="disabled"'; ?>>Exam</option>
                                        <option value="A" <?php if($delv_type=='A') echo 'selected="selected"'; elseif($method != 'M' && $method != 'V') echo ' disabled="disabled"'; ?>>Assessment</option>
                                        <option value="S" <?php if($delv_type=='S') echo 'selected="selected"'; elseif($method != 'M' && $method != 'V') echo ' disabled="disabled"'; ?>>Survey</option>
                                        <option value="K" <?php if($delv_type=='K') echo 'selected="selected"'; elseif($method != 'M' && $method != 'V') echo ' disabled="disabled"'; ?>>Curriculum (former package)</option>
                                        <option value="D" <?php if($delv_type=='D') echo 'selected="selected"'; elseif($method != 'M' && $method != 'V') echo ' disabled="disabled"'; ?>>Video</option>
                                        <option value="M" <?php if($delv_type=='M') echo 'selected="selected"'; elseif($method != 'M' && $method != 'V') echo ' disabled="disabled"'; ?>>Material</option>
                                    </select><?php //if(strlen(trim($delv_type))==1 && stripos('IVWTEASKDM',trim($delv_type)) >= 0 && $method != 'M') echo "<input type='hidden' name='delv_type' id='delv_type' value='".trim($delv_type)."' />"; ?>
                                    <a class="form-control-feedback form-control-feedback-small">@if(trim($delv_type) == '')<span class="icon icon-mandatory"></span>@endif</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <div class="row">
                                <label class="col-md-4 control-label-sm text-left" style="text-align: right; white-space: nowrap;">Catalog Division:</label>
                                <div class="col-md-8 input-required">
                                    <select id="catdiv_id" name="catdiv_id" <?php //if($catdiv_id > 0 && $method != 'M') echo 'disabled'; ?> {{ $disable_all }} >
                                        <option value="" <?php if($method != 'M') echo ' disabled="disabled"'; ?>>Please Select this LO/Course's Catalog Division</option>
                                        <?php
                                        foreach ($catdivs as $catdiv) {
                                            $sel = (isset($catdiv_id) && $catdiv_id == $catdiv->id) ? 'selected="selected"' : (($method != 'M') ? 'disabled="disabled"' : '');
                                            echo '<option value="' . $catdiv->id . '" ' . $sel . ' >' . $catdiv->division_name . '</option>';
                                        } //end foreach
                                        ?>
                                    </select><?php //if($catdiv_id > 0 && $method != 'M') echo "<input type='hidden' name='catdiv_id' id='catdiv_id' value='".trim($catdiv_id)."' />"; ?>
                                    <a class="form-control-feedback form-control-feedback-small">@if(!($catdiv_id > 0))<span class="icon icon-mandatory"></span>@endif</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <div class="row">
                                <label class="col-md-4 control-label-sm text-left" style="text-align: right; white-space: nowrap;">LO/Course Duration:</label>
                                <div class="col-md-8 input-required">
                                    {!! Form::text('course_duration', $course_duration, ['id'=>'course_duration', 'size'=>'20', 'class' => 'form-control n-inputfield n-inputfield-small', $disable_all]) !!}
                                    <a class="form-control-feedback form-control-feedback-small"><span class="icon icon-mandatory"></span></a>(In hours, based on a 6-hour day)
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <div class="row">
                                <label class="col-md-4 control-label-sm text-left" style="text-align: right; white-space: nowrap;">Course/LO Level:</label>
                                <div class="col-md-8 input-required">
                                    <select id="course_level" name="course_level" {{ $disable_all }} >
                                        <option value="">Please Select the Course Level</option>
                                        <option value="S" <?php if($course_level=='S') echo 'selected="selected"'; ?>>Standard</option>
                                        <option value="A" <?php if($course_level=='A') echo 'selected="selected"'; ?>>Advanced</option>
                                        <option value="E" <?php if($course_level=='E') echo 'selected="selected"'; ?>>Expert</option>
                                        <option value="N" <?php if($course_level=='N') echo 'selected="selected"'; ?>>Not Applicable</option>
                                    </select>
                                    <a class="form-control-feedback form-control-feedback-small">@if(!($course_level > 0))<span class="icon icon-mandatory"></span>@endif</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <div class="row">
                                <label class="col-md-4 control-label-sm text-left" style="text-align: right; white-space: nowrap;">Available:</label>
                                <div class="col-md-8 input-required">
                                    <input type="checkbox" name="available" id="available" value="Y" <?php if($available=='Y') echo 'checked'; ?> {{ $disable_all }} />
                                    <a class="form-control-feedback form-control-feedback-small"><span class="icon icon-mandatory"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <div class="row">
                                <label class="col-md-4 control-label-sm text-left" style="text-align: right; white-space: nowrap;">Product Release Number:</label>
                                <div class="col-md-8 input-required">
                                    {!! Form::text('product_relnum', $product_relnum, ['id'=>'product_relnum', 'size'=>'20', 'class' => 'form-control n-inputfield n-inputfield-small', $disable_all]) !!}
                                    <a class="form-control-feedback form-control-feedback-small"></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">&nbsp;</div>
                        @if($complete)
                            <div class="form-group">
                                <div class="alert center-block" style="margin-left: 20px; margin-right: 20px;">
                                    <span class="icon icon-info"></span>
                                    <span><font color="green"><strong>Congratulations</strong></font>, you have successfully generated and reserved LO/Course Number : <br /><br />  {{ $course_title }}</span>
                                    <br/><br>
                                    Please enter this information into the CSOD LO's "Title", "Course Number", and "Minor Version" fields accordingly:<br /><br />
                                    Title:  {!! Form::text('csod_title', $course_title, ['id'=>'csod_title', 'class' => 'form-control n-inputfield n-inputfield-small','onfocus'=>'this.select();']) !!}
                                    <br />
                                    Course Number:  {!! Form::text('csod_cn', $course_no, ['id'=>'csod_cn', 'class' => 'form-control n-inputfield n-inputfield-small','onfocus'=>'this.select();']) !!}
                                    <br />
                                    Minor Version:  {!! Form::text('csod_ver', $version, ['id'=>'csod_ver', 'class' => 'form-control n-inputfield n-inputfield-small','onfocus'=>'this.select();']) !!}
                                    <br />
                                    <a href="javascript:void(0)" onclick="window.open('{{ env('CSOD_CATALOG_DEEPLINK_URL')  }}','_newCsod');"><img src="{{ URL::to('/') }}/img/csod_scrcap.png" /></a>
                                </div>
                            </div>
                        @endif
                        <div class="row">&nbsp;</div>
                        <div class="form-group has-feedback">
                            <div class="row text-center">
                                <span>
                                    @if($complete != true)
                                        <button id="Cancel" class="btn btn-defaultBlue btn-standard" type="button" onclick="history.go(-1);"><span class='icon icon-back'></span> Prev</button> &nbsp;
                                    @endif
                                    @if($act=='E' && $complete != true)
                                        <button id="LoNumBtn1" class="btn btn-defaultBlue btn-standard" type="submit" onclick="javascript: $('frmCsodCourseWizardStep5').submit();">Save and Finish <span class='icon icon-next'></span></button>
                                    @endif
                                    @if($complete == true)
                                        <button id="Cancel" class="btn btn-defaultBlue btn-standard" type="button" onclick="window.location='{{ URL::action('IndexController@dashboard', []) }}';"><span class='icon icon-back'></span> Back to Dashboard</button> &nbsp;
                                        <button id="Cancel" class="btn btn-defaultBlue btn-standard" type="button" onclick="window.open('{{ env('CSOD_CATALOG_DEEPLINK_URL')  }}','_newCsod');void(0);">Open CSOD Catalog <span class='icon icon-next'></span></button>
                                    @endif
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
    {!! Form::hidden('method', $method, array('id' => 'method')) !!}
    {!! Form::hidden('course_no_raw', $course_no_raw, array('id' => 'course_no_raw')) !!}
    {!! Form::hidden('course_no', $course_no, array('id' => 'course_no')) !!}
    {!! Form::hidden('version', $version, array('id' => 'version')) !!}
    {!! Form::close() !!}

@stop

@section('additionalJs')

    <script type="text/javascript">
        @if($complete)
                $(document).ready(function() {
                    $('#csod_title').focus();
                });
        @endif
    </script>
@stop

