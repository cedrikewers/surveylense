var answerCount = [1];
$(document).ready(function(e){

    $(".highlight-blue").on("click", ".addAnswerOption", function(){
        var questionNumber = $(this).parent().parent().attr('id').replace('question', '');//holt die Fragennummer über die ID des umschließenden <div>-Objekts
        answerCount[questionNumber-1]++; 
        $(this).parent().children(":first").append(
            '<div class="form-row row-cols-2">'+
                '<div class="col-11 col-xl-11"><input class="form-control" type="text" name="'+questionNumber+'_'+answerCount[questionNumber-1]+'" placeholder="Answer option '+answerCount[questionNumber-1]+'" style="margin-top: 10px;"></div>'+
                '<div class="col-1 col-xl-1">'+
                '<button class="btn btn-primary btn-sm align-items-md-end deleteAnswerOption" type="button" style="margin: 0;padding: 10px;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 1;margin-top: 11px;background: rgb(193,6,6);margin-left: -6px;"><i class="fas fa-times"></i></button></div>'+
            '</div>'
        );
        
    });

    $(".highlight-blue").on("click", ".addOthers", function(){
        if($(this).parent().find(".others").length == 0){
            var questionNumber = $(this).parent().parent().attr('id').replace('question', '');//holt die Fragennummer über die ID des umschließenden <div>-Objekts
            $(this).parent().children(":first").append(
                '<div class="form-row row-cols-2">'+
                    '<div class="col-11 col-xl-11"><input class="form-control others" name="'+questionNumber+'_others" type="text" placeholder="Others" style="margin-top: 10px;" readonly=""></div>'+
                    '<div class="col-1 col-xl-1">'+
                    '<button class="btn btn-primary btn-sm align-items-md-end deleteAnswerOption" type="button" style="margin: 0;padding: 10px;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 1;margin-top: 11px;background: rgb(193,6,6);margin-left: -6px;"><i class="fas fa-times"></i></button></div>'+
                '</div>'
            );
        }
        
    });

    $(".highlight-blue").on("click", ".deleteAnswerOption", function(){
        $(this).parent().parent().remove();
    });

    $("#addQuestion").click(function(){
        answerCount.push(1);
        $("#questions").append('<div id="question'+answerCount.length+'">'+
                            '<div class="form-row row-cols-md-2 row-cols-lg-3 row-cols-xl-3">'+
                                '<div class="col-md-12 col-lg-8 col-xl-8"><label>Question '+answerCount.length+'</label><input class="form-control" name="q'+answerCount.length+'" type="text" placeholder="Question '+answerCount.length+'"></div>'+
                                '<div class="col-md-12 col-lg-3 col-xl-3 d-lg-flex d-xl-flex align-items-lg-end align-items-xl-end"><select class="custom-select" onchange="changeType($(this))" name="'+answerCount.length+'_type"style="margin-top: 10px;">'+
                                        '<option value="0" selected>Single Choice</option>'
                                        +'<option value="1">Multiple Choice</option>'
                                        +'<option value="2">Scale</option>'
                                        +'<option value="3">Text</option>'
                                +'</select></div>'
                            +'<div class="col-lg-1 col-xl-1 order-2"><button class="btn btn-primary btn-sm d-none d-print-block d-sm-none d-md-none d-lg-block d-xl-block align-items-md-end delQuestion" type="button" style="margin: 0;padding: 10px;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 1;margin-top: 33px;background: #ff0000;margin-left: -6px;"><i class="fas fa-trash"></i></button></div>'
                                +'</div>'
                                +'<div style="margin-left: 1%;">'
                                    +'<span id="answerOption1">'
                                        +'<div class="form-row row-cols-2">'
                                        +'<div class="col-11 col-xl-11"><input class="form-control" type="text" name="'+answerCount.length+'_1" placeholder="Answer option 1" style="margin-top: 10px;"></div>'
                                        +'<div class="col-1 col-xl-1">'
                                    +'<button class="btn btn-primary btn-sm align-items-md-end deleteAnswerOption" type="button" style="margin: 0;padding: 10px;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 1;margin-top: 11px;background: rgb(193,6,6);margin-left: -6px;"><i class="fas fa-times"></i></button></div>'
                                    +'</div>'
                                    +'</span>'
                                +'<button class="btn btn-primary text-capitalize d-none d-lg-inline addAnswerOption" type="button" style="background: var(--indigo);">Add Answer option</button><button class="btn btn-primary text-capitalize d-lg-none addAnswerOption" type="button" style="background: var(--indigo);"><i class="fas fa-plus-circle"></i></button><button class="btn btn-primary text-capitalize addOthers" type="button" style="background: var(--purple);">Add "Others"</button><button class="btn btn-primary text-capitalize d-lg-none delQuestion2" type="button" style="background: rgb(255,0,0);"><i class="fas fa-trash"></i></button>'
                            +'</div>'
                        +'</div>');
    });

    $(".highlight-blue").on("click", ".delQuestion", function(){
        $(this).parent().parent().parent().remove();
    });

    $(".highlight-blue").on("click", ".delQuestion2", function(){
        $(this).parent().parent().remove();
    });

});

