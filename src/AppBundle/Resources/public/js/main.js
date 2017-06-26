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