
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora">
<link rel="stylesheet" href="<?php echo base_url('assets/css/Highlight-Blue.css');?>">

<script src="<?php echo base_url('assets/js/create.js');?>"></script>
<script src="https://SortableJS.github.io/Sortable/Sortable.js"></script>

<script>
    var answerCount = [];
    $(document).ready(function(e){

        $(".highlight-blue").on("click", ".addAnswerOptionPreset", function(){
            var questionNumber = $(this).parent().attr('id').replace('question', '');
            answerCount[questionNumber-1]++; 
            $(this).parent().children(":first").next().children(":first").append(
                '<div class="form-row row-cols-2">'+
                    '<div class="col-11 col-xl-11"><input class="form-control" type="text" name="'+questionNumber+'_'+answerCount[questionNumber-1]+'" placeholder="Answer option '+answerCount[questionNumber-1]+'" style="margin-top: 10px;"></div>'+
                    '<div class="col-1 col-xl-1">'+
                    '<button class="btn btn-primary btn-sm align-items-md-end deleteAnswerOption" type="button" style="margin: 0;padding: 10px;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 1;margin-top: 11px;background: rgb(193,6,6);margin-left: -6px;"><i class="fas fa-times"></i></button></div>'+
                '</div>'
            );
            
        });

        $(".highlight-blue").on("click", ".addOthersPreset", function(){
            var questionNumber = $(this).parent().attr('id').replace('question', '');
            if($(this).parent().find(".others").length == 0){
                $(this).parent().children(":first").next().append(
                                '<div class="form-row row-cols-2">'+
                                    '<div class="col-11 col-xl-11"><input class="form-control others" name="'+questionNumber+'_others" type="text" placeholder="Others" style="margin-top: 10px;" readonly=""></div>'+
                                    '<div class="col-1 col-xl-1">'+
                                    '<button class="btn btn-primary btn-sm align-items-md-end deleteAnswerOption" type="button" style="margin: 0;padding: 10px;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 1;margin-top: 11px;background: rgb(193,6,6);margin-left: -6px;"><i class="fas fa-times"></i></button></div>'+
                                '</div>'
                );
            }
            
        });

        $('#manageQuestions').click(function(){
            $.post(
                '<?php echo site_url('userarea/manageQuestions')?>',
                {
                    order: manageQuestions.toArray(),
                    randomId: '<?php echo $surveyTemp['randomId']; ?>'
                },
                location.reload()
            )
        });

        $('.confirmDeletion').click(function(){
            $(this).parent().append('<button class="btn btn-primary btn-sm align-items-md-end deleteQuestionModal" type="button" style="background: rgb(193,6,6);float: right;border-color:white;">Do you really want to delete the question? This cannot be undone. If so, please click this button again.</button');
            $(this).hide();
        });

        $(".modal").on("click", ".deleteQuestionModal", function(){
            var number = $(this).parent().attr('data-id');
            $.post(
                '<?php echo site_url('userarea/deleteQuestionModal')?>',
                {
                    number: number,
                    randomId: '<?php echo $surveyTemp['randomId']; ?>'
                }, 
                $(this).parent().hide()

            )
            
        });

    });

</script>


