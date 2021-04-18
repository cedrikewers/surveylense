<script src="<?php echo base_url('assets/js/chart.min.js')?>"></script>
<div style="padding: 8%">
    <?php 
        $i = 1;
        $colors = array(
            array("rgba(255, 99, 132, 0.2)","rgba(255, 99, 132, 1)"),
            array("rgba(54, 162, 235, 0.2)", "rgba(54, 162, 235, 1)"),
            array("rgba(255, 206, 86, 0.2)", "rgba(255, 206, 86, 1)"),
            array("rgba(75, 192, 192, 0.2)", "rgba(75, 192, 192, 1)"),
            array("rgba(153, 102, 255, 0.2)", "rgba(153, 102, 255, 1)"),
            array("rgba(255, 159, 64, 0.2)", "rgba(255, 159, 64, 1)") 
        );
        echo '<h1 style="margin-bottom: 3%" class="d-none d-sm-block">'.$title.'</h1>
            <h3 class="d-sm-none" style="margin-bottom: 3%">'.$title.'</h3>';
        foreach($result as $question){
            $labels = "";
            $values = "";
            $sum = 0;
            $entryCount = 0;
            $generatedColors = array("","");
            $colorCount = 0;
            // $colorCount = random_int(0, 5);

            switch($question['type']){
                case 0:
                case 1:
                    foreach($question['dataset'] as $answer){

                        $entryCount += $answer['count'];

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
                    echo '<h2 class="d-none d-sm-block">'.$question['name'].'</h2>
                        <h4 class="d-sm-none">'.$question['name'].'</h2>';
                    echo '<div class="row" style="margin-bottom: 50px"><div class="col-xl-7">';
                    echo '<canvas id="'.$i.'" width="200" height="100"></canvas>
                    <script>
                    var ctx = document.getElementById("'.$i.'");
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
                    </script>
                    </div>';
                    echo '
                        <div class="col-xl-5 d-none d-md-block">
                        <div class="row">
                        <div class="col-xl-12 col-md-6">
                            <table class="table" style="margin-top: 5px;">
                                <thead>
                                    <tr>';
                                        foreach($question['dataset'] as $answer){
                                            echo '<th scope="col">'.$answer['data'].'</th>';
                                        }              
                    echo '         </tr>
                                </thead>
                                <tbody>
                                    <tr>';
                                        foreach($question['dataset'] as $answer){
                                            echo '<td>'.round(floatval($answer['count']*100/$entryCount), 2).'%</td>';
                                        }
                    echo'           </tr>
                                </tbody>
                            </table>
                            </div>';
                    if(isset($question['othersData'])){
                    echo '  <div class="col-xl-12 col-md-6">
                            <p>Top custom answers: </p>
                            <table class="table d-none d-md-block">
                                <thead>
                                    <tr>
                                        <th scope="col">Answer</th>
                                        <th scope="col">#</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                        $k = 0; 
                                        foreach($question['othersData'] as $data => $count){
                                            if($k > 2){break;}
                                            echo '<tr><td>'.$data.'</td>';
                                            echo '<td>'.$count.'</td></tr>';
                                            $k++;
                                        }
                    echo'          
                                </tbody>
                            </table>
                            </div>';}
                    echo'</div class="col-xl-5">
                    </div>
                    </div>
                    ';
                    $i++;
                break;
                case 2:     
                    foreach($question['dataset'] as $answer){
                        $entryCount += $answer['count'];
                        $sum += $answer['count']*intval($answer['data']); 
                    }
                    foreach($question['dataset'] as $answer){
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
                    echo '<h2 class="d-none d-sm-block">'.$question['name'].'</h2>
                         <h4 class="d-sm-none">'.$question['name'].'</h2>';
                    echo '<div class="row" style="margin-bottom: 50px"><div class="col-xl-7">';
                    echo '<canvas id="'.$i.'" width="200" height="100"></canvas>
                    <script>
                    var ctx = document.getElementById("'.$i.'");
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
                    echo '</div>';            
                    echo '<div class="col-5">
                            <table class="table d-none d-md-block">
                                <thead>
                                    <th scope="col">&empty;</th>';
                    echo'            </thead>
                                <tbody>
                                    <tr>
                                        <td>'.floatval($sum/$entryCount).'</td>';      
                    echo'                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>';
                    $i++;
                break;
            case 3:
                echo '<h2 class="d-none d-sm-block">'.$question['name'].'</h2>
                      <h4 class="d-sm-none">'.$question['name'].'</h2>
                        <p>The five most popular answers: <p>
                ';
                echo '<div style="margin-bottom: 50px; max-width: 500px">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Antwort</th>
                                        <th scope="col">#</th>
                                    </tr>
                               </thead>
                               <tbody>';
                               foreach($question['dataset'] as $answer){
                                    echo '<tr>
                                        <td>'.$answer['data'].'</td>
                                        <td>'.$answer['count'].'</td>
                                    </tr>
                                    ';
                                }
                echo '         </tbody>
                            </table>
                        </div>';

            break;
            }
        }
        echo '<p> You can download the plain results as an Excel sheet by clicking the button. Please be aware that some programms such as <i>Libre Office</i> are unable to open this document. 
            However, the offical <i>Microsoft Excel</i> and the <i>Google Sheets</i> Web-App do work.</p><a href="'.site_url('/results/download/'.$randomId).'" class="btn btn-light"><i class="fas fa-download"></i> Download</a>';
    ?>
</div>