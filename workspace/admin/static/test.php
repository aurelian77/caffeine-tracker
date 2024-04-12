<?php

if (!empty($_POST)) {
    print_r($_POST);
    exit;
}

?><!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" type="text/css" href="http://test.local/suneditor.css" />

<style>
.sun-editor {
    font-family: Verdana, sans-serif;
}
.sun-editor .se-menu-list button[data-command="save"] {
    color: #2196f3;
    background-color: #ffc;
    border: 1px solid #2196f3;
}
</style>

<script type="text/javascript" src="http://test.local/suneditor.js"></script>

</head>
<body>

<form method="post" enctype="multipart/form-data" id="form">
    <textarea id="textarea" name="dolfi"></textarea>
</form>

<script>
function ActivateEditor(formId, textareaId) {
    const Editor = SUNEDITOR.create(textareaId, {
        display: 'block',
        width: '762px',
        height: '400px',
        popupDisplay: 'full',
        defaultStyle: "font-family: Verdana; font-size: 14px; line-height: 1;",
        buttonList: [
            ['undo', 'redo'],
            ['font', 'fontSize', 'formatBlock'],
            ['paragraphStyle', 'blockquote'],
            ['bold', 'underline', 'italic', 'strike', 'subscript', 'superscript'],
            ['fontColor', 'hiliteColor', 'textStyle'],
            ['removeFormat'],
            ['outdent', 'indent'],
            ['align', 'horizontalRule', 'list', 'lineHeight'],
            ['table', 'link', 'image', 'video', 'audio'],
            ['fullScreen', 'showBlocks', 'codeView'],
            ['preview', 'print'],
            ['save']
        ],
        // Should be aborted, since we use only monospace
        font: [
            "Arial",
            "Comic Sans MS",
            "Courier New",
            "Impact",
            "Georgia",
            "Tahoma",
            "Trebuchet MS",
            "Verdana",
            "Garamond",
            "Times New Roman",
            "Helvetica",
            "sans-serif",
            "serif",
            "monospace"
        ],
        fontSize : [
            8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22
        ],
        paragraphStyles : [
            'spaced'
        ],
        textStyles : [
            'code', 'translucent'
        ],
        callBackSave: function (contents, isChanged) {
            document.getElementById(textareaId).value = Editor.getContents();
            document.getElementById(formId).submit();
        }
    });
}

ActivateEditor('form', 'textarea');
</script>
</body>
</html>