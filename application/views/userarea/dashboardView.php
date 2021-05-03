
<script>
    $(document).ready(function(e){
        $('.copyToClipboard').click(function(){
            navigator.clipboard.writeText($(this).attr('data-text'))
            $(this).tooltip('show');
        });
    });

</script>
<script src="<?php echo base_url('assets/js/chart.min.js')?>"></script>

<container>
<div id="accordion">

<?php $colors = array(
            array("rgba(255, 99, 132, 0.2)","rgba(255, 99, 132, 1)"),
            array("rgba(54, 162, 235, 0.2)", "rgba(54, 162, 235, 1)"),
            array("rgba(255, 206, 86, 0.2)", "rgba(255, 206, 86, 1)"),
            array("rgba(75, 192, 192, 0.2)", "rgba(75, 192, 192, 1)"),
            array("rgba(153, 102, 255, 0.2)", "rgba(153, 102, 255, 1)"),
            array("rgba(255, 159, 64, 0.2)", "rgba(255, 159, 64, 1)")     
        );
            $target = $mostRecentSurvey;
            $l = 0;
            for($i = 0; $i < 10; $i++){
              echo '<div class="card">
              <button class="btn" data-toggle="collapse" data-target="#collapse'.$i.'" aria-controls="collaps'.$i.'" >
                  <div class="card-header">
                      <h5 style="float: left;">'.$target['name'];
                      if($target['countSinceLastOnline'] > 0){
                        echo ' <span class="badge badge-pill badge-danger">'.$target['countSinceLastOnline'].'</span>';
                      }
                      echo '</h5>&nbsp;
                      <a href="/results/results/'.$target['randomId'].'" style="float: right;"><span class="d-none d-sm-inline">view full results&nbsp;</span><i class="fas fa-arrow-circle-right"></i></a>
                      <a href="#" type="link" class="copyToClipboard d-none d-sm-inline" title="Link copied!" style="float: right; color:gray; text-decoration: none; margin-right: 10px" data-text="'.site_url('s/'.$target['randomId']).'">Copy Link</a>
                  </div>
              </button>
            </div>';
              echo '<div id="collapse'.$i.'" class="collapse '; if($i == 0){echo 'show';} echo'" data-parent="#accordion">
                      <div class="card-body">
                      <div class="row">
                        <div class="col-md-2">
                          <h5>New Answers since your last visit: '.$target['countSinceLastOnline'].'</h5>
                        </div>';
                      for($j = 0; $j < 2; $j++){//es werden 2 belibige Fraben dargestellt
                        $k = rand(0, count($target['result'])-1);//wählt die Frage aus
                        echo '<div class="col-12 col-md-5">';
                        echo '<h6>'.$target['result'][$k]['name'].'</h6>';
                        $labels = "";
                        $values = "";
                        $entryCount = 0;
                        $sum = 0;
                        $generatedColors = array("","");
                        $colorCount = 0;
            
                        switch($target['result'][$k]['type']){
                            case 0:
                            case 1:
                                foreach($target['result'][$k]['dataset'] as $answer){
            
                                    if($labels == ""){
                                        $labels .= '"'.$answer['data'].'"';
                                        $generatedColors[0] .= '"'.$colors[$colorCount][0].'"';
                                        $generatedColors[1] .= '"'.$colors[$colorCount][1].'"';
                                    }
                                    else{
                                        $labels .= ',"'.$answer['data'].'"';
                                        $generatedColors[0] .= ',"'.$colors[$colorCount][0].'"';
                                        $generatedColors[1] .= ',"'.$colors[$colorCount][1].'"';
                                    }
                                    if($values == ""){
                                        $values .= $answer['count'];
                                    }
                                    else{
                                        $values .= ','.$answer['count'];
                                    }
                                    $colorCount++;
                                    if($colorCount > 5){
                                        $colorCount = 0;
                                    }
                                }
                                echo '<canvas id="'.$l.'" width="200" height="100"></canvas>
                                <script>
                                var ctx = document.getElementById("'.$l.'");
                                var myChart = new Chart(ctx, {
                                    type: "horizontalBar",
                                    data: {
                                        labels: ['.$labels.'],
                                        datasets: [{
                                            label: "#",
                                            data: ['.$values.'],
                                            backgroundColor: ['.$generatedColors[0].'],
                                            borderColor: ['.$generatedColors[1].'],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        legend: {
                                            display: false,
                                        },
                                        scales: {
                                            xAxes: [{
                                                ticks: {
                                                    beginAtZero: true,
                                                    stepSize: 1
                                                }
                                            }]
                                        }
                                    }
                                });
                                </script>';
                                $l++;
                            break;
                            case 2:     
                                foreach($target['result'][$k]['dataset'] as $answer){
                                    $entryCount += $answer['count'];
                                    $sum += $answer['count']*intval($answer['data']); 
                                }
                                foreach($target['result'][$k]['dataset'] as $answer){
                                    if($labels == ""){
                                        $labels .= '"'.$answer['data'].', '.round(floatval($answer['count']*100/$entryCount), 2).'%"';
                                        $generatedColors[0] .= '"'.$colors[$colorCount][0].'"';
                                        $generatedColors[1] .= '"'.$colors[$colorCount][1].'"';
                                    }
                                    else{
                                        $labels .= ',"'.$answer['data'].', '.round(floatval($answer['count']*100/$entryCount), 2).'%"';
                                        $generatedColors[0] .= ',"'.$colors[$colorCount][0].'"';
                                        $generatedColors[1] .= ',"'.$colors[$colorCount][1].'"';
                                    }
                                    if($values == ""){
                                        $values .= $answer['count'];
                                    }
                                    else{
                                        $values .= ','.$answer['count'];
                                    }
                                    $colorCount++;
                                    if($colorCount > 5){
                                        $colorCount = 0;
                                    }
                                }
                                echo '<canvas id="'.$l.'" width="200" height="100"></canvas>
                                <script>
                                var ctx = document.getElementById("'.$l.'");
                                var myChart = new Chart(ctx, {
                                    type: "pie",
                                    data: {
                                        labels: ['.$labels.'],
                                        datasets: [{
                                            label: "#",
                                            data: ['.$values.'],
                                            backgroundColor: ['.$generatedColors[0].'],
                                            borderColor: ['.$generatedColors[1].'],
                                            borderWidth: 1
                                        }]
                                    }
                                });
                                </script>';          
                                $l++;
                            break;
                        case 3:
                            echo '<p>The five most popular answers: <p>';
                            echo '<div style="margin-bottom: 50px; max-width: 500px">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Antwort</th>
                                                    <th scope="col">#</th>
                                                </tr>
                                           </thead>
                                           <tbody>';
                                           foreach($target['result'][$k]['dataset'] as $answer){
                                                echo '<tr>
                                                    <td>'.$answer['data'].'</td>
                                                    <td>'.$answer['count'].'</td>
                                                </tr>
                                                ';
                                            }
                            echo '         </tbody>
                                        </table>
                                    </div>';
                        }
                        echo '</div>';
                        if(count($target['result']) < 2){
                          break;
                        }
                      }
                      echo '</div></div></div>';
                      if(array_key_exists($i,$mostTrafficSurvey)){
                        $target = $mostTrafficSurvey[$i];
                      }
                      else{
                        break;
                      }
                        
                    }
                        ?>
</div>    
</container>
    
