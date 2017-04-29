{* Purpose of this template: edit view of generic item list content type *}
<div class="form-group">
    {gt text='Object type' domain='muyourcitymodule' assign='objectTypeSelectorLabel'}
    {formlabel for='mUYourCityModuleObjectType' text=$objectTypeSelectorLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {muyourcitymoduleObjectTypeSelector assign='allObjectTypes'}
        {formdropdownlist id='mUYourCityModuleObjectType' dataField='objectType' group='data' mandatory=true items=$allObjectTypes cssClass='form-control'}
        <span class="help-block">{gt text='If you change this please save the element once to reload the parameters below.' domain='muyourcitymodule'}</span>
    </div>
</div>

{if $featureActivationHelper->isEnabled(constant('MU\\YourCityModule\\Helper\\FeatureActivationHelper::CATEGORIES'), $objectType)}
{formvolatile}
{if $properties ne null && is_array($properties)}
    {nocache}
    {foreach key='registryId' item='registryCid' from=$registries}
        {assign var='propName' value=''}
        {foreach key='propertyName' item='propertyId' from=$properties}
            {if $propertyId eq $registryId}
                {assign var='propName' value=$propertyName}
            {/if}
        {/foreach}
        <div class="form-group">
            {assign var='hasMultiSelection' value=$categoryHelper->hasMultipleSelection($objectType, $propertyName)}
            {gt text='Category' domain='muyourcitymodule' assign='categorySelectorLabel'}
            {assign var='selectionMode' value='single'}
            {if $hasMultiSelection eq true}
                {gt text='Categories' domain='muyourcitymodule' assign='categorySelectorLabel'}
                {assign var='selectionMode' value='multiple'}
            {/if}
            {formlabel for="mUYourCityModuleCatIds`$propertyName`" text=$categorySelectorLabel cssClass='col-sm-3 control-label'}
            <div class="col-sm-9">
                {formdropdownlist id="mUYourCityModuleCatIds`$propName`" items=$categories.$propName dataField="catids`$propName`" group='data' selectionMode=$selectionMode cssClass='form-control'}
                <span class="help-block">{gt text='This is an optional filter.' domain='muyourcitymodule'}</span>
            </div>
        </div>
    {/foreach}
    {/nocache}
{/if}
{/formvolatile}
{/if}

<div class="form-group">
    {gt text='Sorting' domain='muyourcitymodule' assign='sortingLabel'}
    {formlabel text=$sortingLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formradiobutton id='mUYourCityModuleSortRandom' value='random' dataField='sorting' group='data' mandatory=true}
        {gt text='Random' domain='muyourcitymodule' assign='sortingRandomLabel'}
        {formlabel for='mUYourCityModuleSortRandom' text=$sortingRandomLabel}
        {formradiobutton id='mUYourCityModuleSortNewest' value='newest' dataField='sorting' group='data' mandatory=true}
        {gt text='Newest' domain='muyourcitymodule' assign='sortingNewestLabel'}
        {formlabel for='mUYourCityModuleSortNewest' text=$sortingNewestLabel}
        {formradiobutton id='mUYourCityModuleSortDefault' value='default' dataField='sorting' group='data' mandatory=true}
        {gt text='Default' domain='muyourcitymodule' assign='sortingDefaultLabel'}
        {formlabel for='mUYourCityModuleSortDefault' text=$sortingDefaultLabel}
    </div>
</div>

<div class="form-group">
    {gt text='Amount' domain='muyourcitymodule' assign='amountLabel'}
    {formlabel for='mUYourCityModuleAmount' text=$amountLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formintinput id='mUYourCityModuleAmount' dataField='amount' group='data' mandatory=true maxLength=2 cssClass='form-control'}
    </div>
</div>

<div class="form-group">
    {gt text='Template' domain='muyourcitymodule' assign='templateLabel'}
    {formlabel for='mUYourCityModuleTemplate' text=$templateLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {muyourcitymoduleTemplateSelector assign='allTemplates'}
        {formdropdownlist id='mUYourCityModuleTemplate' dataField='template' group='data' mandatory=true items=$allTemplates cssClass='form-control'}
    </div>
</div>

<div id="customTemplateArea" class="form-group"{* data-switch="mUYourCityModuleTemplate" data-switch-value="custom"*}>
    {gt text='Custom template' domain='muyourcitymodule' assign='customTemplateLabel'}
    {formlabel for='mUYourCityModuleCustomTemplate' text=$customTemplateLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formtextinput id='mUYourCityModuleCustomTemplate' dataField='customTemplate' group='data' mandatory=false maxLength=80 cssClass='form-control'}
        <span class="help-block">{gt text='Example' domain='muyourcitymodule'}: <em>itemlist_[objectType]_display.html.twig</em></span>
    </div>
</div>

<div class="form-group">
    {gt text='Filter (expert option)' domain='muyourcitymodule' assign='filterLabel'}
    {formlabel for='mUYourCityModuleFilter' text=$filterLabel cssClass='col-sm-3 control-label'}
    <div class="col-sm-9">
        {formtextinput id='mUYourCityModuleFilter' dataField='filter' group='data' mandatory=false maxLength=255 cssClass='form-control'}
    </div>
</div>

<script type="text/javascript">
    (function($) {
    	$('#mUYourCityModuleTemplate').change(function() {
    	    $('#customTemplateArea').toggleClass('hidden', $(this).val() != 'custom');
	    }).trigger('change');
    })(jQuery)
</script>
