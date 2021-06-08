<link rel="stylesheet" href="<?php echo base_url('assets/css/Highlight-Blue.css')?>">
<script>
    $(document).ready(function(e){
        $(".other").change(function(){
            $(this).prev().val($(this).val());
            $(this).prev().attr('checked', "")
        });
    });
</script>
<section class="highlight-blue">
        <div class="container">
            <div class="intro">
                <h2 class="text-center"><?php echo $name ?></h2>
                <p><?php echo $description ?></p>
            </div>
        </div>
    </section>
    <div style="background: #dddddd;min-height: 649px;">
        <div class="p-md-5 p-2">
        <form action="<?php echo(site_url('survey/storeAnswers'))?>" method="post">
            <div class="form-group" style="color: var(--dark);">
                <?php
                echo '<input name="randomId" value="'.$randomId.'" type="hidden">';//Ein verstecketer Input, damit der Controller nacher weiß, zu welcher Umfrage die Antworten gehöhren
                $i = 1;
                while(array_key_exists('q'.$i, $data)){
                    echo '<label style="font-family: Nunito, sans-serif;font-size: 30px;color: #313437;">'.$data['q'.$i].'</label>';//Fragentext
                    switch($data[$i."_type"]){
                        case 0:
                            $j = 1;
                            while(array_key_exists($i."_".$j, $data)){//Antwortmöglichkeit
                                echo '<div class="form-check" style="margin-left: 32px;"><input id="'.$i."_".$j.'" class="form-check-input" name="'.$i.'" type="radio" value="'.$i."_".$j.'" required><label class="form-check-label" for="'.$i."_".$j.'" style="color: var(--gray-dark);">'.$data[$i."_".$j].'</label></div>';
                                $j++;
                            }
                            if(array_key_exists($i."_".'0', $data)){//others Objekt
                                echo '<div class="form-check" style="margin-left: 32px;"><input id="'.$i.'_0" class="form-check-input" name="'.$i.'" type="radio"><input class="form-check-label other" type="text" for="'.$i.'_0" style="background-color:#dddddd; border: none; margin-top: -8px; margin-left:-3px" placeholder="Other..." ></div>';
                            }
                            break;
                        case 1:  
                            $j = 1;
                            while(array_key_exists($i."_".$j, $data)){//Antwortmöglichkeit
                                echo '<div class="form-check" style="margin-left: 32px;"><input id="'.$i."_".$j.'" class="form-check-input" name="'.$i."_".$j.'" type="checkbox" value="'.$i."_".$j.'"  ><label class="form-check-label" for="'.$i."_".$j.'" style="color: var(--gray-dark);">'.$data[$i."_".$j].'</label></div>';
                                $j++;
                            }
                            if(array_key_exists($i."_".'0', $data)){//others Objekt
                                echo '<div class="form-check" style="margin-left: 32px;"><input id="'.$i.'_0" class="form-check-input" name="'.$i.'_0" type="checkbox"><input class="form-check-label other" type="text" for="'.$i.'_0" style="background-color:#dddddd; border: none; margin-top: -8px; margin-left:-3px" placeholder="Other..." ></div>';
                            }
                            break;
                        case 2:
                            if(array_key_exists($i."_0", $data)){//Untere grenze entweder 0 oder 1
                                $lower = 0;
                            }
                            else{
                                $lower = 1;
                            }
                            for($j = 2; $j <=10; $j++){//"higher" wird auf den Wert gesetzt, der in der Datenbak existiert.  
                                if(array_key_exists($i."_".$j, $data))
                                $higher = $j;
                            }
                            if($data[$i.'_'.$higher]!=null){//Falls die Extremwerte benannt sind, wird dies hier übernommen. 
                                $lableHigher = $data[$i.'_'.$higher].' ('.$higher.')';
                            }
                            else{
                                $lableHigher = $higher;
                            }
                            if($data[$i.'_'.$lower]!=null){
                                $lableLower = $data[$i.'_'.$lower].' ('.$lower.')';
                            }
                            else{
                                $lableLower = $lower;
                            }
                            echo '<input type="range" name="'.$i.'_0" style="width: '.strval(100-(100/$higher)+3).'%; margin-left: '.strval(((100/$higher)/2)-1.5).'%" value='.$lower.'" min="'.$lower.'" max="'.$higher.'" step="1" />';//der Slider mit passenden Werten und einer Passenden Größe
                            echo '<div class="row">
                                <div class="col" style="width: '.strval(100/$higher).'%; padding:0px">
                                    <p style="text-align: center">'.$lableLower.'</p>
                                </div>';
                                for($j = $lower+1; $j < $higher; $j++){//Die Zwischenwerte werden passend unter die jeweilige Stelle auf dem Slider gesetzt 
                                    echo '<div class="col" style="width: '.strval(100/$higher).'%; padding:0px">
                                            <p style="text-align: center">'.$j.'</p>
                                        </div>';
                                }
                            echo '<div class="col" style="width: '.strval(100/$higher).'%; padding:0px">
                                    <p style="text-align: center">'.$lableHigher.'</p>
                                </div>
                            </div>';
                            break;
                        case 3:
                            echo '<textarea class="form-control" name="'.$i.'_0" required></textarea>';//einfach nur eine Textarea
                            break;
                    }
                    $i++;
                }
                ?>
            </div>
            <button class="btn btn-primary" type="submit" style="margin-top: 32px;">Answer</button>
        </form>
        </div>
    </div>