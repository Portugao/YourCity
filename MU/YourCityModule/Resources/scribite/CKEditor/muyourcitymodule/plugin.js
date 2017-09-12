CKEDITOR.plugins.add('muyourcitymodule', {
    requires: 'popup',
    init: function (editor) {
        editor.addCommand('insertMUYourCityModule', {
            exec: function (editor) {
                MUYourCityModuleFinderOpenPopup(editor, 'ckeditor');
            }
        });
        editor.ui.addButton('muyourcitymodule', {
            label: 'Your city',
            command: 'insertMUYourCityModule',
            icon: this.path.replace('scribite/CKEditor/muyourcitymodule', 'images') + 'admin.png'
        });
    }
});
