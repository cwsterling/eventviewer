<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller {

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
	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('home/home');
		$this->load->view('template/footer');
	}

	//custom.js functions
	public function tags(){
		$tags = $this->tempest->get_data('gettags');
		$tag_info = $tags->ret_data;
		unset($tag_info->start_info);
		$this->output
    		->set_content_type('application/json')
    		->set_output(json_encode($tag_info));
	}

	public function checkurl($urlslug){
		$suggest = $this->tempest->get_data('checkslug/'.$urlslug);
		$suggest_data = $suggest->ret_data->available;
		$this->output
    		->set_content_type('application/json')
    		->set_output(json_encode($suggest_data));
	}

	
	public function zipcode($zipcode){
		$suggest = $this->tempest->get_data('suggestcity/'.$zipcode);
		$suggest_data = $suggest->ret_data->city;
		$this->output
    		->set_content_type('application/json')
    		->set_output(json_encode($suggest_data));
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */