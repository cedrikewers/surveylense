
<!-- Banner with option to create a new servey -->
<header class="homepageBanner text-white text-center" style="background:url('assets/pictures/bg-homepage.jpg') no-repeat center center; background-size:cover;">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-xl-9 mx-auto">
                <h1 class="mb-0">Surveylense<br></h1>
                <h4 class="mb-5">The simple and intuitive survey tool</h4>
            </div>
            <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                <form action="<?php echo site_url('homepage/create')?>" method="get">
                    <div class="form-row">
                        <div class="col-12 col-md-9 mb-2 mb-md-0"><input class="form-control form-control-lg" name="title" placeholder="give your survey a suitable name..."></div>
                        <div class="col-12 col-md-3"><button class="btn btn-primary btn-block btn-lg" type="submit">Let's go</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>

<!-- Short feature explanation -->
<div class="row bg-light m-0" style="max-width: 100%;" >
<div class="col-9">
<section class="features-icons bg-light text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="mx-auto features-icons-item mb-5 mb-lg-0 mb-lg-3">
                    <div class="d-flex features-icons-icon"><i class="fas fa-desktop fa-5x m-auto text-primary" data-bs-hover-animate="pulse"></i></div>
                    <h3>Fully Customisable</h3>
                    <p class="lead mb-0">Endless customisation options is everything you need to make the perfect survey.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mx-auto features-icons-item mb-5 mb-lg-0 mb-lg-3">
                    <div class="d-flex features-icons-icon"><i class="far fa-check-circle fa-5x m-auto text-primary" data-bs-hover-animate="pulse"></i></div>
                    <h3>Easy to Use</h3>
                    <p class="lead mb-0">You will able to generate your dream survey in minutes! So start now!</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Detailed feature explanation -->
<section class="information bg-light text-center">
    <div class="container p-0">
        <div class="row h-100 no-gutters">
            <div class="col-lg-4 order-lg-2 information-item-picture" style="background:url('assets/pictures/placeholder.jpg') no-repeat center center; background-size:cover;"></div>
            <div class="col-lg-8 order-lg-1 p-4">
                <h2>Analyse Everything</h2>
                <p class="lead mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi deserunt aliquid qui, eaque, voluptates tempore ad pariatur vero, nemo repellat consequuntur. Sit rerum minus, repellat similique molestias fuga labore corporis? Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laudantium commodi nobis eveniet ullam, odio quidem? Ipsam tempore soluta, dicta velit ullam qui, accusantium ad ea voluptatibus accusamus eligendi minus nisi.</p>
            </div>
        </div>
        <div class="row h-100 no-gutters mt-5">
            <div class="col-lg-4 information-item-picture" style="background:url('assets/pictures/placeholder.jpg') no-repeat center center; background-size:cover;"></div>
            <div class="col-lg-8 order-lg-1 p-4">
                <h2>Fully Responsive Design</h2>
                <p class="lead mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi deserunt aliquid qui, eaque, voluptates tempore ad pariatur vero, nemo repellat consequuntur. Sit rerum minus, repellat similique molestias fuga labore corporis? Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laudantium commodi nobis eveniet ullam, odio quidem? Ipsam tempore soluta, dicta velit ullam qui, accusantium ad ea voluptatibus accusamus eligendi minus nisi.</p>
            </div>
        </div>
        <div class="row h-100 no-gutters mt-5">
            <div class="col-lg-4 order-lg-2 information-item-picture" style="background:url('assets/pictures/placeholder.jpg') no-repeat center center; background-size:cover;"></div>
            <div class="col-lg-8 order-lg-1 p-4">
                <h2>Fully Responsive Design</h2>
                <p class="lead mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi deserunt aliquid qui, eaque, voluptates tempore ad pariatur vero, nemo repellat consequuntur. Sit rerum minus, repellat similique molestias fuga labore corporis? Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laudantium commodi nobis eveniet ullam, odio quidem? Ipsam tempore soluta, dicta velit ullam qui, accusantium ad ea voluptatibus accusamus eligendi minus nisi.</p>
            </div>
        </div>
    </div>
</section>
</div>

<!-- Sidebar with public Surveys-->
<div class="col-lg-3 bg-light" style="margin-top: 20px;" >
    <?php 
        foreach($publicSurveys as $survey){
            $shortDesc = substr($survey['description'], 0, 60);
            if(strlen($survey['description']) > 60){
                $shortDesc .= '<span style="cursor:pointer;">...</span>';
            }
            echo '<div class="card" style="padding: 3%;">
                    <div class="card-body">
                        <h4 class="card-title"><a href="'.site_url('s/'.$survey['randomId']).'" style="text-decoration: none; color:black;">'.$survey['name'].'</a></h4>
                        <h6 class="text-muted card-subtitle mb-2">Created: '.substr($survey['timestamp'], 0, 9).', '.$survey['count'].' answers</h6>
                        <p class="card-text shortDesc" onclick="toggleDesc($(this))">'.$shortDesc.'</p><p class="card-text longDesc d-none">'.$survey['description'].'</p><a class="card-link" href="'.site_url('s/'.$survey['randomId']).'">Complete it</a>
                    </div>
                </div>';
        }
    ?>
</div>
</div>

<script>
    function toggleDesc(pThis){
        $(pThis).toggleClass("d-none");
        $(pThis).next().toggleClass("d-none");
    }
</script>
