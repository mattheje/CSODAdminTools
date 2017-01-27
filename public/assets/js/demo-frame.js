/**
 * Created by ejacob on 3/30/2016.
 */


require(['jquery', 'wulf/navbar'], function ($) {
    'use strict';

    // Spec: this function is here waiting to be used, no use yet, waiting solution to be evolved in CI side
    function getAllUrlParams(url) {

        // gets query string from url (optional) or window
        var queryString = url ? url.split('?')[1] : window.location.search.slice(1);

        // we'll store the parameters here
        var obj = {};

        // if query string exists
        if (queryString) {

            // stuff after # is not part of query string, so get rid of it
            queryString = queryString.split('#')[0];

            // split our query string into its component parts
            var arr = queryString.split('&');

            for (var i = 0; i < arr.length; i++) {
                // separate the keys and the values
                var a = arr[i].split('=');

                // in case params look like: list[]=thing1&list[]=thing2
                var paramNum = undefined;
                var paramName = a[0].replace(/\[\d*\]/, function (v) {
                    paramNum = v.slice(1, -1);
                    return '';
                });

                // set parameter value (use 'true' if empty)
                var paramValue = typeof(a[1]) === 'undefined' ? true : a[1];

                // (optional) keep case consistent
                paramName = paramName.toLowerCase();
                paramValue = paramValue.toLowerCase();

                // if parameter name already exists
                if (obj[paramName]) {
                    // convert value to array (if still string)
                    if (typeof obj[paramName] === 'string') {
                        obj[paramName] = [obj[paramName]];
                    }
                    // if no array index number specified...
                    if (typeof paramNum === 'undefined') {
                        // put the value on the end of the array
                        obj[paramName].push(paramValue);
                    }
                    // if array index number specified...
                    else {
                        // put the value at that index number
                        obj[paramName][paramNum] = paramValue;
                    }
                }
                // if param name doesn't exist yet, set it
                else {
                    obj[paramName] = paramValue;
                }
            }
        }
        return obj;
    }

    $(document).ready(function () {
        //Store devmode state
        var hash = window.location.hash.replace(/^.*?#/, '');
        var devMode = (hash.split('&').indexOf('devmode') !== -1);
        window.devmode = devMode;

        // Parse through demo page url to identify the demo version
        var getDemoVersion = (function() {
            var parser = window.location;
            if (parser.pathname.indexOf("dev-OT4.0") !== -1) {
                return " OT4.0 dev";
            }
            if (parser.pathname.indexOf("OT4.0") !== -1) {
                return " OT4.0";
            }
            if (parser.pathname.indexOf("development") !== -1) {
                return " OT3.1 dev";
            }
            if (parser.pathname.indexOf("index.jsf") !== -1) {
                return " OT3.1 JSF";
            }
            if (parser.hostname.indexOf("wulf-demo") !== -1) {
                return " OT3.1";
            }
            // Spec: no solution yet for identifying the version if run in local server, so we leave it empty
            return " - ";
        })();

        // Show the demo version in the banner area
        var demoText = document.createTextNode(getDemoVersion);
        var child = document.getElementById('banner_active_demo');
        child.appendChild(demoText);

        // Activate the first tab by default unless we are in devmode
        if (devMode) {
            $('#nav_examples').trigger('click');
            $('#main_content').attr('src', "demo-examples.html");
        } else {
            $('#nav_home').trigger('click');
            $('#main_content').attr('src', "demo-home.html");
        }
        // If need to clear activation from banner tabs
        //$ ('#wulf_contacts').click (function () {
        //    clearTabActivation ();
        //});
        // Receiving the tab change message caused by buttons inside iframe
        window.addEventListener("message", receiveMessage, false);

        function receiveMessage(event)
        {
            var origin = event.origin || event.originalEvent.origin; // For Chrome, the origin property is in the event.originalEvent object.
            // Sender is in local use: file for IE/FF, null for Chrome
            // Sender is in server use: wulf-demo
            // TODO make null accepted only for Chrome case
            if (origin !== "null" && origin !== "file:" && origin !== "http://wulf-demo.dynamic.nsn-net.net") {
                return;
            }
            // Actual messages to be handled. Remove the activation from current tab and activate the new tab
            if (event.data === "nav_download" || event.data === "nav_get_started") {
                clearTabActivation ();
                document.getElementById (event.data).className += ' active';
            }
            // TODO Also if someone clicks inside the iframe, we need to close the possibly open banner menu tree
        }

        function clearTabActivation () {
            var elements = document.getElementsByClassName ("n-banner-3Link");
            for (var i = 0; i < elements.length; i++) {
                if ($(elements[i]).hasClass('active')) {
                    elements[i].classList.remove ('active');
                }
            }
        }

        //Store devmode state
        var hash = window.location.hash.replace(/^.*?#/, '');
        window.devmode = (hash.split('&').indexOf('devmode') !== -1);
    });
});

