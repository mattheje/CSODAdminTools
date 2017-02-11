<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ URL::to('/') }}/wulfdist/css/fuelux.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.panel.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.basic.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.tree-normal.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/wulfdist/css/wulf.links.min.css" rel="stylesheet"/>
    <link href="{{ URL::to('/') }}/css/demo.css" rel="stylesheet"/>

    <title>{{ env('APP_NAME_FULL') }} Menu</title>
    <style type="text/css">
        body {
            background:white; overflow: hidden; background: url('{{ URL::to('/') }}/img/menubkgr1.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>
</head>
<body>
<div class="row col-md-12" style="padding-right: 11px;">
<div class="panel panel-simple-shadow panel-blue-cap" style="max-width: 600px;">
    <div class="panel-heading" style="padding-top: 4px; padding-bottom: 1px; padding-left: 2px; padding-right: 2px;">
        <!-- Tree component without checkbox -->
        <div class="fuelux menu-tree">
            <ul id="myTree" class="tree" role="tree">
                <li class="tree-branch hide" data-template="treebranch" role="treeitem" aria-expanded="false">
                    <div class="tree-branch-header">
                        <a class="tree-branch-name">
                            <span class="glyphicon icon-caret glyphicon-play"></span>
                            <span class="glyphicon icon-folder glyphicon-folder-close"></span>
                            <span class="tree-label"></span>
                        </a>
                    </div>
                    <ul class="tree-branch-children" role="group"></ul>
                    <div class="tree-loader" role="alert">Loading...</div>
                </li>
                <li class="tree-item hide" data-template="treeitem" role="treeitem">
                    <a class="tree-item-name"  target="content">
                        <span class="glyphicon icon-item fueluxicon-bullet"></span>
                        <span class="tree-label"></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
</div>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.min.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/components/tree.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/../components/keyboard/keyboard-tree.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/fuelux/tree.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/components/scroll.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/components/keyboard/keyboard-core.js"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/wulfdist/js/dependencies/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript">
    $(document).ready(
            function () { //
                var childNodesArray = [
                    @if(in_array('lonumadmin',Session::get('userpermissions')) || in_array('lonumadminedit',Session::get('userpermissions')) )
                    { "name": "<span class='icon icon-list'></span> LO Number Generator", "type": "folder", "attr":{"parentNode" : "rootNode", "src" :"", "id":"<span class='icon icon-list'></span> LO Number Generator"}},
                    { "name": "<span class='icon icon-dashboard'></span> Dashboard", "type": "item", "attr":{"parentNode" : "<span class='icon icon-list'></span> LO Number Generator", "src" :"{{ URL::action('IndexController@dashboard', []) }}"}},
                    @if(in_array('lonumadminedit',Session::get('userpermissions')))
                    { "name": "<span class='icon icon-add'></span> Create New LO Number", "type": "item", "attr":{"parentNode" : "<span class='icon icon-list'></span> LO Number Generator", "src":"{{ URL::action('LoNumController@step1', []) }}"}},
                    { "name": "<span class='icon icon-edit'></span> Manage My LO Numbers", "type": "item", "attr":{"parentNode" : "<span class='icon icon-list'></span> LO Number Generator", "src":"{{ URL::action('IndexController@dashboard', ['type'=>'M']) }}"}},
                    { "name": "<span class='icon icon-edit'></span> Manage Others LO Numbers", "type": "item", "attr":{"parentNode" : "<span class='icon icon-list'></span> LO Number Generator", "src":"{{ URL::action('IndexController@dashboard', ['type'=>'O']) }}"}},
                    @endif
                    @endif

                    @if(in_array('csoddeeplink',Session::get('userpermissions')) || in_array('scormautocompbuilder',Session::get('userpermissions')) || in_array('scormnocompbuilder',Session::get('userpermissions')) )
                    { "name": "<span class='icon icon-list'></span> CSOD Content Tools", "type": "folder", "attr":{"parentNode" : "rootNode", "src" :"", "id":"<span class='icon icon-list'></span> CSOD Content Tools"}},
                    @if(in_array('csoddeeplink',Session::get('userpermissions')))
                    { "name": "<span class='icon icon-dropdown-menu'></span> CSOD Deeplink Generator", "type": "item", "attr":{"parentNode" : "<span class='icon icon-list'></span> CSOD Content Tools", "src" :"{{ URL::action('IndexController@construction', []) }}"}},
                    @endif
                    @if(in_array('scormautocompbuilder',Session::get('userpermissions')))
                    { "name": "<span class='icon icon-license-info'></span> SCORM Auto-Complete Builder", "type": "item", "attr":{"parentNode" : "<span class='icon icon-list'></span> CSOD Content Tools", "src" :"{{ URL::action('IndexController@construction', []) }}"}},
                    @endif
                    @if(in_array('scormnocompbuilder',Session::get('userpermissions')))
                    { "name": "<span class='icon icon-indicator'></span> SCORM No-Complete Builder", "type": "item", "attr":{"parentNode" : "<span class='icon icon-list'></span> CSOD Content Tools", "src" :"{{ URL::action('IndexController@construction', []) }}"}},
                    @endif
                    @endif

                    @if(in_array('useradmin',Session::get('userpermissions')))
                    { "name": "<span class='icon icon-list'></span> Administration", "type": "folder", "attr":{"parentNode" : "rootNode", "src" :"", "id":"<span class='icon icon-list'></span> Administration"}},
                    @if(in_array('useradmin',Session::get('userpermissions')))
                    { "name": "<span class='icon icon-profile'></span> User and Tool Permissions", "type": "item", "attr":{"parentNode" : "<span class='icon icon-list'></span> Administration", "src" :"{{ URL::action('UserController@index', []) }}"}},
                    @endif
                    @endif

                    { "name": "<span class='icon icon-goto'></span> CSOD", "type": "item", "attr":{"parentNode" : "rootNode", "src" :"javascript:window.open('https://alcatel-lucent.csod.com/','_newCsod');void(0);"}},
                    { "name": "<span class='icon icon-actions-menu'></span> Log Out", "type": "item", "attr":{"parentNode" : "rootNode", "src" :"javascript:top.window.location.href='{{ URL::action('LoginController@logout', []) }}';"}}
                ];

                function staticDataSource(openedParentData, callback) {
                    if(typeof openedParentData.attr != 'undefined'){
                            callback({
                                data: get(childNodesArray,openedParentData.name)
                            });
                    }else{
                            callback({
                                data: get(childNodesArray ,"rootNode")
                            });
                    }
                }

                function get(arrPerson,objValue)
                {
                    return $.grep(arrPerson, function(cur,i){
                        return cur.attr.parentNode==objValue;
                    });
                }

                var basicTree = $('#myTree');
                basicTree.tree({
                    dataSource: staticDataSource,
                    folderSelect :true
                });
                basicTree.tree('discloseAll');
            });

</script>
</body>
</html>