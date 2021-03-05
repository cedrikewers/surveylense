<link rel="stylesheet" href="<?php echo base_url('assets/css/Highlight-Blue.css')?>">
<section class="highlight-blue">
        <div class="container">
            <div class="intro">
                <h2 class="text-center"><?php echo $name ?></h2>
            </div>
        </div>
    </section>
    <div style="background: #dddddd;min-height: 649px;">
        <div style="padding: 36px;padding-right: 36px;padding-left: 75px;">
        <form action="<?php echo(site_url('survey/storeAnswers'))?>" method="post">
            <div class="form-group" style="color: var(--dark);">
                <?php
                echo '<input name="randomId" value="'.$randomId.'" style="display:none">';
                $i = 1;
                while(array_key_exists('q'.$i, $data)){
                    echo '<label style="font-family: Nunito, sans-serif;font-size: 30px;color: #313437;">'.$data['q'.$i].'</label>';
                    $j = 1;
                    while(array_key_exists($i."_".$j, $data)){
                        echo '<div class="form-check" style="margin-left: 32px;"><input id="'.$i."_".$j.'" class="form-check-input" name="'.$i.'" type="radio" value="'.$i."_".$j.'"><label class="form-check-label" for="'.$i."_".$j.'" style="color: var(--gray-dark);">'.$data[$i."_".$j].'</label></div>';
                        $j++;
                    }
                    $i++;
                }
                ?>
            </div>
            <button class="btn btn-primary" type="submit" style="margin-top: 32px;">Answer</button>
        </form>
        </div>
    </div>