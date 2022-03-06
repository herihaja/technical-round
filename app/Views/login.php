Bonjour et login
<form action="<?php echo base_url(); ?>/user/signin" method="post">
    <label for="name" class="">Email/Mobile:</label>
    <input type="text" name="name" /><br />

    <label for="">Password:</label>
    <input type="password" name="password"> <br />
    <input type="submit" value="Submit">
</form>