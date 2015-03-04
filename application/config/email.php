<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| EMAIL configurations
|--------------------------------------------------------------------------
|
*/



$config = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'ssl://smtp.googlemail.com',
    'smtp_port' => 465,
    'smtp_user' => 'asdfasdf81',//tmp username -- for testing
    'smtp_pass' => 'lkjlkj',//tmp password -- for testing
    'mailtype'  => 'html', 
    'charset'   => 'utf-8',
    'validate'	=> true
);


/* End of file email.php */
/* Location: ./application/config/email.php */
