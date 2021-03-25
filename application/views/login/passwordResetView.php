<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image" style="background:url('assets/pictures/placeholder.jpg');"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Reset your password!</h4>
                                    </div>
                                    <div class="text-center">
                                        <?php if(isset($_SESSION)) {
                                                echo '<div class="text-success">';
                                                echo $this->session->flashdata('flash_data');
                                                echo '</div>';
                                            }
                                        ?>
                                    </div>
                                    <form action="<?php site_url('passwordreset') ?>" method="post" class="user">
                                        <div class="form-group"><input class="form-control form-control-user" type="email" placeholder="Enter Email..." name="email"></div>
                                        <button class="btn btn-primary btn-block text-white btn-user" type="submit">Reset</button>
                                        <hr>
                                    </form>
                                    <div class="text-center"><a class="small" href="/login">Already have an account? Login!</a></div>
                                    <div class="text-center"><a class="small" href="/register">Create an Account!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>