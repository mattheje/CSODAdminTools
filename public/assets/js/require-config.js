/**
 * Configuration file for RequireJS loader.
 * Created by mingghe on 2016/3/2.
 */
'use strict';

(function () {
    //Calculate the base URL according to the path of current page.
    var path = window.location.pathname;
    var baseUrl = 'wulfdist/js/dependencies';
    var index = path.lastIndexOf("components");
    baseUrl = index > 0 ? '../'.concat(baseUrl) : baseUrl;

    require.config({
        baseUrl: baseUrl,
        paths: {
            angular: '../../../wulfdist_ang15/js/dependencies/angular.min',
            angularAnimate: '../../../wulfdist_ang15/js/dependencies/angular-animate.min',
            angularTranslate:'../../../wulfdist_ang15/js/dependencies/angular-translate.min',
            translateLoader:'../../../wulfdist_ang15/js/dependencies/angular-translate-loader-partial.min',
            jquery: 'jquery.min',
            bootstrap: 'bootstrap.min',
            fuelux: 'fuelux',
            wulf_umd: '../wulf.min',
            wulf: '../components',
            'wulf-ng': '../../../wulfdist_ang15/js/components',
            'malihu-custom-scrollbar-plugin': 'jquery.mCustomScrollbar.concat.min',
            moment: 'moment-with-locales.min',
            'twitter-bootstrap-wizard': 'jquery.bootstrap.wizard.min',
            'moment-timezone': 'moment-timezone-with-data.min',
            jqxcore: 'jqxcore',
            jqxdata: 'jqxdata',
            jqxbuttons: 'jqxbuttons',
            jqxscrollbar: 'jqxscrollbar',
            jqxmenu: 'jqxmenu',
            jqxcheckbox: 'jqxcheckbox',
            jqxlistbox: 'jqxlistbox',
            jqxdropdownlist: 'jqxdropdownlist',
            jqxgrid: 'jqxgrid',
            jqxpanel: 'jqxpanel',
            'jqxgrid.edit': 'jqxgrid.edit',
            'jqxgrid.columnsresize': 'jqxgrid.columnsresize',
            'jqxgrid.columnsreorder': 'jqxgrid.columnsreorder',
            'jqxdata.export': 'jqxdata.export',
            'jqxgrid.export': 'jqxgrid.export',
            'jqxgrid.selection': 'jqxgrid.selection',
            'jqxgrid.filter': 'jqxgrid.filter',
            'jqxgrid.pager': 'jqxgrid.pager',
            'jqxgrid.sort': 'jqxgrid.sort',
            'jqxgrid.storage': 'jqxgrid.storage',
            jqxcombobox: 'jqxcombobox',
            jqxdraw: 'jqxdraw',
            jqxgauge:'jqxgauge',
            'jqxchart.core': 'jqxchart.core',
            jqxchart: 'jqxchart',
            jqxdatatable: 'jqxdatatable',
            jqxtreegrid: 'jqxtreegrid',
            jqxsplitter: 'jqxsplitter',
            jqxtree: 'jqxtree',
            i18next: 'i18next.min',
            'jquery-i18next':'jquery-i18next.min',
            'i18next-xhr-backend':'i18nextXHRBackend.min',
            d3: '../../../wulfdist_ang15/js/dependencies/d3.min'
        },

        shim: {
            angular: {
                exports: 'angular'
            },
            angularTranslate:{
                deps: ['angular']
            },
            translateLoader:{
                deps: ['angular','angularTranslate']
            },
            angularAnimate: {
                deps: ['angular']
            },
            bootstrap: {
                deps: ['jquery']
            },
            'twitter-bootstrap-wizard': {
                deps: ['jquery', 'bootstrap']
            },
            'malihu-custom-scrollbar-plugin': {
                deps: ['jquery']
            },
            jqxcore: {
                deps: ['jquery']
            },
            jqxdata: {
                deps: ['jqxcore']
            },
            jqxgrid: {
                deps: ['jqxcore', 'jqxdata', 'jqxbuttons', 'jqxscrollbar', 'jqxmenu', 'jqxlistbox', 'jqxdropdownlist']
            },
            'jqxgrid.selection': {
                deps: ['jqxgrid']
            },
            'jqxgrid.sort': {
                deps: ['jqxgrid']
            },
            'jqxgrid.storage': {
                deps: ['jqxgrid']
            },
            'jqxgrid.pager': {
                deps: ['jqxgrid']
            },
            'jqxgrid.filter': {
                deps: ['jqxgrid']
            },
            'jqxgrid.columnsresize': {
                deps: ['jqxgrid']
            },
            'jqxgrid.columnsreorder': {
                deps: ['jqxgrid']
            },
            'jqxdata.export': {
                deps: ['jqxgrid']
            },
            'jqxgrid.export': {
                deps: ['jqxgrid']
            },
            'jqxgrid.edit': {
                deps: ['jqxgrid']
            },
            jqxpanel: {
                deps: ['jqxcore', 'jqxscrollbar']
            },
            jqxdropdownlist: {
                deps: ['jqxcore', 'jqxbuttons', 'jqxscrollbar', 'jqxlistbox']
            },
            jqxlistbox: {
                deps: ['jqxcore', 'jqxbuttons', 'jqxscrollbar']
            },
            jqxcheckbox: {
                deps: ['jqxcore']
            },
            jqxmenu: {
                deps: ['jqxcore']
            },
            jqxscrollbar: {
                deps: ['jqxcore', 'jqxbuttons']
            },
            jqxbuttons: {
                deps: ['jqxcore']
            },
            jqxcombobox: {
                deps: ['jqxcore', 'jqxbuttons', 'jqxscrollbar', 'jqxlistbox']
            },
            'jqxchart.core': {
                deps: ['jqxcore']
            },
            jqxdraw: {
                deps: ['jqxcore']
            },
            jqxchart: {
                deps: ['jqxcore', 'jqxchart.core', 'jqxdraw', 'jqxdata']
            },
            jqxgauge:{
                deps: ['jqxcore','jqxdraw']
            },
            jqxdatatable: {
                deps: ['jqxdata','jqxbuttons','jqxscrollbar','jqxlistbox','jqxdropdownlist']
            },
            jqxtreegrid: {
                deps: ['jqxdatatable']
            },
            jqxsplitter: {
                deps: ['jqxcore']
            },
            jqxtree: {
                deps: ['jquery', 'jqxcore']
            },
            i18next: {
                deps: ['jquery']
            },
            'jquery-i18next': {
                deps: ['i18next','i18next-xhr-backend']
            },
            'i18next-xhr-backend': {
                deps: ['jquery']
            }
        }
    });
}());


