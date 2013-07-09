<?php
$event = $result->ret_data;
echo '<pre>';
var_dump($event);
echo '</pre>';
$format = 'Y-m-d H:i:s.u';
$date = DateTime::createFromFormat($format, $event->Created);
?>
<div class="content blog">
	<div class="container">
		<div class="row">
			<div class="span8">
            	<div class="posts">
				<!-- Each posts should be enclosed inside "entry" class" -->
                <!-- Post one -->
                	<div class="entry">
                    	<h2><?php echo $event->Title;?></h2>
                       	<!-- Meta details -->
                       	<div class="meta">
                         	<i class="icon-calendar"></i><?php echo $date->format('F j, Y, g:i a'); ?> <i class="icon-user"></i> <a href="mailto:<?php echo $event->Email; ?>"><?php echo $event->Email; ?></a>
                        </div>     
                        <!-- Thumbnail -->
                        <div class="bthumb">
                           	<img src="img/photos/l1.jpg" alt="" />
                        </div>
						<?php
						echo $event->Description;
						?>
                    </div>

	                <div class="well">
    	              	<!-- Social media icons -->
        	            <div class="social pull-left">
            	           	<h5>Follow this Event: </h5>
            	           	<?php
            	           	foreach($event->Social as $key=>$value){
								echo '<a href="'.$value.'"><i class="icon-'.$key.' '.$key.'"></i></a>';            	           		
            	           	}
            	           	?>
        	            </div>
            	        <!-- Tags -->
                	    <div class="tags pull-right">
                    	   	<?php
                    	   	$tag_string = '';
                    	   	$tags_used = 0;
                    	   	foreach($event->Tags as $tag){
                    	   		$tag_string .= '<a href="/search/tag/'.strtolower($tag->tag).'">'.ucfirst($tag->tag).'</a>';
                    	   		$tags_used++;
                    	   	}
                    	   	if($tags_used > 1){
                    	   		echo '<h5>Tags:</h5>';
                    	   	}else{
                    	   		echo '<h5>Tag</h5>';
                    	   	}
                    	   	echo $tag_string;
                    	   	?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="span4">
			<!-- Sidebar -->
            	<div class="sidebar">
                    <div class="widget">
                    <h4>Upcoming Events</h4>
                    	<ul>
                        	<li>Etiam adipiscing posuere justo, nec iaculis justo dictum non</li>
                            <li>Cras tincidunt mi non arcu hendrerit eleifend</li>
                            <li>Aenean ullamcorper justo tincidunt justo aliquet et lobortis diam faucibus</li>
                            <li>Maecenas hendrerit neque id ante dictum mattis</li>
                            <li>Vivamus non neque lacus, et cursus tortor</li>
                        </ul>
                    </div>
                </div>                                                
            </div>
		</div>
	</div>
</div>