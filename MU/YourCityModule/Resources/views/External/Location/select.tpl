{* Purpose of this template: Display a popup selector for Forms and Content integration *}
{assign var='baseID' value='location'}
<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <label for="{$baseID}Id" class="col-sm-3 control-label">{gt text='Location'}:</label>
            <div class="col-sm-9">
                <select id="{$baseID}Id" name="id" class="form-control">
                    {foreach item='location' from=$items}
                        <option value="{$location->getKey()}"{if $selectedId eq $location->getKey()} selected="selected"{/if}>{$location->getName()}</option>
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
                    <option value="letterForOrder"{if $sort eq 'letterForOrder'} selected="selected"{/if}>{gt text='Letter for order'}</option>
                    <option value="logoOfYourLocation"{if $sort eq 'logoOfYourLocation'} selected="selected"{/if}>{gt text='Logo of your location'}</option>
                    <option value="description"{if $sort eq 'description'} selected="selected"{/if}>{gt text='Description'}</option>
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
                    <option value="partOfCity"{if $sort eq 'partOfCity'} selected="selected"{/if}>{gt text='Part of city'}</option>
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
            {img id='ajaxIndicator' modname='core' set='ajax' src='indicator_circle.gif' alt='' class='hidden'}
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