<section class="highlight-blue" style="background-color: 8BD8FF;">
        <div class="container">
            <div class="intro">
                <h2 class="text-center">Edit a new Survey</h2>
                <p class="text-center">You can edit this survey by changing the questions or answers. Please notice, that this can cause problems with the results if people already answered this survey. To delete questions or change their order, click on 'Manage Questions' below. Changing the order works via drag and drop.
                </p>
            </div>
            <div class="buttons">
                <form class="text-left" action="<?php echo site_url('userarea/updateSurvey')?>" method="post">
                <input type="hidden" name="randomId" value="<?php echo $surveyTemp['randomId']; ?>">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col text-left"><label>Name</label><input class="form-control" type="text" required="" name="name" placeholder="Give your survey a name" value="<?php echo $surveyTemp['name']?>"><label>Description</label><textarea class="form-control" name="description" placeholder="Tell them what this survey is about" ><?php echo $surveyTemp['description']?></textarea></div>
                            <div class="col-xl-3 text-left"><label>Visibility</label><select class="custom-select" name="visibility">
                                    <?php 
                                        if($surveyTemp['visibility'] == "private"){
                                            echo'<option value="private" selected>Private</option>
                                                <option value="public">Public</option>';
                                        }
                                        else{
                                            echo'<option value="private">Private</option>
                                                <option value="public" selected>Public</option>';
                                        }
                                    ?>
                                    
                                </select></div>
                        </div>
                        <span id="questions">
                            <?php 
                            if(isset($surveyTemp['questions'])){
                                foreach($surveyTemp['questions'] as $question){
                                    echo '<script>answerCount.push(0);</script>';                                    
                                    $select = array("Single Choice", "Multiple Choice", "Scale", "Text");
                                    echo'
                                    <div id="question'.$question['number'].'">
                                    <div class="form-row row-cols-md-2 row-cols-lg-3 row-cols-xl-3">
                                        <div class="col-md-12 col-lg-8 col-xl-8"><label>Question '.$question['number'].'</label><input class="form-control" name="q'.$question['number'].'" type="text" placeholder="Question '.$question['number'].'" value="'.$question['data'].'"></div>
                                        <div class="col-md-12 col-lg-3 col-xl-3 d-lg-flex d-xl-flex align-items-lg-end align-items-xl-end"><select disabled class="custom-select type" style="margin-top: 10px;">
                                                <option>'.$select[$question['type']].'</option>
                                            </select>
                                            <input type="hidden" name="'.$question['number'].'_type" value="'.$question['type'].'">
                                        </div>
                                        </div>
                                    <div style="margin-left: 1%;"><span class="answerOptions">';
                                    switch($question['type']){
                                        case 0:
                                        case 1:
                                            $i = 1;
                                            while(array_key_exists($i, $question['answers'])){
                                                echo '<script>answerCount['.$question['number'].'-1]++;</script>';
                                                echo '
                                                    <span id="answerOption'.$i.'">
                                                        <div class="form-row row-cols-2">
                                                            <div class="col-11 col-xl-11"><input class="form-control" type="text" name="'.$question['number'].'_'.$i.'" placeholder="Answer option '.$i.'" style="margin-top: 10px;" value="'.$question['answers'][$i].'"></div>
                                                            <div class="col-1 col-xl-1">
                                                            <button class="btn btn-primary btn-sm align-items-md-end deleteAnswerOption" type="button" style="margin: 0;padding: 10px;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 1;margin-top: 11px;background: rgb(193,6,6);margin-left: -6px;"><i class="fas fa-times"></i></button></div>
                                                        </div>
                                                    </span> ';
                                                $i++;
                                            }
                                            echo '</span>';
                                            if(isset($question['answers'][0])){
                                                echo '<div class="form-row row-cols-2">
                                                        <div class="col-11 col-xl-11"><input class="form-control others" name="'.$question['number'].'_others" type="text" placeholder="Others" style="margin-top: 10px;" readonly=""></div>
                                                        <div class="col-1 col-xl-1">
                                                        <button class="btn btn-primary btn-sm align-items-md-end deleteAnswerOption" type="button" style="margin: 0;padding: 10px;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 1;margin-top: 11px;background: rgb(193,6,6);margin-left: -6px;"><i class="fas fa-times"></i></button></div>
                                                    </div>';
                                            }
                                            echo '</div><button class="btn btn-primary text-capitalize d-none d-lg-inline addAnswerOptionPreset" type="button" style="background: var(--indigo);">Add Answer option</button><button class="btn btn-primary text-capitalize d-lg-none addAnswerOptionPreset" type="button" style="background: var(--indigo);"><i class="fas fa-plus-circle"></i></button><button class="btn btn-primary text-capitalize addOthersPreset" type="button" style="background: var(--purple);">Add "Others"</button><button class="btn btn-primary text-capitalize d-lg-none delQuestion2" type="button" style="background: rgb(255,0,0);"><i class="fas fa-trash"></i></button>';
                                            break;
                                        case 2:
                                            $selected = array("", "", "", "", "", "", "", "", "", "", "",);
                                            $lowerHigher = array();
                                            foreach($question['answers'] as $key => $value){
                                                $selected[$key] = 'selected';
                                                array_push($lowerHigher, $key);
                                            }
                                            echo '<div class="form-row row-cols-2">
                                            <div class="col-3 col-sm-2 col-md-2 col-lg-1 col-xl-1"><select name="'.$question['number'].'_lower" class="form-control labelLower" onchange="changeScale($(this))">
                                                    <option value="0" '.$selected[0].'>0</option>
                                                    <option value="1" '.$selected[1].'>1</option>
                                                 </select></div>
                                            <div class="col-3 col-md-2 col-lg-1 col-xl-1 d-flex d-lg-flex justify-content-lg-center align-items-lg-end"><label class="col-form-label">to</label></div>
                                            <div class="col-3 col-sm-2 col-md-2 col-lg-1 col-xl-1"><select class="form-control labelHigher" name="'.$question['number'].'_higher" onchange="changeScale($(this))">
                                                    <option value="2" '.$selected[2].'>2</option>
                                                    <option value="3" '.$selected[3].'>3</option>
                                                    <option value="4" '.$selected[4].'>4</option>
                                                    <option value="5" '.$selected[5].'>5</option>
                                                    <option value="6" '.$selected[6].'>6</option>
                                                    <option value="7" '.$selected[7].'>7</option>
                                                    <option value="8" '.$selected[8].'>8</option>
                                                    <option value="9" '.$selected[9].'>9</option>
                                                    <option value="10"'.$selected[10].'>10</option>
                                                </select></div>
                                        </div>
                                        <div class="form-row row-cols-2">
                                            <div class="col-1 col-xl-1 text-right"><label class="labelLower" style="width: 100%;margin-top: 17px;">'.current($lowerHigher).'</label><label class="labelHigher" style="margin-top: 17px;">'.next($lowerHigher).'</label></div>
                                            <div class="col-11 col-xl-10 offset-xl-0"><input class="form-control" type="text" placeholder="Label (optional)" style="margin-top: 10px;" name="'.$question['number'].'_labelLower" value="'.current($question['answers']).'"><input class="form-control" type="text" placeholder="Label (optional)" style="margin-top: 10px;" name="'.$question['number'].'_labelHigher" value="'.next($question['answers']).'"></div>
                                        </div><button class="btn btn-primary text-capitalize d-lg-none delQuestion2" type="button" style="background: rgb(255,0,0);"><i class="fas fa-trash"></i></button>
                                        </div>';
                                            break;
                                        case 3:
                                        }

                                    echo '</div>';
                                }
                            }
                            else{
                                echo 'Oops. Something may not be displayed correctly here. Please reload the page or contact support if the problem persists.';
                            }
                            ?>
                        </span>
                    </div>
                    <button class="btn btn-light manageQuestionModal" type="button" style="background-color: #f8f9fa; border-color: #f8f9fa;" data-toggle="modal" data-target="#manageQuestionsModal">Manage Questions</button>
            </div>
        </div>
