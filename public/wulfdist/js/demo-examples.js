/**
 * Created by ejacob on 3/30/2016.
 */
require(['jquery', 'jqxsplitter'], function ($) {

    $(document).ready(function () {
        'use strict';

        var $content = $('#content');
        var panels = [{size: 250, collapsible: false}, {collapsible: false}];
        var hash = location.hash;

        $('#demoExampleSplitterVertical').jqxSplitter({panels: panels});
        $(window).on('hashchange', function () {
            location.reload();
        });
        $(window).resize(function () {
            $('#demoExampleSplitterVertical').jqxSplitter('refresh');
        });
        $('#menu').attr('src', 'demo-examples-menu.html' + hash);

        window.contentIframe = $content;

    });
});