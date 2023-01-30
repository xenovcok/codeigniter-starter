<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model', 'user_model');
	}

	public function index_get()
	{
		$this->auth();

		$data = $this->user_model->get();

		if ($this->auth()) {
			$this->response([
				'status' => true,
				'message' => 'ok',
				'data' => $data
			], 200);
		} else {
			$this->response([
				'status' => false,
				'message' => 'unauthorized'
			], 401);
		}
	}

	public function verify_post()
	{
		$phone = $this->post('phone');
		$new_phone = preg_replace("/^0/", "62", $phone);

		$data = array(
			'verification_status' => true
		);

		if (!empty($this->session->userdata('uid'))) {
			$user = $this->user_model->getByPhoneNumber($new_phone);
			if ($user !== null) {
				$update = $this->user_model->update($new_phone, $data);
				if ($update) {
					$this->response([
						'status' => true,
						'message' => 'ok',
						'data' => $update
					], 200);
				} else {
					$this->response([
						'status' => false,
						'message' => 'bad request'
					], 400);
				}
			} else {
				$this->response([
					'status' => false,
					'message' => 'no user found'
				], 404);
			}
		} else {
			$this->response([
				'status' => false,
				'message' => 'unauthorized'
			], 401);
		}
	}

	public function index_post()
	{
		$phone = $this->post('phone');
		$name = $this->post('name');
		$email = $this->post('email');
		$address = $this->post('address');
		$nik = $this->post('nik');

		$new_phone = preg_replace("/^0/", "62", $phone);

		$data = array(
			'user_phone_number' => $new_phone,
			'user_name' => $name,
			'user_email' => $email,
			'user_address' => $address,
			'nik' => $nik,
			'created_at' => date('Y-m-d h:i:s')
		);

		$exist_user = $this->user_model->getByPhoneNumber($new_phone);

		if ($this->auth()) {
			if ($exist_user !== null) {
				$update_user = $this->user_model->update($exist_user->user_id, $data);

				$updated_user = $this->user_model->getByPhoneNumber($new_phone);

				$response_data['user'] = $updated_user;

				if ($update_user) {
					$this->response([
						'status' => true,
						'message' => 'ok',
						'data' => $response_data
					], 200);
				} else {
					$this->response([
						'status' => false,
						'message' => 'bad request'
					], 400);
				}
			} else {
				$insert_user = $this->user_model->add($data);

				$inserted_user = $this->user_model->getByPhoneNumber($new_phone);

				$response_data['user'] = $inserted_user;

				if ($insert_user) {
					$this->response([
						'status' => true,
						'message' => 'ok',
						'data' => $response_data
					], 200);
				} else {
					$this->response([
						'status' => false,
						'message' => 'bad request'
					], 400);
				}
			}
		} else {
			$this->response([
				'status' => false,
				'message' => 'unauthorized'
			], 401);
		}
	}

	public function delete_post()
	{
		$id = $this->post('id');

		$data = array(
			'is_deleted' => '1'
		);

		if (!empty($this->session->userdata('uid'))) {
			$update = $this->user_model->update($id, $data);
			if ($update) {
				$this->response([
					'status' => true,
					'message' => 'ok',
					'data' => $update
				], 200);
			} else {
				$this->response([
					'status' => false,
					'message' => 'bad request'
				], 400);
			}
		} else {
			$this->response([
				'status' => false,
				'message' => 'unauthorized'
			], 401);
		}
	}
}
