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

        var tableRowsPerPage = 7;

        var cachedCourseNumberSearchList = null;
        function showCourseNumberLookupTableByFilters(crsnum, offset, divid)
        {
            if(crsnum == '' || crsnum == undefined || crsnum.length < 3 ) {
                alert("Please Enter a Valid LO/Course Number or Title.");
                return false;
            } //end if

            var loadingimg = '<span class="icon icon-spinner icon-spinner-large"></span>';
            $('#'+divid).html(loadingimg);

            $.ajax({
                type: 'POST',
                url: '{{ URL::action('LoNumController@searchCourseDataForVersioning', []) }}',
                dataType: 'text',
                asych: true,
                data: {crsnum: crsnum, offset: offset, _token: "{{ csrf_token() }}"},
                success: function(jsonResponse){
                    var courses = $.parseJSON(jsonResponse);
                    cachedCourseNumberSearchList = courses;
                    displayCourseNumberLookupTable(offset, divid);
                },
                error: function(jqXHR) { if(window.status) window.status='Error: ' + jqXHR.status + ' - ' + jqXHR.statusText; }
            });
        } //end showCourseNumberLookupTableByFilters

        function displayCourseNumberLookupTable(offset, divid) {
            var rows = cachedCourseNumberSearchList; //read from global variable (course data is cached there so we don't have to make repeat AJAX calls)
            var output = null;
            var rowsOutput = 0;
            var totalColumns = 7;
            if(!(rows != null && rows.length > 0)) {
                $('#'+divid).html('Sorry, No LOs Found.');
                return;
            } //end if

            offset = (offset <= 0) ? 0 : (offset >= rows.length) ? rows.length - 1 : offset;
            output  = '<table class="n-table n-table-standard n-table-striped n-table-cell-hover n-table-paging" style="min-width: 800px;">';
            output += '<thead>';
            output += '<tr>';
            output += '<th NOWRAP>Course Number</th>';
            output += '<th NOWRAP>Version</th>';
            output += '<th>Owner</th>';
            output += '<th NOWRAP>Created On</th>';
            output += '<th width="100%">Title</th>';
            output += '<th>System</th>';
            output += '<th align="center" NOWRAP>Action</th>';
            output += '</tr>';
            output += '</thead>';
            output += '<tbody>';
            while((rowsOutput + offset) < rows.length && rowsOutput < tableRowsPerPage) {
                var row = rows[rowsOutput + offset];
                output += '<tr>';
                output += '<td valign="middle" NOWRAP>'+ row.course_no +'</td>';
                output += '<td valign="middle" NOWRAP>'+ row.version +'</td>';
                output += '<td valign="middle">' + row.owner + '</td>';
                output += '<td valign="middle" NOWRAP>' + row.cdate + '</td>';
                output += '<td>' + ((row.course_title === null) ? '' : row.course_title) + '</td>';
                output += '<td valign="middle">' + row.place + '</td>';
                output += '<td valign="middle" NOWRAP>';
                output += '<span id="spanselectbtn'+rowsOutput+'">';
                output += '<button type="button" id="selectbtn_1_'+rowsOutput+'" onclick="$(\'input[id=course_no_selected]\').val(\'' + row.course_no + '\'); $(\'input[id=version_selected]\').val(\'' + row.version + '\'); showNextVersionField($(\'input[id=course_no_selected]\').val(),\'selectbtn_1_'+rowsOutput+'\');" class="btn btn-small" title="Select"><span class="icon icon-right"></span> Select</button></span>';
                output += '</td>';
                output += '</tr>';
                rowsOutput++;
            } //end while

            //Prev Link
            var previous = false;
            if(offset > 0) {
                previous = true;
            } //end if

            //Next Link
            var next = false;
            if(rows.length > (tableRowsPerPage + offset)) {
                next = true;
            } //end if

            output += buildTableFooter(divid, 'displayCourseNumberLookupTable', offset, rowsOutput, totalColumns, tableRowsPerPage, previous, next, rows.length, (offset + 1), (offset + rowsOutput));

            $('#'+divid).html(output);
        } //end displayCourseNumberLookupTable

        function buildTableFooter(divid, funcname, offset, rowsOutput, columns, pagesize, previous, next, total, from, to) {
            var output = '';
            output += '</tbody>';
            output += '<tfoot>';
            output += '<tr>';
            output += '<td colspan="'+ columns +'">';
            output += '<div class="n-table-total">';
            output += '<span style="vertical-align: text-bottom;">Total:  '+total+'</span>';
            output += '</div>';
            output += '<div class="n-table-pagenum">';
            if(previous) {
                var prevoffset = ((offset - pagesize) <= 0) ? 0 : (offset - pagesize);
                output += '<button id="TA-tableWithPaging-firstPage" class="btn btn-icon" type="button" onclick="'+funcname+'('+prevoffset+', \''+divid+'\');">';
                output += '<span class="icon icon-back"></span>';
                output += '</button>';
            } //end if
            output += '<span>Displaying Record(s) '+from+' - '+to+'</span>';
            if(next) {
                var nextoffset = (rowsOutput + offset);
                output += '<button id="TA-tableWithPaging-afterPage" class="btn btn-icon" type="button" onclick="'+funcname+'('+nextoffset+', \''+divid+'\');">';
                output += '<span class="icon icon-next"></span>';
                output += '</button>';
            } //end if
            output += '</div>';
            output += '<div class="n-table-pageselect"></div>';
            output += '</td>';
            output += '</tr>';
            output += '</tfoot>';
            output += '</table>';
            return output;
        } //end buildUserAdminTableFooter

        function showNextVersionField(crsnum, selectspan) {
            if(crsnum == '' || crsnum == undefined || crsnum.length < 3 ) {
                alert("Please Select a Valid Course.");
                return false;
            } //end if
            var t = false;
            if(selectspan != null && selectspan != '' && selectspan != undefined) {
                t = $('#'+selectspan).html();
                var ajaxImage = '<span class="icon icon-spinner"></span>';
                $('#'+selectspan).html(ajaxImage);
            } //end if
            var nextversion = null;
            $.ajax({
                type: 'POST',
                url: '{{ URL::action('LoNumController@getNextCourseVersion', []) }}',
                dataType: 'text',
                asych: true,
                data: {crsnum: crsnum, _token: "{{ csrf_token() }}"},
                success: function(jsonResponse){
                    if(t !== false) { $('#'+selectspan).html(t) };
                    var nextversion = $.parseJSON(jsonResponse);
                    displayNextVersionInputField(crsnum, nextversion.nextversion);
                },
                error: function(jqXHR) { if(window.status) window.status='Error: ' + jqXHR.status + ' - ' + jqXHR.statusText; }
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
    <div id="searchcnform" style="display: @if(trim($course_no_selected) != '') none @else inline @endif;">
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
                        <br />Please search for the existing LO/Course Number of the LO/Course you would like to create a new version for.  Please click the &apos;Search LO/Course&apos; button to look-up the existing course, and then select the existing course and enter the new version number.
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
        <div class="row col-md-12">
            <div id="courseslisttable"></div>
        </div>
    </div>

    <div id="selectnewversionno" style="display: @if(trim($course_no_selected) != '') inline @else none @endif;">
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
                        Please confirm the LO/Course Number and confirm or change the pre-populated/suggested next version number.
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
                                    <label class="col-md-4 control-label-sm text-left" style="text-align: right; white-space: nowrap;">Existing Course Number:</label>
                                    <div class="col-md-8 input-required">
                                        {!! Form::text('selected_cn_display', $course_no_selected, ['id'=>'selected_cn_display', 'size'=>'20', 'style'=>'text-transform: uppercase', 'class' => 'form-control n-inputfield n-inputfield-small']) !!}
                                        <a class="form-control-feedback form-control-feedback-small"><span class="icon icon-mandatory"></span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="row">
                                    <label class="col-md-4 control-label-sm text-left" style="text-align: right; white-space: nowrap;">Requested New Version:</label>
                                    <div class="col-md-8 input-required">
                                        {!! Form::text('version_requested', $version_requested, ['id'=>'version_requested', 'size'=>'10', 'style'=>'text-transform: uppercase', 'class' => 'form-control n-inputfield n-inputfield-small']) !!}
                                        <a class="form-control-feedback form-control-feedback-small"><span class="icon icon-mandatory"></span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="row">&nbsp;</div>
                                <div id="conflictmessages">
                                    @if($go == '1')
                                        @if($valid == true)
                                            <div class="alert center-block" style="margin-left: 20px; margin-right: 20px;">
                                                <span class="icon icon-info"></span>
                                                <font color="green">Congratulations</font></strong>, the LO/Course Number <strong>{{ $course_no_selected }}</strong> and version <strong>{{ $version_requested }}</strong> are available and can be reserved.
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
                                                Sorry, course number <strong><font color='red'>{{ $course_no_selected }}</font></strong> and version <strong><font color='red'>{{ $version_requested }}</font></strong>are <strong><font color='red'>not available</font></strong>.  Please try another version number and check again.
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
                                    @endif
                                </div>
                                <div class="row text-center">
                                <span>
                                    @if($valid == true)
                                        <button id="LoNumBtn2_1" class="btn btn-defaultBlue btn-standard" type="button" onclick="$('input[id=act]').val(3); $('#frmCsodCourseWizardStep2v').submit();"><span class='icon icon-back'></span> Release &amp; Check Another Version</button>&nbsp;
                                        <button id="LoNumBtn2_2" class="btn btn-defaultBlue btn-standard" type="button" onclick="$('input[id=act]').val(2); $('#frmCsodCourseWizardStep2v').submit();"><span class='icon icon-back'></span> Release &amp; Start Over</button>&nbsp;
                                        <button id="LoNumBtn2_3" class="btn btn-defaultBlue btn-standard" type="button" onclick="$('input[id=act]').val(1); $('#frmCsodCourseWizardStep2v').submit();">Reserve &amp; Continue <span class='icon icon-next'></span></button>
                                    @else
                                        <button id="Cancel2" class="btn btn-defaultBlue btn-standard" type="button" onclick="$('#conflictmessages').html(''); $('#selectnewversionno').hide(); $('#searchcnform').show();"><span class='icon icon-back'></span> Back to Search Results</button>&nbsp;
                                        <button id="LoNumBtn2_Go" class="btn btn-defaultBlue btn-standard" type="button" onclick="$('#frmCsodCourseWizardStep2v').submit();">Check LO/Course Number&apos;s Version Availability <span class='icon icon-next'></span></button>
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

