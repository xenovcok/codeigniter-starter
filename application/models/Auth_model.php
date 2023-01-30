<?php
class Auth_model extends CI_Model
{
	private $_table = "auth";
	const SESSION_KEY = 'uid';

	public function rules()
	{
		return [
			[
				'field' => 'username',
				'label' => 'username',
				'rules' => 'trim|required'
			],
			[
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'trim|required|max_length[200]'
			]
		];
	}

	public function login($username, $password)
	{
		$this->db->where('username', $username);
		$query = $this->db->get($this->_table);
		$user = $query->row();

		// cek apakah user sudah terdaftar?
		if (!$user) {
			return FALSE;
		}

		// cek apakah passwordnya benar?
		if (!password_verify($password, $user->password)) {
			return FALSE;
		}

		// bikin session
		$user_data = array(
			'name' => $user->username
		);

		$this->session->set_userdata([self::SESSION_KEY => $user->id]);
		$this->session->set_userdata($user_data);
		// $this->_update_last_login($user->id);

		return $this->session->has_userdata(self::SESSION_KEY);
	}

	public function current_user()
	{
		if (!$this->session->has_userdata(self::SESSION_KEY)) {
			return null;
		}

		$user_id = $this->session->userdata(self::SESSION_KEY);
		$query = $this->db->get_where($this->_table, ['id' => $user_id]);
		return $query->row();
	}

	public function logout()
	{
		$this->session->unset_userdata(self::SESSION_KEY);
		$this->session->unset_userdata('name');
		return !$this->session->has_userdata(self::SESSION_KEY);
	}

	// private function _update_last_login($id)
	// {
	// 	$data = [
	// 		'last_login' => date("Y-m-d H:i:s"),
	// 	];

	// 	return $this->db->update($this->_table, $data, ['id' => $id]);
	// }

	public function sendOtp($otp, $number)
	{
		$curl = curl_init();

		$data = [
			"messaging_product" => "whatsapp",
			"to" => $number,
			"type" => "template",
			"template" => [
				"name" => "macito_mobile",
				"language" => [
					"code" => "id"
				],
				"components" => [
					[
						"type" => "body",
						"parameters" => [
							[
								"type" => "text",
								"text" => $otp
							]
						]
					]
				]
			]
		];

		$token = self::getToken()->access_token;

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://graph.facebook.com/' . getenv('WA_API_VERSION') . '/' . getenv('WA_PHONE_NUMBER_ID') . '/messages',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($data),
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer ' . $token,
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return json_encode($response);
	}

	private function getToken()
	{
		$curls = curl_init();

		$fb_url = 'https://graph.facebook.com/oauth/access_token?client_id=' . getenv('WA_CLIENT_ID') . '&client_secret=' . getenv('WA_CLIENT_SECRET') . '&grant_type=fb_exchange_token&fb_exchange_token=' . getenv('WA_ACCESS_TOKEN');

		curl_setopt_array($curls, array(
			CURLOPT_URL => $fb_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(),
		));

		$response = curl_exec($curls);

		curl_close($curls);
		//echo $response;

		return json_decode($response);
	}
}
