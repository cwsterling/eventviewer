<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

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

	public function home()
	{
		if(!$this->session->userdata('logged_in')){
			redirect('/account/login','refresh');
		}
		$this->load->view('template/header');
		$this->load->view('account/home');
		$this->load->view('template/footer');
	}

	public function login()
	{
		$data = array();
		$response = new StdClass();
		if($this->input->post('username')){
			$account['username'] = $this->input->post('username');
			$account['password'] = $this->input->post('password');
			if($account['username'] != '' || $account['password'] != ''){
				$response = $this->tempest->post_data('login',$account);
				if($response->code == 200){
					if($response->ret_data->success == true){
						$newdata = array(
							'username'  => $response->ret_data->userdata->username,
							'email'     => $response->ret_data->userdata->email,
							'id'		=> $response->ret_data->userdata->id,
							'logged_in' => TRUE
						);
						$this->session->set_userdata($newdata);
						redirect('/account/home', 'refresh');
					}
				}
			}else{
				$response->ret_data->error = true;
				$response->ret_data->message = 'Error Logging In, please try again.';
			}
			$data['login'] = $response;
		}
		$this->load->view('template/header');
		$this->load->view('account/login',$data);
		$this->load->view('template/footer');
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		$this->session->set_flashdata('logged_out','<div class="alert alert-info"><p>You have been logged out successfully. You can log back in below.</p></div>');
		redirect('/account/login', 'refresh');
	}
	
	public function register()
	{
		if($this->input->post('username')){
			if($this->input->post('password') == $this->input->post('password2')){
				$account['username'] = $this->input->post('username');
				$account['password'] = $this->input->post('password');
				$account['email'] = $this->input->post('email');
				$account['local_zip'] = $this->input->post('zip_code');
				$account['local_city'] = $this->input->post('city');
				$account['name'] = $this->input->post('name');
				$account['phone'] = $this->input->post('phone');
				$fail = false;
				if($account['username'] == '' || $account['password'] == ''){
					$fail = true;
				}
			}else{
				$fail = true;
			}
			if(!$fail){
				$response = $this->tempest->post_data('createaccount',$account);
				if(($response->code != 500) && $response->code != 0){
					if($response->ret_data->success == true){
						$newdata = array(
							'username'  => $add_response->ret_data->userdata->username,
							'email'     => $add_response->ret_data->userdata->email,
							'id'		=> $add_response->ret_data->userdata->id,
							'logged_in' => TRUE
						);
						$this->session->set_userdata($newdata);
						$this->session->set_flashdata('new_account','<div class="alert alert-success"><p>Your Account has been created. Use the menu above to get started.</p></div>');
						redirect('/account/home', 'refresh');
					}
				}
			}else{
				$response = new StdClass();
				$response->ret_data->success = false;
				$response->ret_data->error->email = true;
				$response->ret_data->message->email = 'Passwords did not match.';
				$response->user_data = $this->input->post();
			}
		$data['add_response'] = $response;
		}else{
			$data = array();
		}

		$this->load->view('template/header');
		$this->load->view('account/register',$data);
		$this->load->view('template/footer');
	}
	
	public function addevent()
	{
		if($this->input->post('event_name')){
			$now = new DateTime('now');
			$event_time = new DateTime($this->input->post('event_date'));
			$event['title'] = $this->input->post('event_name');
			$event['url'] = $this->input->post('slug');
			$event['event_date'] = $event_time->format('m/d/Y');
			$event['event_time'] = $event_time->format('H:i A');
			$event['promote_event'] = $this->input->post('promote_event');
			$event['description'] = $this->input->post('event_description');
			$event['cost'] = str_replace('$','',$this->input->post('event_cost'));
			$event['tags'] = $this->input->post('tags');
			$event['zip'] = $this->input->post('zip_code');
			$event['location'] = $this->input->post('city');
			$event['directions'] = $this->input->post('general_directions');
			$event['contact_name'] = $this->input->post('contact_name');
			$event['email'] = $this->input->post('contact_email');
			$event['show_email'] = $this->input->post('show_email');
			$event['phone'] = $this->input->post('contact_phone');
			$event['show_phone'] = $this->input->post('show_phone');
			$event['website'] = $this->input->post('website');
			$event['analytics']  = $this->input->post('tracking_id');
			$event['sponsor'] = $this->input->post('sponsor');
			$social_media_links = $this->input->post('social_media_links');
			$social_media = $this->input->post('social_media');
			echo '<pre>';
			var_dump($social_media_links);
			var_dump($social_media);
			echo '</pre>';
			$event['social'] = $this->input->post('social');
			$event['created'] = $now->format(DATE_ISO8601);
			$event['created_by'] = $this->session->userdata('id');
//			$response = $this->tempest->post_data('addevent',$event);
			
		}else{
			$response = new StdClass();
			$response->code = 0;
		}
		$data['submit'] = false;
		$data['response'] = $response;
		$data['post'] = $this->input->post();
		$this->load->view('template/header');
		$this->load->view('account/addevent',$data);
		$this->load->view('template/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */