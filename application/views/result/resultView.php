<script src="<?php echo base_url('assets/js/chart.min.js')?>"></script>
<div style="margin: 10%">
    <?php 
        foreach($result as $question){
            $labels = "";
            $values = "";
            foreach($question['dataset'] as $answer){
                if($labels == ""){
                    $labels .= '"'.$answer['data'].'"';
                }
                else{
                    $labels .= ',"'.$answer['data'].'"';
                }
                if($values == ""){
                    $values .= '"'.$answer['count'].'"';
                }
                else{
                    $values .= ',"'.$answer['count'].'"';
                }
            }
            echo '<h1>'.$question['name'].'</h1>';
            // echo '<div><canvas data-bss-chart="{
            //     &quot;type&quot;:&quot;horizontalBar&quot;,
            //     &quot;data&quot;:{
            //         &quot;labels&quot;:['.$labels.'],
            //         &quot;datasets&quot;:[
            //             {   
            //                 &quot;label&quot;:&quot;Revenue&quot;,
            //                 &quot;backgroundColor&quot;:&quot;#4e73df&quot;,
            //                 &quot;borderColor&quot;:&quot;#4e73df&quot;,
            //                 &quot;data&quot;:['.$values.']
            //             }
            //         ]
            //     },
            //     &quot;options&quot;:{
            //         &quot;maintainAspectRatio&quot;:true,
            //         &quot;legend&quot;:{
            //             &quot;display&quot;:false
            //         },
            //         &quot;tooltips&quot;:{
            //             &quot;enabled&quot;:false
            //         }, 
            //         &quot;scales&quot;: {
            //             &quot;yAxes&quot;: [{
            //                 &quot;ticks&quot;: {
            //                     &quot;beginAtZero&quot;:true
            //                 } 
            //             }]
            //         }
            //     }
            // }"></canvas></div>';
            echo '<canvas id="myChart" width="400" height="400"></canvas>
            <script>
                var ctx = document.getElementById("myChart");
                var myChart = new Chart(ctx, {
                    type: "horizontalBar",
                    data: {
                        labels: ['.$labels.'],
                        datasets: [{
                            data: ['.$values.'],
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            </script>';
            break;
        }
    ?>
    
    <script src="<?php echo base_url('assets/js/bs-init.js')?>"></script>
</div>