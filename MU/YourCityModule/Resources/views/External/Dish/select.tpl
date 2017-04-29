{* Purpose of this template: Display a popup selector for Forms and Content integration *}
{assign var='baseID' value='dish'}
<div class="row">
    <div class="col-sm-8">

        {if $properties ne null && is_array($properties)}
            {gt text='All' assign='lblDefault'}
            {nocache}
            {foreach key='propertyName' item='propertyId' from=$properties}
                <div class="form-group">
                    {assign var='hasMultiSelection' value=$categoryHelper->hasMultipleSelection('dish', $propertyName)}
                    {gt text='Category' assign='categoryLabel'}
                    {assign var='categorySelectorId' value='catid'}
                    {assign var='categorySelectorName' value='catid'}
                    {assign var='categorySelectorSize' value='1'}
                    {if $hasMultiSelection eq true}
                        {gt text='Categories' assign='categoryLabel'}
                        {assign var='categorySelectorName' value='catids'}
                        {assign var='categorySelectorId' value='catids__'}
                        {assign var='categorySelectorSize' value='8'}
                    {/if}
                    <label for="{$baseID}_{$categorySelectorId}{$propertyName}" class="col-sm-3 control-label">{$categoryLabel}:</label>
                    <div class="col-sm-9">
                        {selector_category name="`$baseID`_`$categorySelectorName``$propertyName`" field='id' selectedValue=$catIds.$propertyName|default:null categoryRegistryModule='MUYourCityModule' categoryRegistryTable="`$objectType`Entity" categoryRegistryProperty=$propertyName defaultText=$lblDefault editLink=false multipleSize=$categorySelectorSize cssClass='form-control'}
                    </div>
                </div>
            {/foreach}
            {/nocache}
        {/if}
        <div class="form-group">
            <label for="{$baseID}Id" class="col-sm-3 control-label">{gt text='Dish'}:</label>
            <div class="col-sm-9">
                <select id="{$baseID}Id" name="id" class="form-control">
                    {foreach item='dish' from=$items}
                        <option value="{$dish.id}"{if $selectedId eq $dish.id} selected="selected"{/if}>{$dish->getName()}</option>
                    {foreachelse}
                        <option value="0">{gt text='No entries found.'}</option>
                    {/foreach}
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="{$baseID}Sort" class="col-sm-3 control-label">{gt text='Sort by'}:</label>
            <div class="col-sm-9">
                <select id="{$baseID}Sort" name="sort" class="form-control">
                    <option value="name"{if $sort eq 'name'} selected="selected"{/if}>{gt text='Name'}</option>
                    <option value="description"{if $sort eq 'description'} selected="selected"{/if}>{gt text='Description'}</option>
                    <option value="imageOfDish"{if $sort eq 'imageOfDish'} selected="selected"{/if}>{gt text='Image of dish'}</option>
                    <option value="priceOfDish"{if $sort eq 'priceOfDish'} selected="selected"{/if}>{gt text='Price of dish'}</option>
                    <option value="positionOfDish"{if $sort eq 'positionOfDish'} selected="selected"{/if}>{gt text='Position of dish'}</option>
                    <option value="createdDate"{if $sort eq 'createdDate'} selected="selected"{/if}>{gt text='Creation date'}</option>
                    <option value="createdBy"{if $sort eq 'createdBy'} selected="selected"{/if}>{gt text='Creator'}</option>
                    <option value="updatedDate"{if $sort eq 'updatedDate'} selected="selected"{/if}>{gt text='Update date'}</option>
                    <option value="updatedBy"{if $sort eq 'updatedBy'} selected="selected"{/if}>{gt text='Updater'}</option>
                </select>
                <select id="{$baseID}SortDir" name="sortdir" class="form-control">
                    <option value="asc"{if $sortdir eq 'asc'} selected="selected"{/if}>{gt text='ascending'}</option>
                    <option value="desc"{if $sortdir eq 'desc'} selected="selected"{/if}>{gt text='descending'}</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="{$baseID}SearchTerm" class="col-sm-3 control-label">{gt text='Search for'}:</label>
            <div class="col-sm-9">
                <div class="input-group">
                    <input type="text" id="{$baseID}SearchTerm" name="q" class="form-control" />
                    <span class="input-group-btn">
                        <input type="button" id="mUYourCityModuleSearchGo" name="gosearch" value="{gt text='Filter'}" class="btn btn-default" />
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div id="{$baseID}Preview" style="border: 1px dotted #a3a3a3; padding: .2em .5em">
            <p><strong>{gt text='Dish information'}</strong></p>
            {img id='ajax_indicator' modname='core' set='ajax' src='indicator_circle.gif' alt='' class='hidden'}
            <div id="{$baseID}PreviewContainer">&nbsp;</div>
        </div>
    </div>
</div>

<script type="text/javascript">
/* <![CDATA[ */
    ( function($) {
        $(document).ready(function() {
            mUYourCityModule.itemSelector.onLoad('{{$baseID}}', {{$selectedId|default:0}});
        });
    })(jQuery);
/* ]]> */
</script>
