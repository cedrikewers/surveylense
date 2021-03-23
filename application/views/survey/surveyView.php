<link rel="stylesheet" href="<?php echo base_url('assets/css/Highlight-Blue.css')?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/surveyView.css')?>">
<script src="<?php echo base_url('assets/js/rangeSlider.js')?>"></script>
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
        <div style="padding: 36px;padding-right: 36px;padding-left: 75px;">
        <form action="<?php echo(site_url('survey/storeAnswers'))?>" method="post">
            <div class="form-group" style="color: var(--dark);">
                <?php
                echo '<input name="randomId" value="'.$randomId.'" type="hidden">';
                $i = 1;
                while(array_key_exists('q'.$i, $data)){
                    echo '<label style="font-family: Nunito, sans-serif;font-size: 30px;color: #313437;">'.$data['q'.$i].'</label>';
                    switch($data[$i."_type"]){
                        case 0:
                            $j = 1;
                            while(array_key_exists($i."_".$j, $data)){
                                echo '<div class="form-check" style="margin-left: 32px;"><input id="'.$i."_".$j.'" class="form-check-input" name="'.$i."_".$j.'" type="radio" value="'.$i."_".$j.'"><label class="form-check-label" for="'.$i."_".$j.'" style="color: var(--gray-dark);">'.$data[$i."_".$j].'</label></div>';
                                $j++;
                            }
                            if(array_key_exists($i."_".'0', $data)){
                                echo '<div class="form-check" style="margin-left: 32px;"><input id="'.$i.'_0" class="form-check-input" name="'.$i.'_0" type="radio"><input class="form-check-label other" type="text" for="'.$i.'_0" style="background-color:#dddddd; border: none; margin-top: -8px; margin-left:-3px" placeholder="Other..." ></div>';
                            }
                            break;
                        case 1:  
                            $j = 1;
                            while(array_key_exists($i."_".$j, $data)){
                                echo '<div class="form-check" style="margin-left: 32px;"><input id="'.$i."_".$j.'" class="form-check-input" name="'.$i."_".$j.'" type="checkbox" value="'.$i."_".$j.'"><label class="form-check-label" for="'.$i."_".$j.'" style="color: var(--gray-dark);">'.$data[$i."_".$j].'</label></div>';
                                $j++;
                            }
                            if(array_key_exists($i."_".'0', $data)){
                                echo '<div class="form-check" style="margin-left: 32px;"><input id="'.$i.'_0" class="form-check-input" name="'.$i.'_0" type="checkbox"><input class="form-check-label other" type="text" for="'.$i.'_0" style="background-color:#dddddd; border: none; margin-top: -8px; margin-left:-3px" placeholder="Other..." ></div>';
                            }
                            break;
                        case 2:
                            if(array_key_exists($i."_0", $data)){
                                $lower = 0;
                            }
                            else{
                                $lower = 1;
                            }
                            for($j = 2; $j <=10; $j++){
                                if(array_key_exists($i."_".$j, $data))
                                $higher = $j;
                            }
                            echo '<div id="'.$i.'_range" style="width: 99%"></div>';
                            echo '<script>$("#'.$i.'_range").rangeSlider({ skin: "red", direction: "horizontal", tip:false, scale:true, type:"single",
                            }, { step: 1, min: '.$lower.', max: '.$higher.'});</script>';
                            echo '<div>
                            <div class="form-row">
                                <div class="col">
                                    <p>'.$data[$i.'_'.$lower].'</p>
                                </div>
                                <div class="col">
                                    <p class="text-right">'.$data[$i.'_'.$higher].'</p>
                                </div>
                            </div>
                        </div>';
                            break;
                        case 3:
                            echo '<textarea class="form-control" name="'.$i.'_0"></textarea>';
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