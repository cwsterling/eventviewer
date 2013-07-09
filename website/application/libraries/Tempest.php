<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Tempest {

    public function curl_get($uri)
    {
   		$url = 'https://vpn.chrissterling.me/'.$uri;

		$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	$ret_data = curl_exec($ch);
    	$info = curl_getinfo($ch);
    	curl_close($ch);
    	$response = new StdClass();
    	if($info['http_code'] == 500){
    		$response->code = 500;
    		$response->get_info = $info;
    		$response->ret_data = $response;
		}else{
			if(gettype($ret_data) == 'string'){
				$response->ret_data = json_decode($ret_data);
			}else{
				$response->ret_data = $ret_data;
			}
			$response->code = $info['http_code'];
			$response->get_info = $info;
		}
		return $response;
    }
    
    public function curl_post($url,$data)
    {
    	$url = 'https://vpn.chrissterling.me/'.$url;
		$post_data['data'] = $data;
		$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch,CURLOPT_POST,true);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$ret_data = curl_exec($ch);
    	$info = curl_getinfo($ch);
    	curl_close($ch);
    	$response = new StdClass();
    	if($info['http_code'] == 500){
    		$response->code = 500;
    		$response->get_info = $info;
    		$response->ret_data = $response;
		}else{
			if(gettype($ret_data) == 'string'){
				$response->ret_data = json_decode($ret_data);
			}else{
				$response->ret_data = $ret_data;
			}
			$response->code = $info['http_code'];
			$response->get_info = $info;
		}
		return $response;
    	
    }
    
    public function get_data($url){    	
    	$return_data = $this->curl_get($url);
    	return $return_data;
    }
    
    public function post_data($uri,$data){
    	$post_data = json_encode($data);
    	$return_data = $this->curl_post($uri,$post_data);
    	return $return_data;
    }
}

/* End of file Tempest.php */