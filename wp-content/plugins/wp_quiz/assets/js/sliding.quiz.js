var smoke={smoketimeout:[],init:!1,zindex:1e3,i:0,bodyload:function(a){var b=document.createElement("div");b.setAttribute("id","smoke-out-"+a),b.className="smoke-base",b.style.zIndex=smoke.zindex,smoke.zindex++,document.body.appendChild(b)},newdialog:function(){var a=(new Date).getTime();return a=Math.random(1,99)+a,smoke.init?smoke.bodyload(a):smoke.listen(window,"load",function(){smoke.bodyload(a)}),a},forceload:function(){},build:function(a,b){smoke.i++,b.stack=smoke.i,a=a.replace(/\n/g,"<br />"),a=a.replace(/\r/g,"<br />");var h,c="",d="X",e="Cancel",f="",g="";"prompt"===b.type&&(c='<div class="dialog-prompt"><input id="dialog-input-'+b.newid+'" type="text" '+(b.params.value?'value="'+b.params.value+'"':"")+" />"+"</div>"),b.params.ok&&(d=b.params.ok),b.params.cancel&&(e=b.params.cancel),b.params.classname&&(f=b.params.classname),"signal"!==b.type&&(g='<div class="dialog-buttons">',"alert"===b.type?g+='<button id="alert-ok-'+b.newid+'">'+d+"</button>":("prompt"===b.type||"confirm"===b.type)&&(g+=b.params.reverseButtons?'<button id="'+b.type+"-ok-"+b.newid+'">'+d+"</button>"+'<button id="'+b.type+"-cancel-"+b.newid+'" class="cancel">'+e+"</button>":'<button id="'+b.type+"-cancel-"+b.newid+'" class="cancel">'+e+"</button>"+'<button id="'+b.type+"-ok-"+b.newid+'">'+d+"</button>"),g+="</div>"),h='<div id="smoke-bg-'+b.newid+'" class="smokebg"></div>'+'<div class="dialog smoke '+f+'">'+g+'<div class="dialog-inner">'+a+c+"</div>"+"</div>",smoke.init?smoke.finishbuild(a,b,h):smoke.listen(window,"load",function(){smoke.finishbuild(a,b,h)})},finishbuild:function(a,b,c){var d=document.getElementById("smoke-out-"+b.newid);for(d.className="smoke-base smoke-visible  smoke-"+b.type,d.innerHTML=c;""===d.innerHTML;)d.innerHTML=c;switch(smoke.smoketimeout[b.newid]&&clearTimeout(smoke.smoketimeout[b.newid]),smoke.listen(document.getElementById("smoke-bg-"+b.newid),"click",function(){smoke.destroy(b.type,b.newid),"prompt"===b.type||"confirm"===b.type?b.callback(!1):"alert"===b.type&&b.callback!==void 0&&b.callback()}),b.type){case"alert":smoke.finishbuildAlert(a,b,c);break;case"confirm":smoke.finishbuildConfirm(a,b,c);break;case"prompt":smoke.finishbuildPrompt(a,b,c);break;case"signal":smoke.finishbuildSignal(a,b,c);break;default:throw"Unknown type: "+b.type}},finishbuildAlert:function(a,b){smoke.listen(document.getElementById("alert-ok-"+b.newid),"click",function(){smoke.destroy(b.type,b.newid),b.callback!==void 0&&b.callback()}),document.onkeyup=function(a){a||(a=window.event),(13===a.keyCode||32===a.keyCode||27===a.keyCode)&&(smoke.destroy(b.type,b.newid),b.callback!==void 0&&b.callback())}},finishbuildConfirm:function(a,b){smoke.listen(document.getElementById("confirm-cancel-"+b.newid),"click",function(){smoke.destroy(b.type,b.newid),b.callback(!1)}),smoke.listen(document.getElementById("confirm-ok-"+b.newid),"click",function(){smoke.destroy(b.type,b.newid),b.callback(!0)}),document.onkeyup=function(a){a||(a=window.event),13===a.keyCode||32===a.keyCode?(smoke.destroy(b.type,b.newid),b.callback(!0)):27===a.keyCode&&(smoke.destroy(b.type,b.newid),b.callback(!1))}},finishbuildPrompt:function(a,b){var d=document.getElementById("dialog-input-"+b.newid);setTimeout(function(){d.focus(),d.select()},100),smoke.listen(document.getElementById("prompt-cancel-"+b.newid),"click",function(){smoke.destroy(b.type,b.newid),b.callback(!1)}),smoke.listen(document.getElementById("prompt-ok-"+b.newid),"click",function(){smoke.destroy(b.type,b.newid),b.callback(d.value)}),document.onkeyup=function(a){a||(a=window.event),13===a.keyCode?(smoke.destroy(b.type,b.newid),b.callback(d.value)):27===a.keyCode&&(smoke.destroy(b.type,b.newid),b.callback(!1))}},finishbuildSignal:function(a,b){smoke.smoketimeout[b.newid]=setTimeout(function(){smoke.destroy(b.type,b.newid)},b.timeout)},destroy:function(a,b){var c=document.getElementById("smoke-out-"+b),d=document.getElementById(a+"-ok-"+b),e=document.getElementById(a+"-cancel-"+b);c.className="smoke-base",d&&(smoke.stoplistening(d,"click",function(){}),document.onkeyup=null),e&&smoke.stoplistening(e,"click",function(){}),smoke.i=0,c.innerHTML=""},alert:function(a,b,c){"object"!=typeof b&&(b=!1);var d=smoke.newdialog();smoke.build(a,{type:"alert",callback:c,params:b,newid:d})},signal:function(a,b){b===void 0&&(b=5e3);var c=smoke.newdialog();smoke.build(a,{type:"signal",timeout:b,params:!1,newid:c})},confirm:function(a,b,c){"object"!=typeof c&&(c=!1);var d=smoke.newdialog();smoke.build(a,{type:"confirm",callback:b,params:c,newid:d})},prompt:function(a,b,c){"object"!=typeof c&&(c=!1);var d=smoke.newdialog();return smoke.build(a,{type:"prompt",callback:b,params:c,newid:d})},listen:function(a,b,c){return a.addEventListener?a.addEventListener(b,c,!1):a.attachEvent?a.attachEvent("on"+b,c):!1},stoplistening:function(a,b,c){return a.removeEventListener?a.removeEventListener("click",c,!1):a.detachEvent?a.detachEvent("on"+b,c):!1}};smoke.init||smoke.listen(window,"load",function(){smoke.init=!0});

