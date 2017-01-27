/*
 * ========================================================================
 * Copyright (C) 2016 Nokia Solutions and Networks. All rights Reserved.
 * ========================================================================
 */
require (['jquery', 'wulf/chart'], function ($) {
    'use strict';

    var tags = {
        'N/A': 'Not applicable',
        'Pending': 'Pending',
        'Draft': 'Draft',
        'Ongoing': 'Ongoing',
        'Proposal': 'Proposal',
        'Done': 'Done'
    };

    var ROW_HEIGHT = 15;
    var COL_WIDTH = 200;

    var ENTER_KEY = 13;
    var SPACE_BAR_KEY = 32;

    function getTag(view) {
        if (view === undefined || view.tags === undefined || view.tags.length === 0) {
            return 'N/A';
        }
        var viewTags = view.tags;
        for (var tag in tags) {
            for (var vt = 0; vt < viewTags.length; vt++) {
                if (tag === viewTags[vt]) {
                    return tag;
                }
            }
        }
        return 'N/A';
    }

    function getData(tech, components, data, parentName, level) {
        parentName = (parentName === undefined) ? '' : parentName;
        level = (level === undefined) ? 0 : level;
        for (var i = 0; i < components.length; i++) {
            var component = components[i];
            if (component.items && component.items.length > 0) {
                var passName = (parentName === '') ? component.label : parentName + ' ' + component.label;
                data = getData(tech, component.items, data, passName, level + 1);
            } else if (component.multiView && component.multiView.length > 0) {
                var viewTags = $.grep(component.multiView, function(multiView) {
                    return multiView.view === tech;
                });
                var tag = getTag(viewTags[0]);
                var noCount = component.noCount;
                if (tag && data[tag] !== undefined && (noCount === undefined || noCount === false)) {
                    data[tag].count++;
                    data['Total'].count++;
                    data[tag]['components'].push(component.label);
                    data[tag]['levels'].push(level);
                    data[tag]['parents'].push(parentName);
                }
            }
        }
        return data;
    }

    function getShare(tag, data) {
        return parseInt(data[tag].count / data['Total'].count * 100 + 0.49);
    }

    function getStatusData() {
        return { 'count': 0, 'components': [], 'levels': [], 'parents': [] };
    }

    function addChart(tech, components, devMode) {
        var id = tech.replace(/[\s\/.]/g,'-') + 'DemoGraph';
        var clone = $('.demo-graph-example').clone().removeClass('demo-graph-example');
        var data = { 'Pending' : getStatusData(), 'Draft' : getStatusData(),
                        'Ongoing' : getStatusData(), 'Proposal' : getStatusData(),
                        'Done' : getStatusData(), 'Total' : getStatusData() };
        // Clone chart
        $(clone).find('#graphExampleId').attr('id', id);
        data = getData(tech, components, data);
        if (!devMode) {
            data['Total'].count -= data['Draft'].count;
            data['Draft'].count = 0;
        }
        sessionStorage[id] = JSON.stringify(data);
        $(clone).find('.demo-graph-total').text(data['Total'].count);
        // Chart data
        var chartDataSummary = [
            { 'Status' : 'Draft',     'Share' : getShare('Draft', data) },
            { 'Status' : 'Pending',   'Share' : getShare('Pending', data) },
            { 'Status' : 'Ongoing',   'Share' : getShare('Ongoing', data) },
            { 'Status' : 'Proposal',  'Share' : getShare('Proposal', data) },
            { 'Status' : 'Done',      'Share' : getShare('Done', data) }
        ];
        // Chart settings
        var settingsSummary = {
            title: tech,
            description: '',
            enableAnimations: true,
            showLegend: false,
            showBorderLine: false,
            backgroundColor:'transparent',
            source: chartDataSummary,
            padding: { left: 0, top: 0, right: 0, bottom: 0 },
            seriesGroups: [
                {
                    type: 'donut',
                    showLabels: false,
                    showLegend: true,
                    toolTipFormatFunction: function (value, itemIndex) {
                        var browser =  chartDataSummary[itemIndex]['Status'];
                        return browser + '  &nbsp;&nbsp;<b>' + value + '%</b>';
                    },
                    series: [
                        {
                            dataField: 'Share',
                            displayText: 'Status',
                            labelRadius: 60,
                            initialAngle: 90,
                            radius: 100,
                            innerRadius: 60,
                            centerOffset: 0,
                            formatFunction : function (value, itemIndex) {
                                var browser =  chartDataSummary[itemIndex]['Status'];
                                return browser + ' \b ' + value + '%';
                            }
                        }
                    ]
                }
            ]
        };
        // Append and prepare
        $(clone).appendTo('.demo-technology-graphs');
        var $id = $('#' + id);
        $id.jqxChart(settingsSummary);
        $id.jqxChart('addColorScheme', 'nokiaScheme',
            [ '#ff6d24', '#646464', '#7778f6', '#759d39', '#149e07' ]);
        $id.jqxChart('colorScheme', 'nokiaScheme');
        $('.chart-panel').remove();
    }

    function addCharts(devMode) {
        var components = JSON.parse(sessionStorage['components']);
        if (components === undefined) {
            console.log('no component data!');
            return;
        }
        addChart('HTML/CSS', components, devMode);
        addChart('Angular 1.5', components, devMode);
        addChart('Angular 2.0', components, devMode);
    }

    function getFeatureData(id) {
        var data = JSON.parse(sessionStorage[id]);
        var back = [];
        var order = [ 'Done', 'Proposal', 'Ongoing', 'Pending', 'Draft' ];

        for (var i = 0; i < order.length; i++) {
            if (data[order[i]].count > 0) {
                var comps = data[order[i]];
                var parent = '-';
                back.push( { 'label': order[i], 'level': -1} );
                for (var j = 0; j < comps.components.length; j++) {
                    if (parent !== comps.parents[j]) {
                        if (parent.indexOf(comps.parents[j]) !== 0) {
                            back.push( { 'label': comps.parents[j].replace(parent, '').trim(),
                                            'level': comps.levels[j] - 1, 'header': true } )
                        }
                        parent = comps.parents[j];
                    }
                    back.push( { 'label': comps.components[j], 'level': comps.levels[j] } );
                }
            }
        }
        return back;
    }

    function prepareSummaryDialog(event) {
        var id = $(event.target).closest('.pie-chart').attr('id');
        var dialog = $('#SummaryDialog');
        if (id !== undefined) {
            //Fetch data for this graph
            var data = getFeatureData(id);
            var body = dialog.find('.modal-body');
            var total = data.length;
            var columns = parseInt((ROW_HEIGHT * total / 7 * 4) / COL_WIDTH + 0.5);
            columns = (columns < 1) ? 1 : columns;
            var componentsPerColumn = parseInt((total / columns) + 0.5);
            if (columns * componentsPerColumn !== total) {
                columns++;
                componentsPerColumn -= parseInt((componentsPerColumn - (total % columns)) / columns);
            }
            //Clear old data from dialog
            body.empty();
            //Create table with data
            body.append('<table style="width:100%">');
            for (var row = 0; row < componentsPerColumn; row++) {
                var tr = '<tr>';
                for (var col = 0; col < columns; col++) {
                    var c = row + col * componentsPerColumn;
                    var css = '';
                    var value = '';
                    if (c < data.length) {
                        value = data[c].label;
                        if (data[c].level === -1) {
                            var cssClass = value.toLowerCase();
                            css = "demo-color-" + cssClass;
                        } else {
                            css = 'table-space-on-left-level-' + data[c].level;
                            if (data[c].header === true) {
                                css += ' demo-color-header';
                            }
                        }
                    }
                    tr += '<td class="' + css + '">' + value + '</td>';
                }
                tr += '</tr>';
                body.append(tr);
            }
            body.append('</table>')
        }
        dialog.find('.modal-dialog').css('width', columns * COL_WIDTH + 50);
    }

    function showSummary(event) {
        prepareSummaryDialog(event);
        $('#SummaryDialog').show();
    }

    function closeSummary() {
        $('#SummaryDialog').hide();
    }

    function keyOnSummary(event) {
        if (event.keyCode === ENTER_KEY || event.keyCode === SPACE_BAR_KEY) {
            closeSummary();
        }
    }

    $(document).ready(function () {
        var devMode = window.parent.parent.devmode;
        addCharts(devMode);
        if (!devMode) {
            $('.demo-status-draft').closest('p').addClass('hidden');
        }
    });

    $(document)
        .on('click', '.chartContainer', showSummary)
        .on('click', '.modal-dialog button, .modal-dialog [role=button]', closeSummary)
        .on('keyup', '.modal-dialog button, .modal-dialog [role=button]', keyOnSummary)
    ;
});