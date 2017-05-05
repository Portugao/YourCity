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

    return 'width=' + pWidth + ',height=' + pHeight + ',scrollbars,resizable';
}

/**
 * Open a popup window with the finder triggered by a CKEditor button.
 */
function MUYourCityModuleFinderCKEditor(editor, yourcityUrl)
{
    // Save editor for access in selector window
    currentMUYourCityModuleEditor = editor;

    editor.popup(
        Routing.generate('muyourcitymodule_external_finder', { objectType: 'location', editor: 'ckeditor' }),
        /*width*/ '80%', /*height*/ '70%',
        'location=no,menubar=no,toolbar=no,dependent=yes,minimizable=no,modal=yes,alwaysRaised=yes,resizable=yes,scrollbars=yes'
    );
}


var mUYourCityModule = {};

mUYourCityModule.finder = {};

mUYourCityModule.finder.onLoad = function (baseId, selectedId)
{
    var imageModeEnabled;

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
    if ('tinymce' === editor) {
        mUYourCityClosePopup();
    } else if ('ckeditor' === editor) {
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

    editor = jQuery("[id$='editor']").first().val();
    if ('tinymce' === editor) {
        html = mUYourCityGetPasteSnippet('html', itemId);
        tinyMCE.activeEditor.execCommand('mceInsertContent', false, html);
        // other tinymce commands: mceImage, mceInsertLink, mceReplaceContent, see http://www.tinymce.com/wiki.php/Command_identifiers
    } else if ('ckeditor' === editor) {
        if (null !== window.opener.currentMUYourCityModuleEditor) {
            html = mUYourCityGetPasteSnippet('html', itemId);

            window.opener.currentMUYourCityModuleEditor.insertHtml(html);
        }
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




//=============================================================================
// MUYourCityModule item selector for Forms
//=============================================================================

mUYourCityModule.itemSelector = {};
mUYourCityModule.itemSelector.items = {};
mUYourCityModule.itemSelector.baseId = 0;
mUYourCityModule.itemSelector.selectedId = 0;

mUYourCityModule.itemSelector.onLoad = function (baseId, selectedId)
{
    mUYourCityModule.itemSelector.baseId = baseId;
    mUYourCityModule.itemSelector.selectedId = selectedId;

    // required as a changed object type requires a new instance of the item selector plugin
    jQuery('#mUYourCityModuleObjectType').change(mUYourCityModule.itemSelector.onParamChanged);

    jQuery('#' + baseId + '_catidMain').change(mUYourCityModule.itemSelector.onParamChanged);
    jQuery('#' + baseId + '_catidsMain').change(mUYourCityModule.itemSelector.onParamChanged);
    jQuery('#' + baseId + 'Id').change(mUYourCityModule.itemSelector.onItemChanged);
    jQuery('#' + baseId + 'Sort').change(mUYourCityModule.itemSelector.onParamChanged);
    jQuery('#' + baseId + 'SortDir').change(mUYourCityModule.itemSelector.onParamChanged);
    jQuery('#mUYourCityModuleSearchGo').click(mUYourCityModule.itemSelector.onParamChanged);
    jQuery('#mUYourCityModuleSearchGo').keypress(mUYourCityModule.itemSelector.onParamChanged);

    mUYourCityModule.itemSelector.getItemList();
};

mUYourCityModule.itemSelector.onParamChanged = function ()
{
    jQuery('#ajaxIndicator').removeClass('hidden');

    mUYourCityModule.itemSelector.getItemList();
};

mUYourCityModule.itemSelector.getItemList = function ()
{
    var baseId;
    var params;

    baseId = mUYourCityModule.itemSelector.baseId;
    params = {
        ot: baseId,
        sort: jQuery('#' + baseId + 'Sort').val(),
        sortdir: jQuery('#' + baseId + 'SortDir').val(),
        q: jQuery('#' + baseId + 'SearchTerm').val()
    }
    if (jQuery('#' + baseId + '_catidMain').length > 0) {
        params[catidMain] = jQuery('#' + baseId + '_catidMain').val();
    } else if (jQuery('#' + baseId + '_catidsMain').length > 0) {
        params[catidsMain] = jQuery('#' + baseId + '_catidsMain').val();
    }

    jQuery.getJSON(Routing.generate('muyourcitymodule_ajax_getitemlistfinder'), params, function( data ) {
        var baseId;

        baseId = mUYourCityModule.itemSelector.baseId;
        mUYourCityModule.itemSelector.items[baseId] = data;
        jQuery('#ajaxIndicator').addClass('hidden');
        mUYourCityModule.itemSelector.updateItemDropdownEntries();
        mUYourCityModule.itemSelector.updatePreview();
    });
};

mUYourCityModule.itemSelector.updateItemDropdownEntries = function ()
{
    var baseId, itemSelector, items, i, item;

    baseId = mUYourCityModule.itemSelector.baseId;
    itemSelector = jQuery('#' + baseId + 'Id');
    itemSelector.length = 0;

    items = mUYourCityModule.itemSelector.items[baseId];
    for (i = 0; i < items.length; ++i) {
        item = items[i];
        itemSelector.get(0).options[i] = new Option(item.title, item.id, false);
    }

    if (mUYourCityModule.itemSelector.selectedId > 0) {
        jQuery('#' + baseId + 'Id').val(mUYourCityModule.itemSelector.selectedId);
    }
};

mUYourCityModule.itemSelector.updatePreview = function ()
{
    var baseId, items, selectedElement, i;

    baseId = mUYourCityModule.itemSelector.baseId;
    items = mUYourCityModule.itemSelector.items[baseId];

    jQuery('#' + baseId + 'PreviewContainer').addClass('hidden');

    if (items.length === 0) {
        return;
    }

    selectedElement = items[0];
    if (mUYourCityModule.itemSelector.selectedId > 0) {
        for (var i = 0; i < items.length; ++i) {
            if (items[i].id == mUYourCityModule.itemSelector.selectedId) {
                selectedElement = items[i];
                break;
            }
        }
    }

    if (null !== selectedElement) {
        jQuery('#' + baseId + 'PreviewContainer')
            .html(window.atob(selectedElement.previewInfo))
            .removeClass('hidden');
        mUYourCityInitImageViewer();
    }
};

mUYourCityModule.itemSelector.onItemChanged = function ()
{
    var baseId, itemSelector, preview;

    baseId = mUYourCityModule.itemSelector.baseId;
    itemSelector = jQuery('#' + baseId + 'Id').get(0);
    preview = window.atob(mUYourCityModule.itemSelector.items[baseId][itemSelector.selectedIndex].previewInfo);

    jQuery('#' + baseId + 'PreviewContainer').html(preview);
    mUYourCityModule.itemSelector.selectedId = jQuery('#' + baseId + 'Id').val();
    mUYourCityInitImageViewer();
};
