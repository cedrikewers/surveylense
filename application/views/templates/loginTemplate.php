<?php
    $session = $this->session->userdata('id_user');
    if(!empty($session)){
        redirect('/userarea');
    }
    else{
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" >
        <meta name="robots" content="noindex">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/fontawesome.min.css');?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>">
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
        <nav class="navbar navbar-light navbar-expand bg-white shadow navigation-clean">
            <div class="container">
                <a class="navbar-brand" href="/">Surveylense</a>
            </div>
        </nav>

        <!-- Custom content -->
        <?php echo $content; ?>

        <!-- Footer -->
        <footer class="footer bg-white shadow fixed-bottom">
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