<?php $this->extend("layouts/site") ?>
<?php $this->section("content") ?>
<h1>Welcome</h1>
<p>You are about to reset your password.</p>
<form action="<?php echo base_url(); ?>/user/sendotp" method="post">
    <label for="name" class="">Email/Mobile:</label>
    <input type="text" name="name" id="name" value="<?php echo (isset($identifier) ? $identifier : "") ?>" />
    <span id="otp-error" class="error"><?php echo (isset($identifier) ? $errors["name"] : "") ?></span><br />

    <input type="submit" value="Submit">
</form>


<?php $this->endSection() ?>