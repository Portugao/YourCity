'use strict';

var mUYourCityModule = {};

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

jQuery(document).ready(function() {
    var infoElem;

    infoElem = jQuery('#itemSelectorInfo');
    if (infoElem.length == 0) {
        return;
    }

    mUYourCityModule.itemSelector.onLoad(infoElem.data('base-id'), infoElem.data('selected-id'));
});