jQuery(document).ready(function() {
    jQuery.noConflict();

    jQuery.sliding_quiz = {
        version: '1.0'
    };
    jQuery.fn.sliding_quiz = function(config){
        config = jQuery.extend({}, {
            quiz_id: null,
            instruction: null,
            questions: null,
            locale: null,
            show_contact_form : false,
            hint: 2,
            contact_redirect : '',
            effect: 'slide',
            callback: function() {}
        }, config);

        //check question
        if(config.questions == null || config.questions == undefined){
            return false;
        }
        // initial container object
        var container = jQuery(this);
        container.addClass('quiz-content');


        //set locale
        var locale = {
            'msg_not_found' : 'Cannot find questions',
            'msg_please_select_an_option' : 'Please select an option',
            'msg_question' : 'Question',
            'msg_you_scored' : 'Correct: %correct%/%total% questions (%percent%)',
            'msg_share_scored' : 'Hurray! I reached high score',
            'msg_click_to_review' : 'Click to Question button to review your answers',
            'bt_start' : 'Start',
            'bt_next' : 'Next',
            'bt_back' : 'Back',
            'bt_finish' : 'Finish',
            'result_comment_perfect' : 'Perfect!',
            'result_comment_excellent' : 'Excellent!',
            'result_comment_good' : 'Good!',
            'result_comment_average' : 'Average!',
            'result_comment_bad' : 'Bad!',
            'result_comment_poor' : 'Poor!',
            'result_comment_worst' : 'Worst!',
            'hint' : 'Hint',
            'contact_heading' : 'Submit Your Score',
            'contact_name' : 'Name',
            'contact_email' : 'Email',
            'contact_phone' : 'Phone',
            'contact_message' : 'Message',
            'contact_show_form_button' : 'Submit Your Score',
            'contact_submit_button' : 'Submit',
            'contact_thankyou' : 'Thank you for your submission.'
        };

        if(config.locale != null){
            jQuery.each(locale, function(index, value) {
                if(config.locale[index] == undefined){
                    config.locale[index] = value;
                }
            })
        }else{
            config.locale = locale;
        }

        // Function to get the Max value in Array
        Array.max = function( array ){
            return Math.max.apply( Math, array );
        };

        /*Initial question*/
        if (config.questions.length === 0) {
            container.html('<div class="quiz-wrapper"><div class="steps"><form id="formElem" name="formElem" action="" method="post"><fieldset class="step"><legend><div>'+config.locale['msg_not_found']+'</div></legend></fieldset></form></div></div>');
            return;
        }

        var welcomePage = '';
        if(config.instruction != null){
            welcomePage = '<div class="quiz-wrapper" id="quiz-instruction-container">\n\
                    <div class="steps">\n\
                    <form>\n\
                    <fieldset class="step"><legend><div>' + config.instruction['title']+'</div></legend><div style="padding: 20px 10px;">'+config.instruction['description']+'</div></fieldset></form></div>\n\
                    <div id="quiz-navigation" style=""><ul><li class="hidden"><a href="#">&nbsp;</a></li><li class="hidden"><a href="#">&nbsp;</a></li><li><a href="javascript:;;" id="btn-start-quiz">'+config.locale['bt_start']+'</a></ul></div>\n\
                    </div>';
            container.html(welcomePage);

            /*
            *bind Start button click
            */
            container.find('#btn-start-quiz').bind('click', function(){
                runQuiz();
                container.find('#quiz-instruction-container').fadeOut(500, function() {

                });
            });
        }else{
            runQuiz();
        }

        function runQuiz(){
            // number of questions
            var numOfQuestions = config.questions.length;

            // array user choice answer
            var userAnswers = [];
            // array user choice answer for email
            var userAnswersForEmail = [];
            /*
            current position of fieldset / navigation link
            */
            var current     = 1;

            var competitionForm = '<fieldset class="step" style="display:none">\n\
            <legend><div>'+config.locale['contact_heading']+'</div></legend>\n\
                    <table width="100%" class="competition-form" border="0" cellpadding="0" cellspacing="10">\n\
                        <tr><td width="1%" nowrap="">'+config.locale['contact_name']+'*</td><td align="right"><input type="text" class="required letters_only" id="competitionName"/></td></tr>\n\
                        <tr><td width="1%" nowrap="">Apellido*</td><td align="right"><input type="text" class="required letters_only" id="competitionApellido"/></td></tr>\n\
                        <tr><td width="1%" nowrap="">'+config.locale['contact_email']+'*</td><td align="right"><input type="text" id="competitionEmail"/></td></tr>\n\
                        <tr><td width="1%" nowrap="">'+config.locale['contact_phone']+'</td><td align="right"><input type="text" class="required" id="competitionPhone"/></td></tr>\n\
                        <tr><td width="1%" nowrap="">'+config.locale['contact_message']+'</td><td align="right"><input type="text" id="competitionMessage"/></td></tr>\n\
                    </table>\n\
            </fieldset>';

            // var showQuiz = (welcomePage == '')  ? 'show_container' : 'hide_container';
            var quizContent = '<div class="quiz-wrapper '+config.effect+'"><div class="steps"><form id="formElem" name="formElem" action="" method="post">';
            for (questionIdx = 0; questionIdx < numOfQuestions; questionIdx++) {
                if(config.questions[questionIdx] != undefined){
                    show = (questionIdx==0) ? "show" : "";
                    var $maxScore = Array.max(config.questions[questionIdx].weight);
                    var $holderQuestion = jQuery('<div>');
                    // config.questions[questionIdx].question.replace(/\n/g, "<br>");
                    $holderQuestion.append(config.questions[questionIdx].question);

                    var $formatQuestion = $holderQuestion.html();
                    // $formatQuestion = $formatQuestion.replace(/\n/g, "<br />");
                    // $formatQuestion = $formatQuestion.replace("<br>", "&lt;br&gt;");
                    // $formatQuestion = $formatQuestion.replace(/\n/g, "&lt;br&gt;");
                    $formatQuestion = jQuery('<div>').append($formatQuestion);
                    $formatQuestion.find('img').remove();
                    $formatQuestion.find('iframe').remove();
                    $formatQuestion = $formatQuestion.html();

                    quizContent += '<fieldset class="step '+show+'" question="'+(questionIdx+1)+'" choice=""><legend><div>'+$formatQuestion+'</div></legend>';
                    //get image and iframe in question and print it to body
                    if($holderQuestion.find('img').length){
                        //get all src of image in holderQuestion
                        $holderQuestion.find('img').each(function(){
                            var src = jQuery(this).attr('src');
                            var width = jQuery(this).attr('width');
                            var height = jQuery(this).attr('height');
                            var style = jQuery(this).attr('style');
                            quizContent += '<img src="'+src+'" width="'+width+'" height="'+height+'" style="'+style+'">';
                        });

                        $holderQuestion.find('img').remove();
                    }

                    if($holderQuestion.find('iframe').length){
                        $holderQuestion.find('iframe').each(function(){
                            var src = jQuery(this).attr('src');
                            var width = jQuery(this).attr('width');
                            var height = jQuery(this).attr('height');
                            quizContent += '<iframe src="'+src+'" frameborder="" width="'+width+'" height="'+height+'"></iframe>';
                        });

                        $holderQuestion.find('iframe').remove();

                    }
                    /*Check correct*/
                    var checkCorrectId = 'check-correct-' + (questionIdx + 1);
                    var checkCorrectPopup = '<div id="' + checkCorrectId+'" class="final-result">';
                    checkCorrectPopup += '<h3>'+config.questions[questionIdx].question+'</h3>';

                    for (answerIdx = 0; answerIdx < config.questions[questionIdx].answers.length; answerIdx++) {

                        var rightOrwrong = '';
                        if (config.questions[questionIdx].weight[answerIdx] == $maxScore) {
                            rightOrwrong += 'right';
                        }
                        quizContent += '<p data-correct="' + rightOrwrong + '" answer="'+(answerIdx+1)+'">'+config.questions[questionIdx].answers[answerIdx]+'</p>';
                        checkCorrectPopup += '<p class="' + rightOrwrong + '">' + config.questions[questionIdx].answers[answerIdx] + '</p>';
                    }
                    checkCorrectPopup += '</div>';

                    // explanation
                    explain = config.questions[questionIdx].explanation;
                    if(typeof explain == 'undefined' || explain ==''){
                        explain = '';
                    }else{
                        explain = '<div class="explanation-box"><div class="explanation-content">'+config.questions[questionIdx].explanation+'</div></div>';
                    }
                    var $hintButton = (config.hint > 0) ? '<span class="label label-info" data-id="' + checkCorrectId+'" class="check-correct">'+config.locale['hint']+' (<span class="hint-number">'+config.hint+'</span>)</span>' : '';
                    quizContent += checkCorrectPopup+explain+'<div class="check-correct">'+$hintButton+'</div>'+'</fieldset>';
                };
            }
            NextFinishButton = '<a href="javascript:;;" id="next-quiz">'+config.locale['bt_next']+'</a><a href="javascript:;;" id="finish-quiz" style="display: none;">'+config.locale['bt_finish']+'</a>';
            if(numOfQuestions == 1){
                NextFinishButton = '<a href="javascript:;;" id="finish-quiz">'+config.locale['bt_finish']+'</a>';
            }
            quizContent += '</form></div><div id="quiz-navigation" style="display:none;"><ul><li class="disabled"><a href="javascript:;;" id="back-quiz">'+config.locale['bt_back']+'</a></li><li class="page-number"><a href="javascript:;;">1/'+numOfQuestions+'</a></li><li class=""><span id="quiz-notice" class="label label-important"><i class="qicon-exclamation-sign qicon-white"></i> '+config.locale['msg_please_select_an_option']+'</span>'+NextFinishButton+'</li></ul></div><div class="progress-container"><div class="progress"></div></div></div></div>';
            container.html(quizContent);


            //bind check correct click
            // var $quizNavigationHeight = container.find('#quiz-navigation').height();
            // var $quizProgressHeight = container.find('.progress-container').height();
            container.find('.check-correct').click(function(){
                if(config.hint == 0){
                    return false;
                }
                //show explanation
                var $explanationBox = jQuery(this).prev('.explanation-box');
                $explanationBox.show()
                var $explanationBoxHeight = $explanationBox.outerHeight();
                $explanationBox.hide();

                var $totalBoxHeight = container.find('.quiz-wrapper').height() + $explanationBoxHeight;//$explanationBoxHeight + 13 ;

                if(jQuery(this).data('height')){
                    // $explanationBox.css({'bottom':-$explanationBox.data('height')});
                    container.find('.quiz-wrapper').css({'height': $explanationBox.data('height') });
                }else{
                    // $explanationBox.css({'bottom': -$totalBoxHeight});
                    container.find('.quiz-wrapper').css({'height': $totalBoxHeight });
                }

                $explanationBox.show();

                //save to data
                jQuery(this).attr('data-height', $totalBoxHeight);

                //show correct answer
                jQuery(this).parent().find('p').each(function(){
                    var choiceOpt = jQuery(this);
                    $correct = choiceOpt.data('correct');
                    if($correct != ''){
                        choiceOpt.addClass('right');
                        // do fading 3 times
                        //for(i=0;i<3;i++) {
                            choiceOpt.fadeTo('slow', 0.5).fadeTo('slow', 1.0, function(){
                                choiceOpt.removeClass('right');
                            });
                        //}
                    }
                });

                //update hint
                config.hint--;
                container.find('.hint-number').html(config.hint);
            });

            /*Change default style to user config style*/
            $interface_config = jQuery('#wp_quiz_interface_config').val();
            if($interface_config != ''){
                $interface_config = jQuery.base64.decode($interface_config);
                $interface_config = jQuery.parseJSON($interface_config);

                //general
                background    = "#"+$interface_config.background;
                color         = "#"+$interface_config.color;
                border        = "#"+$interface_config.border
                transparent   = ($interface_config.transparent == 'yes') ? 0.9 : 1;
                navigation_bg = "#"+$interface_config.navigation_bg;
                footer_bg     = "#"+$interface_config.footer_bg;
                progress_bar  = "#"+$interface_config.progress_bar;
                pop_up_border = "#"+$interface_config.pop_up_border;

                //question
                question_bg    = "#"+$interface_config.question_bg;
                question_color = "#"+$interface_config.question_color;

                //question
                answer_bg              = "#"+$interface_config.answer_bg;
                answer_selected_bg     = "#"+$interface_config.answer_selected_bg;
                answer_color           = "#"+$interface_config.answer_color;
                answer_selected_color  = "#"+$interface_config.answer_selected_color;
                answer_border          = "#"+$interface_config.answer_border;
                answer_selected_border = "#"+$interface_config.answer_selected_border;

                //button
                button_bg          = "#"+$interface_config.button_bg;
                button_bg_hover    = "#"+$interface_config.button_bg_hover;
                button_color       = "#"+$interface_config.button_color;
                button_color_hover = "#"+$interface_config.button_color_hover;

                jQuery('head').append("<style>.smoke {border-color:"+pop_up_border+";} .dialog-buttons button {background-color:"+pop_up_border+";} .progress-container{background:"+footer_bg+";} .progress-container .progress{ background:"+progress_bar+"; } div.quiz-wrapper{background:"+background+"; color:"+color+"; opacity:"+transparent+"; box-shadow: 0 2px 2px rgba(0,0,0,0.2),0 1px 5px rgba(0,0,0,0.2), 0 0 0 12px "+border+";} div.steps form .resultset,div.steps form legend{background:"+question_bg+"; color:"+question_color+"} div.steps form div.the-answer,div.steps form p{ background:"+answer_bg+"; color:"+answer_color+" } div.steps form div.the-answer-selected, div.steps form p.selected, div.steps form p.right { background: "+answer_selected_bg+"; color: "+answer_selected_color+";  border: 2px solid "+answer_selected_border+";} #quiz-navigation{background:"+navigation_bg+";} #quiz-navigation ul li a{ background:"+button_bg+"; color:"+button_color+" } #quiz-navigation ul li a:hover,#quiz-navigation ul li.selected a{ background:"+button_bg_hover+"; color:"+button_color_hover+" } table.competition-form {color:"+color+"}</style");
            }
            if(config.effect == 'slide'){
                //jQuery('head').append("<style>div#quiz-"+config.quiz_id+" .step{float:left;width:600px;display:block;}</style>");
            }

            /*Initial object*/
            // initial progress object
            var progress = container.find('.progress');
            var progressContainer = container.find('.progress-container');
            var progressWidth = progressContainer.width() - 40;
            // initial steps object
            var steps = container.find('.steps'),
            notice = container.find('#quiz-notice'),
            page_number = container.find(".page-number a"),
            next_button = container.find("#next-quiz"),
            back_button = container.find("#back-quiz"),
            finish_button = container.find("#finish-quiz");

            /*
            sum and save the widths of each one of the fieldsets
            set the final sum as the total width of the steps element
            */
            var widths      = new Array();
            // if(config.effect == 'slide'){
            //     var stepsWidth  = 0;
            //     steps.find('.step').each(function(i){
            //         var $step       = jQuery(this);
            //         widths[i]       = stepsWidth;
            //         stepsWidth      += $step.width();//600
            //     });
            //     console.log(stepsWidth);
            //     steps.width(stepsWidth);
            // }else{
                var checkFirstStep  = 0;
                container.find('.steps').find('.step').each(function(i){
                    if(checkFirstStep == 0){
                        jQuery(this).fadeIn();
                    }else{
                        jQuery(this).hide();
                    }
                    checkFirstStep++;
                });
            // }

            function msgSkills(percentage, correctQuestion, totalQuestion) {
                $resultMessage = config.locale['msg_you_scored'];
                $resultMessage = $resultMessage.replace('%correct%', correctQuestion);
                $resultMessage = $resultMessage.replace('%total%', totalQuestion);
                $resultMessage = $resultMessage.replace('%percent%', percentage+'%');
                if (percentage == 100) return '<h3 class="skill pass">'+$resultMessage + ' ' +config.locale['result_comment_perfect']+'</h3>';
                if (percentage > 90) return '<h3 class="skill pass">'+$resultMessage + ' ' +config.locale['result_comment_excellent']+'</h3>';
                if (percentage > 70) return '<h3 class="skill pass">'+$resultMessage + ' ' +config.locale['result_comment_good']+'</h3>';
                if (percentage > 50) return '<h3 class="skill pass">'+$resultMessage + ' ' +config.locale['result_comment_average']+'</h3>';
                if (percentage > 30) return '<h3 class="skill fail">'+$resultMessage + ' ' +config.locale['result_comment_bad']+'</h3>';
                if (percentage > 20) return '<h3 class="skill fail">'+$resultMessage + ' ' +config.locale['result_comment_poor']+'</h3>';
                else return '<h3 class="skill fail">'+$resultMessage + ' '+config.locale['result_comment_worst']+'</h3>';
            }

            var $totalWeightage = 0;
            var $finalWeightageArray = Array();

            /**
             * Get max length of weightage array
             */
            var $listWeightageLength = Array();
            for (var i = 0, toLoopTill = config.questions.length; i < toLoopTill; i++) {
                $totalWeightage += parseFloat(Array.max(config.questions[i].weight));
                $weightageLength = config.questions[i].weight.length;
                $listWeightageLength[i] = $weightageLength;
            }
            var $maxWeightageLength = Array.max($listWeightageLength);
            /*
            Answer selected
            */
            container.find('p').click(function () {
                var thisAnswer = jQuery(this);

                if (thisAnswer.hasClass('selected')) {
                    thisAnswer.removeClass('selected');
                    thisAnswer.parents('.step').attr('choice', '');
                } else {
                    thisAnswer.parents('.step').children('p').removeClass('selected');
                    thisAnswer.addClass('selected');
                    thisAnswer.parents('.step').attr('choice', thisAnswer.attr('answer'));
                }
            });

            /*
            show the navigation bar
            */
            container.find('#quiz-navigation').show();

            /*
            //bind Start button click
            */
            /*
            container.find('#btn-start-quiz').bind('click', function(){
                container.find('#quiz-instruction-container').fadeOut(500, function() {
                    jQuery(this).next().fadeIn(500, function(){
                        // create div.explanation position
                        $explanationBox = jQuery(this).find('.explanation-box');
                        console.log($explanationBox.height());
                        $explanationBox.css({'bottom': -(parseFloat($explanationBox.height()+48+15))}); //48 is padding 20 and border 4
                    });
                    jQuery(this).next().find('#quiz-navigation').show();
                });
            });
            */

            /*
            when clicking on a next link
            the form slides to the next corresponding fieldset
            */
            next_button.click(function(e){
                current = steps.find(".show");

                //calculate index
                index   = current.index() + 1;
                index ++;
                slider.next(index);

                e.preventDefault();
            });

            /*
            when clicking on a back link
            the form slides to the back corresponding fieldset
            */
            back_button.click(function(e){

                current = steps.find(".show");

                //calculate index
                index   = current.index() + 1;
                index--;
                slider.back(index);

                e.preventDefault();
            });

            /*
            when clicking on a finish link
            show the user results
            */
            finish_button.click(function(e){
                slider.finish();
                e.preventDefault();
            });

            var slider = {
                next: function(index){
                    if (container.find('.show').attr('choice').length === 0) {
                        notice.slideDown(300);
                        notice.css('display','inline-block');
                        return false;
                    };
                    notice.slideUp();
                    if(widths[index-1] != undefined && config.effect == 'slide'){
                        steps.stop().animate({
                            marginLeft: '-' + widths[index-1] + 'px'
                        },500,function(){
                            //mark current slide as show
                            steps.find(".show").removeClass('show');
                            current.next('fieldset').addClass('show');

                            // hide div.explanation
                            container.find('.quiz-wrapper').attr('style', '');
                            container.find('.explanation-box').hide();

                            //increase page number
                            page_number.html(index+"/"+numOfQuestions);

                            //enable first back button
                            back_button.parent().removeClass("disabled");
                            //last next button become finish
                            if(numOfQuestions == index){
                                next_button.hide();
                                finish_button.show();
                            }
                        });
                    }else{
                        steps.find(".show").fadeOut(500, function() {
                            //mark current slide as show
                            jQuery(this).removeClass('show');
                            current.next('fieldset').addClass('show');
                            current.next('fieldset').fadeIn(500);

                            // hide div.explanation
                            container.find('.quiz-wrapper').attr('style', '');
                            container.find('.explanation-box').hide();

                            //increase page number
                            page_number.html(index+"/"+numOfQuestions);

                            //enable first back button
                            back_button.parent().removeClass("disabled");
                            //last next button become finish
                            if(numOfQuestions == index){
                                next_button.hide();
                                finish_button.show();
                            }

                        });
                    }
                    //Calculate & Animate progress bar
                    progress.animate({width: progress.width() + Math.round(progressWidth / numOfQuestions)}, 300);
                },
                back: function(index){
                    notice.slideUp();
                    if(index-1 >= 0 && config.effect == 'slide'){
                        steps.stop().animate({
                            marginLeft: '-' + widths[index-1] + 'px'
                        },500,function(){
                            //mark current slide as show
                            steps.find(".show").removeClass('show');
                            current.prev('fieldset').addClass('show');

                            // hide div.explanation
                            container.find('.quiz-wrapper').attr('style', '');
                            container.find('.explanation-box').hide();

                            //decrease page number
                            page_number.html(index+"/"+numOfQuestions);

                            //disabled first back button
                            if((index - 1) <= 0){
                                back_button.parent().addClass("disabled");
                            }
                            //enabled last next button
                            if(numOfQuestions > index){
                                finish_button.hide();
                                next_button.show();
                                next_button.parent().removeClass("disabled");
                            }
                        });
                    }else{
                        steps.find(".show").fadeOut(500, function() {
                            //mark current slide as show
                            jQuery(this).removeClass('show');
                            current.prev('fieldset').addClass('show');
                            current.prev('fieldset').fadeIn(500);

                            // hide div.explanation
                            container.find('.quiz-wrapper').attr('style', '');
                            container.find('.explanation-box').hide();

                            //decrease page number
                            page_number.html(index+"/"+numOfQuestions);

                            //disabled first back button
                            if((index - 1) <= 0){
                                back_button.parent().addClass("disabled");
                            }
                            //enabled last next button
                            if(numOfQuestions > index){
                                finish_button.hide();
                                next_button.show();
                                next_button.parent().removeClass("disabled");
                            }


                        });
                    }
                    //Calculate & Animate progress bar
                    progress.animate({width: progress.width() - Math.round(progressWidth / numOfQuestions)}, 300);
                },
                finish: function(){
                    if (container.find('.show').attr('choice').length === 0) {
                        notice.slideDown(300);
                        notice.css('display','inline-block');
                        return false;
                    };

                    //get user answer - index of array
                    container.find('.step').each(function (index) {
                        questionNumber = jQuery(this).attr('question');
                        userSelect = jQuery(this).attr('choice');
                        userAnswers[questionNumber] = userSelect;
                    });

                    //quiz result
                    var numOfRightAnswer = 0,
                    finalScore = 0,
                    questionList = '',
                    answerList = '';

                    for (i = 0; i < numOfQuestions; i++) {
                        if(config.questions[i] == undefined) {
                            continue;
                        }

                        $userScore = config.questions[i].weight[(userAnswers[i+1]-1)];
                        $maxScore = Array.max(config.questions[i].weight);

                        bt_rightOrwrong = 'label-important';
                        sign_rightOrwrong = '&nbsp;<i class="qicon-remove qicon-white"></i>';
                        if ($userScore == $maxScore) {
                            numOfRightAnswer++;
                            bt_rightOrwrong = 'label-success';
                            sign_rightOrwrong = '&nbsp;<i class="qicon-ok qicon-white"></i>';
                        }

                        questionList += '<span class="label '+bt_rightOrwrong+'"><a style="color:white" href="#q' + (i + 1)+'" questionNumber="' + (i + 1)+'" class="quiz-result">'+config.locale['msg_question']+' ' + (i + 1)+'</a>'+sign_rightOrwrong +'</span>';
                        answerList += '<div id="q' + (i + 1)+'" class="final-result">';
                        answerList += '<h3>'+config.questions[i].question+'</h3>';

                        var emailContentList = {};
                         //add question and user ans to email content
                        emailContentList['question_id'] = config.questions[i].id;
                        emailContentList['question'] = config.questions[i].question;

                        for (answersIndex = 0; answersIndex < config.questions[i].answers.length; answersIndex++) {
                            var rightOrwrong = '';


                            if (config.questions[i].weight[answersIndex] == $maxScore) {
                                rightOrwrong += 'right';
                            }

                            if (userAnswers[i+1] == (answersIndex + 1) ) {
                                rightOrwrong = 'selected '+rightOrwrong;

                                emailContentList['answer'] = config.questions[i].answers[answersIndex];
                                emailContentList['answer_id'] = config.questions[i].answerIdList[answersIndex];

                                if ($userScore < $maxScore) {
                                    rightOrwrong += ' wrong';
                                }

                                //sum score
                                finalScore += parseFloat($userScore);

                                emailContentList['score'] = config.questions[i].weight[answersIndex];
                            }

                            if(typeof config.questions[i].answers[answersIndex] === "undefined"){
                                //do nothing
                            }else{
                                answerList += '<p class="' + rightOrwrong + '">' + config.questions[i].answers[answersIndex] + '</p>';
                                // answerList += '<p class="' + rightOrwrong + '"><span class="weight">'+config.questions[i].weight[answersIndex]+'</span>' + config.questions[i].answers[answersIndex] + '</p>';
                            }
                        }
                        //add to email content
                        userAnswersForEmail.push(emailContentList);

                        //explanation
                        expId = 'inline'+i;
                        expLink = 'href="#inline'+i+'"';
                        explain = config.questions[i].explanation;
                        if(typeof explain == 'undefined' || explain == ''){
                            explain = '';
                        }else{
                            explain = '<div id="'+expId+'" class="explanation-text" style="display: none;">'+config.questions[i].explanation+'</div>';
                            //explain +='<a title="Explanation" class="simple-modal-link" '+expLink+' >'+config.locale['msg_explanation']+'</a>';
                        }
                        answerList += '<div class="quiz-explain">'+explain+'</div></div>';

                    }
                    //var score = finalScore;//score by total
                    var score = Math.round((numOfRightAnswer / numOfQuestions) * 100);//score by percentage
                    var skill = msgSkills(score, numOfRightAnswer, numOfQuestions);

                    var contact_button = (config.show_contact_form == true) ? '<li><a href="javascript:;;" id="show-submit-score">'+config.locale['contact_show_form_button']+'</a></li>' : '';
                    //social share
                    //var $judgeWeightage = config.locale['msg_share_scored']+':'+score+'/'+$totalWeightage
                    var $judgeWeightage = skill ;//+ ' ' +config.locale['msg_you_scored']+' '+score+'%'
                    var shareURL = window.location;
                    var shareButton = '';

                    //facebook
                    shareButton += '<a href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]='+shareURL+'&p[images][0]=&p[title]='+encodeURIComponent($judgeWeightage )+'&p[summary]=" target="_blank"><img src="'+wpQuiz.pluginURL+'/assets/img/facebook.png" /></a>';
                    //twitter
                    shareButton += '<a href="http://twitter.com/home?status='''+shareURL+'" target="_blank" ><img src="'+wpQuiz.pluginURL+'/assets/img/twitter.png" /></a>';
                    //gplus
                    shareButton += '<a href="https://plus.google.com/share?url='+shareURL+'" target="_blank" ><img src="'+wpQuiz.pluginURL+'/assets/img/google.png" /></a>';


                    var resultContent = '<div class="quiz-wrapper">\n\
                        <div class="steps">\n\
                        <form id="competitionForm" name="competitionForm" action="quiz_submit_score.php" method="post">\n\
                        <input type="hidden" value="'+score+'" id="quiz_user_score">\n\
                        '+$judgeWeightage+'\n\
                        <div class="social_share">'+shareButton+'</div>\n\
                        <fieldset class="step" style="display:block">\n\
                        <div class="resultset">'+questionList+'</div>\n\
                        <div id="your-score" class="final-result">\n\
                            <span class="label label-warning"><i class="qicon-exclamation-sign qicon-white"></i> '+config.locale['msg_click_to_review']+'</span>\n\
                        </div>'+answerList+'</fieldset>'+competitionForm+'</form></div>\n\
                        <div id="quiz-navigation" style=""><ul class="final-nav" style="float:right"><li><a href="javascript:;;" id="btn-submit-score">'+config.locale['contact_submit_button']+'</a><img src="'+wpQuiz.pluginURL+'/assets/img/ajax-loader.gif" alt="loading" id="ajax-loader"></li>'+contact_button+'</ul></div>\n\
                        </div>';

                    //parse HTML
                    container.html(resultContent);

                    //when click finish - submit score to server
                    var params = {
                        action:'quiz_submit_score',
                        'user_score': score,
                        'quiz_id': config.quiz_id,
                        'json_results': userAnswersForEmail
                    };

                    jQuery.ajax({
                        type:'POST',
                        data: params,
                        url: wpQuiz.ajaxURL,
                        success: function(response) { console.log(response); }
                    });



                    //unbind select answer
                    container.find('p').unbind('click');
                    //bind explanation click event
                    container.find('.simple-modal-link').click(function (e) {
                        $this = jQuery(this);
                        $href = $this.attr('href');
                        jQuery($href).modal();
                        return false;

                    });

                    //validate form
                    var competition = {
                        isValidEmailAddress : function(emailAddress){
                            var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
                            return pattern.test(emailAddress);
                        },
                        validate : function(){
                            var error = 1;
                            var hasError = false;

                            jQuery('#competitionForm').find(':input:not(button)').each(function(){
                                var $this       = jQuery(this);

                                if($this.hasClass('required') && !$this.is(':disabled')){
                                    var valueLength = jQuery.trim($this.val()).length;

                                    if(valueLength == '' || (!$this.prop("checked") && $this.attr('type') == 'checkbox') ){
                                        $this.css('background-color','#FFEDEF');
                                        if($this.attr('type') == 'checkbox'){
                                            $this.parent().addClass('red');
                                        }
                                        hasError = true;
                                    }else{
                                        $this.css('background-color','#FFFFFF');
                                        if($this.attr('type') == 'checkbox'){
                                            $this.parent().removeClass('red');
                                        }
                                    }
                                }
                            });

                            if(jQuery('#competitionName').hasClass('letters_only')){
                                var $this = jQuery('#competitionName');
                                var valueLength = jQuery.trim($this.val()).length;
                                var letterOnly = /^[a-zA-Z ]+$/;

                                if (valueLength == '' || !letterOnly.test($this.val())) {
                                    $this.css('background-color','#FFEDEF');
                                    hasError = true;
                                }else{
                                    $this.css('background-color','#FFFFFF');
                                }
                            }

                            if(competition.isValidEmailAddress(jQuery('#competitionEmail').val()) == false){
                                jQuery('#competitionEmail').css('background-color','#FFEDEF');
                                jQuery('#competitionEmail').focus();
                                hasError = true;
                            }else{
                                jQuery('#competitionEmail').css('background-color','#FFFFFF');
                            }

                            if(hasError){
                                error = -1;
                            }
                            return error;
                        }
                    }

                    //submit score and send to email
                    container.find('#btn-submit-score').bind('click', function(){
                        $this = jQuery(this);
                        $ajaxLoader = jQuery('#ajax-loader');

                        $ajaxLoader.show();
                        $this.hide();

                        noError = competition.validate();
                        if(noError == 1){
                            var params = {
                                action: 'quiz_send_contact_mail',
                                'quiz_id': config.quiz_id,
                                'name': jQuery('#competitionName').val(),
                                'apellido': jQuery('#competitionApellido').val(),
                                'email': jQuery('#competitionEmail').val(),
                                'phone': jQuery('#competitionPhone').val(),
                                'message': jQuery('#competitionMessage').val(),
                                'user_score': jQuery('#quiz_user_score').val(),
                                'json_results': userAnswersForEmail
                            };

                            jQuery.ajax({
                                type:'POST',
                                data:jQuery.param(params),
                                url: wpQuiz.ajaxURL,
                                success: function(response) {
                                    //console.log(response);
                                    if(config.contact_redirect != ''){
                                        window.location.href = config.contact_redirect;
                                        return;
                                    }

                                    var thanksContent = '<div class="quiz-wrapper">\n\
                                        <div class="steps">\n\
                                        <form id="competitionForm" name="competitionForm" action="quiz_submit_score.php" method="post">\n\
                                        <fieldset class="step" style="display:block">\n\
                                        <legend><div>'+config.locale['contact_thankyou']+'</div></legend>\n\
                                        </fieldset></form></div>\n\
                                        </div>';

                                    //parse HTML
                                    container.html(thanksContent);
                                }
                            });
                        }else{
                            $ajaxLoader.hide();
                            $this.show();
                        }
                    });

                    //bind show submit score form
                    container.find('#show-submit-score').bind('click', function(){
                        jQuery(this).hide();
                        container.find('.step:first').fadeOut(500, function() {
                            jQuery('#btn-submit-score').attr('style', 'display: block');
                            jQuery(this).next().fadeIn(500);
                        });
                    });

                    //bind show result event
                    container.find('.quiz-result').parent('span').bind('click', function(){
                        $this = jQuery(this).find('a');
                        jQuery('.quiz-result').removeClass('active');
                        $this.addClass('active');
                        questionNumber = $this.attr('questionNumber');
                        $currentQues = container.find('#q' + questionNumber);
                        $explainText = $currentQues.find('.explanation-text').html();

                        if(typeof $explainText == 'undefined'){
                            smoke.alert($currentQues.html(),{},function(){ jQuery('.quiz-result').removeClass('active'); });
                        }else{
                            smoke.confirm($currentQues.html(),function(e){
                                if (e){
                                    jQuery('.quiz-result').removeClass('active');
                                }else{
                                    smoke.alert("<p class=\"explanation-text\">"+$explainText+"</p>", {},function(){
                                        jQuery('.quiz-result').removeClass('active');
                                    });
                                }
                            }, {ok: "X",cancel:"?"});
                        }
                    });

                    //if(numOfQuestions == 1){ container.find('.quiz-result').trigger('mouseenter'); }
                }
            };
        }
    };
});