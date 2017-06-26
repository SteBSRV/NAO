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
    $('.form_newsletters').on('submit', function(e) {
        e.preventDefault();
 
        var $this = $(this);
        var name = $this.find('#news_letter_name').val();
        var mail = $this.find('#news_letter_mail').val();
 
        if(name === '' || mail === '') {
            alert('Les deux champs doivent êtres remplis');
        } else {
            $.ajax({
                url: $this.attr('action'), 
                type: $this.attr('method'),
                data: $this.serialize(), 
                success: function(html) {
                    if (html.indexOf('<form name=') > -1)  {
                      $this.html(html);
                    } else {
                      alert(html);
                      $this.find('#news_letter_name').val('');
                      $this.find('#news_letter_mail').val('');
                      $("#newsletter_modal").modal("hide");
                    }
                }
            });
        }
    });

    /* Autocomplete filter */
    var liste = [
        "Auvergne-Rhône-Alpes",
        "Bourgogne-Franche-Comté",
        "Bretagne",
        "Centre-Val de Loire",
        "Corse",
        "Grand Est",
        "Hauts-de-France",
        "Île-de-France",
        "Normandie",
        "Nouvelle-Aquitaine",
        "Occitanie",
        "Pays de la Loire",
        "Provence-Alpes-Côte d'Azur"
    ];

    if ($('#observation_filter_region').length)
      $('#observation_filter_region').autocomplete({
          source : liste,
          minLength: 0
      }).bind('focus', function(){ $(this).autocomplete("search"); } );

    /* Autocomplete birds list */
    if($('#observation_filter_bird').length) {
      $('#observation_filter_bird').chosen({placeholder_text_single: "Choisir une espèce..."});
    }
    if($('#observation_bird').length) {
      $('#observation_bird').chosen({placeholder_text_single: "Choisir une espèce..."});
    }
})

function displayImageOnChange(id){
    document.getElementById(id).addEventListener('change', readURL, true);
    function readURL(){
        var file = document.getElementById(id).files[0];
        var reader = new FileReader();
        reader.onloadend = function(){
            document.getElementById('new_profile_img').style.display = "";
            document.getElementById('new_profile_img').style.backgroundImage = "url(" + reader.result + ")";
        }
        document.getElementById('old_profile_img').style.display = "none";
        if(file){
            reader.readAsDataURL(file);
        }
    }
}
function showMotivationField(){
    var accountType = $("#fos_user_registration_form_accountType").val();
    if(accountType === "amateur"){
        $("#motivationField").hide();
        $("#fos_user_registration_form_motivation").attr("required", false);
    }
    else{
        $("#motivationField").show();
        $("#fos_user_registration_form_motivation").attr("required", true);
    }
}
