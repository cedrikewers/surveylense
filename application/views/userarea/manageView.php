<div style="margin: 0px 10% 0px 10%">
    <h1>Manage your Surveys</h1>
    <div style="margin: 50px 0px 0px 0px">
    <?php 
        foreach($surveyTemp as $survey){
         echo '
        <div class="row row-cols-2">
            <div class="col-4 col-xl-4">
                <p>'.$survey['name'].'</p>
            </div>
            <div class="col-8 d-flex justify-content-end">
                            <span class="d-none d-lg-inline">Created: '.$survey['timestamp'].'</span>
                            <span class="d-none d-lg-inline" style="margin-left: 5%;">Total Answers: '.$survey['count'].'</span>
                            <a style="margin-left: 5%;"><i class="fas fa-pen"></i><span class="d-none d-sm-inline"> Edit</span></a>
                            <a href="'.site_url('results/results/'.$survey['randomId']).'"style="margin-left: 5%;"><i class="far fa-chart-bar"></i><span class="d-none d-sm-inline"> Results</span></a>
                            <a href="'.site_url('results/download/'.$survey['randomId']).'" style="margin-left: 5%;"><i class="fas fa-download"></i><span class="d-none d-sm-inline"> Download</span></a>
                        </div> 
              
        </div>';
        }
    ?>
    </div>
</div>