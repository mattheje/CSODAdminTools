@extends('app')

@section('additionalCss')
    <style type="text/css">
        .n-drilldown-table tr:nth-child(4n+2) td { /* Fix error in WULF CSS */
        !important;
            padding-left: 8px;
            padding-right: 8px;
        }
        .n-drilldown-table tr:nth-child(4n) td {
            /* Fix error in WULF CSS */
        !important;
            padding-left: 8px;
            padding-right: 8px;
        }
    </style>
@stop

@section('content')
    {!! Form::open(['action' => 'IndexController@dashboard', 'method' => 'post', 'id' => 'srchLoNumForm', 'class' => 'form-horizontal']) !!}
    <div class="row col-md-12">
        <div class="panel panel-blue-cap" style="max-width: 300px;">
            <div class="panel-heading" style="padding-top: 4px; padding-bottom: 1px; padding-left: 2px; padding-right: 2px; background-image: linear-gradient(to bottom, #fff 0px, #e5e5e5 100%);  min-height: 30px; max-height: 30px;">
                <h1><span class='icon icon-dashboard'></span> Dashboard :</h1>
            </div>
        </div>
        <hr style="width: 100%; margin-top: -21px; margin-bottom: 5px;" />
    </div>
    <div class="row col-md-12">
        <div class="col-md-5 col-md-push-7" style="padding-left: 1px;">
            <div class="panel-shadow-description" style="max-width: 550px;">
                Instructions:
                <div class="instructionblock">
                    This tool is used to generate/reserve LO/Course Numbers for CSOD.  Please either click the 'Create New LO Number' button or search for a learning object number using course number or title.  You can also browse through the tables listed below to locate an existing learning object number.<br /><br />
                    <button id="newLoNumBtn" onclick="window.location='{{ URL::action('LoNumController@step1', []) }}';" class="btn btn-defaultBlue btn-standard center-block" type="button"><span class="icon icon-add"></span> Create New LO Number</button><br />
                </div>
            </div>
        </div>
        <div class="col-md-7 col-md-pull-5" style="padding-left: 1px;">
            <div class="panel panel-shadow" style="max-width: 450px">
                <div class="panel-heading">
                    <strong>LO Number Search : </strong>
                </div>
                <div class="panel-body">
                    <div class="col-md-12 text-center panel-section">
                        <div class="col-md-12">
                            <div class="row" style="vertical-align: middle; display: inline-block; float: none;">
                                <div class="col-md-6" style="margin-top: 7px;">
                                    {!! Form::text('crsnum', $crsnum, ['id' => 'crsnum', 'class' => 'n-inputfield n-inputfield-small', 'size' => '20', 'placeholder' => 'LO Number or Title']) !!}
                                </div>
                                <div class="col-md-6">
                                    <button id="srchLoNumBtn" class="btn btn-defaultBlue btn-standard" type="button" onclick="updateDashboardSearchResults($('#crsnum').val());"><span class="icon icon-search"></span> Search</button>
                                </div>
                            </div>
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
    @if(trim($type) == 'O')
        <div class="row col-md-12">
            <h2>Other Users' In-Progress/Reserved LO Numbers:</h2>
            <div id="otherReservedCoursesTableDiv"><span class="icon icon-spinner icon-spinner-large"></span></div>
        </div>
    @elseif(trim($type) == 'M')
        <div class="row col-md-12">
            <h2>My In-Progress/Reserved LO Numbers:</h2>
            <div id="myReservedCoursesTableDiv"><span class="icon icon-spinner icon-spinner-large"></span></div>
            <hr style="width: 100%;">
        </div>

        <div class="row col-md-12">
            <h2>My Published LO Numbers in CSOD:</h2>
            <div id="myPublishedCoursesTableDiv"><span class="icon icon-spinner icon-spinner-large"></span></div>
        </div>
    @else
        <div class="row col-md-12">
            <h2>My In-Progress/Reserved LO Numbers:</h2>
            <div id="myReservedCoursesTableDiv"><span class="icon icon-spinner icon-spinner-large"></span></div>
            <hr style="width: 100%;">
        </div>

        <div class="row col-md-12">
            <h2>My Published LO Numbers in CSOD:</h2>
            <div id="myPublishedCoursesTableDiv"><span class="icon icon-spinner icon-spinner-large"></span></div>
            <hr style="width: 100%;">
        </div>

        <div class="row col-md-12">
            <h2>Other Users' In-Progress/Reserved LO Numbers:</h2>
            <div id="otherReservedCoursesTableDiv"><span class="icon icon-spinner icon-spinner-large"></span></div>
        </div>
    @endif

    <div class="modal" id="ConfirmationDialogRelease" role="dialog" aria-labelledby="myModalDlgLabel-confirm" aria-hidden="true" tabindex="1" style="display: none;">
        <div class="modal-dialog n-dialog-confirm">
            <div class="modal-content" id="TA-dialog-confirmation-content">
                <div class="modal-header" id="TA-dialog-confirmation-content-header">
                    <div class="n-dialog-header-fg-filler">
                        <h1 class="modal-title">Are you sure you want to release this LO Number?</h1>
                    </div>
                    <div class="n-dialog-header-bg-filler"></div>
                    <!-- -->
                    <div class="n-dialog-header-curve">
                        <div class="fg-mask"></div>
                        <div class="bg-mask"></div>
                        <div class="fg-corner"></div>
                        <div class="bg-corner"></div>
                    </div>
                    <i role="button" class="icon icon-close-rounded" data-dismiss="modal" aria-label="Close" tabindex="3" id="TA-dialog-confirmation-content-close"></i>
                    <div style="clear: both"></div>
                    <div class="modal-title-confirm" id="TA-dialog-confirmation-content-body">This will delete this LO Number from this system (since it is unpublished in CSOD anyways).  Then you or someone else may re-purpose this LO Number.</div>
                </div>
                <div class="modal-footer" id="TA-dialog-confirmation-content-footer">
                    <button class="btn btn-standard" data-dismiss="modal" tabindex="4" type="submit" id="TA-dialog-confirmation-buttons-delete" onclick="document.forms[0].submit();">Release LO Number</button>
                    <button class="btn btn-standard btn-defaultBlue" data-dismiss="modal" tabindex="2" id="TA-dialog-confirmation-buttons-cancel">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    {!! Form::hidden('loId', '', array('id' => 'loId')) !!}
    {!! Form::hidden('loAction', '', array('id' => 'loAction')) !!}
    {!! Form::hidden('go', '1', array('id' => 'go')) !!}
    {!! Form::close() !!}

