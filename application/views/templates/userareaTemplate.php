<?php
    $session = $this->session->userdata('id_user');
    if(empty($session)){
        redirect('/');
    }
    else{
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/fontawesome.min.css');?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>">

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo base_url('assets/js/jquery-3.5.1.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/fontawesome.min.js');?>"></script>
        <title><?php echo $title; ?></title>
    </head>

    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-light navbar-expand bg-light navigation-clean">
            <div class="container">
                <a class="navbar-brand" href="/">Surveylense</a>
                <div class="nav-item"><a class="nav-link" href="#">Link</a></div>
                <div class="nav-item"><a class="nav-link" href="#">Link2</a></div>
                <div class="nav-item dropdown">
                    <a class="nav-link btn btn-primary dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php 
                        $session = $this->session->userdata('username');
                        echo $session; 
                    ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/userarea/profile">Profile</a>
                    <a class="dropdown-item" href="#">test</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/login/logout">Logout</a>
                    </div>
                </div>
                <!--<div class="collapse navbar-collapse" id="navcol-1"><a class="btn btn-primary ml-auto" role="button" href="/login">Sign In</a></div>-->
            </div>
        </nav>

        <!-- Custom content -->
        <?php echo $content; ?>

        <!-- Footer -->
        <footer class="footer bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 my-auto h-100 text-center">
                    <ul class="list-inline mb-2">
                        <li class="list-inline-item"><a href="/imprint">About</a></li>
                        <li class="list-inline-item"><span>⋅</span></li>
                        <li class="list-inline-item"><a href="/imprint">Contact</a></li>
                        <li class="list-inline-item"><span>⋅</span></li>
                        <li class="list-inline-item"><a href="/imprint">Terms of Use</a></li>
                        <li class="list-inline-item"><span>⋅</span></li>
                        <li class="list-inline-item"><a href="/imprint">Privacy Policy</a></li>
                    </ul>
            </div>
        </div>
    </footer>
    </body>
</html>
<?php } ?>