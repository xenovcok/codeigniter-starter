<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
	private $_table = 'users';

	public function get($id = null)
	{
		if ($id !== null) {
			$this->db->where('user_id', $id);
		}

		$this->db->where('is_deleted', '0');
		$this->db->order_by('created_at', 'DESC');
		$query = $this->db->get($this->_table);

		if ($query) {
			if ($id !== null) {
				return $query->row();
			} else {
				return $query->result();
			}
		}

		return FALSE;
	}

	public function add($data)
	{
		$query = $this->db->insert($this->_table, $data);

		if ($query) {
			return $query;
		}

		return FALSE;
	}

	public function update($id, $data)
	{

		$this->db->where('user_phone_number', $id);
		$this->db->or_where('user_id', $id);
		$query = $this->db->update($this->_table, $data);

		if ($query) {
			return $query;
		}

		return FALSE;
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->delete($this->_table);

		if ($query) {
			return $query->result();
		}

		return FALSE;
	}

	public function getByPhoneNumber($phone)
	{
		$this->db->where('user_phone_number', $phone);
		$this->db->where('is_deleted', '0');

		$query = $this->db->get($this->_table);

		if ($query) {
			return $query->row();
		}

		return FALSE;
	}

	public function getByOtpCode($user_id, $code)
	{
		$this->db->where('otp_code', $code);
		$this->db->where('user_id', $user_id);
		$this->db->where('is_deleted', '0');
		// $this->db->where('otp_expired <=', time());

		$query = $this->db->get($this->_table);

		if ($query) {
			return $query->row();
		}

		return FALSE;
	}
}
