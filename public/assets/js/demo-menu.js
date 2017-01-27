/**
 * ========================================================================
 * Copyright (C) 2016 Nokia Solutions and Networks. All rights Reserved.
 * ======================================================================== */

require (['jquery', 'wulf/tree', 'jqxcore', 'jqxbuttons', 'jqxscrollbar',
    'jqxpanel', 'jqxtree'], function ($) {

    var ENTER_KEY = 13;
    var SPACE_BAR_KEY = 32;
    var PAGE_UP_KEY = 33;
    var PAGE_DOWN_KEY = 34;
    var END_KEY = 35;
    var HOME_KEY = 36;
    var LEFT_KEY = 37;
    var UP_KEY = 38;
    var RIGHT_KEY = 39;
    var DOWN_KEY = 40;

    var idMap = [];
    var keyStrokeTimer;

    var HTMLCSS = "HTML/CSS";
    var ANG15 = "Angular 1.5";
    var ANG20 = "Angular 2.0";

    var TAG = {
        PURE: "Pure HTML/CSS",
        DRAFT: "Draft",
        ONGOING: "Ongoing",
        DONE: "Done",
        NA: "N/A",
        PENDING: "Pending",
        PROPOSAL: "Proposal",
        JS: "JS",
        JQUERY: "jQuery",
        FUX: "FuelUX",
        HC: "HighCharts",
        JQX: "jqxWidget"
    };

    var dirDefs = [
        {name: 'HTML/CSS', dir: 'components', short: 'H/C'},
        {name: 'Angular 1.5', dir: 'ng-components', short: 'A1.5'},
        {name: 'Angular 2.0', dir: 'ng2-components', short: 'A2.0'}
    ];

    // Components definition
    //
    // Tree tag status:
    //
    // N/A:         Not available and currently no plans to do this
    // Draft:       Visible only in devmode
    // Pending:     Some work done but not worked on currently
    // Ongoing:     Work currently ongoing, some parts may be already usable
    // Proposal:    Component is almost ready for use, minor tuning expected
    // Done:        Component ready
    //
    // 1) Only one status is shown per tech. If multiple status exists,
    // worst status is picked, e.g. if you have DRAFT and DONE => DRAFT status is shown
    // 2) If no status exists, "N/A" is used
    // 3) Parents are not filtered, include parent in keyword if you want to include an item based on parent
    //
    // Other settings:
    // noHidden:    This tree item is always visible, no filter or tech selection will hide it
    // noCount:     This tree item is not counted as "component" in welcome page

    var components = [
        {label: 'Welcome', src: 'demo-examples-welcome.html', notHidden: true},
        {
            label: 'Common',
            items: [
                {
                    // demo-examples-empty.html
                    // color.html
                    label: 'Colors', "src": "components/color.html", "tags": [TAG.DONE], keywords: [""]
                },
                {
                    label: 'Icons', "src": "components/icons.html", "tags": [TAG.DONE], keywords: [""]
                },
                {
                    label: 'Icons in table cells',
                    "src": "components/icons-table-cells.html",
                    "tags": [TAG.DONE],
                    keywords: [""]
                },
                {
                    label: 'Typography', "src": "components/typography.html", "tags": [TAG.DONE], keywords: ["fonts"]
                }
            ]
        },
        {
            label: 'Dialog',
            items: [
                {
                    // dlg-common.html
                    label: 'Common', "src": "dlg-common.html", keywords: ["dialog"], noCount: true,
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                }, {
                    // dlg-about.html
                    label: 'About', "src": "dlg-about.html", keywords: ["dialog"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    label: 'Login', expanded: true,
                    items: [
                        {
                            // login-common.html
                            label: "Common", src: "login-common.html", keywords: ["login", "dialog"],
                            "multiView": [
                                {"view": HTMLCSS, "tags": [TAG.DONE]},
                                {"view": ANG15, "tags": [TAG.DONE]},
                                {"view": ANG20, "tags": [TAG.NA]}
                            ]
                        },
                        {
                            // login-standard.html
                            label: "Standard", src: "login-standard.html", keywords: ["login", "dialog"],
                            "multiView": [
                                {"view": HTMLCSS, "tags": [TAG.DONE]},
                                {"view": ANG15, "tags": [TAG.DONE]},
                                {"view": ANG20, "tags": [TAG.NA]}
                            ]
                        },
                        {
                            // login-error.html
                            label: "Error", src: "login-error.html", keywords: ["login", "dialog"],
                            "multiView": [
                                {"view": HTMLCSS, "tags": [TAG.DONE]},
                                {"view": ANG15, "tags": [TAG.DONE]},
                                {"view": ANG20, "tags": [TAG.NA]}
                            ]
                        },
                        {
                            // login-signup.html
                            label: "Account sign", src: "login-signup.html", keywords: ["login", "dialog"],
                            "multiView": [
                                {"view": HTMLCSS, "tags": [TAG.DONE]},
                                {"view": ANG15, "tags": [TAG.DONE]},
                                {"view": ANG20, "tags": [TAG.NA]}
                            ]
                        },
                        {
                            // login-product.html
                            label: "Product", src: "login-product.html", keywords: ["login", "dialog"],
                            "multiView": [
                                {"view": HTMLCSS, "tags": [TAG.DONE]},
                                {"view": ANG15, "tags": [TAG.DONE]},
                                {"view": ANG20, "tags": [TAG.NA]}
                            ]
                        },
                        {
                            // login-legal-copy.html
                            label: "Legal copy", src: "login-legal-copy.html", keywords: ["login", "dialog"],
                            "multiView": [
                                {"view": HTMLCSS, "tags": [TAG.DONE]},
                                {"view": ANG15, "tags": [TAG.DONE]},
                                {"view": ANG20, "tags": [TAG.NA]}
                            ]
                        },
                        {
                            // login-legal-accept.html
                            label: "Legal acceptance", src: "login-legal-accept.html", keywords: ["login", "dialog"],
                            "multiView": [
                                {"view": HTMLCSS, "tags": [TAG.DONE]},
                                {"view": ANG15, "tags": [TAG.DONE]},
                                {"view": ANG20, "tags": [TAG.NA]}
                            ]
                        },
                        {
                            // login-four-column.html
                            label: "Four column", src: "login-four-column.html", keywords: ["login", "dialog"],
                            "multiView": [
                                {"view": HTMLCSS, "tags": [TAG.DONE]},
                                {"view": ANG15, "tags": [TAG.DONE]},
                                {"view": ANG20, "tags": [TAG.NA]}
                            ]
                        }
                    ]
                },
                {
                    // file-upload.html
                    label: 'File upload', "src": "file-upload.html", keywords: ["dialog"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // dlg-active.html
                    label: "Active", src: "dlg-active.html", keywords: ["dialog"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // dlg-subheader.html
                    label: "Plain subheader", src: "dlg-subheader.html", keywords: ["dialog"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "src": "ng-components/dlg-common.html", "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // dlg-subheader-instruct.html
                    label: "Subheader instruct",
                    src: "dlg-subheader-instruct.html",
                    keywords: ["dialog"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // dlg-instruct.html
                    label: "Instruction", src: "dlg-instruct.html", keywords: ["dialog"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // dlg-subheader-resize.html
                    label: "Subheader resize", src: "dlg-subheader-resize.html", keywords: ["dialog"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.ONGOING]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // dlg-wizard.html
                    label: "Wizard", src: "dlg-wizard.html", keywords: ["dialog"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                }
            ]
        },
        {
            label: 'Message',
            items: [
                {
                    // alert.html
                    label: 'Alert', src: "alert.html", keywords: ["message"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE, TAG.PURE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // balloon.html
                    label: 'Balloon', src: "balloon.html", keywords: ["message"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.PURE, TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "src": "ng2-components/balloon.demo.html", "tags": [TAG.DONE]}
                    ]
                },
                {
                    label: 'Dialog', expanded: true,
                    items: [
                        {
                            // dlg-confirmation.html
                            label: "Confirm", src: "dlg-confirmation.html", keywords: ["dialog", "message"],
                            "multiView": [
                                {"view": HTMLCSS, "tags": [TAG.DONE]},
                                {"view": ANG15, "src": "ng-components/dlg-common.html", "tags": [TAG.DONE]},
                                {"view": ANG20, "tags": [TAG.NA]}
                            ]
                        },
                        {
                            // dlg-error.html
                            label: "Error", src: "dlg-error.html", keywords: ["dialog", "message"],
                            "multiView": [
                                {"view": HTMLCSS, "tags": [TAG.DONE]},
                                {"view": ANG15, "src": "ng-components/dlg-common.html", "tags": [TAG.DONE]},
                                {"view": ANG20, "tags": [TAG.NA]}
                            ]
                        },
                        {
                            // dlg-warning.html
                            label: "Warning", src: "dlg-warning.html", keywords: ["dialog", "message"],
                            "multiView": [
                                {"view": HTMLCSS, "tags": [TAG.DONE]},
                                {"view": ANG15, "src": "ng-components/dlg-common.html", "tags": [TAG.DONE]},
                                {"view": ANG20, "tags": [TAG.NA]}
                            ]
                        }
                    ]
                },
                {
                    // tooltip.html
                    label: 'Tooltip', src: "tooltip.html", keywords: ["message"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.PURE, TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "src": "ng2-components/tooltip.demo.html", "tags": [TAG.DONE]}
                    ]
                },
                {
                    // inline-info.html
                    label: 'Inline Info', src: "inline-info.html", keywords: ["message"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.NA]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                }
            ]
        },
        {
            label: 'Charts',
            items: [
                {
                    // chart-jqx-bar-vert.html
                    label: 'Bar vertical JQX',
                    "src": "chart-jqx-bar-vert.html",
                    keywords: ["chart"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE, TAG.JQX]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // chart-jqx-bar-horiz.html
                    label: 'Bar horizontal JQX',
                    "src": "chart-jqx-bar-horiz.html",
                    keywords: ["chart"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE, TAG.JQX]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // chart-jqx-line.html
                    label: 'Line JQX', "src": "chart-jqx-line.html", keywords: ["chart"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE, TAG.JQX]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // chart-jqx-pie.html
                    label: 'Pie JQX', "src": "chart-jqx-pie.html", keywords: ["chart"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE, TAG.JQX]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // chart-jqx-gauge.html
                    label: 'Speedometer JQX', "src": "chart-jqx-gauge.html", keywords: ["chart"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE, TAG.JQX]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // chart-dashboard-tile.html
                    label: 'Dashboard tile', "src": "chart-dashboard-tile.html", keywords: ["chart"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DRAFT]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // chart-line.html
                    label: 'Line chart', "src": "chart-line.html", keywords: ["chart"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.NA]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // chart-hc-bar-vert.html
                    label: 'Bar HC', "src": "chart-hc-bar-vert.html", keywords: ["chart"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE, TAG.HC]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                }
            ]
        },
        {
            label: 'Control',
            items: [
                {
                    // button.html
                    label: 'Button', src: "button.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.PURE, TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // checkbox.html
                    label: 'Checkbox', src: "checkbox.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.PURE, TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // combobox.html
                    label: 'Combobox', src: "combobox.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.PURE, TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // combobox-scrollbar.html
                    label: 'Combobox scroll', src: "combobox-scrollbar.html", noCount: true,
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // label.html
                    label: 'Label', src: "label.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.NA]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // link.html
                    label: 'Link', src: "link.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.PURE, TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // list.html
                    label: 'List', src: "list.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // list-scrollbar.html
                    label: 'List scroll', src: "list-scrollbar.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // list-description.html
                    label: 'List description', src: "list-description.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // list-multicolumn.html
                    label: 'List multicolumn', src: "list-multicolumn.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // progress.html
                    label: 'Progress', src: "progress.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // dropdown.html
                    label: 'Pulldown', src: "dropdown.html", keywords: ["dropdown"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.PURE, TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // dropdown-scrollbar.html
                    label: 'Pulldown scroll', src: "dropdown-scrollbar.html", keywords: ["dropdown"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // splitter.html
                    label: 'Splitter', src: "splitter.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // textarea.html
                    label: 'Text area', src: "textarea.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.PURE, TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // textarea-borderless.html (CAN THIS BE MERGED WITH TEXTAREA ?)
                    label: 'Text area borderless', src: "textarea-borderless.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.PURE, TAG.NA]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // inputfield.html
                    label: 'Text field', src: "inputfield.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.PURE, TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // button-toggle.html
                    label: 'Toggle button', src: "button-toggle.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.PURE, TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, src: "ng2-components/toggle_button.demo.html", "tags": [TAG.DONE]}
                    ]
                },
                {
                    // button-tab.html
                    label: 'Tab button', src: "button-tab.html", keywords: ["action"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "src": "ng2-components/tab_button.demo.html", "tags": [TAG.DONE]}
                    ]
                },
                {
                    // button-carousel.html
                    label: 'Carousel button', src: "button-carousel.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DRAFT]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // button-radio.html
                    label: 'Radio button', src: "button-radio.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // drilldown.html
                    label: 'Drilldown', src: "drilldown.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // inline-toolbar.html
                    label: 'Inline toolbar', src: "inline-toolbar.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.NA]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // drilldown-without-arrow.html
                    label: 'Drilldown without arrow', src: "drilldown-without-arrow.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // scroll.html
                    label: 'Scroll', src: "scroll.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "src": "ng2-components/scrollbar.demo.html", "tags": [TAG.DONE]}
                    ]
                },
                {
                    // spinner.html
                    label: 'Spinner', src: "spinner.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // slider.html
                    label: 'Slider', src: "slider.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // breadcrumb.html
                    label: 'Breadcrumb', src: "breadcrumb.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // search.html
                    label: 'Search', src: "search.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // calendar.html
                    label: 'Calendar', src: "calendar.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // calendar-timer.html
                    label: 'Calendar with time', src: "calendar-timer.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // calendar-date-range.html
                    label: 'Calendar with date range', src: "calendar-date-range.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // timezone.html
                    label: 'Timezone', src: "timezone.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // lifecycle.html
                    label: 'Lifecycle', src: "lifecycle.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // taskpad.html
                    label: 'Taskpad', src: "taskpad.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // validation.html
                    label: 'Validations', src: "validation.html", keywords: ["text", "field"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                }
            ]
        },
        {
            label: 'Container',
            items: [
                {
                    // form.html
                    label: 'Form', src: "form.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // panel.html
                    label: 'Panel', src: "panel.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.PURE, TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // panel-scrollbar.html
                    label: 'Panel scroll', src: "panel-scrollbar.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, src: "ng-components/panel.html", "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // panel-slide-vert.html
                    label: 'Panel vertical', src: "panel-slide-vert.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, src: "ng-components/panel.html", "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // panel-slide-horiz.html
                    label: 'Panel horizontal', src: "panel-slide-horiz.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, src: "ng-components/panel.html", "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // drawer.html
                    label: 'Drawer', src: "drawer.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // tab-pane.html
                    label: 'Tabbed pane', src: "tab-pane.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // tab-pane-scrollbar.html
                    label: 'Tabbed pane scroll', src: "tab-pane-scrollbar.html",
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.ONGOING]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                }
            ]
        },
        {
            label: 'Table and tree',
            items: [
                {
                    // table.html
                    label: 'Table', src: "table.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "src": "ng2-components/table.demo.html", "tags": [TAG.ONGOING]}
                    ]
                },
                {
                    // table-scrollbar.html
                    label: 'Table scroll', src: "table-scrollbar.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // table-filter.html
                    label: 'Table filter', src: "table-filter.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "src": "ng2-components/table_filter.demo.html", "tags": [TAG.ONGOING]}
                    ]
                },
                {
                    // table-paging.html
                    label: 'Table paging', src: "table-paging.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // table-indicator.html
                    label: 'Table indicator', src: "table-indicator.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // table-error.html
                    label: 'Table error', src: "table-error.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // table-cell-visual.html
                    label: 'Table cell visual', src: "table-cell-visual.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.ONGOING]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // grid.html
                    label: 'Table JQX', src: "grid.html", keywords: ["grid"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE, TAG.JQX]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // grid-filter.html
                    label: 'Table filter JQX', src: "grid-filter.html", keywords: ["grid"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE, TAG.JQX]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // grid-paging.html
                    label: 'Table paging JQX', src: "grid-paging.html", keywords: ["grid"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE, TAG.JQX]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // grid-indicator.html
                    label: 'Table indicator JQX', src: "grid-indicator.html", keywords: ["grid"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE, TAG.JQX]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // grid-error.html
                    label: 'Table error JQX', src: "grid-error.html", keywords: ["grid"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE, TAG.JQX]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // grid-sorter.html
                    label: 'Table sort JQX', src: "grid-sorter.html", keywords: ["grid"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE, TAG.JQX]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // grid-add-delete-row.html
                    label: 'Table add/delete JQX', src: "grid-add-delete-row.html", keywords: ["grid"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE, TAG.JQX]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // table-smart.html
                    label: 'Smart Table', src: "table-smart.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.NA]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // table-smart-filter.html
                    label: 'Smart Table filter', src: "table-smart-filter.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.NA]},
                        {"view": ANG15, "tags": [TAG.ONGOING]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // table-smart-paging.html
                    label: 'Smart Table paging', src: "table-smart-paging.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.NA]},
                        {"view": ANG15, "tags": [TAG.ONGOING]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // table-smart-indicator.html
                    label: 'Smart Table indicator', src: "table-smart-indicator.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.NA]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // table-smart-error.html
                    label: 'Smart Table error', src: "table-smart-error.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.NA]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // table-smart-scroll.html
                    label: 'Smart Table scroll', src: "table-smart-scroll.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.NA]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // tree.html
                    label: 'Tree', src: "tree.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // tree-scrollbar.html
                    label: 'Tree scroll', src: "tree-scrollbar.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // tree-folder-select.html
                    label: 'Tree folder', src: "tree-folder-select.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // tree-html-css.html
                    label: 'Tree pure', src: "tree-html-css.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE, TAG.PURE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // tree-grid.html
                    label: 'Tree table', src: "tree-grid.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, src: "ng-components/tree-table.html", "tags": [TAG.DONE]},
                        {"view": ANG20, src: "ng2-components/tree_table.demo.html", "tags": [TAG.ONGOING]}
                    ]
                }
            ]
        },
        {
            label: 'Banner and footer',
            items: [
                {
                    // banner-common.html
                    label: 'Banner Common', src: "banner-common.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.NA]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // banner-normal.html
                    label: 'Banner', src: "banner-normal.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // banner-action-nav.html
                    label: 'Banner action nav', src: "banner-action-nav.html", keywords: ["navigation"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // banner-overflow.html
                    label: 'Banner overflow', src: "banner-overflow.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // banner-condensed.html
                    label: 'Banner condensed', src: "banner-condensed.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // banner-filter.html
                    label: 'Banner filter', src: "banner-filter.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, src: "ng-components/banner-normal.html", "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // footer-common.html
                    label: 'Footer Common', src: "footer-common.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // footer-consumer.html
                    label: 'Footer consumer', src: "footer-consumer.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // footer-product-copyright.html
                    label: 'Footer product copyright', src: "footer-product-copyright.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // footer-product-link-bordered.html
                    label: 'Footer product border', src: "footer-product-link-bordered.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // flyout-menu.html
                    label: 'Flyout menu', src: "flyout-menu.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // flyout-activity-area.html
                    label: 'Flyout activity', src: "flyout-activity-area.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                }
            ]
        },
        {
            label: 'Navigation',
            items: [
                {
                    // navigation-local.html
                    label: 'Local navigation', src: "navigation-local.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // navigation-second-vert.html
                    label: 'Secondary nav vertical', src: "navigation-second-vert.html", keywords: ["navigation"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.ONGOING]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // navigation-second-horiz.html
                    label: 'Secondary nav horizontal', src: "navigation-second-horiz.html", keywords: ["navigation"],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                },
                {
                    // navigation-localized-sub.html
                    label: 'Local sub navigation', src: "navigation-localized-sub.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.DONE]},
                        {"view": ANG15, "tags": [TAG.DONE]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                }
            ]
        },
        {
            label: 'Widgets',
            items: [
                {
                    label: 'Table panel', "src": "table-panel.html", keywords: [""],
                    "multiView": [
                        {"view": HTMLCSS, "tags": [TAG.ONGOING]},
                        {"view": ANG15, "tags": [TAG.NA]},
                        {"view": ANG20, "tags": [TAG.NA]}
                    ]
                }
            ]
        },
        {
            // examples-all-in-one.html
            label: 'All components', src: "examples-all-in-one.html", keywords: [""], noCount: true,
            "multiView": [
                {"view": HTMLCSS, "tags": [TAG.DRAFT]},
                {"view": ANG15, "tags": [TAG.NA]},
                {"view": ANG20, "tags": [TAG.NA]}
            ]
        }
    ];

    //Creates two dimensional map where key is jqxTree item and value component item
    function createIdMap(source, items, index, parent) {
        for (var i = 0; i < source.length; i++) {
            var s = source[i];
            s.parent = parent;
            idMap[items[index].id] = s;
            index++;
            if (s.items && s.items.length > 0) {
                index = createIdMap(s.items, items, index, s);
            }
        }
        return index;
    }

    function getSourceTreeId(source) {
        for (var value in idMap) {
            if (idMap[value] === source) {
                return value;
            }
        }
        return -1;
    }

    function addStatusTag(itemSource, item, view, devMode) {
        var tags = {
            'N/A': '<span class="demo-status-na"></span>',
            'Pending': '<span class="demo-status-pending"></span>',
            'Draft': '<span class="demo-status-draft"></span>',
            'Ongoing': '<span class="demo-status-ongoing"></span>',
            'Proposal': '<span class="demo-status-proposal"></span>',
            'Done': '<span class="demo-status-ok"></span>'
        };
        var back = 'N/A';
        var viewWithTags = [];
        //If common page, tags are in root
        if (view === '') {
            viewWithTags.push(itemSource);
        } else {
            viewWithTags = $.grep(itemSource.multiView, function(multiView) {
                return multiView.view === view;
            });
        }

        if (viewWithTags.length === 0) {
            item.append(tags['N/A']);
        } else {
            var set = false;
            var viewTags = viewWithTags[0].tags;
            for (tag in tags) {
                for (var vt = 0; vt < viewTags.length && !set; vt++) {
                    if (tag === viewTags[vt] && !set) {
                        //If state is Draft but not in devMode, do not show item
                        if (viewTags[vt] === 'Draft' && !devMode) {
                            item.append(tags['N/A']);
                            set = true;
                        } else {
                            item.append(tags[tag]);
                            back = tag;
                            set = true;
                        }
                    }
                }
            }
            //If no status tag exist, set it to N/A
            if (!set) {
                back = 'N/A';
                item.append(tags[back]);
            }
        }
        //Filter last visible states, basically all but N/A is visible only in dev mode atm
        return !(devMode || back === 'Proposal' || back === 'Pending' || back === 'Ongoing' || back === 'Done' ||
                    back === 'Draft');
    }

    function getSelectedTechs() {
        var techs = $('.tech-select');
        var back = [];

        for (var i = 0; i < techs.length; i++) {
            if ($(techs[i]).hasClass('selected')) {
                back.push(dirDefs[i].name);
                dirDefs[i].selected = true;
            } else {
                dirDefs[i].selected = false;
            }
        }
        return back;
    }

    function checkParent(id) {
        var $tree = $('#componentTree');
        var $search = $('#component-search');
        var visible = false;
        var source = idMap[id];
        var liItem = $tree.find('#' + id);
        var count = 0;
        var text = source.label;
        var filterOn = ($search.val() !== '') && ($search.hasClass('js-typed'));

        for (var i = 0; i < source.items.length; i++) {
            if (source.items[i].items && source.items[i].items.length > 0) {
                var nextParentId = getSourceTreeId(source.items[i]);

                if (nextParentId !== -1) {
                    var child = checkParent(nextParentId);
                    visible |= child.visible;
                    count += child.count;
                }
            } else {
                if (source.items[i].visible === true) {
                    visible = true;
                    count++;
                }
            }
        }

        if (visible) {
            $(liItem[0]).css('display', 'list-item');
            if (filterOn) {
                $tree.jqxTree('expandItem', liItem[0]);
            }
        } else {
            $tree.jqxTree('collapseItem', liItem[0]);
            $(liItem[0]).css('display', 'none');
        }
        text = (count > 0) ? '<span class="menu-component-count"> (' + count + ')</span>' : '';
        $(liItem[0]).find('.jqx-tree-item .menu-component-count').first().remove();
        $(liItem[0]).find('.jqx-tree-item').first().append(text);
        source.visible = visible;

        return { 'visible': visible, 'count': count };
    }

    function updateParentActiveState() {
        var $tree = $('#componentTree');
        var allItems = $tree.jqxTree('getItems');

        for (var i = 0; i < allItems.length; i++) {
            if (allItems[i].parentElement === null && allItems[i].hasItems) {
                checkParent(allItems[i].id);
            }
        }

        $('#component-search').removeClass('js-typed');
    }

    function isFiltered(source) {
        var filter = $('#component-search').val().toUpperCase();
        var keywords = source.keywords || [];

        if (filter === '*') {
            return false;
        }

        if (filter !== '' && source.label.toUpperCase().indexOf(filter) === -1) {
            if (keywords && keywords.length) {
                for (var i = 0; i < keywords.length; i++) {
                    if (keywords[i].toUpperCase().indexOf(filter) !== -1) {
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }

    function updateStatus() {
        var devMode = window.parent.parent.devmode || false;
        var $tree = $('#componentTree');
        var allItems = $tree.jqxTree('getItems');
        var status;
        //Get selected techs
        order = getSelectedTechs().reverse();
        //Remove old statuses
        $tree.find('span[class*=demo-status]').remove();

        for (var i = 0; i < allItems.length; i++) {
            var element = allItems[i].element;
            var item = $(allItems[i].element).find('.jqx-tree-item').first();
            var itemSource = idMap[allItems[i].id];

            var hide = true;
            var setVisibility = false;
            if (itemSource !== -1) {
                //Multiview handling
                if (itemSource.multiView && itemSource.multiView.length > 0) {
                    if (!isFiltered(itemSource)) {
                        for (var o = 0; o < order.length; o++) {
                            if (!addStatusTag(itemSource, item, order[o], devMode)) {
                                hide = false;
                            }
                        }
                    }
                    setVisibility = true;
                } else {
                    //Common page handling
                    if (itemSource.notHidden !== true && itemSource.items === undefined) {
                        if (!isFiltered(itemSource)) {
                            hide = addStatusTag(itemSource, item, '', devMode);
                        }
                        setVisibility = true;
                    }
                }
                //In this method we only hide/show child elements
                if (setVisibility) {
                    //Show or hide tree item based on value
                    $(element).css('display', (hide) ? 'none' : 'list-item');
                    itemSource.visible = !hide;
                    //This is needed because of firefox
                    $(element).css('white-space', 'normal');
                }
            }
        }
        //Check if parent leaf have no active children
        updateParentActiveState();
    }

    function clickTechSelect(event) {
        var $menu = $(event.target);
        var $tree = $('#componentTree');
        var source = window.parent.MultiView.item;

        if ($menu.hasClass('selected')) {
            $menu.removeClass('selected');
            storeValue('example-' + $menu.text(), '');
        } else {
            $menu.addClass('selected');
            storeValue('example-' + $menu.text(), 'selected');
        }
        //Run filter again just in case there are now some new hidden values
        //We do not call keyStrokeInFilter as it has that timeout, we would not get latest info now
        $('#component-search').addClass('js-typed');
        refreshTreeSize();
        //Select the item again to remove/add added tech as needed
        if (source !== undefined && source.visible) {
            selectItemInTree(source);
        } else {
            $tree.jqxTree('selectItem', $tree.find('li:first')[0]);
        }
    }

    function clearFilter() {
        $filter = $('#component-search');
        if ($filter.val() !== '') {
            $filter.val('');
            keyStrokeInFilter();
        }
    }

    function keyStrokeInFilter() {
        var $search = $('#component-search');
        clearTimeout(keyStrokeTimer);
        $search.addClass('js-typed');
        keyStrokeTimer = setTimeout(refreshTreeSize, 200);
        storeValue('example-filter', $search.val());
    }

    function selectItemInTree(sourceItem) {
        window.parent.MultiView.item = sourceItem;
        storeValue('example-source-item', sourceItem.label + '+' + sourceItem.src);

        if (sourceItem !== undefined) {
            if (sourceItem.multiView && sourceItem.multiView.length > 0) {
                window.parent.contentIframe.attr('src', 'demo-multiview.html');
            } else if (sourceItem.src) {
                //Check if welcome page
                if (sourceItem.notHidden) {
                    window.parent.contentIframe.attr('src', sourceItem.src);
                } else {
                    //Common page, handled by multiview
                    window.parent.contentIframe.attr('src', 'demo-multiview.html');
                }
            } else if (sourceItem.items && sourceItem.items.length > 0) {
                window.parent.contentIframe.attr('src', 'demo-examples-summary.html');
            }
        }
    }

    function selectItemInTreeEvent(event) {
        selectItemInTree(idMap[event.args.element.id]);
    }

    function refreshTreeSize() {
        var $tree = $('#componentTree');
        updateStatus();
        $tree.jqxTree('refresh');
        var isScrollBarHidden = ($('#panelcomponentTreeverticalScrollBar').css('visibility') === 'hidden');
        var width = $tree.css('width').replace('px', '') - (isScrollBarHidden ? 0 : 18);
        $tree.find('.jqx-tree-dropdown-root').css('width', width + 'px');
        $tree.find('.jqx-tree-item-li .jqx-tree-item').each( function( i, e) {
            $(e).css("width", width - $(e).offset().left + 'px');
        });
    }

    function storeValue(name,value) {
        sessionStorage[name] = value;
    }

    function readValue(name) {
        return sessionStorage[name] === undefined ? null : sessionStorage[name];
    }

    function filterKeyUp(event) {
        if (event.keyCode === SPACE_BAR_KEY || event.keyCode === ENTER_KEY) {
            clearFilter();
        }
    }

    function restoreSelections() {
        var firstTreeItem = true;
        var sourceItem = readValue('example-source-item');
        var filter = readValue('example-filter');
        var $tree = $('#componentTree');

        //Make tech selection active
        $('#example-component-filter').find('.tech-select').each(function (i, e) {
            var selected = readValue('example-' + $(e).text());
            if (selected !== null) {
                if (selected === '') {
                    $(e).removeClass('selected');
                } else {
                    $(e).addClass('selected');
                }
            }
        });
        //Update filter based on saved value
        if (filter !== null) {
            $('#component-search').val(filter);
            keyStrokeInFilter();
        }
        //Update selected item in tree and make sure all parents to it are expanded
        if (sourceItem !== null) {
            for (var value in idMap) {
                if (idMap[value].label + '+' + idMap[value].src === sourceItem) {
                    $tree.jqxTree('selectItem', $tree.find('#' + value)[0]);
                    var s = idMap[value];
                    while (s.parent !== undefined) {
                        var id = getSourceTreeId(s.parent);
                        $tree.jqxTree('expandItem',  $tree.find('#' + id)[0]);
                        s = s.parent;
                    }
                    setTimeout(function() {
                        $tree.jqxTree('ensureVisible', $tree.find('#' + value)[0]);
                    }, 150);

                    firstTreeItem = false;
                }
            }
        }
        if (firstTreeItem) {
            $tree.jqxTree('selectItem', $tree.find('li:first')[0]);
        }
        //Finally make tree visible
        $('#waitingForTree').addClass('hidden');
        $tree.removeClass('hidden');
    }

    function clickOnTreeItem(event) {
        $(event.target).closest('.jqx-tree-item').find('a').first().trigger('focus');
    }

    function keyDownOnTree(event) {
        var $tree = $('#componentTree');
        var id = $(event.target).closest('.jqx-tree-item-li').attr('id');
        var item = $tree.find('#' + id)[0];
        var items = $('.jqx-tree-dropdown-root').find('a:visible:not([disabled])');
        var currentIndex = items.index(event.target);
        var pageSize = parseInt($tree.height() / $($tree.find('li:first')[0]).height());
        pageSize = pageSize < 0 ? 0 : pageSize;
        var newIndex;

        switch (event.keyCode) {
            case SPACE_BAR_KEY:
                $tree.jqxTree('selectItem', item);
                break;
            case RIGHT_KEY:
                $tree.jqxTree('expandItem', item);
                break;
            case LEFT_KEY:
                $tree.jqxTree('collapseItem', item);
                break;
            case DOWN_KEY:
                newIndex = currentIndex < items.length - 1 ? currentIndex + 1 : items.length - 1;
                break;
            case UP_KEY:
                newIndex = currentIndex > -1 ? currentIndex - 1 : 0;
                break;
            case HOME_KEY:
                newIndex = 0;
                break;
            case END_KEY:
                newIndex = items.length - 1;
                break;
            case PAGE_UP_KEY:
                newIndex = currentIndex - pageSize < 0 ? 0 : currentIndex - pageSize;
                break;
            case PAGE_DOWN_KEY:
                newIndex = currentIndex + pageSize > items.length - 1 ? items.length - 1 : currentIndex + pageSize;
                break;
            default:
                break;
        }

        if (newIndex != undefined && currentIndex !== newIndex) {
            $(items[newIndex]).trigger('focus');
        }
    }

    function onFocusInTree() {
        var $tree = $('#componentTree');
        var a = $tree.find('a:focus');
        if (a.length > 0) {
            $tree.jqxTree('ensureVisible', (a.closest('.jqx-tree-item-li')));
            a.closest('.jqx-tree-item').addClass('js-focus');
        }
    }

    function onBlurInTree() {
        $('#componentTree').find('.js-focus').removeClass('js-focus');
    }

    $(document)
        .on('click', '.tech-select', clickTechSelect)
        .on('keyup', '#component-search', keyStrokeInFilter)
        .on('expand', '#componentTree', refreshTreeSize)
        .on('collapse', '#componentTree', refreshTreeSize)
        .on('select', '#componentTree', selectItemInTreeEvent)
        .on('click', '.n-search-control-icon', clearFilter)
        .on('keydown', '.n-search-control-icon', filterKeyUp)
        .on('click', '.jqx-tree-item', clickOnTreeItem)
        .on('keydown', '.jqx-tree-item a', keyDownOnTree)
        .on('focus', '.jqx-tree-item a', onFocusInTree)
        .on('blur', '.jqx-tree-item a', onBlurInTree);

    $(document).ready (function () {
        window.parent.MultiView = {};
        window.parent.MultiView.defs = dirDefs;
        storeValue('components', JSON.stringify(components));
        var $tree = $('#componentTree');
        $tree.jqxTree(
            {
                source: components,
                height: '100%',
                keyboardNavigation: false,
                animationShowDuration: 0,
                animationHideDuration: 0
            });
        createIdMap(components, $tree.jqxTree('getItems'), 0);

        //Add anchors to support focus traversal in tree
        $tree.find('.jqx-tree-item').each(function (i, e) {
            var li = $(e).closest('li');
            var noChildren = (li.find('ul').length === 0);// ? '' : 'class="a-no-children"';
            if (noChildren) {
                li.addClass('a-no-children');
                li.find('div').first().addClass('a-no-children');
            }
            var text = $(e).text();
            $(e).text('');
            $(e).append('<a href="#">' + text + '</a>');
        });
        $(window).resize(function () {
            refreshTreeSize();
        });
        restoreSelections();
        refreshTreeSize();
    });
});
