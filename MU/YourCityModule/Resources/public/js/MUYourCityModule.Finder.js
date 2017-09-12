'use strict';

var currentMUYourCityModuleEditor = null;
var currentMUYourCityModuleInput = null;

/**
 * Returns the attributes used for the popup window. 
 * @return {String}
 */
function getMUYourCityModulePopupAttributes()
{
    var pWidth, pHeight;

    pWidth = screen.width * 0.75;
    pHeight = screen.height * 0.66;

    return 'width=' + pWidth + ',height=' + pHeight + ',location=no,menubar=no,toolbar=no,dependent=yes,minimizable=no,modal=yes,alwaysRaised=yes,resizable=yes,scrollbars=yes';
}

/**
 * Open a popup window with the finder triggered by an editor button.
 */
function MUYourCityModuleFinderOpenPopup(editor, editorName)
{
    var popupUrl;

    // Save editor for access in selector window
    currentMUYourCityModuleEditor = editor;

    popupUrl = Routing.generate('muyourcitymodule_external_finder', { objectType: 'location', editor: editorName });

    if (editorName == 'ckeditor') {
        editor.popup(popupUrl, /*width*/ '80%', /*height*/ '70%', getMUYourCityModulePopupAttributes());
    } else {
        window.open(popupUrl, '_blank', getMUYourCityModulePopupAttributes());
    }
}


var mUYourCityModule = {};

mUYourCityModule.finder = {};

mUYourCityModule.finder.onLoad = function (baseId, selectedId)
{
    var imageModeEnabled;

    if (jQuery('#mUYourCityModuleSelectorForm').length < 1) {
        return;
    }

    imageModeEnabled = jQuery("[id$='onlyImages']").prop('checked');
    if (!imageModeEnabled) {
        jQuery('#imageFieldRow').addClass('hidden');
        jQuery("[id$='pasteAs'] option[value=6]").addClass('hidden');
        jQuery("[id$='pasteAs'] option[value=7]").addClass('hidden');
        jQuery("[id$='pasteAs'] option[value=8]").addClass('hidden');
        jQuery("[id$='pasteAs'] option[value=9]").addClass('hidden');
    } else {
        jQuery('#searchTermRow').addClass('hidden');
    }

    jQuery('input[type="checkbox"]').click(mUYourCityModule.finder.onParamChanged);
    jQuery('select').not("[id$='pasteAs']").change(mUYourCityModule.finder.onParamChanged);
    
    jQuery('.btn-default').click(mUYourCityModule.finder.handleCancel);

    var selectedItems = jQuery('#muyourcitymoduleItemContainer a');
    selectedItems.bind('click keypress', function (event) {
        event.preventDefault();
        mUYourCityModule.finder.selectItem(jQuery(this).data('itemid'));
    });
};

mUYourCityModule.finder.onParamChanged = function ()
{
    jQuery('#mUYourCityModuleSelectorForm').submit();
};

mUYourCityModule.finder.handleCancel = function (event)
{
    var editor;

    event.preventDefault();
    editor = jQuery("[id$='editor']").first().val();
    if ('ckeditor' === editor) {
        mUYourCityClosePopup();
    } else if ('quill' === editor) {
        mUYourCityClosePopup();
    } else if ('summernote' === editor) {
        mUYourCityClosePopup();
    } else if ('tinymce' === editor) {
        mUYourCityClosePopup();
    } else {
        alert('Close Editor: ' + editor);
    }
};


function mUYourCityGetPasteSnippet(mode, itemId)
{
    var quoteFinder;
    var itemPath;
    var itemUrl;
    var itemTitle;
    var itemDescription;
    var imagePath;
    var pasteMode;

    quoteFinder = new RegExp('"', 'g');
    itemPath = jQuery('#path' + itemId).val().replace(quoteFinder, '');
    itemUrl = jQuery('#url' + itemId).val().replace(quoteFinder, '');
    itemTitle = jQuery('#title' + itemId).val().replace(quoteFinder, '').trim();
    itemDescription = jQuery('#desc' + itemId).val().replace(quoteFinder, '').trim();
    imagePath = jQuery('#imagePath' + itemId).length > 0 ? jQuery('#imagePath' + itemId).val().replace(quoteFinder, '') : '';
    pasteMode = jQuery("[id$='pasteAs']").first().val();

    // item ID
    if (pasteMode === '3') {
        return '' + itemId;
    }

    // relative link to detail page
    if (pasteMode === '1') {
        return mode === 'url' ? itemPath : '<a href="' + itemPath + '" title="' + itemDescription + '">' + itemTitle + '</a>';
    }
    // absolute url to detail page
    if (pasteMode === '2') {
        return mode === 'url' ? itemUrl : '<a href="' + itemUrl + '" title="' + itemDescription + '">' + itemTitle + '</a>';
    }

    if (pasteMode === '6') {
        // relative link to image file
        return mode === 'url' ? imagePath : '<a href="' + imagePath + '" title="' + itemDescription + '">' + itemTitle + '</a>';
    }
    if (pasteMode === '7') {
        // image tag
        return '<img src="' + imagePath + '" alt="' + itemTitle + '" width="300" />';
    }
    if (pasteMode === '8') {
        // image tag with relative link to detail page
        return mode === 'url' ? itemPath : '<a href="' + itemPath + '" title="' + itemTitle + '"><img src="' + imagePath + '" alt="' + itemTitle + '" width="300" /></a>';
    }
    if (pasteMode === '9') {
        // image tag with absolute url to detail page
        return mode === 'url' ? itemUrl : '<a href="' + itemUrl + '" title="' + itemTitle + '"><img src="' + imagePath + '" alt="' + itemTitle + '" width="300" /></a>';
    }


    return '';
}


// User clicks on "select item" button
mUYourCityModule.finder.selectItem = function (itemId)
{
    var editor, html;

    html = mUYourCityGetPasteSnippet('html', itemId);
    editor = jQuery("[id$='editor']").first().val();
    if ('ckeditor' === editor) {
        if (null !== window.opener.currentMUYourCityModuleEditor) {
            window.opener.currentMUYourCityModuleEditor.insertHtml(html);
        }
    } else if ('quill' === editor) {
        if (null !== window.opener.currentMUYourCityModuleEditor) {
            window.opener.currentMUYourCityModuleEditor.clipboard.dangerouslyPasteHTML(window.opener.currentMUYourCityModuleEditor.getLength(), html);
        }
    } else if ('summernote' === editor) {
        if (null !== window.opener.currentMUYourCityModuleEditor) {
            html = jQuery(html).get(0);
            window.opener.currentMUYourCityModuleEditor.invoke('insertNode', html);
        }
    } else if ('tinymce' === editor) {
        window.opener.currentMUYourCityModuleEditor.insertContent(html);
    } else {
        alert('Insert into Editor: ' + editor);
    }
    mUYourCityClosePopup();
};

function mUYourCityClosePopup()
{
    window.opener.focus();
    window.close();
}

jQuery(document).ready(function() {
    mUYourCityModule.finder.onLoad();
});
