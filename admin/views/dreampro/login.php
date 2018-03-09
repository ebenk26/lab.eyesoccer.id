<!DOCTYPE html>
<?php $set = $this->catalog->get_setting(array('row' => true)); ?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login Administrator | <?php echo $set->web_name; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="shortcut icon" href="<?php echo $this->config->item('base_static')."/images/$set->web_favicon"; ?>">
    <link href='<?php echo $this->config->item('base_cdn').'/css/'.$this->config->item('base_theme').'/login.css'; ?>' rel='stylesheet' type='text/css'>
    <link href='<?php echo base_url('assets/css/font-awesome/css/font-awesome.css'); ?>' rel='stylesheet' type='text/css'>
    <script src='<?php echo $this->config->item('base_cdn').'/js/jquery-2.0.2.min.js'; ?>'></script>
</head>
<body>
    <div id='contain'>
	<?php echo form_open('login/check'); ?>
	<div id='title_login'><i class='fa fa-lock'></i> Login to your Account</div>
	<div id='box_login'>
	    <?php
		$flashmessage = $this->session->flashdata('message');
		echo ! empty($flashmessage) ? '<div class="message">' . $flashmessage . '</div>': '';
	    ?>
	    
	    <div class='box_space'>
		<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
		<input class="form-control" type="text" name='email' placeholder="Email address">
	    </div>
	    <div class='box_space'>
		<span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
		<input class="form-control" type="password" name='password' placeholder="Password">
	    </div>
	    <div class='box_space'>
		<input type='checkbox' name='remember'><span>Remember Me</span>
	    </div>
	    <div class='box_space'>
		<a href='<?php echo base_url('login/forgot_password'); ?>'>Forgot Password?</a>
	    </div>
	    <div class='box_space'>
		<input class="form-login" type='submit' value='login'>
	    </div>
	</div>
    </div>
</body>
</html>