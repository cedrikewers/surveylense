<script src="<?php echo base_url('assets/js/chart.min.js')?>"></script>
<div style="margin: 10%">
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
        foreach($result as $question){
            $labels = "";
            $values = "";
            $sum = 0;
            $entryCount = 0;
            $generatedColors = array("","");
            $colorCount = 0;// $colorCount = random_int(0, 5);$colorCount = 0;
            foreach($question['dataset'] as $answer){
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
                $sum += $answer['count']*intval($answer['data']);
                $entryCount += $answer['count'];    
                $colorCount++;
                if($colorCount > 5){
                    $colorCount = 0;
                }
            }
            echo '<h1>'.$question['name'].'</h1>';
            echo '<div class="row"><div class="col-xl-7">';
            echo '<canvas id="'.$i.'" width="200" height="100"></canvas>
            <script>
            var ctx = document.getElementById("'.$i.'");
            var myChart = new Chart(ctx, {
                type: "horizontalBar",
                data: {
                    labels: ['.$labels.'],
                    datasets: [{
                        label: "times choosen",
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
            echo '</div>';            
            echo '<div class="col-5">
                    <table class="table d-none d-md-block">
                        <thead>
                            <th scope="col">&empty;</th>';
                        foreach($question['dataset'] as $answer){
                            echo '<th scope="col">'.$answer['data'].'</th>';
                        }
            echo'            </thead>
                        <tbody>
                            <tr>
                                <td>'.floatval($sum/$entryCount).'</td>';
                            foreach($question['dataset'] as $answer){
                                echo '<td>'.round(floatval($answer['count']*100/$entryCount), 2).'&#37;</td>';
                            }        
            echo'                </tr>
                        </tbody>
                    </table>
                </div>
            </div>';
            $i++;
        }
    ?>
    
    <script src="<?php echo base_url('assets/js/bs-init.js')?>"></script>
</div>