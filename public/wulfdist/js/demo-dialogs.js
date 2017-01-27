/**
 * ========================================================================
 * Copyright (C) 2016 Nokia. All rights Reserved.
 * ======================================================================== */

function handleStaticDialog( linkId, staticDialogId, dialogContentClassName, dialogFileName,
                             functionButtonCommonClassName, exitButtonClassName )
{
    // Hide static dialog when linkId is pressed
    $(linkId).click(function (event) {
        $(staticDialogId).hide();
    });

    // Load content from given dialogFileName for all dialogs having class pointed by dialogContentClassName
    var dialogContent = $(dialogContentClassName);
    dialogContent.load(dialogFileName);

    // Show static dialog when functionButtonCommonClassName or exitButtonClassName is clicked from modal dialog
    dialogContent.on("click", functionButtonCommonClassName +','+ exitButtonClassName, function () {
        $(staticDialogId).show();
    });

    //Remove class modal, modal-dialog and remove tab indexes from static dialog
    (function() {
        setTimeout(function() {
            var tabElement = document.querySelectorAll(staticDialogId +' [tabindex]');
            for (i = 0; i < tabElement.length; i++) {
                tabElement[i].setAttribute('tabindex', '-1');
            }
            var dialogStatic = $(staticDialogId);
            dialogStatic.removeClass('modal');
            dialogStatic.css({'padding-top': '20px', 'padding-left': '0'});
            dialogStatic.children('div').removeClass('modal-dialog');
            //Add modal dialog style for static dialog exit button
            dialogStatic.find(exitButtonClassName).addClass('demo-modal-icon-style');
        }, 500);
    })();
}
