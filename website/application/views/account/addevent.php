<div class="container">
	<div class="row">
		<?php
		if(isset($response)){
			echo '<br />';
			if($response->code == 200){
				echo '<div class="alert alert-success">Event was successfully added.</div>';
			}else if($response->code == 500){
				$this->load->view('template/database');
			}
		}
		?>
    	<div class="span12">
    		<!-- Title -->
    		<h3>Add New Event</h3>
       		<form class="form-inline" method="post" action="">
       			<fieldset> <!--mandatory-->
					<legend>Event Info</legend>
          			<div class="control-group">
            			<label class="control-label" for="event_name">Event Name</label>
			            <div class="controls">
              				<input type="text" class="input-xlarge" name="event_name" id="event_name">
            			</div>
          			</div>
          			<div class="control-group input-append date form_datetime eventmanager_datepicker">
	          			<label class="control-label" for="event_name">Event Date</label>
	          			<div class="controls">
		    				<input size="16" type="text" name="event_date" value="">
							<span class="add-on" style="margin-top:5px;"><i class="icon-remove"></i></span>
							<span class="add-on" style="margin-top:5px;"><i class="icon-th"></i></span>
						</div>
					</div>
					<div class="control-group">
            			<div class="controls">
			              <label class="checkbox">
                			<input type="checkbox" id="promote_event" name="promote_event" value="yes">
							Promote this event for only: <strong>$<?php echo $this->config->item('promotion_cost');?></strong>
			              </label>
			              <p class="help-block"><?php echo $this->config->item('promotion_features');?></p>
            			</div>
          			</div>
          			<div class="control-group" style="display:none;" id="suggested_url">
            			<label class="control-label" for="event_name">Custom Event URL</label>
			            <div class="controls">
              				<input type="text" class="input-xlarge slug" name="slug" id="slug">
              				<span class="add-on" style="margin-top:5px;"><button type="button" class="btn btn-info" onclick="check_url()">Check Availability</button></span>
            			</div>
            			<p class="help-block" id="url_check"></p>
          			</div>
					<div class="control-group">
            			<label class="control-label" for="description">Event Description</label>
            			<div class="controls">
              				<textarea class="input-xlarge" id="textarea" name="event_description" rows="10" style="width:100%;"></textarea>
            			</div>
          			</div>
          			<div class="control-group">
            			<label class="control-label" for="description">Event Cost</label>
            			<div class="controls">
              				<input type="text" name="event_cost" placeholder="Cost to Participate"/>
            			</div>
          			</div>
          			<div class="control-group">
            			<label class="control-label" for="description">Event Tags</label>
            			<div class="controls">
              				<input type="text" name="tags" placeholder="Tags" class="eventmanager_tags" autocomplete="off"/>
            			</div>
            			<p class="help-block">As many as you want, separated by a comma</p>
          			</div>
	        	</fieldset>
	        	
	        	<fieldset><!-- Location Info -->
					<legend>Location Information</legend>
          			<div class="control-group">
            			<label class="control-label" for="zip_code">Zip Code</label>
			            <div class="controls">
              				<input type="text" class="input-xlarge" name="zip_code" id="zip_code">
              				<span class="add-on" style="margin-top:5px;"><button type="button" class="btn btn-info" onclick="suggest_city()">Suggest City</button></span>
            			</div>
            			<p class="help-block" id="city_help"></p>
          			</div>
          			<div class="control-group">
            			<label class="control-label" for="city">City</label>
			            <div class="controls">
              				<input type="text" class="input-xlarge" name="city" id="city">
            			</div>
          			</div>
					<div class="control-group">
            			<label class="control-label" for="directions">General Directions</label>
            			<div class="controls">
              				<textarea class="input-xlarge" id="directions" name="general_directions" rows="10" style="width:100%;"></textarea>
            			</div>
          			</div>
	        	</fieldset>
	        	<table style="width:100%;">
	        		<tr>
	        			<td style="width:49%;">
	        	<fieldset><!-- Contact Info -->
					<legend>Contact Information</legend>
          			<div class="control-group">
            			<label class="control-label" for="contact_name">Contact Name</label>
			            <div class="controls">
              				<input type="text" class="input-xlarge" name="contact_name" id="contact_name">
            			</div>
          			</div>
          			<div class="control-group">
            			<label class="control-label" for="contact_email">Contact Email</label>
			            <div class="controls">
              				<input type="text" class="input-xlarge" name="contact_email" id="contact_email">
            			</div>
          			</div>
          			<div class="control-group">
            			<div class="controls">
			              <label class="checkbox">
                			<input type="checkbox" id="show_email" name="show_email" value="yes">
							Allow users to see your email address
			              </label>
            			</div>
          			</div>
					<div class="control-group">
            			<label class="control-label" for="contact_phone">Contact Phone Number</label>
			            <div class="controls">
              				<input type="text" class="input-xlarge" name="contact_phone" id="contact_phone">
            			</div>
          			</div>
          			<div class="control-group">
            			<div class="controls">
			              <label class="checkbox">
                			<input type="checkbox" id="show_phone" name="show_phone" value="yes">
							Allow users to see your phone number
			              </label>
            			</div>
          			</div>
	        	</fieldset>
	        	</td>
	        	<td style="width:50%;">
	        	<fieldset><!-- optional -->
					<legend>Optional Information</legend>
					<div class="control-group">
            			<label class="control-label" for="website">Website</label>
			            <div class="controls">
              				<input type="text" class="input-xlarge" name="website" id="website">
            			</div>
          			</div>
          			<div class="control-group">
            			<label class="control-label" for="google_id">Google Analytics Tracking Code ID</label>
			            <div class="controls">
              				<input type="text" class="input-xlarge" name="tracking_id" id="tracking_id" placeholder="UA-28337160-2">
            			</div>
          			</div>
          			<div class="control-group">
            			<label class="control-label" for="sponsor">Event Sponsor</label>
			            <div class="controls">
              				<input type="text" class="input-xlarge" name="sponsor" id="sponsor">
            			</div>
          			</div>
        			<div class="control-group">
						<p style="height:61px;">&nbsp;</span>
          			</div>
	        	</fieldset>
          			</td>
          			</tr>
          			</table>
          		<fieldset><!-- optional -->
					<legend>Social Media</legend>
					<table id="social_media">
					<tfoot>
					<tr>
						<td><button type="button" class="btn btn-info" onclick="add_social_media()">Add Another Social Media</button></td>
					</tr>
					</tfoot>
					<tbody>
					<tr>
					<td>
					<div class="control-group">
            			<label class="control-label" for="social_media_0">Social Media</label>
			            <div class="controls">
			            	<select id="social_media[0]">
                				<option value="">Select</option>
                				<option value="facebook">Facebook</option>
                				<option value="twitter">Twitter</option>
                				<option value="google-plus">Google Plus</option>
							</select>
              				<input type="text" class="input-xlarge" name="social_media_link[0]" id="social_media_0" placeholder="http://www.link.com/page">
            			</div>
          			</div>
          			</td>
          			</tr>
          			</tbody>
          			</table>
	        	</fieldset>

          			<div class="form-actions">
			            <button type="submit" class="btn btn-primary">Add Event</button>
          			</div>

       		</form>
  		</div>
  	</div>
</div>
