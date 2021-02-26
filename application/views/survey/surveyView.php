<?php 

    $surveyContent = unserialize($data);
    // foreach($surveyContent as $key => $value){
    //     echo $key.": ".$value."<br>";
    // }


?>
<link rel="stylesheet" href="http://127.0.0.1:8081/assets/css/Highlight-Blue.css">
<section class="highlight-blue">
        <div class="container">
            <div class="intro">
                <h2 class="text-center"><?php echo $name ?></h2>
            </div>
        </div>
    </section>
    <div style="background: #dddddd;min-height: 649px;">
        <div style="padding: 36px;padding-right: 36px;padding-left: 75px;">
        <form>
            <div class="form-group" style="color: var(--dark);">
                <?php
                    foreach($surveyContent as $key => $value){
                        if(strpos($key, "q") === 0){
                            echo '<label style="font-family: Nunito, sans-serif;font-size: 30px;color: #313437;">'.$value.'</label>';
                        }
                        else{
                            echo '<div class="form-check" style="margin-left: 32px;"><input class="form-check-input" name="'.$value.'" type="radio" id="formCheck-1"><label class="form-check-label" for="formCheck-1" style="color: var(--gray-dark);">'.$value.'</label></div>';
                        }
                    }
                ?>
            </div>
            <button class="btn btn-primary" type="submit" style="margin-top: 32px;">Answer</button>
        </form>
        </div>
    </div>