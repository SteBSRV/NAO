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

    $("#btn_open_filter").click(function() {
      $("#btn_open_filter").hide();
      $("#form_filter_container").removeClass('hidden-xs hidden-sm');
      $("#form_filter_container").show();
    });
    $("#btn_close_filter").click(function() {
      $("#form_filter_container").hide();
      $("#form_filter_container").addClass('hidden-xs hidden-sm');
      $("#btn_open_filter").show();
    });
})
