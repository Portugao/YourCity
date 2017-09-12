/**
 * Initializes the plugin, this will be executed after the plugin has been created.
 * This call is done before the editor instance has finished it's initialization so use the onInit event
 * of the editor instance to intercept that event.
 *
 * @param {tinymce.Editor} ed Editor instance that the plugin is initialised in
 * @param {string} url Absolute URL to where the plugin is located
 */
tinymce.PluginManager.add('muyourcitymodule', function(editor, url) {
    var icon;

    icon = Zikula.Config.baseURL + Zikula.Config.baseURI + '/web/modules/muyourcity/images/admin.png';

    editor.addButton('muyourcitymodule', {
        //text: 'Your city',
        image: icon,
        onclick: function() {
            MUYourCityModuleFinderOpenPopup(editor, 'tinymce');
        }
    });
    editor.addMenuItem('muyourcitymodule', {
        text: 'Your city',
        context: 'tools',
        image: icon,
        onclick: function() {
            MUYourCityModuleFinderOpenPopup(editor, 'tinymce');
        }
    });

    return {
        getMetadata: function() {
            return {
                title: 'Your city',
                url: 'https://homepages-mit-zikula.de'
            };
        }
    };
});
