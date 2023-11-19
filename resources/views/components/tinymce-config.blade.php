<script src="https://cdn.tiny.cloud/1/rqjtoo2tghibqr646jn7iaxwkrttuq0tm4vypi90fd8k0a4i/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  let content = document.getElementById('editor-content'); // no problem
  
  tinymce.init({
    selector: 'textarea#myeditor', // Replace this CSS selector to match the placeholder element for TinyMCE
    plugins: 'code table lists',
    setup: (editor) => {
        editor.on('input', (e) => {
            content.value = editor.getContent();
        });
    },
    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
  });
</script>