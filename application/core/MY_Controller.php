<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
require APPPATH . '/libraries/JWK.php';

use \chriskacerguis\RestServer\RestController;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use \Firebase\JWT\ExpiredException;

class MY_Controller extends RestController
{

	public function __construct()
	{
		parent::__construct();
		// $this->load->model('Logging_model', 'logging_model');
		// $this->load->model('Api_model', 'api_model');
		// $this->load->library('user_agent');
		// $this->load->library('Authorization_Token');

		// $this->logger();
	}

	function configToken()
	{
		$conf['exp'] = 3600 * 24;
		$conf['secretKey'] = getenv('JWT_SECRET_KEY');

		return $conf;
	}

	function auth()
	{
		$headers =  $this->input->request_headers();

		if (!isset($headers['Authorization'])) {
			return false;
		}

		$authHeader = $headers['Authorization'];
		$arr = explode(" ", $authHeader);
		$token = $arr[1];

		if ($token) {
			try {
				$decodedToken = JWT::decode($token, new Key($this->configToken()['secretKey'], 'HS256'));
				if ($decodedToken) {
					return true;
				}
			} catch (\Exception $e) {
				return false;
			}
		}
	}

	// function logger()
	// {
	// 	$session_id = $this->session->userdata('session_id');
	// 	$log_data = $this->logging_model->getBySessionId($session_id);

	// 	$logging_data = array();

	// 	if ($log_data !== NULL && $session_id !== NULL) {
	// 		$logging_data = array(
	// 			'username' => $log_data->username,
	// 			'session_id' => $session_id,
	// 			'signin' => date('Y-m-d h:i:s'),
	// 			'browser' => $this->agent->browser() . ' ' . $this->agent->version(),
	// 			'login_status' => $log_data->login_status,
	// 			'ip' => $this->api_model->get_client_ip(),
	// 			'type' => $log_data->type,
	// 			'activity' => $_SERVER['REQUEST_URI'],
	// 			'created_at' => date('Y-m-d h:i:s')
	// 		);
	// 	} else {
	// 		$logging_data = array(
	// 			'browser' => $this->agent->browser() . ' ' . $this->agent->version(),
	// 			'ip' => $this->api_model->get_client_ip(),
	// 			'activity' => $_SERVER['REQUEST_URI'],
	// 			'created_at' => date('Y-m-d h:i:s')
	// 		);
	// 	}

	// 	$this->logging_model->add($logging_data);
	// }
}
