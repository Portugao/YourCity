'use strict';

function yourcityToggleShrinkSettings(fieldName) {
    var idSuffix = fieldName.replace('muyourcitymodule_appsettings_', '');
    jQuery('#shrinkDetails' + idSuffix).toggleClass('hidden', !jQuery('#muyourcitymodule_appsettings_enableShrinkingFor' + idSuffix).prop('checked'));
}

jQuery(document).ready(function() {
    jQuery('.shrink-enabler').each(function (index) {
        jQuery(this).bind('click keyup', function (event) {
            yourcityToggleShrinkSettings(jQuery(this).attr('id').replace('enableShrinkingFor', ''));
        });
        yourcityToggleShrinkSettings(jQuery(this).attr('id').replace('enableShrinkingFor', ''));
    });
});
