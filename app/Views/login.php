<?php $this->extend("layouts/site") ?>
<?php $this->section("content") ?>
<h1>Welcome</h1>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<form action="<?php echo base_url(); ?>/user/signin" method="post" onsubmit="return handleSubmit();">
    <label for="name" class="">Email/Mobile:</label>
    <input type="text" name="name" id="name" /><span id="name-error" class="error"></span><br />

    <label for="">Password:</label>
    <input type="password" name="password" id="password" /> <span id="password-error" class="error"></span><br />
    <input type="submit" value="Submit">
</form>

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
            'password': valueById('password')
        };

        axios({
            method: 'post',
            url: '/user/signin',
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