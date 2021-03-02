tinymce.init({

    setup: function (editor) {
        editor.on('PostProcess', function (ed) {
            ed.content = ed.content.replace(/(<br \/><br \/><br \/><br \/><br \/><br \/><br \/><br \/>)/gi, '<br \/><br \/>');

            ed.content = ed.content.replace(/(<div>)/gi, '<br \/>');
            ed.content = ed.content.replace(/(<\/div>)/gi, '<br \/>');

            ed.content = ed.content.replace(/(<h1>)/gi, '<br \/>');
            ed.content = ed.content.replace(/(<\/h1>)/gi, '<br \/>');

            ed.content = ed.content.replace(/(<h2>)/gi, '<br \/>');
            ed.content = ed.content.replace(/(<\/h2>)/gi, '<br \/>');

            ed.content = ed.content.replace(/(<h3>)/gi, '<br \/>');
            ed.content = ed.content.replace(/(<\/h3>)/gi, '<br \/>');

            ed.content = ed.content.replace(/(<h4>)/gi, '<br \/>');
            ed.content = ed.content.replace(/(<\/h4>)/gi, '<br \/>');

            ed.content = ed.content.replace(/(<h5>)/gi, '<br \/>');
            ed.content = ed.content.replace(/(<\/h5>)/gi, '<br \/>');

            ed.content = ed.content.replace(/(<h6>)/gi, '<br \/>');
            ed.content = ed.content.replace(/(<\/h6>)/gi, '<br \/>');

            ed.content = ed.content.replace(/(<p>)/gi, '<br \/>');
            ed.content = ed.content.replace(/(<\/p>)/gi, '<br \/>');

            ed.content = ed.content.replace(/(<div)/gi, '<br');

        });
    },
    selector: 'textarea.tinymce',
    language: 'fr_FR',
    height: 430,
    plugins: [
        'image link code media emoticons',
    ],
    branding: false,

    force_br_newlines: true,
    force_p_newlines: false,

    forced_root_block: '',

    toolbar: 'undo redo | bold italic underline | link | image | code | media | forecolor backcolor | emoticons',
    /*
    content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        '//www.tiny.cloud/css/codepen.min.css'
    ]
    */
});