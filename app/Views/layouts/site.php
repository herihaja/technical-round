<!DOCTYPE html>
<html>

<head>
	<title>Technical round</title>
	<?php $this->renderSection('head') ?>
</head>

<body>
	<a href="<?php echo base_url(); ?>/user/signup">Sign up</a> |
	<a href="<?php echo base_url(); ?>/user/login">Sign in</a> |
	<a href="<?php echo base_url(); ?>/user/forgotpwd">Forgot password</a>
	<?php $this->renderSection('content') ?>
</body>

</html>