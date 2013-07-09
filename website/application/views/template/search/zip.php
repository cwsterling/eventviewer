<div class="container newsletter">
		<div class="row">
    		<div class="span12">
      			<div class="well">
        			<!-- Title -->
           			<h5>Find Events in your area</h5>
           			<!-- para -->
           			<p>Zip Code then Range. Note, currently local testing, REALLY slow</p>
           			<!-- Form -->
           			<form class="form-inline" method="post" action="/search/zip">
              			<div class="controls controls-row">
              			<?php
              			$zip_value = (isset($data['zip']))? 'value="'.$data['zip'].'"' : '';
              			$range_value = (isset($data['range']))? 'value="'.$data['range'].'"' : '';
              			
              			?>
                			<input class="span2" type="text" placeholder="Zip Code" name="zip" <?php echo $zip_value; ?>>
                			<input class="span2" type="text" placeholder="Range (in MI)" name="range_used" <?php echo $range_value; ?>>
                			<button type="submit" class="btn">Search</button>
              			</div>
           			</form>
      			</div>
    		</div>
  		</div>
	</div>