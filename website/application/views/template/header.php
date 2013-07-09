<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  	<meta charset="utf-8">
  	<!-- Title and other stuffs -->
  	<title>Event Calendar</title>
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta name="description" content="">
  	<meta name="keywords" content="">
  	<meta name="author" content="">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="/js/jquery.cookie.js"></script> <!-- Bootstrap -->
  	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>

  	<!-- Stylesheets -->
  	<link href="/style/bootstrap.css" rel="stylesheet">
  	<!-- datetime picker -->
  	<link href="/style/datetimepicker.css" rel="stylesheet">
  	<!-- tag manager -->
  	<link href="/style/tagmanager.css" rel="stylesheet">
  	<!-- Pretty Photo -->
  	<link href="/style/prettyPhoto.css" rel="stylesheet">
  	<!-- Flex slider -->
  	<link href="/style/flexslider.css" rel="stylesheet">
  	<!-- Font awesome icon -->
  	<link rel="stylesheet" href="/style/font-awesome.css">
  	<!-- Parallax slider -->
  	<link rel="stylesheet" href="/style/slider.css">
  	<!-- Refind slider -->
  	<link rel="stylesheet" href="/style/refineslide.css">  
  	<!-- Main stylesheet -->
  	<link href="/style/style.css" rel="stylesheet">
  	<!-- Stylesheet for Color -->
  	<link href="/style/orange.css" rel="stylesheet">
  	<!-- Responsive style (from Bootstrap) -->
  	<link href="/style/bootstrap-responsive.css" rel="stylesheet">
  
  	<!-- HTML5 Support for IE -->
  	<!--[if lt IE 9]>
  	<script src="/js/html5shim.js"></script>
  	<![endif]-->

  	<!-- Favicon -->
  	<link rel="shortcut icon" href="/img/favicon/favicon.png">
  	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-28337160-2']);
		_gaq.push(['_trackPageview']);
		<?php
		if(isset($google)){
		?>
		['b._setAccount', '<?php echo $google['tracking'];?>'],
		//['b._trackPageview']
		<?php
		}
		?>
		(function() {
    		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
 		})();
	</script>
  	<script type="text/javascript">
	function trackOutboundLink(link, category, action) { 
		try { 
			_gaq.push(['_trackEvent', category , action]); 
		} catch(err){}
		setTimeout(function() {
			document.location.href = link.href;
		}, 100);
	}
	</script>
	</head>

	<body>

	<!-- Header starts -->
  	<header>
    	<div class="container">
      		<div class="row">
        		<div class="span4">
					<!-- Logo. Use class "color" to add color to the text. -->
          			<div class="logo">
            			<h1><a href="<?php echo site_url();?>">Event <span class="color bold">Calendar</span></a></h1>
            			<p class="meta">something goes in meta area</p>
          			</div>
        		</div>

        		<div class="span8">
          		<!-- Navigation -->
          			<?php $this->load->view('template/navigation');?>
				</div>
			</div>
    	</div>
  	</header>
  	<!-- Seperator -->

  	<div class="sep"></div>

  	<!-- Header ends -->
