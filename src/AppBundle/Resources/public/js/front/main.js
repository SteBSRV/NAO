$(document).ready(function() {
    /* NAVBAR */
    $("#open_menu").click(function(e) {
        e.preventDefault();
        $("#wrapper").addClass("toggled");
    });
    $("#close_menu").click(function(e) {
        e.preventDefault();
        $("#wrapper").removeClass("toggled");
    });

    /* FAQ Animation */
    $(".faq_slidedown").click(function () {
    	var response = $(this).parent().find('.faq_response');
  		if ( $(response).is(":hidden")) {
    		$(response).slideDown("slow");
  		} else {
    		$(response).slideUp("slow");
  		}
  	});

    /* FANCY BOX */
    $("a.single_image").fancybox();

    /* STARTERPAGE */
    $("#start_button").click(function() {
      $("#first_page").hide("slow");
      $("#second_page").show("slow");
    });
    $("#startpage1").click(function() {
      $("#startpage1").hide("slow");
      $("#startpage2").removeClass("hidden-sm hidden-xs");
    })
    $("#startpage2").click(function() {
      $("#startpage2").hide("slow");
      $("#startpage3").removeClass("hidden-sm hidden-xs");
    })

    $("#startpage1").on("tap", function() {
      $("#startpage1").hide("slow");
      $("#startpage2").removeClass("hidden-sm hidden-xs");
    })
    $("#startpage2").on("tap", function() {
      $("#startpage2").hide("slow");
      $("#startpage3").removeClass("hidden-sm hidden-xs");
    })

    $("#startpage1").on("swipe", function() {
      $("#startpage1").hide("slow");
      $("#startpage2").removeClass("hidden-sm hidden-xs");
    })
    $("#startpage2").on("swipe", function() {
      $("#startpage2").hide("slow");
      $("#startpage3").removeClass("hidden-sm hidden-xs");
    })

    /* FILTERING */
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

    /* AJAX FOR NewsLetterType */
    $('#form_newsletter').on('submit', function(e) {
        e.preventDefault();
 
        var $this = $(this);
        var name = $('#news_letter_name').val();
        var mail = $('#news_letter_mail').val();
 
        if(name === '' || mail === '') {
            alert('Les deux champs doivent êtres remplis');
        } else {
            $.ajax({
                url: $this.attr('action'), 
                type: $this.attr('method'),
                data: $this.serialize(), 
                success: function(html) { 
                    alert(html);
                }
            });
        }
    });
})
