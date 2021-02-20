<div class="container">
        <div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-flex">
                        <div class="flex-grow-1 bg-register-image" style="background:url('assets/pictures/placeholder.jpg');"></div>
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="text-dark mb-4">Create an Account!</h4>
                            </div>
                            <div class="text-center">
                                <?php if(isset($_SESSION)) {
                                        echo '<div class="text-danger">';
                                        echo $this->session->flashdata('flash_data');
                                        echo '</div>';
                                    }
                                ?>
                            </div>
                            <form action="<?php site_url('register') ?>" method="post" class="user">
                                <div class="form-group"><input class="form-control form-control-user" type="text" id="exampleFirstName" placeholder="Username" name="username"></div>
                                <div class="form-group"><input class="form-control form-control-user" type="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Email Address" name="email"></div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="password" id="examplePasswordInput" placeholder="Password" name="password"></div>
                                    <div class="col-sm-6"><input class="form-control form-control-user" type="password" id="exampleRepeatPasswordInput" placeholder="Repeat Password" name="password_repeat"></div>
                                </div><button class="btn btn-primary btn-block text-white btn-user" type="submit">Register Account</button>
                                <hr>
                            </form>
                            <div class="text-center"><a class="small" href="/">Forgot Password?</a></div>
                            <div class="text-center"><a class="small" href="/login">Already have an account? Login!</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>