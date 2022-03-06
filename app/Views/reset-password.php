<?php $this->extend("layouts/site") ?>
<?php $this->section("content") ?>
<h1>Welcome</h1>
<p>Please, reset your password here.</p>



<form action="<?php echo base_url(); ?>/user/resetpwd" method="post" onsubmit="return handleSubmit();">
    <label for="name" class="">OTP (One time password):</label><input id="name" type="hidden" name="name" value="<?php echo $identifier ?>" />
    <input type="password" name="otp" id="otp" /><span id="otp-error" class="error"></span><br />

    <label for="">New Password:</label>
    <input type="password" name="password" id="password" /> <span id="password-error" class="error"></span><br />

    <label for="">Re-enter New Password:</label>
    <input type="password" name="password1" id="password1" /> <span id="password1-error" class="error"></span><br />

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
            'otp': valueById('otp'),
            'password': valueById('password'),
            'password1': valueById('password1')
        };

        axios({
            method: 'post',
            url: '/user/resetpwd',
            data: data
        }).then(function(response) {
            var data = response.data;
            resetErrors();
            if (data.success) {
                document.location.href = "/dashboard";
            } else {
                renderErrors(data.errors);
            }
        });
        return false;
    };
</script>

<?php $this->endSection() ?>