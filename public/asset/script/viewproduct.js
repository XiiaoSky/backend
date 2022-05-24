$(document).ready(function () {
    $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
  if(e.keyCode == 13) {
    e.preventDefault();
    return false;
  }
});

$(".sideBarli").removeClass("activeLi");
        $(".productSideA").addClass("activeLi");
});