<?php $this->extend("layouts/site") ?>
<?php $this->section("content") ?>
<h1>Welcome to the sign up page</h1>

<form action="<?php echo base_url(); ?>/user/registration" method="post" onsubmit="return handleSubmit();">
    <label for="name" class="">Name</label>
    <input type="text" name="name" value="<?= set_value('name') ?>" id="name" /><span id="name-error" class="error"></span><br />

    <label for="name" class="">Email</label>
    <input type="text" name="email" value="<?= set_value('email') ?>" id="email" /><span id="email-error" class="error"></span><br />

    <label for="">Password:</label>
    <input type="password" name="password" value="<?= set_value('password') ?>" id="password"><span id="password-error" class="error"></span> <br />

    <label for="name" class="">Mobile</label>
    <input type="text" name="mobile" value="<?= set_value('mobile') ?>" id="mobile" /><span id="mobile-error" class="error"></span><br />

    <input type="submit" value="Submit">
</form>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script type="text/javascript">
    var valueById = id => {
        return document.getElementById(id).value;
    }
    var renderErrors = errorsList => {
        for (e in errorsList) {
            document.getElementById(e + '-error').innerHTML = errorsList[e];
        }
    }
    var resetErrors = () => {
        for (e in document.getElementsByClassName('error')) {
            document.getElementsByClassName('error')[e].innerHTML = "";
        }
    }
    var handleSubmit = () => {
        var data = {
            'name': valueById('name'),
            'mobile': valueById('mobile'),
            'password': valueById('password'),
            'email': valueById('email')
        };

        axios({
            method: 'post',
            url: '/user/registration',
            data: data
        }).then(function(response) {
            var data = response.data;
            resetErrors();
            if (data.success) {
                document.location.href = "/user/saved";
            } else {
                renderErrors(data.errors);
            }
        });
        return false;
    };
</script>

<?php $this->endSection() ?>