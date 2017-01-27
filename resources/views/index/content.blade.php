@extends('app')

@section('additionalCss')
    <style type="text/css">
        body {
            background:white; overflow: hidden; background: url('{{ URL::to('/') }}/img/contentbkgr1.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
@stop

@section('content')
    <div class="row col-md-12">
        <div class="panel panel-blue-cap" style="max-width: 300px;">
            <div class="panel-heading" style="padding-top: 4px; padding-bottom: 1px; padding-left: 2px; padding-right: 2px; background-image: linear-gradient(to bottom, #fff 0px, #e5e5e5 100%);  min-height: 30px; max-height: 30px;">
                <h1><span class='icon icon-profile'></span> XYZ Administration Form :</h1>
            </div>
        </div>
        <hr style="width: 100%; margin-top: -21px; margin-bottom: 5px;" />
    </div>
    <div class="row col-md-12">
            <p>These forms are for testing labels and different controls in basic use.</p>
        </div>
    <div class="row col-md-12">
            <div class="panel panel-shadow" style="max-width: 900px;">
                <div class="panel-heading">
                    <h1>Normal horizontal form</h1>
                </div>
                <div class="panel-body">
                    <div class="panel-section">
                        <form class="form-horizontal">
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
                        </form>
                    </div>
                </div>
            </div>
        </div>

@stop

@section('additionalJs')
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/fuelux.js"></script>
    <script type="text/javascript">
    </script>
@stop