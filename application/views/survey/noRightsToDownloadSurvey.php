<div class="jumbotron" style="height: 46em;padding: 198px 32px;">
        <h1>You dont have the rights to download this Survey!</h1>
        <p>Ask the owner of the survey to sent you the results.</p>
        <a class="btn btn-primary" href="<?php echo(site_url())?>" role="link">Take me Home!</a>
        <?php
                    $session = $this->session->userdata('id_user');
                    if(!empty($session)){
                        echo '<a href="'.(site_url("create")).'" style="margin-left: 50px;">Create new survey</a>';
                    };
        ?>
        <p></p>
</div>