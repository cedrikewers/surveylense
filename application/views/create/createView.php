
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora">
<link rel="stylesheet" href="<?php echo base_url('assets/css/Highlight-Blue.css');?>">

<script>
    var answerCount = [1];
    $(document).ready(function(e){

        $("#addAnswer").click(function(){
            var questionNo = $(this).parent().attr("id").replace("answers", "") -1;
            answerCount[questionNo]++;
            var content = $("#answers"+(questionNo+1)).find("span").html();
            $("#answers"+(questionNo+1)).find("span").html(content +' <input id="question'+(questionNo+1)+'answer'+answerCount[questionNo]+'" class="form-control" type="text" style="max-width: 67.3%;margin: 5px;margin-left: 3%;" placeholder="Answer option '+answerCount[questionNo]+'...">');
        });

        $("#addQuestion").click(function(){
            answerCount.push(1);
            var content = $("#questions").html();
            $("#questions").html(content+'<br><label style="margin: 5px;margin-bottom: 2px;">Question'+answerCount.length+'</label><input class="form-control" type="text" style="min-width: 243px;max-width: 70%;margin: 5px;" placeholder="Enter your question here..."><span id="answers'+answerCount.length+'"><span><input id="question'+answerCount.length+'answer1" class="form-control" type="text" style="max-width: 67.3%;margin: 5px;margin-left: 3%;" placeholder="Answer option 1..."></span><button id="addAnswer" class="btn btn-primary" type="button" style="margin: 5px;margin-left: 3%;"><strong>Add answer option</strong></button></span>');
        });
    });
</script>

<div style="margin-bottom: 50px">
<div class="highlight-blue">
        <div class="container" style="height: 165px;">
            <div class="intro">
                <h2 class="text-center">Create a new Survey<br></h2>
                <p class="text-center"><br>To create new survey, simply hit the "+" button and add a question<br><br></p>
            </div>
        </div>
        <form style="margin: 0 24px;">
            <label>Survey name</label>
            <input class="form-control" type="text" style="min-width: 243px;max-width: 70%;margin: 5px;" placeholder="Enter the survey's name here...">
            <span id="questions">
                <label style="margin: 5px;margin-bottom: 2px;">Question 1</label>
                <input class="form-control" type="text" style="min-width: 243px;max-width: 70%;margin: 5px;" placeholder="Enter your question here...">
                    <span id="answers1">
                        <span>
                            <input id="question1answer1" class="form-control" type="text" style="max-width: 67.3%;margin: 5px;margin-left: 3%;" placeholder="Answer option 1...">
                        </span>
                        <button id="addAnswer" class="btn btn-primary" type="button" style="margin: 5px;margin-left: 3%;"><strong>Add answer option</strong></button>
                    </span>
            </span>
        </form>
    </div><button id="addQuestion" class="btn btn-primary" type="button" style="font-size: x-large;width: 50px;height: 50px;margin-top: -25px;margin-left: 12%;"><strong>+</strong></button>

