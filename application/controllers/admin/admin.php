<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){

		parent::__construct();
		
		// $this->output->enable_profiler(TRUE);

		// set headers to prevent back after login
		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		$this->output->set_header('Pragma: no-cache');

		// the required files
		$this->load->helper('form');
		$this->load->library('form_validation');
	}


    public function login(){

    	// someone has already logged in
    	if($this->session->userdata('email')){
    		redirect('admin');
    	}


		//if admin is trying to login ...
		if($this->input->post('submit')){

			// email + password's validation rules
 			$this->form_validation->set_rules('email', 
 											  'Email', 
 											  'required|valid_email'
											    );
 			$this->form_validation->set_rules('password', 
 											  'Password', 
 											  'required|xss_clean'
											    );


 			// invalid input ...
 			if($this->form_validation->run() == FALSE){
				$this->load->view('admin/login',
									array('msg'=>$this->session->flashdata('msg'))
				);
				return;
 			}


 			// get user data
			$res = $this->users_model->get(array(
										'email' => $this->input->post('email'),
										'password' => md5($this->input->post('password'))
									)
			);


			// goto dashboard for sucessful login	
			if($res){

				$this->session->set_userdata('email',$res[0]->email);

				redirect('admin/dashboard');
				return;

			}



			// Incorrect username and/or password
			$this->session->set_flashdata('msg','Incorrect username and/or Password.');


			// reload to get login form again
			redirect($this->uri->uri_string());
		}


		// login form with flash msg if exists
		$this->load->view('admin/login',
							array('msg'=>$this->session->flashdata('msg'))
		);
    }


	public function reset(){
		
    	// someone has already logged in
    	if($this->session->userdata('email')){
    		redirect('admin');
    	}


		$msg = false;

		// Submitted for reseting password ...
		if($this->input->post('submit')){

			$email = $this->input->post('email');


			// validation rules
 			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');


 			// if validation passed ...

 			if($this->form_validation->run() == true){

	 			// if email does not exist ...
 				if(!$this->users_model->get(array('email'=>$email))){

					$this->load->view('admin/reset',
										array('msg'=>'Email does not exist.')
					);
					return;
 				}



				// generate new rand. password & reset it in db
				$this->load->helper('string');
				$this->load->library('email');

				$new_password = random_string();

				$this->users_model->update(array(	'email' 	=> $email,
												'password'	=> md5($new_password)
										)
				);



				// create email
				$this->email->from('asdfasdf81@gmail.com') 	//gmail reqd ......
							->to($email)
							->subject('Changing Password')
							->message(
								'Email : '.$email.PHP_EOL.
								'Password : '.$new_password
							)
							->set_newline("\r\n");


				// send email, & set email sent or not msg.
				if($this->email->send()){
					$msg = 'Email has been send.';
				}else{
					$msg = 'There was an error while sending email.';
				}
			}
		}
		

		// Display form to enter email to reset password. some msg. MAY be present ...
		$this->load->view('admin/reset',
							array('msg'=>$msg)
		);
	}


	public function register(){

    	// someone has already logged in
    	if($this->session->userdata('email')){
    		redirect('admin');
    	}


		$msg = false;

		// if new user's data has been submitted ...
		if($this->input->post('submit')){

			$email = $this->input->post('email');
			$password = $this->input->post('password');

			// validation rules
 			$this->form_validation->set_rules('email', 
 											  'Email', 
 											  'required|valid_email|is_unique[users.email]'
										  	);
			$this->form_validation->set_rules('password', 
											  'Password', 
											  'required|xss_clean'
										    );
			$this->form_validation->set_rules('repassword', 
											  'Password Confirmation', 
											  'matches[password]'
										    );


 			// if validation passed ...
 			if($this->form_validation->run() == true){

				$this->load->library('email');

				// insert new user
				$this->users_model->set(array(	'email' 	=> $email,
												'password'	=> md5($password)
										)
				);



				// send email to notify new user
				$this->email->from('asdfasdf81@gmail.com') 	//gmail reqd ......
							->to($email)
							->subject('New User Registered :')
							->message(
								'Email : '.$email.PHP_EOL.
								'Password : '.$password
							);

				$this->email->set_newline("\r\n");

				if($this->email->send()){

					$this->session->set_userdata('email',$email);
					
					redirect('admin');
				
				}


				
				// unable to send email to notify the new user !!!! something wrong happened ???
				else{
			
					$msg = 'There was an error while sending email.';
				}
			}
		}
		

		// Display new user form, with msg if exists.
		$this->load->view('admin/register',array('msg'=>$msg));
	}


	public function index(){


		// is user is already logged in, goto dashboard
		if($this->session->userdata('email')) {
			redirect('admin/dashboard');
		}


		// else goto login page
		else{
			$this->login();
		}
	}


	public function dashboard(){

		// is user is not logged in, goto login page.
		if(!$this->session->userdata('email')){
			redirect('admin/login');
			return;
		}
		

		// display dashboard.
		$this->load->view( 'admin/dashboard',
							array('email' => $this->session->userdata('email'))
						);
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin/admin.php */
