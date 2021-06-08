<?php
    $session = $this->session->userdata('id_admin');
    if(empty($session)){
        redirect('/admin');
    }
    else{
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="robots" content="noindex">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/fontawesome.min.css');?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/Dashboard-layout.css');?>">
        <link rel="icon" href="<?php echo base_url("assets/icon.ico");?>">
        <script src="https://kit.fontawesome.com/0a1c5913ac.js" crossorigin="anonymous"></script>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="<?php echo base_url('assets/js/jquery-3.5.1.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
        <script src="<?php echo base_url('assets/js/fontawesome.min.js');?>"></script>
        <script data-ad-client="ca-pub-9035096517255870" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <title><?php echo $title; ?></title>
    </head>

    <body>
        <!-- Navbar -->
        <div class="wrapper">
        <div class="sidebar" data-color="purple" data-image="" style="background-image:url(&quot;https://vignette.wikia.nocookie.net/the-xmen-roleplay/images/c/c1/Forest-Lake-HD-Desktop-Wallpaper.jpg/revision/latest?cb=20130822192442&quot;);">
            <div class="sidebar-wrapper">
                <div class="logo"><a class="simple-text" href="#">Admin dashboard</a></div>
                <ul class="list-group">
                    <li class="list-group-item"><a href="/admin/adminarea/"><span>Home </span></a></li>
                    <li class="list-group-item"><a href="/admin/adminarea/users"><span>Users </span></li>
                    <li class="list-group-item"><a href="/admin/adminarea/surveys"><span>Surveys </span></li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-light navbar-expand-md">
                <div class="container-fluid">
                    <div><a class="navbar-brand" href="#">Control panel</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button></div>
                    <div class="collapse navbar-collapse" id="navcol-1">
                        <ul class="navbar-nav"></ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item"><a class="nav-link text-danger" href="/admin/logout">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">
                    <!-- Custom content -->
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
        </div>

        

        <!-- Footer -->
        <footer class="footer bg-white shadow">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 my-auto h-100 text-center">
                    <ul class="list-inline mb-2">
                        <li class="list-inline-item"><a href="/imprint">Legal details</a></li>
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