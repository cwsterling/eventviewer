<div class="container">
	<div class="row">
	<br />
		<?php
		if(isset($login)){
			if(($login->code != 500) && ($login->code != 0)){
				if($login->ret_data->success == false){
					echo '<div class="alert alert-error"><p>'.$login->ret_data->error->message.'</p></div>';
				}
			}else{
				$this->load->view('template/database');
			}
		}
		?>
		
		<form class="form-horizontal" method="post" action="">
        <fieldset>
        	<legend>Login</legend>
          	<div class="control-group">
            	<label class="control-label" for="email">Username</label>
            	<div class="controls">
              		<input type="text" name="username" class="input-xlarge" id="username" placeholder="Username or Email Address">
            	</div>
	           	<label class="control-label" for="password">Password</label>
            	<div class="controls">
              		<input type="password" name="password" class="input-xlarge" id="password">
            	</div>
          	</div>
          	<div class="control-group">
            	<div class="controls">
              		<label class="checkbox">
                		<input type="checkbox" id="optionsCheckbox" value="remember">
                		Remember Me (Not working yet...In Progress)
              		</label>
            	</div>
          	</div>
          
          	<div class="form-actions">
            	<button type="submit" class="btn btn-primary">Login</button>
            	<a href="/account/forgotpassword" class="btn">Forgot Password</a>
          	</div>
        </fieldset>
      	</form>
    </div>
</div>
