{* Purpose of this template: Display a popup selector for Forms and Content integration *}
{assign var='baseID' value='product'}
<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <label for="{$baseID}Id" class="col-sm-3 control-label">{gt text='Product'}:</label>
            <div class="col-sm-9">
                <select id="{$baseID}Id" name="id" class="form-control">
                    {foreach item='product' from=$items}
                        <option value="{$product->getKey()}"{if $selectedId eq $product->getKey()} selected="selected"{/if}>{$product->getName()}</option>
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
                    <option value="keywordsForProduct"{if $sort eq 'keywordsForProduct'} selected="selected"{/if}>{gt text='Keywords for product'}</option>
                    <option value="description"{if $sort eq 'description'} selected="selected"{/if}>{gt text='Description'}</option>
                    <option value="kindOfProduct"{if $sort eq 'kindOfProduct'} selected="selected"{/if}>{gt text='Kind of product'}</option>
                    <option value="today"{if $sort eq 'today'} selected="selected"{/if}>{gt text='Today'}</option>
                    <option value="monday"{if $sort eq 'monday'} selected="selected"{/if}>{gt text='Monday'}</option>
                    <option value="tuesday"{if $sort eq 'tuesday'} selected="selected"{/if}>{gt text='Tuesday'}</option>
                    <option value="wednesday"{if $sort eq 'wednesday'} selected="selected"{/if}>{gt text='Wednesday'}</option>
                    <option value="thursday"{if $sort eq 'thursday'} selected="selected"{/if}>{gt text='Thursday'}</option>
                    <option value="friday"{if $sort eq 'friday'} selected="selected"{/if}>{gt text='Friday'}</option>
                    <option value="saturday"{if $sort eq 'saturday'} selected="selected"{/if}>{gt text='Saturday'}</option>
                    <option value="sunday"{if $sort eq 'sunday'} selected="selected"{/if}>{gt text='Sunday'}</option>
                    <option value="priceOfProduct"{if $sort eq 'priceOfProduct'} selected="selected"{/if}>{gt text='Price of product'}</option>
                    <option value="myLocation"{if $sort eq 'myLocation'} selected="selected"{/if}>{gt text='My location'}</option>
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
            <p><strong>{gt text='Product information'}</strong></p>
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
