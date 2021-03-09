<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora">
<link rel="stylesheet" href="<?php echo base_url('assets/css/Highlight-Blue.css');?>">

<div class="highlight-blue">
        <div class="container" style="height: 165px;">
            <div class="intro">
                <h2 class="text-center">Manage your Profile<br></h2>
                <p class="text-center"><br>If you change your username or password you will be logged out<br><br></p>
            </div>
        </div>
        <form action="<?php echo(site_url('userarea/profile'))?>" method="post" id="createSurvey" style="margin: 0 24px;">
            <label>Email:</label>
            <input class="form-control" name="email" type="email" style="min-width: 243px;max-width: 70%;margin: 5px;" value="<?php echo $this->session->flashdata('email');?>">
            <br>
            <label>Username:</label>
            <input class="form-control" name="username" type="text" style="min-width: 243px;max-width: 70%;margin: 5px;" value="<?php echo $this->session->userdata('username');?>">
            <br>
            <label>Password:</label>
            <input class="form-control" name="oldPassword" type="password" style="min-width: 243px;max-width: 70%;margin: 5px;" placeholder="old password">
            <br>
            <input class="form-control" name="newPassword" type="password" style="min-width: 243px;max-width: 70%;margin: 5px;" placeholder="new password">
            <input class="form-control" name="newPasswordRetype" type="password" style="min-width: 243px;max-width: 70%;margin: 5px;" placeholder="retype new password">
            <button class="btn btn-primary" type="submit" style="background: var(--purple);font-size: 19px; margin-top: 20px;">Update</button>
        </form>
        <?php
            echo '<div class="text-danger text-center">';
            echo $this->session->flashdata('userProfileMessage');
            echo '</div>';
        ?>
    </div>
