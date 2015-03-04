<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<title>Administrator New User</title>	

</head>
<body>
	
    <?=$msg?>
    <?=validation_errors()?>

    <?=form_open()?>

	    <h2>
			Register
	    </h2>

	    <p>
			<label for="email">Email</label>
			<input type="text" name="email" id="email" placeholder="Your Email" value="<?=set_value('email')?>">
	    </p>

	    <p>
			<label for="password">Password</label>
			<input type="password" name="password" id="password" placeholder="Password Here">
	    </p>

	    <p>
			<label for="repassword">Reenter Password</label>
			<input type="password" name="repassword" id="repassword" placeholder="Password Again">
	    </p>

	    <p>
			<input class="login-button" type="submit" name="submit" value="Submit" >
			<a href="<?=site_url('admin')?>">Login Page</a>
	    </p>

	</form>

</body>
</html>
