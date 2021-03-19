<link rel="stylesheet" href="<?php echo base_url('assets/css/Highlight-Blue.css')?>">
<script>
    $(document).ready(function(e){
        $(".other").change(function(){
            $(this).prev().val($(this).val());
            $(this).prev().attr('checked', 'checked')
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
                    $j = 1;
                    while(array_key_exists($i."_".$j, $data)){
                        echo '<div class="form-check" style="margin-left: 32px;"><input id="'.$i."_".$j.'" class="form-check-input" name="'.$i.'" type="radio" value="'.$i."_".$j.'"><label class="form-check-label" for="'.$i."_".$j.'" style="color: var(--gray-dark);">'.$data[$i."_".$j].'</label></div>';
                        $j++;
                    }
                    if(array_key_exists($i."_".'0', $data)){
                        echo '<div class="form-check" style="margin-left: 32px;"><input id="'.$i."_".'0" class="form-check-input" name="'.$i.'" type="radio"><input class="form-check-label other" type="text" for="'.$i."_".'0" style="background-color:#dddddd; border: none; margin-top: -8px; margin-left:-3px" placeholder="Other..." ></div>';
                    }
                    $i++;
                }
                ?>
            </div>
            <button class="btn btn-primary" type="submit" style="margin-top: 32px;">Answer</button>
        </form>
        </div>
    </div>