{* Purpose of this template: Display a popup selector for Forms and Content integration *}
{assign var='baseID' value='offer'}
<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <label for="{$baseID}Id" class="col-sm-3 control-label">{gt text='Offer'}:</label>
            <div class="col-sm-9">
                <select id="{$baseID}Id" name="id" class="form-control">
                    {foreach item='offer' from=$items}
                        <option value="{$offer->getKey()}"{if $selectedId eq $offer->getKey()} selected="selected"{/if}>{$offer->getName()}</option>
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
                    <option value="description"{if $sort eq 'description'} selected="selected"{/if}>{gt text='Description'}</option>
                    <option value="urlToOfferOnHomepage"{if $sort eq 'urlToOfferOnHomepage'} selected="selected"{/if}>{gt text='Url to offer on homepage'}</option>
                    <option value="imageOfOffer"{if $sort eq 'imageOfOffer'} selected="selected"{/if}>{gt text='Image of offer'}</option>
                    <option value="priceOfOffer"{if $sort eq 'priceOfOffer'} selected="selected"{/if}>{gt text='Price of offer'}</option>
                    <option value="normalPrice"{if $sort eq 'normalPrice'} selected="selected"{/if}>{gt text='Normal price'}</option>
                    <option value="percentOfOffer"{if $sort eq 'percentOfOffer'} selected="selected"{/if}>{gt text='Percent of offer'}</option>
                    <option value="effectivFrom"{if $sort eq 'effectivFrom'} selected="selected"{/if}>{gt text='Effectiv from'}</option>
                    <option value="effectivUntil"{if $sort eq 'effectivUntil'} selected="selected"{/if}>{gt text='Effectiv until'}</option>
                    <option value="inViewUntil"{if $sort eq 'inViewUntil'} selected="selected"{/if}>{gt text='In view until'}</option>
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
            <p><strong>{gt text='Offer information'}</strong></p>
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
