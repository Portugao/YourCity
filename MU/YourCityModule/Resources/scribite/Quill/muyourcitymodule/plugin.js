var muyourcitymodule = function(quill, options) {
    setTimeout(function() {
        var button;

        button = jQuery('button[value=muyourcitymodule]');

        button
            .css('background', 'url(' + Zikula.Config.baseURL + Zikula.Config.baseURI + '/web/modules/muyourcity/images/admin.png) no-repeat center center transparent')
            .css('background-size', '16px 16px')
            .attr('title', 'Your city')
        ;

        button.click(function() {
            MUYourCityModuleFinderOpenPopup(quill, 'quill');
        });
    }, 1000);
};
