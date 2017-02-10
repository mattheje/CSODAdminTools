@extends('app')

@section('additionalCss')
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.tabpane.min.css" rel="stylesheet"/>
    <style type="text/css">

    </style>
    <script type="text/javascript">

        function validateCourseWizardForm() {
            var val1 = $('#course_no_selected').val();
            var val2 = $('#version_requested').val();
            if(val1 == '' || val1 == undefined || val1.length < 3 || val2 == '' || val2 == undefined) {
                $('#searchcnform').hide();
                $('#selectnewversionno').show();
                alert("Please Enter a Valid Version Number.");
                $('#version_requested').focus();
                $('#version_requested').select();
                return false;
            } //end if
            return true;
        } //end validateCourseWizardForm
    </script>

@stop

@section('content')
    {!! Form::open(['action' => 'LoNumController@step2v', 'method' => 'post', 'id' => 'frmCsodCourseWizardStep2v',
                    'name' => 'frmCsodCourseWizardStep2v', 'onsubmit' => 'return validateCourseWizardForm();', 'class' => 'form-horizontal']) !!}
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
                                    <li class="passed" style="width: calc(25% - 13.3333px);"><a href="#" data-toggle="tab" aria-expanded="false"><span>1</span></a></li>
                                    <li class="active" style="width: calc(25% - 13.3333px);" class=""><a href="#" data-toggle="tab" aria-expanded="true"><span>2</span></a></li>
                                    <li style="width: calc(25% - 13.3333px);" class=""><a href="#" data-toggle="tab" aria-expanded="false"><span>3</span></a></li>
                                    <li style="width: calc(25% - 13.3333px);" class=""><a href="#" data-toggle="tab" aria-expanded="false"><span>4</span></a></li>
                                    <li class=""><a href="#" data-toggle="tab" aria-expanded="false"><span>5</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    Please search for the existing LO/Course Number of the LO/Course you would like to create a new version for.  Please click the &apos;Search LO/Course&apos; button to look-up the existing course, and then select the existing course and enter the new version number.
                </div>
            </div>
        </div>
        <div class="col-md-9 col-md-pull-3" style="padding-left: 1px;">
            <div class="panel panel-shadow" style="max-width: 800px">
                <div class="panel-heading">
                    <strong>Step 2:  Create A New Version of an Existing LO/Course Number</strong>
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
                            @if($go == 1 && strlen($rcourse_no) > 3)
                                <div class="row">&nbsp;</div>
                                <div class="row">
                                    @if($valid == true)
                                        <div class="alert center-block" style="margin-left: 20px; margin-right: 20px;">
                                            <span class="icon icon-info"></span>
                                            <font color="green">Congratulations</font></strong>, the LO/Course Number <strong><?php echo $rcourse_no; ?></strong> (Version 1.0) is available and can be reserved.
                                            @if(is_array($messages) && count($messages) > 0)
                                                <br/>However, the following <font color="orange">warning(s)</font> apply:<br/>
                                                <ul>
                                                    @foreach ($messages as $message)
                                                        <li>{{ $message }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    @else
                                        <div class="alert center-block" style="margin-left: 20px; margin-right: 20px;">
                                            <span class="icon icon-error"></span>
                                            Sorry, <font color='red'><?php echo $rcourse_no; ?></font></strong> (Version: 1.0) is <font color='red'>not available</font></strong>.  Please try another course number and check again.
                                            @if(is_array($messages) && count($messages) > 0)
                                                <br/><strong>The reason:</strong><br/>
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
                                        <button id="LoNumBtn4" class="btn btn-defaultBlue btn-standard" onclick="$('input[id=act]').val(4);" type="submit"><span class='icon icon-back'></span> Release &amp; Check Another LO/Course Number</button>
                                        <button id="LoNumBtn3" class="btn btn-defaultBlue btn-standard" onclick="$('input[id=act]').val(3);" type="submit"><span class='icon icon-back'></span> Release &amp; Start Over</button>>
                                        <button id="LoNumBtn1" class="btn btn-defaultBlue btn-standard" onclick="$('input[id=act]').val(1);" type="submit">Reserve &amp; Continue <span class='icon icon-next'></span></button>
                                    @else
                                        <button id="Cancel" class="btn btn-defaultBlue btn-standard" type="button" onclick="history.go(-1);"><span class='icon icon-back'></span> Prev</button> &nbsp;
                                        <button id="LoNumBtn" class="btn btn-defaultBlue btn-standard" type="button" onclick="showCourseNumberLookupTableByFilters($('#scourse_no').val(), 0, 'courseslisttable');"><span class='icon icon-search'></span> Search LO/Course</button>
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

    <div class="row col-md-12">
        <div id="courseslisttable"></div>
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
            } //end if
        });

        var cachedCourseNumberSearchList = null;
        function showCourseNumberLookupTableByFilters(crsnum, offset, divid)
        {
            if(crsnum == '' || crsnum == undefined || crsnum.length < 3 ) {
                alert("Please Enter a Valid Course Number or Title.");
                return false;
            } //end if

            var t = $('.showprocess2').html();
            var ajaxImage = '<img src="' + live_url + '/images/processing.gif" alt="processing" />';
            $('.showprocess2').html(ajaxImage);

            $.post(live_url + "/admin/csodcoursewizard/searchcoursedatalist",
                    {   crsnum: crsnum,
                        offset: offset
                    }, function(jsonResponse)
                    {
                        $('.showprocess2').html(t);
                        var courses = $.parseJSON(jsonResponse);
                        cachedCourseNumberSearchList = courses;
                        displayCourseNumberLookupTable(offset, divid);
                    });
        } //end showCourseNumberLookupTableByFilters

        function displayCourseNumberLookupTable(offset, divid) {
            var courses = cachedCourseNumberSearchList; //read from global variable (course data is cached there so we don't have to make repeat AJAX calls)
            var output = null;
            var rowsOutput = 0;
            var rowsToOuput = 5;
            if(courses != null && courses.length > 0) {
                offset = (offset <= 0) ? 0 : (offset >= courses.length) ? courses.length - 1 : offset;

                output  = '<table width="100%" cellspacing="0" border="0" id="courselisttable">';
                output += '<tr>';
                output += '<th NOWRAP>&nbsp;</th>';
                output += '<th NOWRAP>Course Number</th>';
                output += '<th NOWRAP>Version</th>';
                output += '<th>Owner</th>';
                output += '<th NOWRAP>Created On</th>';
                output += '<th width="100%">Title</th>';
                output += '<th>System</th>';
                output += '</tr>';
                var rowsOutput = 0;
                while((rowsOutput + offset) < courses.length && rowsOutput < rowsToOuput) {
                    var course = courses[rowsOutput + offset];
                    output += '<tr>';
                    output += '<td valign="middle" NOWRAP>';
                    output += '<span id="spanselectbtn'+rowsOutput+'"><input type="button" id="selectbtn'+rowsOutput+'" onclick="$(\'input[id=course_no_selected]\').val(\'' + course.course_no + '\'); $(\'input[id=version_selected]\').val(\'' + course.version + '\'); showNextVersionField($(\'input[id=course_no_selected]\').val(),\'spanselectbtn'+rowsOutput+'\');" value="Select" /></span>';
                    output += '</td>';
                    output += '<td valign="middle" NOWRAP>' + course.course_no + '</td>';
                    output += '<td valign="middle" NOWRAP>' + course.version + '</td>';
                    output += '<td valign="middle">' + course.owner + '</td>';
                    output += '<td valign="middle" NOWRAP>' + course.cdate + '</td>';
                    output += '<td>' + course.course_title + '</td>';
                    output += '<td valign="middle">' + course.place + '</td>';

                    output += '</tr>';
                    rowsOutput++;
                } //end while

                //Prev Link
                var prevlink = '';
                if(offset > 0) {
                    var prevoffset = ((offset - rowsToOuput) <= 0) ? 0 : (offset - rowsToOuput);
                    prevlink += '<a href="javascript:void(0);" onclick="displayCourseNumberLookupTable('+prevoffset+',\''+divid+'\')">&lt;&lt; Prev</a>';
                } //end if

                //Next Link
                var nextlink = '';
                if(courses.length > (rowsOutput + offset)) {
                    var nextoffset = (rowsOutput + offset);
                    nextlink += '<a href="javascript:void(0);" onclick="displayCourseNumberLookupTable('+nextoffset+',\''+divid+'\')">Next &gt;&gt;</a>';
                } //end if

                //Summary Line and Next/Prev Links
                output += '<tr><td colspan="7" align="center">'+ prevlink + ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';
                output += ' Displaying Course Search Results ' + (offset + 1) + ' - ' + (offset + rowsOutput) + ' of ' + courses.length + ' ';
                output += ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ' + nextlink + '</td></tr>';
                output += '</table>';
                //console.log(output);
            } else {
                output = 'No Courses Found!';
            } //end if
            $('#'+divid).html(output);
        } //end displayCourseLookupTable

        function showNextVersionField(crsnum, selectspan) {
            if(crsnum == '' || crsnum == undefined || crsnum.length < 3 ) {
                alert("Please Select a Valid Course.");
                return false;
            } //end if
            var t = false;
            if(selectspan != null && selectspan != '' && selectspan != undefined) {
                t = $('#'+selectspan).html();
                var ajaxImage = '<img src="' + live_url + '/images/processing.gif" alt="processing" />';
                $('#'+selectspan).html(ajaxImage);
            } //end if
            var nextversion = null;
            $.post(live_url + "/admin/csodcoursewizard/getnextcourseversion",
                    {   crsnum: crsnum
                    }, function(jsonResponse)
                    {
                        if(t !== false) { $('#'+selectspan).html(t) };
                        var nextversion = $.parseJSON(jsonResponse);
                        displayNextVersionInputField(crsnum, nextversion.nextversion);
                    });

        } //end showNextVersionField

        function displayNextVersionInputField(crsnum, nextversion) {
            $('#selected_cn_display').val(crsnum);
            $('#version_requested').val(nextversion);
            $('#searchcnform').hide();
            $('#selectnewversionno').show();
        } //end displayNextVersionInputField


    </script>
@stop

