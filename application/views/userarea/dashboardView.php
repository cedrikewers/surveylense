
<script>
    $(document).ready(function(e){
        $('.copyToClipboard').click(function(){
            navigator.clipboard.writeText($(this).attr('data-text'))
            $(this).tooltip('show');
        });
    });

</script>

<container>
<div id="accordion">
  <div class="card">
    <button class="btn" data-toggle="collapse" data-target="#collapse0" aria-expanded="true" aria-controls="collapse0" >
        <div class="card-header">
            <h5 style="float: left;"><?php echo $mostRecentSurvey['name'] ?></h5>&nbsp;
            <a href="/results/results/<?php echo $mostRecentSurvey['randomId']?>" style="float: right;">view full results&nbsp;<i class="fas fa-arrow-circle-right"></i></a>
            <a href="#" type="link" class="copyToClipboard" title="Link copied!" style="float: right; color:gray; text-decoration: none; margin-right: 10px" data-text="<?php echo site_url('s/'.$mostRecentSurvey['randomId'])?>">Copy Link</a>
        </div>
    </button>
   

    <div id="collapse0" class="collapse show" data-parent="#accordion">
      <div class="card-body">
        <?php 

          $colors = array(
            array("rgba(255, 99, 132, 0.2)","rgba(255, 99, 132, 1)"),
            array("rgba(54, 162, 235, 0.2)", "rgba(54, 162, 235, 1)"),
            array("rgba(255, 206, 86, 0.2)", "rgba(255, 206, 86, 1)"),
            array("rgba(75, 192, 192, 0.2)", "rgba(75, 192, 192, 1)"),
            array("rgba(153, 102, 255, 0.2)", "rgba(153, 102, 255, 1)"),
            array("rgba(255, 159, 64, 0.2)", "rgba(255, 159, 64, 1)")     
          );

          foreach($mostRecentSurvey['result'] as $number => $question){
            switch($question['type']){
              case 0:
              case 1:
                echo '<p>The top answer is: '.$question['dataset'][0]['data'].'</p>';
                break;
              case 2:
                break;
              case 3:
                
            }
          }
        
        ?>
      </div>
    </div>
  </div>

  <?php
    foreach($mostTrafficSurvey as $number => $survey){
      echo '
      <div class="card">
      <button class="btn" data-toggle="collapse" data-target="#collapse'.strval($number+1).'" aria-expanded="true" aria-controls="collapse'.strval($number+1).'" >
          <div class="card-header" >
              <h5 style="float: left;">'.$survey['name'] .'</h5>&nbsp;
              <a href="/results/results/'.$survey['randomId'] .'" style="float: right;">view full results&nbsp;<i class="fas fa-arrow-circle-right"></i></a>
              <a href="#" type="link" class="copyToClipboard" title="Link copied!" style="float: right; color:gray; text-decoration: none; margin-right: 10px" data-text="'.site_url('s/'.$survey['randomId']).'">Copy Link</a>
          </div>
      </button>
     
  
      <div id="collapse'.strval($number+1).'" class="collapse" data-parent="#accordion">
        <div class="card-body">';

        $colors = array(
          array("rgba(255, 99, 132, 0.2)","rgba(255, 99, 132, 1)"),
          array("rgba(54, 162, 235, 0.2)", "rgba(54, 162, 235, 1)"),
          array("rgba(255, 206, 86, 0.2)", "rgba(255, 206, 86, 1)"),
          array("rgba(75, 192, 192, 0.2)", "rgba(75, 192, 192, 1)"),
          array("rgba(153, 102, 255, 0.2)", "rgba(153, 102, 255, 1)"),
          array("rgba(255, 159, 64, 0.2)", "rgba(255, 159, 64, 1)")     
        );

        foreach($survey['result'] as $number => $question){
          switch($question['type']){
            case 0:
            case 1:
              echo '<p>The top answer is: '.$question['dataset'][0]['data'].'</p>';
              break;
            case 2:
              echo '<p>The top answer is: '.$question['dataset'][0]['data'].'</p>';
              break;
            case 3:
              echo '<p>The top answer is: '.$question['dataset'][0]['data'].'</p>';
              
          }
        }
      
        echo '</div>
      </div>
    </div>
      
      
      ';
    }

  ?>
</div>


</container>

