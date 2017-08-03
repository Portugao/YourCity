CKEDITOR.plugins.add('muyourcitymodule', {
    requires: 'popup',
    lang: 'en,nl,de',
    init: function (editor) {
        editor.addCommand('insertMUYourCityModule', {
            exec: function (editor) {
                var url = Routing.generate('muyourcitymodule_external_finder', { objectType: 'location', editor: 'ckeditor' });
                // call method in MUYourCityModule.Finder.js and provide current editor
                MUYourCityModuleFinderCKEditor(editor, url);
            }
        });
        editor.ui.addButton('muyourcitymodule', {
            label: editor.lang.muyourcitymodule.title,
            command: 'insertMUYourCityModule',
            icon: this.path.replace('scribite/CKEditor/muyourcitymodule', 'public/images') + 'admin.png'
        });
    }
});
