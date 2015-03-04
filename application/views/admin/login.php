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

        <p>
          <label for="email">Email:</label>
          <input type="text" name="email" id="email" value="<?=set_value('email')?>">
        </p>

        <p>
          <label for="password">Password:</label>
          <input type="password" name="password" id="password">
        </p>

        <p class="login-submit">
          <input type="submit" class="login-button" name="submit" value="Login">
        </p>

        <p class="forgot-password">
          <a href="<?=site_url('admin/reset')?>">Forgot your password?</a>
        </p>

        <p>
          <a href="<?=site_url('admin/register')?>">New User ?</a>
        </p>

    </form>


</body>
</html>
