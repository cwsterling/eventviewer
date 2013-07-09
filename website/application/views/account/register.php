<div class="container newsletter">
	<div class="row">
	<br />
	<?php

	if(isset($add_response)){
		if($add_response->ret_data->success == false){
			echo '<div class="alert alert-error"><p>There was an error adding your account. The error(s) are as follows: <br />';
			if($add_response->ret_data->error->email == true){
				echo $add_response->ret_data->message->email.'<br />';
			}
			if(isset($add_response->ret_data->error->account) && $add_response->ret_data->error->account == true){
				echo $add_response->ret_data->message->account.'<br />';
			}
			echo '</p></div>';	
		}
	}

	?>
    	<div class="span12">
    		<!-- Title -->
    		<h3>Create Account</h3>
    		<p>In order to be able to post events, and in the future, register for events, you will need to have an account created.</p>
       		<form class="form-inline" method="post" action="">
       			<fieldset> <!--mandatory-->
					<legend>Account Info</legend>
          			<div class="control-group">
            			<label class="control-label" for="username">Username</label>
			            <div class="controls">
              				<input type="text" class="input-xlarge" name="username" id="username">
            			</div>
          			</div>
          			<div class="control-group">
            			<label class="control-label" for="password">Password</label>
			            <div class="controls">
              				<input type="password" class="input-xlarge" name="password" id="password">
            			</div>
          			</div>
          			<div class="control-group">
            			<label class="control-label" for="password2">Repeat Password</label>
			            <div class="controls">
              				<input type="password" class="input-xlarge" name="password2" id="password2">
            			</div>
          			</div>
          			<div class="control-group">
            			<label class="control-label" for="email">Email Address</label>
			            <div class="controls">
              				<input type="text" class="input-xlarge" name="email" id="email">
            			</div>
          			</div>
	        	</fieldset>
	        	
	        	<fieldset><!-- Location Info -->
	        		<table style="width:100%;">
	        			<tr>
	        				<td style="width:45%;">
					<legend>Optional Contact Information</legend>
					<p>Filling out the following information will speed up the event creation process</p>
          			<div class="control-group">
            			<label class="control-label" for="name">Name</label>
			            <div class="controls">
              				<input type="text" class="input-xlarge" name="name" id="name">
            			</div>
          			</div>
          			<div class="control-group">
            			<label class="control-label" for="phone">Phone Number</label>
			            <div class="controls">
              				<input type="text" class="input-xlarge" name="phone" id="phone">
            			</div>
          			</div>
          			</td>
          			<td style="width:55%">
          			<legend>Optional Location Information</legend>
          			<div class="control-group">
					<p>Filling out the following information will speed up the event search and creation process</p>
            			<label class="control-label" for="zip_code">Local Zip Code</label>
			            <div class="controls">
              				<input type="text" class="input-xlarge" name="zip_code" id="zip_code">
              				<span class="add-on" style="margin-top:5px;"><button type="button" class="btn btn-info" onclick="suggest_city()">Suggest City</button></span>
            			</div>
            			<p class="help-block" id="city_help"></p>
          			</div>
          			<div class="control-group">
            			<label class="control-label" for="city">Local City</label>
			            <div class="controls">
              				<input type="text" class="input-xlarge" name="city" id="city">
            			</div>
          			</div>
          			</td>
          			</tr>
          			</table>
	        	</fieldset>
       			<div class="form-actions">
		            <button type="submit" class="btn btn-primary">Register Account</button>
       			</div>
       		</form>
  		</div>
  	</div>
</div>
