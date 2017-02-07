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
    {!! Form::open(['action' => 'LoNumController@step1', 'method' => 'post', 'id' => 'loNumForm', 'class' => 'form-horizontal']) !!}
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
                    <strong>Step 1:  Select Creation Method</strong>
                </div>
                <div class="panel-body">
                    <div class="panel-section">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Gender:</label>

                            <div class="col-sm-8">
                                <div class="btn-group selectlist" data-resize="auto" data-initialize="selectlist" id="form_Selectlist1" style="width: 160px;">
                                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button" id="selectlist1" style="width: 160px;">
                                        <span class="selected-label"><span>Male</span></span>
                                        <span class="selected-caret"><span class="caret"></span></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul id="TA_form_selectmenu1" class="dropdown-menu" role="menu" style="width: 160px;">
                                        <li data-value="1" data-selected="true"><a href="#"><span>Male</span></a></li>
                                        <li data-value="2"><a href="#"><span>Female</span></a></li>
                                    </ul>
                                    <input class="hidden hidden-field" name="form_Selectlist1" readonly="readonly" aria-hidden="true" type="text">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Email address:</label>

                            <div class="col-sm-8">
                                <input class="form-control n-inputfield" id="exampleInputEmail1" placeholder="&lt;Enter email&gt;" type="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Password:</label>

                            <div class="col-sm-8">
                                <input class="form-control n-inputfield" id="exampleInputPassword1" placeholder="&lt;Password&gt;" type="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputDomain1" class="col-sm-4 control-label control-label-disabled">Domain:</label>

                            <div class="col-sm-8">
                                <input class="form-control n-inputfield" id="exampleInputDomain1" disabled="" value="Domain" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="existingValue" class="col-sm-4 control-label">Existing value:</label>

                            <div class="col-sm-8">
                                <input class="form-control n-inputfield" readonly="" tabindex="-1" id="existingValue" value="You have already a password" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Selectable values:</label>

                            <div class="col-sm-4">
                                <div class="checkbox">
                                    <input id="val1" checked="" type="checkbox">
                                    <label id="TA_form_Selectablevalue1" for="val1">Value 1</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="checkbox">
                                    <input id="val2" type="checkbox">
                                    <label id="TA_form_Selectablevalue2" for="val2">Value 2</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Option selection:</label>

                            <div class="col-sm-4">
                                <div class="radio">
                                    <input id="option1" name="colorOptionGroup" class="n-radio-btn" type="radio">
                                    <label id="TA_form_Optionselection1" for="option1">Red</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="radio">
                                    <input id="optionGreen" name="colorOptionGroup" class="n-radio-btn" checked="" type="radio">
                                    <label id="TA_form_Optionselection2" for="optionGreen">Green</label>
                                </div>
                            </div>
                        </div>
                        <button id="TA_form_button1" type="button" class="btn">Submit</button>
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
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/assets/js/require.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/assets/js/require-config.js"></script>
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

