var pathArray = window.location.pathname.split('/');

if (jQuery.inArray("loader", pathArray) >= 1 && jQuery.inArray("details", pathArray) >= 1) {

    $('.loader-details').summernote({
        height: 350, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: false, // set focus to editable area after initializing summernote
        // callbacks: {
        //     onInit: function () {
        //         $("div.note-editor button.btn-codeview").click();
        //     }
        // },
        toolbar: [
            ["view", ["fullscreen", "codeview", "help"]]
        ],
        // codemirror: {
        //     theme: 'blackboard',
        //     lineNumbers: true
        // }
    });

} else {
    $('.summernote').summernote({
        height: 350, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: false, // set focus to editable area after initializing summernote
        placeholder: 'Paste content here...',
    });

    $('.summernote-height-200').summernote({
        height: 200, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: false // set focus to editable area after initializing summernote
    });

    $('.summernote-bigger').summernote({
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: false // set focus to editable area after initializing summernote
    });

    $('.summernote-custom').summernote({
        height: 150, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: false, // set focus to editable area after initializing summernote
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']],
        ]
    });

    $('.summernote-height-200-custom').summernote({
        height: 189, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: false, // set focus to editable area after initializing summernote
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']],
        ]
    });

    $('.summernote-product').summernote({
        height: 190, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: false, // set focus to editable area after initializing summernote
        // toolbar: [
        //     ['style', ['bold', 'italic', 'underline', 'clear']],
        //     ['color', ['color']],
        // ],
        placeholder: 'Paste content here...',
    });

    $('.summernote-one').summernote({
        height: 190, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: false, // set focus to editable area after initializing summernote
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']],
        ]
    });

    $('.summernote-one').summernote({
        // height: 190,
        // minHeight: null,
        // maxHeight: null,
        // focus: false,
        // toolbar: [
        //     ['style', ['bold', 'italic', 'underline', 'clear']],
        //     ['color', ['color']],
        // ]

        height: 350,
        minHeight: null,
        maxHeight: null,
        focus: false,
        placeholder: 'Paste content here...',
    });
}
