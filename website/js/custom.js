/* JS */


/* Recent posts carousel */


$(window).load(function(){
  $('.rps-carousel').carouFredSel({
  	responsive: true,
  	width: '100%',
  	pauseOnHover : true,
  	auto : false,
  	circular	: true,
  	infinite	: false,
  	prev : {
  		button	: "#car_prev",
  		key		: "left"
  	},
  	next : {
  		button	: "#car_next",
  		key		: "right"
  	},
  	swipe: {
  		onMouse: true,
  		onTouch: true
  	},
  	items: {
  		visible: {
  			min: 1,
  			max: 4
  		}
  	}
  }); 
});

/* Parallax Slider */
  $(function() {
    $('#da-slider').cslider({
      autoplay  : true,
      interval : 8000
    });
  });


/* Flex image slider */


   $('.flex-image').flexslider({
      direction: "vertical",
      controlNav: false,
      directionNav: true,
      pauseOnHover: true,
      slideshowSpeed: 10000      
   });

/* Refind slider */

    $('#rs-slider').refineSlide({
        transition : 'random'
    });

/* Testimonial slider */


   $('.testi-flex').flexslider({
      direction: "vertical",
      controlNav: true,
      directionNav: false,
      pauseOnHover: true,
      slideshowSpeed: 8000      
   });

/* About slider */


   $('.about-flex').flexslider({
      direction: "vertical",
      controlNav: true,
      directionNav: false,
      pauseOnHover: true,
      slideshowSpeed: 8000      
   });


/* Support */

$("#slist a").click(function(e){
   e.preventDefault();
   $(this).next('p').toggle(200);
});

/* Tooltip */

$('#price-tip1').tooltip();

/* Scroll to Top */

$(document).ready(function(){
  $(".totop").hide();

  $(function(){
    $(window).scroll(function(){
      if ($(this).scrollTop()>600)
      {
        $('.totop').slideDown();
      } 
      else
      {
        $('.totop').slideUp();
      }
    });

    $('.totop a').click(function (e) {
      e.preventDefault();
      $('body,html').animate({scrollTop: 0}, 500);
    });

  });
});


/* Portfolio filter */

/* Isotype */

// cache container
var $container = $('#portfolio');
// initialize isotope
$container.isotope();

// filter items when filter link is clicked
$('#filters a').click(function(){
  var selector = $(this).attr('data-filter');
  $container.isotope({ filter: selector });
  return false;
});

/* Pretty Photo for Gallery*/

jQuery(".prettyphoto").prettyPhoto({
overlay_gallery: false, social_tools: false
});

$(".eventmanager_datepicker").datetimepicker({
    format: "mm/dd/yyyy HH:ii P",
    showMeridian: true,
    autoclose: true,
    todayBtn: false
});
/*
$(".eventmanager_tags").tagsManager({
	typeahead: false
});
*/
function get_tags(){
	$.get("/about/tags").done(function(data) {
	  	return data;
	});
}

function suggest_city(){
	$('#city_help').html('<img src="/img/ajax-loader.gif"> Loading City Data');
	zipcode = $('#zip_code').val();
	if(zipcode.length == 5){
		$.get("/about/zipcode/"+zipcode).done(function(data) {
		  	if(data.City != ''){
			  	$('#city').val(data.City)
			  }
	  		$('#city_help').html("");
		});

	}else{
		$('#city_help').html("The zipcode you entered must be 5 digits long.");
	}
	
}

function check_url(){
	$('#url_check').html('<img src="/img/ajax-loader.gif"> Checking URL');
	suggested_slug = $('#slug').val();
	$.get("/about/checkurl/"+suggested_slug).done(function(data) {
		console.log(data);
  		if(data){
		  	$('#url_check').html('<span style="color:green;">URL is Available</span>');
  		}else{
		  	$('#url_check').html('<span style="color:red;">Please try again, URL is <strong>NOT</strong> Available</span>');
  		}
	});	
}

//
//	jQuery Slug Generation Plugin by Perry Trinier (perrytrinier@gmail.com)
//  Licensed under the GPL: http://www.gnu.org/copyleft/gpl.html

jQuery.fn.slug = function(options) {
	var settings = {
		slug: 'slug', 
		hide: false	
	};
	
	if(options) {
		jQuery.extend(settings, options);
	}
	
	$this = jQuery(this);

	jQuery(document).ready( function() {
		if (settings.hide) {
			jQuery('input.' + settings.slug).after("<span class="+settings.slug+"></span>");
			jQuery('input.' + settings.slug).hide();
		}
	});
	
	makeSlug = function() {
			var slugcontent = $this.val();
			var slugcontent_hyphens = slugcontent.replace(/\s/g,'-');
			var finishedslug = slugcontent_hyphens.replace(/[^a-zA-Z0-9\-]/g,'');
			jQuery('input.' + settings.slug).val(finishedslug.toLowerCase());
			jQuery('span.' + settings.slug).text(finishedslug.toLowerCase());

		}
		
	jQuery(this).keyup(makeSlug);
		
	return $this;
};
$(document).ready(function(){ 
	$("#event_name").slug(); 
}); 

$('#promote_event').click(function () {
   	$("#suggested_url").toggle();
});

social_media_count = 1;
function add_social_media(){
	$('#social_media tr:last').after('<tr><td><div class="control-group"><div class="controls"><select id="social_media['+social_media_count+']"><option value="">Select</option><option value="facebook">Facebook</option><option value="twitter">Twitter</option><option value="google-plus">Google Plus</option></select><input type="text" class="input-xlarge" name="social_media_link['+social_media_count+']" id="social_media_'+social_media_count+'" placeholder="http://www.link.com/page"></div></div></td></tr>');
	social_media_count++;
}
