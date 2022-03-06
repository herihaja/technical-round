User registration

<?php if (isset($validation)) : ?>
    <div class="alert alert-warning">
        <?= $validation->listErrors() ?>
    </div>
<?php endif; ?>

<form action="<?php echo base_url(); ?>/user/registration" method="post">
    <label for="name" class="">Name</label>
    <input type="text" name="name" value="<?= set_value('name') ?>" /><br />

    <label for="name" class="">Email</label>
    <input type="text" name="email" value="<?= set_value('email') ?>" /><br />

    <label for="">Password:</label>
    <input type="password" name="password" value="<?= set_value('password') ?>"> <br />

    <label for="name" class="">Mobile</label>
    <input type="text" name="mobile" value="<?= set_value('mobile') ?>" /><br />

    <input type="submit" value="Submit">
</form>