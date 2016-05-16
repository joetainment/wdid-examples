require.config({
    paths: {
        jquery: 'js/lib/jquery/jquery',
        classify: 'js/lib/classify/classify',
        ckeditor: 'ckeditor/ckeditor',
        bootstrap: 'js/lib/bootstrap/bootstrap'
    },    shim: { ckeditor:{exports:'CKEDITOR'} }
});