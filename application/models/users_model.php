<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model{

	protected $table = 'users';

	public function __construct(){
		parent::__construct();

	}


	/**
	 * get users [of selected parameter]
	 * @param array of selected parameter
	 * @return array of objects, or false 
	 */
	public function get($users=false){
		if($users){
			foreach($users as $key=>$value){
				$this->db->where($key,$value);
			}
		}
		$res = $this->db->get($this->table);
		return count($res->result())?$res->result():false;
	}


	/**
	 * set/update record's info
	 * @param record array/object
	 * @return the inserted/updated object
	 */
	public function set($data=false){
		if(!$data)
			return false;

		$data = (object)$data;

		//insert new data
		$this->db->insert($this->table,$data);

		return $data;
	}


	/**
	 * update record's info
	 * @param record array/object
	 */
	public function update($data){
		$data = (object)$data;
		$email = $data->email;
		unset($data->email);
	
		$this->db->where('email', $email);
		$this->db->update($this->table, $data); 

		return $data;
	}



	//------------------------------------------------------------------------------------------
	// currently not needed functions

		// /**
		//  * count records
		//  * @param records array/object
		//  * @return integer
		//  */
		// public function record_count($data=false){
		// 	if($data){
		// 		foreach($data as $key=>$val){
		// 			$this->db->where($key,$val);
		// 		}
		// 	}
		// 	return $this->db->count_all_records($this->table);
		// }


		// /**
		//  * change password
		//  * @param array[string[id],string[new password]]
		//  * @return void
		//  */
		// public function change_password($data=false){
		// 	if($data==false){
		// 		return false;
		// 	}
		// 	$data = array(	'id'		=> $data['id'],
		// 					'password'	=> md5($data['password'].$data['username']) 
		// 				);

		// 	$this->set($data);
		// }


		// /**
		//  * delete objects
		//  * @param array of objects ids to be deleted
		//  * @return boolean
		//  */
		// public function del($data=false){

		// 	if(!$data){
		// 		return false;
		// 	}
		// 	$items = $this->get($data);

		// 	foreach($items as $key=>$val){

		// 		$this->db->where('id',$val->id)
		// 				 ->delete($this->table);
		// 	}
		// 	return true;
		// }


		// /**
		//  *	check username, password
		//  *  @param string,string username,password 
		//  *  @return boolean
	 	//  */
		// public function check_login($username,$password){
		// 	$data = array('username'=>$username,'password'=>md5($password.$username));

		// 	if( $data = $this->get($data) ){
		// 		$this->session->set_userdata('userid',$data[0]->id);
		// 		$this->session->set_userdata('username',$data[0]->username);
		// 		$this->session->set_userdata('usertype',$data[0]->usertype);
		// 		return true;
		// 	}

		// 	return false;
		// }
	//------------------------------------------------------------------------------------------
}

/* End of file users_model.php */
/* Location: ./application/models/users_model.php */
