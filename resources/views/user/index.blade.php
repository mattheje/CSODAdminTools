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
    {!! Form::open(['action' => 'UserController@index', 'method' => 'post', 'id'=>'srchUserForm', 'class' => 'form-horizontal']) !!}
    <div class="row col-md-12">
        <div class="panel panel-blue-cap" style="max-width: 300px;">
            <div class="panel-heading" style="padding-top: 4px; padding-bottom: 1px; padding-left: 2px; padding-right: 2px; background-image: linear-gradient(to bottom, #fff 0px, #e5e5e5 100%);  min-height: 30px; max-height: 30px;">
                <h1><span class='icon icon-profile'></span> User Administration :</h1>
            </div>
        </div>
        <hr style="width: 100%; margin-top: -21px; margin-bottom: 5px;" />
    </div>
    <div class="row col-md-12">
        <div class="col-md-3 col-md-push-9">
            <div class="panel-shadow-description" style="max-width: 400px;">
                Instructions:
                <div class="instructionblock">Please search for a user to import, edit, or disable.<br/>New user information is suplied from LDAP and these search results always appear on top of the existing users results.<br />(Note:  User data is supplied via LDAP, and the basic user information can not be updated in this system.  It must be updated in the corporate HR systems that feed LDAP.)</div>
            </div>
        </div>
        <div class="col-md-9 col-md-pull-3" style="padding-left: 0px;">
            <div class="panel panel-shadow" style="max-width: 800px">
                <div class="panel-heading">
                    <strong>User Search</strong>
                </div>
                <div class="panel-body">
                    <div class="col-md-12 text-center panel-section">

                            <div class="form-group has-feedback">
                                <div class="col-md-12">
                                    <label class="col-md-4 control-label-sm" style="white-space: nowrap;">Last Name:</label>
                                    <div class="col-md-8 input-required">
                                        {!! Form::text('srchName', $srchName, ['class' => 'form-control n-inputfield n-inputfield-small']) !!}
                                        <a class="form-control-feedback form-control-feedback-small"><span class="icon icon-mandatory"></span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="col-md-12">
                                    <label class="col-md-4 control-label-sm" style="white-space: nowrap;">CSL or NSN Intra Name:</label>
                                    <div class="col-md-8 input-required">
                                        {!! Form::text('srchCsl', $srchCsl, ['class' => 'form-control n-inputfield n-inputfield-small']) !!}
                                        <a class="form-control-feedback form-control-feedback-small"><span class="icon icon-mandatory"></span></a>
                                    </div>
                                </div>
                            </div>
                            <button id="srchUserBtn" class="btn btn-defaultBlue btn-standard center-block" type="submit">Search For User</button>
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
    <div class="row col-md-12">
        <div id="userAdminTableDiv"><span class="icon icon-spinner icon-spinner-large"></span></div>
    </div>
    {!! Form::hidden('userAction', '', array('id' => 'userAction')) !!}
    {!! Form::hidden('userActionUserID', '', array('id' => 'userActionUserID')) !!}
    {!! Form::close() !!}

    <div class="modal" id="ConfirmationDialogDeactivate" role="dialog" aria-labelledby="myModalDlgLabel-confirm" aria-hidden="true" tabindex="1" style="display: none;">
        <div class="modal-dialog n-dialog-confirm">
            <div class="modal-content" id="TA-dialog-confirmation-content">
                <div class="modal-header" id="TA-dialog-confirmation-content-header">
                    <div class="n-dialog-header-fg-filler">
                        <h1 class="modal-title">Are you sure you want to de-activate this user?</h1>
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
                    <div class="modal-title-confirm" id="TA-dialog-confirmation-content-body">The user can be re-activated from this form.</div>
                </div>
                <div class="modal-footer" id="TA-dialog-confirmation-content-footer">
                    <button class="btn btn-standard" data-dismiss="modal" tabindex="4" type="submit" id="TA-dialog-confirmation-buttons-delete" onclick="document.forms[0].submit();">De-Activate User</button>
                    <button class="btn btn-standard btn-defaultBlue" data-dismiss="modal" tabindex="2" id="TA-dialog-confirmation-buttons-cancel">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="ConfirmationDialogReactivate" role="dialog" aria-labelledby="myModalDlgLabel-confirm" aria-hidden="true" tabindex="1" style="display: none;">
        <div class="modal-dialog n-dialog-confirm">
            <div class="modal-content" id="TA-dialog-confirmation-content">
                <div class="modal-header" id="TA-dialog-confirmation-content-header">
                    <div class="n-dialog-header-fg-filler">
                        <h1 class="modal-title">Are you sure you want to re-activate this user?</h1>
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
                    <div class="modal-title-confirm" id="TA-dialog-confirmation-content-body">The user can be de-activated from this form.</div>
                </div>
                <div class="modal-footer" id="TA-dialog-confirmation-content-footer">
                    <button class="btn btn-standard" data-dismiss="modal" tabindex="4" type="submit" id="TA-dialog-confirmation-buttons-delete" onclick="document.forms[0].submit();">Re-Active User</button>
                    <button class="btn btn-standard btn-defaultBlue" data-dismiss="modal" tabindex="2" id="TA-dialog-confirmation-buttons-cancel">Cancel</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('additionalJs')
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/fuelux.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.mousewheel.min.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.mCustomScrollbar.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/assets/js/require.js"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/assets/js/require-config.js"></script>
    <script type="text/javascript">
        require(['wulf/inputfield']);
        require(['wulf/drilldown']);

        var lonumgenUserData={!! $usersData !!};
        var lonumgenToolData={!! $toolsData !!};
        var lonumgenPermissionData={!! $permissionsData !!};

        var userAdminTableRowsPerPage = 10;

        $(document).ready(function() {
            buildUserAdministrationTable(0, 'userAdminTableDiv');
        });

        function buildUserAdministrationTable(offset, divid) {
            var output = null;
            var rowsOutput = 0;
            var totalColumns = 11;
            if(!(lonumgenUserData != null && lonumgenUserData.length > 0)) {
                $('#'+divid).html('Sorry, no users found.');
                return;
            } //end if

            offset = (offset <= 0) ? 0 : (offset >= lonumgenUserData.length) ? lonumgenUserData.length - 1 : offset;
            output = buildUserAdminTableHeader();
            while((rowsOutput + offset) < lonumgenUserData.length && rowsOutput < userAdminTableRowsPerPage) {
                var user = lonumgenUserData[rowsOutput + offset];
                var detailRow = false;
                output += '<tr>';
                output += '<td class="text-right">'+ user.id +'</td>';
                output += '<td>'+ user.fname +'</td>';
                output += '<td>'+ user.lname +'</td>';
                output += '<td>'+ user.username +'</td>';
                output += '<td>'+ user.csod_userid +'</td>';
                output += '<td><a href="mailto:'+ user.email +'">'+ user.email +'</a></td>';
                output += '<td>'+ user.country +'</td>';
                output += '<td>'+ user.status +'</td>';
                output += '<td>'+ user.permissions +'</td>';
                if(user.id == undefined || user.id == null || user.id <= 0) {
                    output += '<td colspan="2" NOWRAP><a href="javascript:void(0);" onclick="document.getElementById(\'userActionUserID\').value=\''+ user.username +'\';document.getElementById(\'userAction\').value=\'I\';document.forms[0].submit();">Import User</a></td>';
                } else if(user.id > 0 && user.status == 1) {
                    detailRow = true;
                    output += '<td class="n-drillDown-item" data-target-selector="#userdetailitem_'+ user.id +'" NOWRAP><a href="javascript:void(0);" onclick="document.getElementById(\'userActionUserID\').value=\''+ user.id +'\';document.getElementById(\'userAction\').value = \'E\';">Edit</a> &nbsp;</td>';
                    output += '<td NOWRAP><a id="TA-dialog-confirmation" onclick="document.getElementById(\'userActionUserID\').value=\''+ user.id +'\';document.getElementById(\'userAction\').value = \'D\';" href="#ConfirmationDialogDeactivate" data-backdrop="false" data-toggle="modal" data-keyboard="true">De-Activate</a></td>';
                } else {
                    output += '<td colspan="2" NOWRAP><a id="TA-dialog-confirmation" onclick="document.getElementById(\'userActionUserID\').value=\''+ user.id +'\';document.getElementById(\'userAction\').value = \'R\';" href="#ConfirmationDialogReactivate" data-backdrop="false" data-toggle="modal" data-keyboard="true">Re-Activate</a></td>';
                } //end if

                output += '</tr>';

                if(detailRow) {
                    output += buildUserAdminTableDetailRow(totalColumns, user.id);
                } //end if

                rowsOutput++;
            } //end while

            //Prev Link
            var previous = false;
            if(offset > 0) {
                previous = true;
            } //end if

            //Next Link
            var next = false;
            if(lonumgenUserData.length > (userAdminTableRowsPerPage + offset)) {
                next = true;
            } //end if

            output += buildUserAdminTableFooter(divid, 'buildUserAdministrationTable', offset, rowsOutput, totalColumns, userAdminTableRowsPerPage, previous, next, lonumgenUserData.length, (offset + 1), (offset + rowsOutput));

            $('#'+divid).html(output);
        } //end buildUserAdministrationTable

        function buildUserAdminTableHeader() {
            var output = '';
            output += '<table class="n-table n-table-standard n-table-striped n-table-cell-hover n-table-paging n-drilldown-table" style="min-width: 1100px;">';
            output += '<thead>';
            output += '<tr>';
            output += '<th class="text-right">ID:</th>';
            output += '<th>First Name:</th>';
            output += '<th>Last Name:</th>';
            output += '<th>CSL/NSN Intra:</th>';
            output += '<th>CSOD UserID:</th>';
            output += '<th>E-Mail:</th>';
            output += '<th>Country:</th>';
            output += '<th>Status:</th>';
            output += '<th>Permissions:</th>';
            output += '<th colspan=2">Actions:</th>';
            output += '</tr>';
            output += '</thead>';
            output += '<tbody>';
            return output;
        } //end buildUserAdminTableHeader

        function buildUserAdminTableDetailRow(columns, userid) {
            var output = '';
            output += '<tr>';
            output += '<td colspan="'+columns+'">';
            output += '<div>';
            output += '<div class="n-drillDown-collapsed" id="userdetailitem_' + userid + '">';
            output += '<div class="n-drillDown-arrowContainer">';
            output += '<div class="n-drillDown-arrow"></div>';
            output += '</div>';
            output += '<div class="n-drillDown-content">';
            output += '<div class="n-drillDown-inner">';
            output += '<div class="form-group">';
            output += '<label>User Permissions:</label>';

            for (var i = 0; i < lonumgenToolData.length; i++) {
                var isChecked=null;
                if(typeof(lonumgenPermissionData[userid]) !== 'undefined') {
                    var toolIndex = lonumgenPermissionData[userid].indexOf(String(lonumgenToolData[i].id));
                    isChecked = (toolIndex > -1) ? 'checked' : '';
                } //end if
                output += '<div class="checkbox">';
                output += '<input id="permission_' + userid + '_'+ lonumgenToolData[i].id +'" name="permission_' + userid + '_'+ lonumgenToolData[i].id +'" value="1" type="checkbox" '+ isChecked +' />';
                output += '<label id="TA_form_Selectablevalue" for="permission_' + userid + '_'+ lonumgenToolData[i].id +'">'+ lonumgenToolData[i].name +'</label>';
                output += '</div>';
            } //end for

            output += '</div>';
            output += '<button id="saveUserPermissionsBtn_' + userid + '" class="btn btn-defaultBlue btn-standard center-block" type="submit">Save User Permissions</button>';
            output += '<span class="icon icon-close-rounded"></span>';
            output += '</div>';
            output += '</div>';
            output += '</div>';
            output += '</div>';
            output += '</td>';
            output += '</tr>';
            return output;
        } //end

        function buildUserAdminTableFooter(divid, funcname, offset, rowsOutput, columns, pagesize, previous, next, total, from, to) {
            var output = '';
            output += '</tbody>';
            output += '<tfoot>';
            output += '<tr>';
            output += '<td colspan="'+ columns +'">';
            output += '<div class="n-table-total">';
            output += '<button id="TA-tableWithPaging-previousPage" class="btn btn-icon" type="button">';
            output += '<span>Total:  '+total+'</span>';
            output += '</button>';
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


        $('#srchUserForm input').blur(function() {
            var valid = false;
            $('#srchUserForm input').each(function() {
                if ($(this).val() && $(this).attr('name') != '_token') {
                    valid = true;
                    return;
                }
            });

            if(valid) {
                $('#srchUserBtn').removeAttr('disabled');
                $('.form-control-feedback').hide();
            } else {
                //$('#srchUserBtn').attr('disabled', 'disabled');
                $('.form-control-feedback').show();
            }//end if
        });

        //$('#TA-dialog-confirmation-buttons-delete').click(function() {
        //    document.forms[0].submit();
        //});
    </script>
@stop