@stop

@section('additionalJs')
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/bootstrap.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function() {
            updateDashboardSearchResults($('#crsnum').val());
        });

        function updateDashboardSearchResults(crsnum) {
            @if(trim($type) == 'O')
                showOtherReservedLOs(crsnum, 0, 'otherReservedCoursesTableDiv');
            @elseif(trim($type) == 'M')
                showMyReservedLOs(crsnum, 0, 'myReservedCoursesTableDiv');
                showMyPublishedLOs(crsnum, 0, 'myPublishedCoursesTableDiv');
            @else
                showMyReservedLOs(crsnum, 0, 'myReservedCoursesTableDiv');
                showMyPublishedLOs(crsnum, 0, 'myPublishedCoursesTableDiv');
                showOtherReservedLOs(crsnum, 0, 'otherReservedCoursesTableDiv');
            @endif
        } //end if updateDashboardSearchResults

        var tableRowsPerPage = 5;

        var cachedMyReservedLOs = null;
        function showMyReservedLOs(crsnum, offset, divid)
        {
            var loadingimg = '<span class="icon icon-spinner icon-spinner-large"></span>';
            $('#'+divid).html(loadingimg);

            $.ajax({
                type: 'POST',
                url: '{{ URL::action('LoNumController@fetchMyReservedLOs', []) }}',
                dataType: 'text',
                asych: true,
                data: {crsnum: crsnum, offset: offset, _token: "{{ csrf_token() }}"},
                success: function(jsonResponse){
                    var courses = $.parseJSON(jsonResponse);
                    cachedMyReservedLOs = courses;
                    displayMyReservedLOs(offset, divid);
                },
                error: function(jqXHR) { if(window.status) window.status='Error: ' + jqXHR.status + ' - ' + jqXHR.statusText; }
            });

        } //end showMyReservedLOs

        function displayMyReservedLOs(offset, divid) {
            var rows = cachedMyReservedLOs; //read from global variable (course data is cached there so we don't have to make repeat AJAX calls)
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
            output += '<th class="text-right">ID</th>';
            output += '<th NOWRAP>Course Number</th>';
            output += '<th NOWRAP>Version</th>';
            output += '<th NOWRAP>Status</th>';
            output += '<th NOWRAP>Created On</th>';
            output += '<th width="100%">Title</th>';
            output += '<th NOWRAP>Action(s):</th>';
            output += '</tr>';
            output += '</thead>';
            output += '<tbody>';
            while((rowsOutput + offset) < rows.length && rowsOutput < tableRowsPerPage) {
                var row = rows[rowsOutput + offset];
                output += '<tr>';
                output += '<td class="text-right" valign="middle" NOWRAP>'+ row.id +'</td>';
                output += '<td valign="middle" NOWRAP>'+ row.course_no_raw +'</td>';
                output += '<td valign="middle" NOWRAP>'+ row.version +'</td>';
                output += '<td>'+ row.stepname +'</td>';
                output += '<td valign="middle" NOWRAP>' + row.inserted_on + '</td>';
                output += '<td>' + ((row.course_title === null) ? '' : row.course_title) + '</td>';
                output += '<td valign="middle" NOWRAP>';
                output += '<span id="spanselectbtn'+rowsOutput+'">';
                if(row.step == 4) {
                    output += '<button type="button" id="selectbtn_1_'+rowsOutput+'" onclick="window.location=\'{{ URL::action('LoNumController@step5', []) }}/act/E/id/'+encodeURIComponent(row.id)+'\';" class="btn btn-small" title="Continue"><span class="icon icon-edit"></span> Continue</button>&nbsp;';
                } //end if
                output += '<button type="button" id="selectbtn_2_'+rowsOutput+'" onclick="document.getElementById(\'loId\').value=\''+ row.id +'\';document.getElementById(\'loAction\').value=\'R\';" data-toggle="modal" data-backdrop="false" data-keyboard="true" data-target="#ConfirmationDialogRelease" class="btn btn-small" title="Release"><span class="icon icon-delete"></span> Release</button></span>';
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

            output += buildTableFooter(divid, 'displayMyReservedLOs', offset, rowsOutput, totalColumns, tableRowsPerPage, previous, next, rows.length, (offset + 1), (offset + rowsOutput));

            $('#'+divid).html(output);
        } //end displayMyReservedLOs

        var cachedMyPublishedLOs = null;
        function showMyPublishedLOs(crsnum, offset, divid)
        {
            var loadingimg = '<span class="icon icon-spinner icon-spinner-large"></span>';
            $('#'+divid).html(loadingimg);

            $.ajax({
                type: 'POST',
                url: '{{ URL::action('LoNumController@fetchMyPublishedLOs', []) }}',
                dataType: 'text',
                asych: true,
                data: {crsnum: crsnum, offset: offset, _token: "{{ csrf_token() }}"},
                success: function(jsonResponse){
                    var courses = $.parseJSON(jsonResponse);
                    cachedMyPublishedLOs = courses;
                    displayMyPublishedLOs(offset, divid);
                },
                error: function(jqXHR) { if(window.status) window.status='Error: ' + jqXHR.status + ' - ' + jqXHR.statusText; }
            });

        } //end showMyPublishedLOs

        function displayMyPublishedLOs(offset, divid) {
            var rows = cachedMyPublishedLOs; //read from global variable (course data is cached there so we don't have to make repeat AJAX calls)
            var output = null;
            var rowsOutput = 0;
            var totalColumns = 7;
            if(!(rows != null && rows.length > 0)) {
                $('#'+divid).html('Sorry, No LOs Found.');
                return;
            } //end if

            offset = (offset <= 0) ? 0 : (offset >= rows.length) ? rows.length - 1 : offset;
            output = '<table class="n-table n-table-standard n-table-striped n-table-cell-hover n-table-paging" style="min-width: 800px;">';
            output += '<thead>';
            output += '<tr>';
            output += '<th class="text-right">ID</th>';
            output += '<th NOWRAP>CSOD LOID</th>';
            output += '<th NOWRAP>Course Number</th>';
            output += '<th NOWRAP>Version</th>';
            output += '<th NOWRAP>Created On</th>';
            output += '<th width="100%">Title</th>';
            output += '<th align="center" NOWRAP>Action</th>';
            output += '</tr>';
            output += '</thead>';
            output += '<tbody>';
            while((rowsOutput + offset) < rows.length && rowsOutput < tableRowsPerPage) {
                var row = rows[rowsOutput + offset];
                output += '<tr>';
                output += '<td class="text-right" valign="middle" NOWRAP>'+ row.id +'</td>';
                output += '<td valign="middle" NOWRAP>'+ row.csod_loid +'</td>';
                output += '<td valign="middle" NOWRAP>'+ row.course_no_raw +'</td>';
                output += '<td valign="middle" NOWRAP>'+ row.version +'</td>';
                output += '<td valign="middle" NOWRAP>' + row.inserted_on + '</td>';
                output += '<td>' + ((row.course_title === null) ? '' : row.course_title) + '</td>';
                output += '<td valign="middle" NOWRAP>';
                output += '<span id="spanselectbtn'+rowsOutput+'">';
                output += '<button type="button" id="selectbtn_1_'+rowsOutput+'" onclick="window.location=\'{{ URL::action('LoNumController@step5', []) }}/act/V/method/M/id/'+encodeURIComponent(row.id)+'\';" class="btn btn-small" title="View"><span class="icon icon-more-vert"></span> View</button></span>';
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

            output += buildTableFooter(divid, 'displayMyPublishedLOs', offset, rowsOutput, totalColumns, tableRowsPerPage, previous, next, rows.length, (offset + 1), (offset + rowsOutput));

            $('#'+divid).html(output);
        } //end displayMyPublishedLOs

        var cachedOthersReservedLOs = null;
        function showOtherReservedLOs(crsnum, offset, divid) {
            var loadingimg = '<span class="icon icon-spinner icon-spinner-large"></span>';
            $('#'+divid).html(loadingimg);

            $.ajax({
                type: 'POST',
                url: '{{ URL::action('LoNumController@fetchOthersReservedLOs', []) }}',
                dataType: 'text',
                asych: true,
                data: {crsnum: crsnum, offset: offset, _token: "{{ csrf_token() }}"},
                success: function(jsonResponse){
                    var courses = $.parseJSON(jsonResponse);
                    cachedOthersReservedLOs = courses;
                    displayOthersReservedLOs(offset, divid);
                },
                error: function(jqXHR) { if(window.status) window.status='Error: ' + jqXHR.status + ' - ' + jqXHR.statusText; }
            });

        } //end showOtherReservedLOs

        function displayOthersReservedLOs(offset, divid) {
            var rows = cachedOthersReservedLOs; //read from global variable (course data is cached there so we don't have to make repeat AJAX calls)
            var output = null;
            var rowsOutput = 0;
            var totalColumns = 8;
            if(!(rows != null && rows.length > 0)) {
                $('#'+divid).html('Sorry, No LOs Found.');
                return;
            } //end if

            offset = (offset <= 0) ? 0 : (offset >= rows.length) ? rows.length - 1 : offset;
            output = '<table class="n-table n-table-standard n-table-striped n-table-cell-hover n-table-paging" style="min-width: 800px;">';
            output += '<thead>';
            output += '<tr>';
            output += '<th class="text-right">ID</th>';
            output += '<th NOWRAP>Course Number</th>';
            output += '<th NOWRAP>Version</th>';
            output += '<th NOWRAP>Owner</th>';
            output += '<th NOWRAP>Status</th>';
            output += '<th NOWRAP>Created On</th>';
            output += '<th width="100%">Title</th>';
            output += '<th align="center" NOWRAP>Action(s):</th>';
            output += '</tr>';
            output += '</thead>';
            output += '<tbody>';
            while((rowsOutput + offset) < rows.length && rowsOutput < tableRowsPerPage) {
                var row = rows[rowsOutput + offset];
                output += '<tr>';
                output += '<td class="text-right" valign="middle" NOWRAP>'+ row.id +'</td>';
                output += '<td valign="middle" NOWRAP>'+ row.course_no_raw +'</td>';
                output += '<td valign="middle" NOWRAP>'+ row.version +'</td>';
                output += '<td valign="middle">' + row.ownername + '</td>';
                output += '<td valign="middle">' + row.stepname + '</td>';
                output += '<td valign="middle" NOWRAP>' + row.inserted_on + '</td>';
                output += '<td>' + ((row.course_title === null) ? '' : row.course_title) + '</td>';
                output += '<td valign="middle" NOWRAP>';
                output += '<span id="spanselectbtn'+rowsOutput+'">';
                if(row.step == 4) {
                    output += '<button type="button" id="selectbtn_1_'+rowsOutput+'" onclick="window.location=\'{{ URL::action('LoNumController@step5', []) }}/act/E/id/'+encodeURIComponent(row.id)+'\';" class="btn btn-small" title="Continue"><span class="icon icon-edit"></span> Continue</button>&nbsp;';
                } //end if
                output += '<button type="button" id="selectbtn_2_'+rowsOutput+'" onclick="document.getElementById(\'loId\').value=\''+ row.id +'\';document.getElementById(\'loAction\').value=\'R\';" data-toggle="modal" data-backdrop="false" data-keyboard="true" data-target="#ConfirmationDialogRelease" class="btn btn-small" title="Release"><span class="icon icon-delete"></span> Release</button></span>';
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

            output += buildTableFooter(divid, 'displayOthersReservedLOs', offset, rowsOutput, totalColumns, tableRowsPerPage, previous, next, rows.length, (offset + 1), (offset + rowsOutput));

            $('#'+divid).html(output);
        } //end displayOthersReservedLOs

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

    </script>
@stop

