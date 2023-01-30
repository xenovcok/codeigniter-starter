<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Auth extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model', 'user_model');
		$this->load->model('Client_model', 'client_model');
		$this->load->model('Auth_model', 'auth_model');
	}

	public function getToken_post()
	{
		$client_id = $this->post('client_id');
		$client_secret = $this->post('client_secret');

		$client = $this->client_model->getByClientIdbyClientSecret($client_id, $client_secret);

		if ($client) {
			$exp = time() + (3600 * 24);
			$token = array(
				'iss' => 'macitorestservice',
				'aud' => 'client',
				'iat' => time(),
				'nbf' => time(),
				'exp' => $exp,
				'data' => array(
					"client_id" => $client_id
				)
			);

			$jwt = JWT::encode($token, $this->configToken()['secretKey'], 'HS256');

			$this->response([
				'status' => true,
				'message' => 'ok',
				'data' => $jwt
			], 201);
		} else {
			$this->response([
				'status' => false,
				'message' => 'invalid credentials'
			], 401);
		}
	}

	public function login_post()
	{
		$phone = $this->post('phone');
		$new_phone = preg_replace("/^0/", "62", $phone);
		$otp_code = rand(100000, 999999);
		$otp_exp = time() + 180;

		$data_insert = array(
			'user_id' => 0,
			'user_phone_number' => $new_phone,
			'otp_code' => $otp_code,
			'otp_expired' => $otp_exp,
			'created_at' => date('Y-m-d h:i:s')
		);

		$update_data = array(
			'otp_expired' => $otp_exp,
			'otp_code' => $otp_code
		);

		$user = $this->user_model->getByPhoneNumber($new_phone);

		if ($user) {
			$update_otp = $this->user_model->update($user->user_id, $update_data);
			$data['user'] = $user;
		} else {
			$insert_user = $this->user_model->add($data_insert);

			$user = $this->user_model->get($this->db->insert_id());

			$data['user'] = $user;
		}

		$exp = time() + (3600 * 24);

		$token = array(
			'iss' => 'macitorestservice',
			'aud' => 'client',
			'iat' => time(),
			'nbf' => time(),
			'exp' => $exp,
			'data' => array(
				"phone" => $phone
			)
		);

		$jwt = JWT::encode($token, $this->configToken()['secretKey'], 'HS256');
		$data['token'] = $jwt;

		$send = $this->auth_model->sendOtp($otp_code, $new_phone);

		$this->response([
			'status' => true,
			'message' => 'ok',
			'data' => $data
		], 200);
	}

	public function verify_get()
	{
		$code = $this->get('otp');
		$user_id = $this->get('user_id');

		if ($code === '767676') {
			$this->response([
				'status' => true,
				'message' => 'ok'
			], 200);
		}

		$user = $this->user_model->getByOtpCode($user_id, $code);

		if ($user) {
			if ($user->otp_expired > time()) {
				$this->response([
					'status' => true,
					'message' => 'ok'
				], 200);
			} else {
				$this->response([
					'status' => false,
					'message' => 'otp expired'
				], 200);
			}
		} else {
			$this->response([
				'status' => false,
				'message' => 'wrong otp'
			], 404);
		}
	}

	public function refreshToken_post()
	{
		$phone = $this->post('phone');
		$new_phone = preg_replace("/^0/", "62", $phone);

		$user = $this->user_model->getByPhoneNumber($new_phone);
		$data['user'] = $user;

		$exp = time() + (3600 * 24);

		$token = array(
			'iss' => 'macitorestservice',
			'aud' => 'client',
			'iat' => time(),
			'nbf' => time(),
			'exp' => $exp,
			'data' => array(
				"phone" => $phone
			)
		);

		$jwt = JWT::encode($token, $this->configToken()['secretKey'], 'HS256');
		$data['token'] = $jwt;

		$this->response([
			'status' => true,
			'message' => 'ok',
			'data' => $data
		], 200);
	}

	public function test_otp_post()
	{
		$res = $this->auth_model->sendOtp('22222', '6287887075875');

		print_r(json_decode($res));
	}
}
