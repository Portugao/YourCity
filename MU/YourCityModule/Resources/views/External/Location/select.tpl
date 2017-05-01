{* Purpose of this template: Display a popup selector for Forms and Content integration *}
{assign var='baseID' value='location'}
<div class="row">
    <div class="col-sm-8">

        {if $properties ne null && is_array($properties)}
            {gt text='All' assign='lblDefault'}
            {nocache}
            {foreach key='propertyName' item='propertyId' from=$properties}
                <div class="form-group">
                    {assign var='hasMultiSelection' value=$categoryHelper->hasMultipleSelection('location', $propertyName)}
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
            <label for="{$baseID}Id" class="col-sm-3 control-label">{gt text='Location'}:</label>
            <div class="col-sm-9">
                <select id="{$baseID}Id" name="id" class="form-control">
                    {foreach item='location' from=$items}
                        <option value="{$location.id}"{if $selectedId eq $location.id} selected="selected"{/if}>{$location->getName()}</option>
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
                    <option value="workflowState"{if $sort eq 'workflowState'} selected="selected"{/if}>{gt text='Workflow state'}</option>
                    <option value="name"{if $sort eq 'name'} selected="selected"{/if}>{gt text='Name'}</option>
                    <option value="logoOfYourLocation"{if $sort eq 'logoOfYourLocation'} selected="selected"{/if}>{gt text='Logo of your location'}</option>
                    <option value="description"{if $sort eq 'description'} selected="selected"{/if}>{gt text='Description'}</option>
                    <option value="description2"{if $sort eq 'description2'} selected="selected"{/if}>{gt text='Description 2'}</option>
                    <option value="imageOfLocation"{if $sort eq 'imageOfLocation'} selected="selected"{/if}>{gt text='Image of location'}</option>
                    <option value="street"{if $sort eq 'street'} selected="selected"{/if}>{gt text='Street'}</option>
                    <option value="numberOfStreet"{if $sort eq 'numberOfStreet'} selected="selected"{/if}>{gt text='Number of street'}</option>
                    <option value="zipCode"{if $sort eq 'zipCode'} selected="selected"{/if}>{gt text='Zip code'}</option>
                    <option value="city"{if $sort eq 'city'} selected="selected"{/if}>{gt text='City'}</option>
                    <option value="telefon"{if $sort eq 'telefon'} selected="selected"{/if}>{gt text='Telefon'}</option>
                    <option value="mobil"{if $sort eq 'mobil'} selected="selected"{/if}>{gt text='Mobil'}</option>
                    <option value="homepage"{if $sort eq 'homepage'} selected="selected"{/if}>{gt text='Homepage'}</option>
                    <option value="bsagStop"{if $sort eq 'bsagStop'} selected="selected"{/if}>{gt text='Bsag stop'}</option>
                    <option value="tram"{if $sort eq 'tram'} selected="selected"{/if}>{gt text='Tram'}</option>
                    <option value="bus"{if $sort eq 'bus'} selected="selected"{/if}>{gt text='Bus'}</option>
                    <option value="openingHours"{if $sort eq 'openingHours'} selected="selected"{/if}>{gt text='Opening hours'}</option>
                    <option value="startOnMonday"{if $sort eq 'startOnMonday'} selected="selected"{/if}>{gt text='Start on monday'}</option>
                    <option value="endOnMonday"{if $sort eq 'endOnMonday'} selected="selected"{/if}>{gt text='End on monday'}</option>
                    <option value="start2OnMonday"{if $sort eq 'start2OnMonday'} selected="selected"{/if}>{gt text='Start 2 on monday'}</option>
                    <option value="end2OnMonday"{if $sort eq 'end2OnMonday'} selected="selected"{/if}>{gt text='End 2 on monday'}</option>
                    <option value="startOnTuesday"{if $sort eq 'startOnTuesday'} selected="selected"{/if}>{gt text='Start on tuesday'}</option>
                    <option value="endOnTuesday"{if $sort eq 'endOnTuesday'} selected="selected"{/if}>{gt text='End on tuesday'}</option>
                    <option value="start2OnTuesday"{if $sort eq 'start2OnTuesday'} selected="selected"{/if}>{gt text='Start 2 on tuesday'}</option>
                    <option value="end2OnTuesday"{if $sort eq 'end2OnTuesday'} selected="selected"{/if}>{gt text='End 2 on tuesday'}</option>
                    <option value="startOnWednesday"{if $sort eq 'startOnWednesday'} selected="selected"{/if}>{gt text='Start on wednesday'}</option>
                    <option value="endOnWednesday"{if $sort eq 'endOnWednesday'} selected="selected"{/if}>{gt text='End on wednesday'}</option>
                    <option value="start2OnWednesday"{if $sort eq 'start2OnWednesday'} selected="selected"{/if}>{gt text='Start 2 on wednesday'}</option>
                    <option value="end2OnWednesday"{if $sort eq 'end2OnWednesday'} selected="selected"{/if}>{gt text='End 2 on wednesday'}</option>
                    <option value="startOnThursday"{if $sort eq 'startOnThursday'} selected="selected"{/if}>{gt text='Start on thursday'}</option>
                    <option value="endOnThursday"{if $sort eq 'endOnThursday'} selected="selected"{/if}>{gt text='End on thursday'}</option>
                    <option value="start2OnThursday"{if $sort eq 'start2OnThursday'} selected="selected"{/if}>{gt text='Start 2 on thursday'}</option>
                    <option value="end2OnThursday"{if $sort eq 'end2OnThursday'} selected="selected"{/if}>{gt text='End 2 on thursday'}</option>
                    <option value="startOnFriday"{if $sort eq 'startOnFriday'} selected="selected"{/if}>{gt text='Start on friday'}</option>
                    <option value="endOnFriday"{if $sort eq 'endOnFriday'} selected="selected"{/if}>{gt text='End on friday'}</option>
                    <option value="start2OnFriday"{if $sort eq 'start2OnFriday'} selected="selected"{/if}>{gt text='Start 2 on friday'}</option>
                    <option value="end2OnFriday"{if $sort eq 'end2OnFriday'} selected="selected"{/if}>{gt text='End 2 on friday'}</option>
                    <option value="startOnSaturday"{if $sort eq 'startOnSaturday'} selected="selected"{/if}>{gt text='Start on saturday'}</option>
                    <option value="endOnSaturday"{if $sort eq 'endOnSaturday'} selected="selected"{/if}>{gt text='End on saturday'}</option>
                    <option value="star2tOnSaturday"{if $sort eq 'star2tOnSaturday'} selected="selected"{/if}>{gt text='Star 2t on saturday'}</option>
                    <option value="end2OnSaturday"{if $sort eq 'end2OnSaturday'} selected="selected"{/if}>{gt text='End 2 on saturday'}</option>
                    <option value="startOnSunday"{if $sort eq 'startOnSunday'} selected="selected"{/if}>{gt text='Start on sunday'}</option>
                    <option value="endOnSunday"{if $sort eq 'endOnSunday'} selected="selected"{/if}>{gt text='End on sunday'}</option>
                    <option value="start2OnSunday"{if $sort eq 'start2OnSunday'} selected="selected"{/if}>{gt text='Start 2 on sunday'}</option>
                    <option value="end2OnSunday"{if $sort eq 'end2OnSunday'} selected="selected"{/if}>{gt text='End 2 on sunday'}</option>
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
            <p><strong>{gt text='Location information'}</strong></p>
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
