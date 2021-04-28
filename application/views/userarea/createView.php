
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora">
<link rel="stylesheet" href="<?php echo base_url('assets/css/Highlight-Blue.css');?>">

<script src="<?php echo base_url('assets/js/create.js');?>"></script>


<section class="highlight-blue" style="background-color: 8BD8FF;">
        <div class="container">
            <div class="intro">
                <h2 class="text-center">Create a new Survey</h2>
                <p class="text-center">To create new survey, simply hit the "+" button and add a question</p>
            </div>
            <div class="buttons">
                <form class="text-left" action="<?php echo site_url('userarea/storeSurvey')?>" method="post">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col text-left"><label>Name</label><input class="form-control" type="text" required="" name="name" placeholder="Give your survey a name" value="<?php if(isset($_GET["title"])){echo $_GET["title"];}?>"><label>Description</label><textarea class="form-control" name="description" placeholder="Tell them what this survey is about"></textarea></div>
                            <div class="col-xl-3 text-left"><label>Visibility</label><select class="custom-select" name="visibility">
                                    <option value="private" selected="">Private</option>
                                    <option value="public">Public</option>
                                </select></div>
                        </div>
                        <span id="questions">
                            <div id="question1">
                                <div class="form-row row-cols-md-2 row-cols-lg-3 row-cols-xl-3">
                                    <div class="col-md-12 col-lg-8 col-xl-8"><label>Question 1</label><input class="form-control" name="q1" type="text" placeholder="Question 1"></div>
                                    <div class="col-md-12 col-lg-3 col-xl-3 d-lg-flex d-xl-flex align-items-lg-end align-items-xl-end"><select class="custom-select type" onchange="changeType($(this))" name="1_type" style="margin-top: 10px;">
                                            <option value="0" selected="">Single Choice</option>
                                            <option value="1">Multiple Choice</option>
                                            <option value="2">Scale</option>
                                            <option value="3">Text</option>
                                        </select></div>
                                    <div class="col-lg-1 col-xl-1 order-2"><button class="btn btn-primary btn-sm d-none d-print-block d-sm-none d-md-none d-lg-block d-xl-block align-items-md-end delQuestion" type="button" style="margin: 0;padding: 10px;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 1;margin-top: 33px;background: #ff0000;margin-left: -6px;"><i class="fas fa-trash"></i></button></div>
                                </div>
                                <div style="margin-left: 1%;">
                                    <span id="answerOption1">
                                        <div class="form-row row-cols-2">
                                            <div class="col-11 col-xl-11"><input class="form-control" type="text" name="1_1" placeholder="Answer option 1" style="margin-top: 10px;"></div>
                                            <div class="col-1 col-xl-1">
                                            <button class="btn btn-primary btn-sm align-items-md-end deleteAnswerOption" type="button" style="margin: 0;padding: 10px;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 1;margin-top: 11px;background: rgb(193,6,6);margin-left: -6px;"><i class="fas fa-times"></i></button></div>
                                        </div>
                                    </span> 
                                    <button class="btn btn-primary text-capitalize d-none d-lg-inline addAnswerOption" type="button" style="background: var(--indigo);">Add Answer option</button><button class="btn btn-primary text-capitalize d-lg-none addAnswerOption" type="button" style="background: var(--indigo);"><i class="fas fa-plus-circle"></i></button><button class="btn btn-primary text-capitalize addOthers" type="button" style="background: var(--purple);">Add "Others"</button><button class="btn btn-primary text-capitalize d-lg-none delQuestion2" type="button" style="background: rgb(255,0,0);"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </span>
                    </div>
            </div>
        </div>
</section>
            <div style="display: flex; align-items: center; width: 100%; flex-direction: column;">
                <button id="addQuestion" class="btn btn-primary" type="button" style="font-size: x-large;width: 50px;height: 50px;margin-top: -25px; margin-left: -40%"><strong>+</strong></button><br>
                <button class="btn btn-primary" type="submit" style="background: var(--purple);font-size: 19px;">Create survey</button>
            </div>

        </form>



