tinymce.init({
  selector: '#content',
  menubar: false,
  plugins: 'lists link image preview',
  toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  branding: false,
  height: 400,
  content_css: '/static/css/layout/main.css',
});