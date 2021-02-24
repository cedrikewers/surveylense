<div class="jumbotron" style="height: 46em;padding: 198px 32px;">
        <h1>Your survey was created successfully!</h1>
        <p>To view your survey by clicking the button below or copy this link to share it.&nbsp;</p><a class="btn btn-primary" href="<?php echo(site_url("s/".$this->session->flashdata('randomId')))?>" role="link">Let's Go!</a><a href="<?php echo(site_url("s/".$this->session->flashdata('randomId')))?>" style="margin-left: 50px;"><?php echo(site_url("s/".$this->session->flashdata('randomId')))?></a>
        <p></p>
</div>