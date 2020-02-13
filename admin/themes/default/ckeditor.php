<!-- <script src="//cdn.ckeditor.com/4.7.1/basic/ckeditor.js"></script> -->
<!-- <script src="//cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script> -->
<script src="//cdn.ckeditor.com/4.7.1/full/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function(){

        var editor = CKEDITOR.replace( '<?php echo $ckeditor_id ?>', {
            language: 'pt-BR',
            filebrowserBrowseUrl: '<?php echo CKEDITOR_FILE_BROWSER ?>',
            filebrowserUploadUrl: '<?php echo CKEDITOR_FILE_UPLOAD ?>',
            toolbarGroups: [
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'paragraph' ] },
                { name: 'styles', groups: [ 'styles' ] },
                { name: 'links', groups: [ 'links' ] },
                // { name: 'editing', groups: [ 'spellchecker', 'editing' ] },
                // { name: 'colors', groups: [ 'colors' ] },
                { name: 'insert', groups: [ 'insert' ] },
                // { name: 'forms', groups: [ 'forms' ] },
                // { name: 'tools', groups: [ 'tools' ] },
                { name: 'document', groups: [ 'mode' ] },
                // '/',
                // { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                // { name: 'others', groups: [ 'others' ] },
                // { name: 'about', groups: [ 'about' ] }
            ],
            removeButtons: 'Subscript,Superscript,Cut,Copy,Paste,PasteText,PasteFromWord'
                            +',Undo,Redo,Strike,Table,HorizontalRule,texzilla,ccmsacdc,Styles,Format'
                            +',Flash,Smiley,Save,NewPage,Preview,Print,CopyFormatting,CreateDiv,Iframe,Font,FontSize'
                            // +',find,selection,editing,bidi,paragraph,forms,doctools'
            /*,
            toolbarGroups: [
                {"name":"basicstyles","groups":["basicstyles"]},
                {"name":"alignment","groups":["justify"]},
                {"name":"links","groups":["links"]},
                {"name":"paragraph","groups":["list","blocks"]},
                {"name":"document","groups":["mode"]},
                {"name":"insert","groups":["insert"]},
                {"name":"styles","groups":["styles"]},
                {"name":"about","groups":["about"]}
            ],
            // Remove the redundant buttons from toolbar groups defined above.
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
            */
        });

        editor = editor || CKEDITOR.instances.<?php echo $ckeditor_id ?>;

        editor.on( 'fileUploadRequest', function( evt ) {
            var xhr = evt.data.fileLoader.xhr;
            console.log(xhr);

            // xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            // xhr.send( this.file );

            console.log($('meta[name="csrf-token"]').attr('content'));

            // Prevented the default behavior.
            // evt.stop();
        });

        // gambi to hide source-code text
        setTimeout(function(){ $('.cke_button__source_label').hide(); $('.cke_dialog_ui_input_file, .cke_dialog_ui_file').css('height', '150px'); }, 5000);
        
    });
</script>