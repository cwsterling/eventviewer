<div class="container newsletter">
	<div class="row">
	<br />
	<?php
	if($this->session->flashdata('new_account') != ''){
		echo $this->session->flashdata('new_account');
	}
	?>
	</div>
</div>