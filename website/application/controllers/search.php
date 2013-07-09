<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function zip($zip='')
	{
		$type = 'zip';
		if($this->input->post('zip')){
			$zip = $this->input->post('zip');
			$range = $this->input->post('range_used');
			if($range == ''){
				$range = 10.0;
			}
			$data['results'] = $this->tempest->get_data('geteventsbylocation/'.$zip.'/'.$type.'?range='.$range);
			$data['zip_used'] = $zip;
		}elseif($zip != ''){
			$range = 10.0;
			$data['results'] = $this->tempest->get_data('geteventsbylocation/'.$zip.'/'.$type.'?range='.$range);
			$data['zip_used'] = $zip;
		}else{
			$local_zip_stored = get_cookie('local_zip');
			if((int)$local_zip_stored > 0){
				$zip = $local_zip_stored;
				$range = 10.0;
				$data['results'] = $this->tempest->get_data('geteventsbylocation/'.$zip.'/'.$type.'?range='.$range);
				$data['zip_used'] = $zip;
				$data['results']->cookie = true;
			}else{
				$response = new StdClass();
				$response->code = 0;
				$response->search_type = 'zip';
				$data['results'] = $response;
			}
		}
		
		$this->load->view('template/header');
		$this->load->view('search/results',$data);
		$this->load->view('template/footer');
	}
	
	public function state($state=''){
		$type = 'state';
		if($this->input->post('state')){
			$state = $this->input->post('state');
			$data['results'] = $this->tempest->get_data('geteventsbylocation/'.$state.'/'.$type);
		}else if($state != ''){
			$data['results'] = $this->tempest->get_data('geteventsbylocation/'.$state.'/'.$type);		
		}else{
			$response = new StdClass();
			$response->code = 0;
			$response->search_type = 'state';
			$data['results'] = $response;
		}
		
		$this->load->view('template/header');
		$this->load->view('search/results',$data);
		$this->load->view('template/footer');
	}
	
	public function city($city='',$state=''){
		$type = 'city';
		if($this->input->post('city')){
			$city = $this->input->post('city');
			$state = $this->input->post('city');
			$state_uri = '';
			if($state != ''){
				$state_uri = '?state='.$state;
			}
			$data['results'] = $this->tempest->get_data('geteventsbylocation/'.$city.'/'.$type.$state_uri);
		}else if($city != ''){
			$state_uri = '';
			if($state != ''){
				$state_uri = '?state='.$state;
			}
			$data['results'] = $this->tempest->get_data('geteventsbylocation/'.$city.'/'.$type.$state_uri);		
		}else{
			$response = new StdClass();
			$response->code = 0;
			$response->search_type = 'city';
			$data['results'] = $response;
		}
		
		$this->load->view('template/header');
		$this->load->view('search/results',$data);
		$this->load->view('template/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */