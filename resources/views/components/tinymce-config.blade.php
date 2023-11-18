<script src="https://cdn.tiny.cloud/1/e7ii6uj0nkqyhytpa0i4017knorjhs094f4vm48p9g1qp718/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    let content = document.getElementById('editor-content');
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
  }
</script>