function changeType(pThis){//ändert den Inhalt eiern Frage entsprechend nach Typ
    var val = $(pThis).val();
    var questionNumber = $(pThis).parent().parent().parent().attr('id').replace('question', '');//holt die Fragennummer über die ID des umschließenden <div>-Objekts
    switch (parseInt(val)){
        case 3: //Es ist eine Frage mit dem "text" Type
            $(pThis).parent().parent().next().html('<button class="btn btn-primary text-capitalize d-lg-none delQuestion2" type="button" style="background: rgb(255,0,0);"><i class="fas fa-trash"></i></button>');
            break;
        case 2://Es ist eine Frage mit dem "scale" Type
            $(pThis).parent().parent().next().html(''+
                        '<div class="form-row row-cols-2">'
                            +'<div class="col-3 col-sm-2 col-md-2 col-lg-1 col-xl-1"><select name="'+questionNumber+'_lower" class="form-control labelLower" onchange="changeScale($(this))">'
                                    +'<option value="0">0</option>'
                                    +'<option value="1" selected="">1</option>'
                                +' </select></div>'
                            +'<div class="col-3 col-md-2 col-lg-1 col-xl-1 d-flex d-lg-flex justify-content-lg-center align-items-lg-end"><label class="col-form-label">to</label></div>'
                            +'<div class="col-3 col-sm-2 col-md-2 col-lg-1 col-xl-1"><select class="form-control labelHigher" name="'+questionNumber+'_higher" onchange="changeScale($(this))">'
                                    +'<option value="2">2</option>'
                                    +'<option value="3">3</option>'
                                    +'<option value="4">4</option>'
                                    +'<option value="5">5</option>'
                                    +'<option value="6">6</option>'
                                    +'<option value="7">7</option>'
                                    +'<option value="8">8</option>'
                                    +'<option value="9">9</option>'
                                    +'<option value="10" selected="">10</option>'
                                +'</select></div>'
                        +'</div>'
                        +'<div class="form-row row-cols-2">'
                            +'<div class="col-1 col-xl-1 text-right"><label class="labelLower" style="width: 100%;margin-top: 17px;">1</label><label class="labelHigher" style="margin-top: 17px;">10</label></div>'
                            +'<div class="col-11 col-xl-10 offset-xl-0"><input class="form-control" type="text" placeholder="Label (optional)" style="margin-top: 10px;" name="'+questionNumber+'_labelLower"><input class="form-control" type="text" placeholder="Label (optional)" style="margin-top: 10px;" name="'+questionNumber+'_labelHigher"></div>'
                        +'</div><button class="btn btn-primary text-capitalize d-lg-none delQuestion2" type="button" style="background: rgb(255,0,0);"><i class="fas fa-trash"></i></button>'
                    +'</div>');
            break;
        case 0://Es ist eine Frage mit dem "single choice" oder "multible choice" Type
        case 1:
            $(pThis).parent().parent().next().html(''
                                +'<span id="answerOption1">'
                                    +'<div class="form-row row-cols-2">'
                                        +'<div class="col-11 col-xl-11"><input class="form-control" type="text" name="'+questionNumber+'_1" placeholder="Answer option 1" style="margin-top: 10px;"></div>'
                                        +'<div class="col-1 col-xl-1">'
                                        +'<button class="btn btn-primary btn-sm align-items-md-end deleteAnswerOption" type="button" style="margin: 0;padding: 10px;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 1;margin-top: 11px;background: rgb(193,6,6);margin-left: -6px;"><i class="fas fa-times"></i></button></div>'
                                    +'</div>'
                                +'</span> '
                                +'<button class="btn btn-primary text-capitalize d-none d-lg-inline addAnswerOption" type="button" style="background: var(--indigo);">Add Answer option</button><button class="btn btn-primary text-capitalize d-lg-none addAnswerOption" type="button" style="background: var(--indigo);"><i class="fas fa-plus-circle"></i></button><button class="btn btn-primary text-capitalize addOthers" type="button" style="background: var(--purple);">Add "Others"</button><button class="btn btn-primary text-capitalize d-lg-none delQuestion2" type="button" style="background: rgb(255,0,0);"><i class="fas fa-trash"></i></button>');
            break;
    } 
}

function changeScale(pThis){//die Funktion ist dafür zuständig, dass sich die label beim "Scale" typ auch ändern
    var name = $(pThis).attr("class").split(" ")[1]; //nimmt die zweite Klasse, entweder labelLower/labelHigher
    $("label."+name).html($(pThis).val());           //setzt den Wert des labels auf den gerade ausgewählten Wert
}