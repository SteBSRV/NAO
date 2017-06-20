$(document).ready(function() {
    $("#open_menu").click(function(e) {
        e.preventDefault();
        $("#wrapper").addClass("toggled");
    });
    $("#close_menu").click(function(e) {
        e.preventDefault();
        $("#wrapper").removeClass("toggled");
    });
    $(".faq_slidedown").click(function () {
    	var response = $(this).parent().find('.faq_response');
  		if ( $(response).is(":hidden")) {
    		$(response).slideDown("slow");
  		} else {
    		$(response).slideUp("slow");
  		}
  	});
    $("a.single_image").fancybox();
    $("#start_button").click(function() {
      $("#first_page").hide("slow");
      $("#second_page").show("slow");
    });
})
