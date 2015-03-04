<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <title>Administrator Login</title>

</head>
<body>
	
    <?=$msg?>
    <?=validation_errors()?>

    <?=form_open()?>

        <h2>Enter your email</h2>
        
        <p>
            <label for="email">Email</label>
            <input type="text" name="email" id="email">
        </p>

        <p>
            <input type="submit" name="submit" value="Submit" >
            <a href="<?=site_url('admin')?>">Login Page</a>
        </p>

    </form>

</body>
</html>
