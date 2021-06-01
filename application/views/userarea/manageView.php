<script>
    $(document).ready(function(e){
        $('.copyToClipboard').click(function(){
            navigator.clipboard.writeText($(this).attr('data-text'))
            $(this).tooltip('show');
        });
    });

</script>

<div style="margin: 0px 10% 0px 10%">
    <h1>Manage your Surveys</h1>
    <div style="margin: 50px 0px 0px 0px">
    <?php 
        foreach($surveyTemp as $survey){
         echo '
        <div class="row row-cols-2">
            <div class="col-7 col-lg-4">
                <p>'.$survey['name'].'</p>
            </div>
            <div class="col-5 col-lg-8 d-flex justify-content-end">
                            <span class="d-none d-lg-inline">Created: '.substr($survey['timestamp'], 0, 10).'</span>
                            <span class="d-none d-lg-inline" style="margin-left: 3%;">Total Answers: '.$survey['count'].'</span>
                            <a href="#" type="link" class="copyToClipboard" title="Link copied!" style="float: right; color:black; text-decoration: none; margin-left: 3%;" data-text="'.site_url('s/'.$survey['randomId']).'"><i class="fas fa-copy" style="color: MediumSeaGreen"></i>&nbsp;<span class="d-none d-sm-inline">Copy Link</span></a>
                            <a href="'.site_url('edit/'.$survey['randomId']).'"style="margin-left: 3%;text-decoration: none;"><i class="fas fa-pen" style="color: Orange"></i>&nbsp;<span class="d-none d-sm-inline" style="color: black; ">Edit</span></a>
                            <a href="'.site_url('results/results/'.$survey['randomId']).'" style="margin-left: 3%;text-decoration: none;"><i class="far fa-chart-bar" style="color: DodgerBlue"></i>&nbsp;<span class="d-none d-sm-inline" style="color: black; ">Results</span></a>
                            <a href="'.site_url('results/download/'.$survey['randomId']).'" style="margin-left: 3%;text-decoration: none;"><i class="fas fa-download" style="color: Tomato"></i>&nbsp;<span class="d-none d-sm-inline" style="color: black; ">Download</span></a>
                        </div> 
              
        </div>';
        }
    ?>
    </div>
</div>