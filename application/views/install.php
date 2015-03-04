<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<title>Install Database</title>	

</head>
<body>
	
    <?=validation_errors()?>

    <?=form_open()?>

	    <h2>
			Database
	    </h2>

	    <p>
			<label for="hostname">Hostname</label>
			<input type="text" name="hostname" id="hostname" placeholder="Database Host Url" value="<?=set_value('hostname')?>">
	    </p>

	    <p>
			<label for="username">Username</label>
			<input type="text" name="username" id="username" placeholder="Database Login Username">
	    </p>

	    <p>
			<label for="password">Password</label>
			<input type="password" name="password" id="password" placeholder="Database Login Password">
	    </p>

	    <p>
			<label for="database">Database</label>
			<input type="text" name="database" id="database" placeholder="Database Name">
	    </p>

	    <p>
			<input type="submit" name="submit" value="Submit" >
	    </p>

	</form>

</body>
</html>
