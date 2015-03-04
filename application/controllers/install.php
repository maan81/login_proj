<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends CI_Controller {

	public function __construct(){

		parent::__construct();


		if(isset($this->db)){
			echo 'This program is already installed.<br>';
			echo 'Highly rercommended to go to <a href="'.site_url('admin/login').'">Admin Login</a>';
			return;
		}

	}


	public function index(){

		$this->load->helper('form');
		$this->load->library('form_validation');

		if($this->input->post('submit')){

			// validation rules
 			$this->form_validation->set_rules('database', 
 											  'Database', 
 											  'required|xss_clean'
										  	);
 			$this->form_validation->set_rules('username', 
 											  'Username', 
 											  'required|xss_clean'
										  	);
			$this->form_validation->set_rules('password', 
											  'Password', 
											  'required|xss_clean'
										    );
			$this->form_validation->set_rules('hostname', 
											  'Hostname', 
											  'required|xss_clean'
										    );


 			if($this->form_validation->run() == false){
				$this->load->view('install');
				return;
 			}


	        // update database settings
 			$this->config_settings();


            // relod to handle database
			redirect('install/database');
		}

		$this->load->view('install');
	}


	private function config_settings(){

        // applications/config/autoload.php
		$searchF  = array(
		                    '$autoload[\'libraries\'] = array(\'session\');'
		                );
		$replaceW = array(
							'$autoload[\'libraries\'] = array(\'database\',\'session\');'
		                );

		$fh = fopen(APPPATH.'config/autoload.php', 'r+');
		$file = file_get_contents(APPPATH.'config/autoload.php');
		$file = str_replace($searchF, $replaceW, $file);


        if(!fwrite($fh, $file)){

        	echo 'Unable to update '.APPPATH.'config/autoload.php';
        	echo 'Update it manually and follow <a href="'.$site_url('install/database').'">here</a>';

        	die;
        };


		// applications/config/database.php
        $searchF  = array(
                            '$db[\'default\'][\'hostname\'] = \'\';',
                            '$db[\'default\'][\'username\'] = \'\';',
                            '$db[\'default\'][\'password\'] = \'\';',
                            '$db[\'default\'][\'database\'] = \'\';',
                        );
        $replaceW = array(
                            '$db[\'default\'][\'hostname\'] = \''.$this->input->post('hostname').'\';',
                            '$db[\'default\'][\'username\'] = \''.$this->input->post('username').'\';',
                            '$db[\'default\'][\'password\'] = \''.$this->input->post('password').'\';',
                            '$db[\'default\'][\'database\'] = \''.$this->input->post('database').'\';',
                        );
        
        $fh = fopen(APPPATH.'config/database.php', 'r+');
        $file = file_get_contents(APPPATH.'config/database.php');
        $file = str_replace($searchF, $replaceW, $file);


        if(!fwrite($fh, $file)){

        	echo 'Unable to update '.APPPATH.'config/database.php';
        	echo 'Update it manually and follow <a href="'.$site_url('install/database').'">here</a>';

        	die;
        };

        // @chmod(APPPATH.'config/database.php', 0644);
	}


	public function database(){

		// load db forge
		$this->load->dbforge();


		$this->dbforge->add_field(array(
									'email' => array(
													'type' => 'VARCHAR',
													'constraint' => '50',
									          	),
									'password'=>array(
													'type' => 'VARCHAR',
													'constraint' => '32',
												),
								)
							);

		$this->dbforge->add_key('email',true);

		$this->dbforge->create_table('users');

		$this->load->view('install_success');
	}
}

/* End of file install.php */
/* Location: ./application/controllers/install.php */
