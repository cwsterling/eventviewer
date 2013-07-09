<div class="content">
	<div class="container">
<?php
if($results->code == 500){
	$this->load->view('template/database');
}elseif($results->code == 0 || $results->code == '200'){
	if($results->code == 200){
		$search_data['data']['zip'] = $results->ret_data->start_info->location;
		$search_data['data']['range'] = $results->ret_data->start_info->range;
		$search_data['data']['type'] = $results->ret_data->start_info->search_type;
	}else{
		$search_data = array();
	}

	if((isset($results->search_type) && $results->search_type == 'zip') || (isset($results->ret_data->start_info->search_type) && $results->ret_data->start_info->search_type == 'zip')){
		$this->load->view('template/search/zip',$search_data);
	}else if((isset($results->search_type) && $results->search_type == 'state') || (isset($results->ret_data->start_info->search_type)  && $results->ret_data->start_info->search_type == 'state')){
		$this->load->view('template/search/state',$search_data);	
	}else if((isset($results->search_type) && $results->search_type == 'city') || (isset($results->ret_data->start_info->search_type)  && $results->ret_data->start_info->search_type == 'city')){
		$this->load->view('template/search/city',$search_data);
	}else{
		echo 'nothing to see here, please move along';
	}
}
if($results->code == 200){
	if($results->ret_data->start_info->search_type == 'zip'){
	?>
		<div class="modal hide fade" id="set_local_zip">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>Set Local Zipcode</h3>
			</div>
			<div class="modal-body">
				<p>Would you like to use: <strong><?php echo $results->ret_data->start_info->location;?></strong> as your local location</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true" id="do_not_use" onClick="hide_local_set('no')">&times; No</button>
				<button type="button" class="btn btn-success" data-dismiss="modal" aria-hidden="true" id="use_as_local" onClick="hide_local_set('yes')"> <i class="icon-ok icon-white"></i> Yes</button>
			</div>
		</div>
		<?php
	}
	?>
	<div class="row">
		<h2>Upcoming Events</h2>
		<div class="span8">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Event Name</th>
					<th>Location</th>
				</tr>
			</thead>
			<tbody>
			<?php

			foreach($results->ret_data->events_found as $key=>$event_info){
				echo '<tr>';
					echo '<td><a href="'.site_url('event/view/'.$event_info->id).'">'.$event_info->title.'</a>';
					if($event_info->Promoted === true){
						echo '<span class="label label-success" style="float:right">Promotion</span> <br class="clear">';
					}
					echo '</td>';
					echo '<td>'.$event_info->location.'('.$event_info->Zip.')</td>';
					echo '<td>'.$event_info->date.'</td>';
				echo '</tr>'."\n";
			}
			
			?>
			</tbody>
		</table>
		</div>
		<div class="span4">
			<div class="well">
				<ul>
				<?php
				foreach($results->ret_data->zips_found as $zipInfo){
					echo '<li>'.$zipInfo->zip.'</li>';
				}
				?>
				</ul>
			</div>
		</div>
	</div>
<?php
}	
?>
		</div>
	</div>
	<?php
	if(!isset($results->code) && $results->ret_data->start_info->search_type == 'zip'){
		if (!get_cookie('local_zip')) {
	?>
	<script type="text/javascript">
		$(window).load(function() {
			<?php
			if($results->code != 500 || $results->code != 0){
				echo '$("#set_local_zip").modal("show");';
			}
			?>
		});
		function hide_local_set(action){
			console.log('Action Selected:'+action);
			<?php
			$zip = $results->ret_data->start_info->location;
			echo 'var local_zip = \''.$zip.'\';';
			?>
			console.log(local_zip);
			if(action == 'no'){
				$.cookie('local_zip', '0', { expires: 49, path: '/' });
			}else if(action == 'yes'){
				$.cookie('local_zip', local_zip, { expires: 49, path: '/' });
			}
			$("#set_local_zip").modal('hide');
		}
	</script>
	<?php
	}
}
?>