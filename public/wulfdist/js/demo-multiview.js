/**
 * ========================================================================
 * Copyright (C) 2016 Nokia. All rights Reserved.
 * ======================================================================== */

require (['jquery'], function ($) {
    'use strict';

    var SPACE_BAR_KEY = 32;
    var LEFT_KEY = 37;
    var RIGHT_KEY = 39;
    var oldTops = [];
    var TAG = {
        PURE: "Pure HTML/CSS",
        DRAFT: "Draft"
    };
    var CSS = {
        items: 'a:not([disabled])'
    };
    var tags = {
        "Pure HTML/CSS": '<span class="used-pure-html-css"></span>'
    };
    var titleTags = {
        'N/A': '<span class="demo-status-title-na"> - Not available</span>',
        'Pending': '<span class="demo-status-title-pending"> - Pending</span>',
        'Draft': '<span class="demo-status-title-draft"> - Draft</span>',
        'Ongoing': '<span class="demo-status-title-ongoing"> - Ongoing</span>',
        'Proposal': '<span class="demo-status-title-proposal"> - Proposal</span>',
        'Done': ''
    };
    var thisIs404Precausion = [];

    function keyCheck(event) {
        var target = event.target;
        var items = $(event.target).closest('ul').find(CSS.items);
        var currentIndex = items.index(target);
        var supportKeys = [LEFT_KEY, RIGHT_KEY, SPACE_BAR_KEY];
        var keyCode = event.keyCode;
        var newIndex;

        if (supportKeys.indexOf(keyCode) === -1) {
            return;
        }

        switch (keyCode) {
            case LEFT_KEY:
                newIndex = currentIndex > -1 ? currentIndex - 1 : -1;
                break;
            case RIGHT_KEY:
                newIndex = currentIndex < items.length - 1 ? currentIndex + 1 : items.length - 1;
                break;
            case SPACE_BAR_KEY:
                $(items[currentIndex]).trigger('click');
                break;
            default:
                break;
        }

        if (newIndex !== undefined) {
            $(items[newIndex]).trigger('focus');
        }
        event.preventDefault();
        event.stopPropagation();
    }

    function addTags(id) {
        var item = window.parent.MultiView.item;
        var index = -1;
        var itemTags;

        if (item === undefined) {
            return;
        }

        //Check if single page
        if(item.multiView === undefined) {
            index = 0;
            itemTags = item.tags;
        } else {
            var views = item.multiView;
            for (var i = 0; i < views.length && index == -1; i++) {
                if (views[i].binding === id) {
                    index = i;
                    itemTags = views[i].tags;
                }
            }
        }
        //Remove old react logo
        var header = $('#' + id).find('iframe').contents().find('.component-header');
        $(header).find('a').remove();
        //Add tags
        if (itemTags !== undefined && index !== -1) {
            for (var tag in tags) {
                var found = $.grep(itemTags, function (t) {
                    return t === tag;
                });
                if (found.length > 0) {
                    $(header).append(tags[tag]);
                }
            }
        }
    }

    function fixScrollPosition(event) {
        var id = $(event.target).attr('href');
        var iframe = $(id).find('iframe').contents();
        var html = $(iframe).find('html');
        var body = $(iframe).find('body');

        if (event.data.setScrollPosition) {
            var top = oldTops[id] === undefined ? 0 : oldTops[id];
            //Chrome looses tracking of scrolling so detach/attach to cover this
            $(body).detach();
            $(body).appendTo(html);
            //Set the new value, once is not enough
            $(body).scrollTop(top + 1);
            $(body).scrollTop(top);
            //FireFox scrolling is on HTML level
            $(html).scrollTop(top);

            updatePillViews();
        } else {
            oldTops[id] = $(body).scrollTop() || $(html).scrollTop();
        }
        //BTW: IE is the only browser that can live without any of these tricks
    }

    function updatePillViews() {
        var body = $('iframe:visible').contents().find('body');
        var active = body.find('.nav-pills .active').first().find('a').text();

        body.find('[data-pill-view]').each(function(index, element) {
            var pillString= $(element).attr('data-pill-view');
            var pillNames = pillString.split(',');

            if (pillString !== '') {
                var found = $.grep(pillNames, function (pill) {
                    return active === pill.trim();
                });
                if (found.length > 0) {
                    $(element).removeClass('hidden');
                } else {
                    $(element).addClass('hidden');
                }
            }
        });
    }

    function pillChange(event) {
        //Update active pill
        $(event.target).closest('ul').find('.active').removeClass('active');
        $(event.target).closest('li').addClass('active');
        $(event.target).trigger('focus');

        updatePillViews();
    }

    function getTag(viewTags) {
        for (var tag in titleTags) {
            for (var vt = 0; vt < viewTags.length; vt++) {
                if (tag === viewTags[vt]) {
                    return titleTags[tag];
                }
            }
        }
        return '';
    }

    function makeTab(file, viewId, tags, viewName) {
        var clone = $('.nav-tabs > li').first().clone();
        var devMode = window.parent.parent.devmode;

        if (!(!devMode && getTag(tags).indexOf('Draft') > 0)) {
            $(clone).removeClass('hidden').find('a').attr('href', '#View' + viewId).html(viewName + getTag(tags));
            $(clone).appendTo('.nav-tabs');
            //With reference
            clone = $('.tab-content > .tab-pane').first().clone();
            $(clone).attr('id', 'View' + viewId).find('iframe').attr('src', file);
            $(clone).appendTo(".tab-content");
        }
    }

    function setUp404(id, event) {
        //Try to fetch demo-404 only once
        if (thisIs404Precausion[id] === undefined) {
            thisIs404Precausion[id] = true;
            $(event.target).attr('src', 'demo-404.html');
        }
    }

    $(document).ready(function () {
        var item = window.parent.MultiView.item;
        var views = item.multiView;
        var defs = window.parent.MultiView.defs;
        var viewCounter = 0;

        //Check first if common page
        if (views === undefined) {
            if (item.src !== '') {
                makeTab(item.src, 0, item.tags, 'Common');
            }
        } else {
            //Go through all multiviews
            for (var i = 0; i < views.length; i++) {
                var dir = $.grep(defs, function (def) {
                    return def.name === views[i].view;
                });
                if (dir[0].selected) {
                    var file = (views[i].src === undefined) ? dir[0].dir + '/' + item.src : views[i].src;
                    makeTab(file, viewCounter, views[i].tags, views[i].view);
                    window.parent.MultiView.item.multiView[i].binding = 'View' + viewCounter;
                    viewCounter++;
                }
            }
        }

        $('iframe').on('load', function(event) {
            var id = $(event.target).closest('.tab-pane').attr('id');
            var allAs;

            try {
                allAs = $(event.target).contents().find(".nav-pills li a");
            } catch(err) {
                return;
            }

            if ($(event.target).contents().find('title').text().indexOf('404') === 0) {
                setUp404(id, event);
                return;
            }

            addTags(id);
            //Activate first tab
            if (id === 'View0') {
                oldTops = [];
                $('[href="#View0"]').trigger('click');
                $('#waiting-for-view').addClass('hidden');
                $('#multi-view').removeClass('hidden');
            }
            //Catch pill changes, these are inside iFrame
            allAs.click(function(event){
                pillChange(event);
            });
            allAs.keydown(function(event) {
                keyCheck(event);
            });
            //Change href='#' to javascript:void(0), this prevents the page to jump 2px up in
            //Chrome when changing pills
            allAs.each(function(index, element) {
                if ($(element).attr('href') === '#') {
                    $(element).attr('href', 'javascript:void(0)');
                }
            });
            //Update pill views
            updatePillViews();
        });
    });

    $(document)
        .on('shown.bs.tab', { setScrollPosition: true }, fixScrollPosition)
        .on('hide.bs.tab', { setScrollPosition: false }, fixScrollPosition)
    ;
});