</section>
            <div style="display: flex; align-items: center; width: 100%; flex-direction: column; margin-bottom: 64px;">
                <button id="addQuestion" class="btn btn-primary" type="button" style="font-size: x-large;width: 50px;height: 50px;margin-top: -25px; margin-left: -40%"><strong>+</strong></button><br>
                <button class="btn btn-primary" type="submit" style="background: var(--purple);font-size: 19px;">Update survey</button>
            </div>

        </form>

<!-- Modal -->
<div class="modal fade" id="manageQuestionsModal" tabindex="-1" aria-labelledby="manageQuestionsModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Manage Question</h5>
        <button type="button" class="btn btn-light" aria-label="Close" data-toggle="modal" data-target="#manageQuestionsModal">X</button>
      </div>
      <div class="modal-body">
        <ul id="orderQuestions" class="list-group">
            <?php 
            
            foreach($surveyTemp['questions'] as $question){
                $name = substr($question['data'], 0, 40);
                if($name != $question['data']){
                    $name .= '...';
                }
                echo '<li class="list-group-item" data-id="'.$question['number'].'" style="cursor:pointer">'.$name.'
                <button class="btn btn-primary btn-sm align-items-md-end confirmDeletion" type="button" style="background: rgb(193,6,6);float: right;border-color:white;"><i class="fas fa-trash"></i></button></li>';
            }
            
            ?>
        </ul>
        <script>var manageQuestions = Sortable.create(document.getElementById('orderQuestions'));</script>
        <p id="test"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="manageQuestions">Save changes</button>
      </div>
    </div>
  </div>
</div>





