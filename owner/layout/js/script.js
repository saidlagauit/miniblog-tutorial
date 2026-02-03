$(document).ready(function () {
  $("#Form").submit(function (event) {
    var isValid = $.validate.form(this);
    return isValid;
  });
  $("#menu-toggle").click(function (e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });
  $("#cover :file").on("change", function () {
    var input = $(this).parents(".input-group").find(":text");
    input.val($(this).val());
    input.blur();
  });
  $("#cover .form-control").validate({
    required: false,
    bootstrap: true,
    type: "custom",
    param: /([^\/\\]+)\.(gif|jpeg|jpg|png)$/i,
    color_text: "#000000",
    color_hint: "#00FF00",
    color_error: "#FF0000",
    color_border: "#808080",
    nohint: false,
    font_family: "Arial",
    font_size: "13px",
    position: "topleft",
    offsetx: 0,
    offsety: 0,
    effect: "none",
    error_text:
      "Invalid file type. Only JPG, JPEG, PNG and GIF files are allowed",
  });
  setTimeout(function () {
    var message = document.getElementById("message");
    if (message != null) {
      message.style.display = "none";
    }
  }, 3000);
});
