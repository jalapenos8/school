$(document).ready(function () {
    class Task{
        constructor(Name, TaskObj, Timer){
            this.Name = Name;
            this.TaskObj = TaskObj;  
            this.Timer = Timer;
        }
    }
    class TestQuestion{
        constructor(quest, opts, ans){
            this.quest = quest;
            this.opts = opts;       //array
            this.ans = ans;   
        }
    }
    class GroupSort{            //need an array to contain many of that for one task
        constructor(group, items){
            this.group = group;             //name of the group
            this.items = items;       //подлежащие
        }
    }
    class PutInOrder{
        constructor(sentence, words){
            this.sentence = sentence;             //think that's enough
            this.words = words;
        }
    }
    class FillMissingWords{
        constructor(completeText, missedWords, incompleteText){
            this.completeText = completeText;             
            this.missedWords = missedWords;     //array of missed words
            this.incompleteText = incompleteText;  //_____ instead of missed words
        }
    }
    class TermToDefItem{
        constructor(term, def){
            this.term = term;             
            this.def = def;
        }
    }
    class TermToDefCollection{
        constructor(paired, singleTerms, singleDefs){
            this.paired = paired;             
            this.singleTerms = singleTerms;
            this.singleDefs = singleDefs;
        }
    }
    
    let clickedOptNum, AnswerTermToDefPairsNum, colArr, metadata, theTask, defClicked, termClicked;
    let timerSyst, progB;
    
    let progressbarinner = document.getElementById('thisProg');
    LoadTheTask();
    function LoadTheTask()
    {
        clickedOptNum = 0;
        AnswerTermToDefPairsNum = 0;
        defClicked = false;
        termClicked = false;

        let xhr = new XMLHttpRequest();
        xhr.open('GET', route('quizzes.interfaceSQL', [subjectID, unitID, quizID]), true);
        xhr.onload = function () {
            console.log(xhr.response);
            let response = JSON.parse(xhr.response);
            
            if (!response.isEnd)
            {
                $('#MainContainer').html(response.data);
                
                    progressBarTimer(response.timer);
                    timeControl(response.timer);

                    progressbarinner.classList.remove("run-animation");
                    void progressbarinner.offsetWidth;
                    progressbarinner.classList.add("run-animation");
                    $('#thisProg').css("animation-duration", response.timer+".8s");
                    progressbarinner.style.animationPlayState = 'running';  
                
                metadata = response.metadata;                  
            }
            else
            {
                $('#thisProg').remove();
                let xml = new XMLHttpRequest();
                xml.open('GET', route('quizzes.interfaceSQL2', [subjectID, unitID, quizID]), true);
                xml.onload = function () {
                    let score = xml.response;
                    $('#MainContainer').html(`<div class='ResultsHeader'>Your score is ${score}</div>
                    <div class='resultsButton'><a href="`+route('units.show', [subjectID, unitID])+`">Назад</a></div>`);
                }
                xml.send();
            }
            
        }
        xhr.send();
    }

    function sendAnswer(Answer){
        clearInterval(progB);
        clearTimeout(timerSyst);

        progressbarinner.style.animationPlayState = 'paused';
        console.log(Answer);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', route('quizzes.interfaceSQL1', [subjectID, unitID, quizID]), true);
        xhr.onload = function () {
            console.log(xhr.response);
            let response = JSON.parse(xhr.response);

            if (response.metadata.includes("Success"))
            {
                theTask = response.data;
                let ShowSolutionStr = `
                ${theTask.Name}_ShowSolution(theTask.TaskObj);
                `;
                eval(ShowSolutionStr);
                
                setTimeout(() => LoadTheTask(), 3000);
            }
            else
            {
                Alert("Error! ".xhr.response);
            }
        }
        let formData = new FormData();
        formData.append('Answer', JSON.stringify(Answer));
        xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
        xhr.send(formData);
    }

    function progressBarTimer(timer) {
        $('#thisProg').css('width', '100%');
        $('#thisProg').css('display', 'block');
        let left = timer;
        
        var start = Date.now();
        $('#thisProg').html(left+"s");
        progB = setInterval(function() {
            var delta = Date.now() - start;
            
            left = timer - Math.floor(delta / 1000);
            $('#thisProg').html(left+"s");
            //console.log(left);  
        }, 100); 
    }
    
    function timeControl (timer) {
        timerSyst = setTimeout(function () {
            sendAnswer(null);
        }, timer*1000);
    }


                                                        /* ___GENERAL_PART_END___ */
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                                                        /* ___TEST_QUESTION_PART_START___ */


    function TestQuestion_ShowSolution(TestQuestObj) {
        $('.testOptClicked').css('background-color', 'red');       
        TestQuestObj.ans.forEach(element => {
            let answerrr = $('#MainContainer').find(`.TestQuestionOptionTextarea:contains("${element}")`).parents('.TestQuestionOption');
            if (answerrr.hasClass('testOptClicked'))
            {
                answerrr.css('background-color', '#37ab4a');
            }
            else
            {
                answerrr.css('background-color', 'green');
            }            
        });  
    }

    $('#MainContainer').on('click', '.TestQuestionOption:not(.testOptClicked)', function() {
        clickedOptNum++;
        $(this).addClass('testOptClicked');
        if(clickedOptNum>=Number(metadata))
        {
            let AnswerVal = $('#MainContainer').find(`.testOptClicked`).map(function() {            //retusn items groups as array
                return $(this).find('.TestQuestionOptionTextarea').text().trim();
                }).get();
            sendAnswer(AnswerVal);
        }
    })


                                                        /* ___TEST_QUESTION_PART_END___ */

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                                                        /* ___GROUP_SORT_PART_START___ */


    $('#MainContainer').on('mouseover', '.GSmouseOverFig', function() {
        //set drop drag elements
        $(".Cust_draggable").draggable({
            revert: "invalid",            //return to original position if not dropped into droppable
            helper: 'clone' // Use a clone of the draggable element as the helper
        });

        $(".Cust_droppable").droppable({
            drop: GroupSort_handleDropEvent
        });
        $(this).removeClass('GSmouseOverFig');
    });

    function GroupSort_ShowSolution(GroupSortArr) {
        GroupSortArr.forEach(element => {                       //check answer
            let arrStudAnsObjs = $('#MainContainer').find(`.GroupName:contains("${element.group}")`).parents('.GroupCard').find('.ItemsContainer .GroupItem').map(function() {            //retusn items groups as array
                return this;
                }).get();
            let groupEl = $('#MainContainer').find(`.GroupName:contains("${element.group}")`).first();
            let arrCorrect = element.items;
            GroupSort_check(groupEl, arrCorrect, arrStudAnsObjs);
        });
    }

    function GroupSort_check(groupEl, arrCorrect, arrStudAnsObjs){
        let arrCorrectlyAnswered = new Array();         //elements
        let arrIncorrectlyAnswered = new Array();       //elements
        let arrCorrectAnswersLeft = new Array();        //text

        arrStudAnsObjs.forEach(element => {             //to find correct and incorrect answers from input
            if (arrCorrect.includes($(element).text().trim()))
            {
                arrCorrectlyAnswered.push(element);
            }
            else
            {
                arrIncorrectlyAnswered.push(element);
            }
        });

        arrCorrect.forEach(element1 => {                //to find correct answers that weren't inputed
            let found = false;
            arrCorrectlyAnswered.forEach(element2 => {
                if (element1==$(element2).text().trim()) 
                {
                    found = true;
                }
            });
            if (!found)
            {
                arrCorrectAnswersLeft.push(element1);
            }
        });

        arrIncorrectlyAnswered.forEach(element => {
            $(element).css('background-color', 'red');
        });

        arrCorrectlyAnswered.forEach(element => {
            $(element).css('background-color', 'green');
        });

        arrCorrectAnswersLeft.forEach(element => {
            let ItemHTML = 
            `<div class="GroupItem shadow Cust_draggable" style="opacity: 0.5;">${element}</div>`;
            $(groupEl).parents('.GroupCard').find('.ItemsContainer').append(ItemHTML);
        });
    }

    function GroupSort_sendInput() {
        let GroupSortArray = new Array();
        $('#MainContainer .GroupName').each(function() {
            let groupName = $(this).text().trim();
            let groupItems = $(this).parents('.GroupCard').find('.ItemsContainer .GroupItem').map(function() {            //retusn items groups as array
                return $(this).text().trim();
            }).get();
            let theGroupSortObj = new GroupSort(groupName, groupItems);
            GroupSortArray.push(theGroupSortObj);
        })

        sendAnswer(GroupSortArray);
    }

    function GroupSort_allItemsDraggedCheck(){
        if ($('#GroupSort_ItemsContainer').children().length === 0) {       
            GroupSort_sendInput();
        }
    }

    function GroupSort_handleDropEvent(event, ui) {
        let $self = $(this);
        let $item = ui.draggable;
        $item.appendTo($self).attr("style", "");                //remove inline styling so item will be positioned nicely
        $item.draggable("destroy");
        setTimeout(() => {
            GroupSort_allItemsDraggedCheck();               //otherwise it counts last removed element
        }, 1);
    }
    
    
                                                        /* ___GROUP_SORT_PART_END___ */

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                                                        /* ___PUT_IN_ORDER_PART_START___ */

    $('#MainContainer').on('mouseover', '.PIOmouseOverFig', function() {
        //set drop drag elements
        $(".Cust_draggable").draggable({
            revert: "invalid",             //return to original position if not dropped into droppable
            helper: 'clone' // Use a clone of the draggable element as the helper
        });

        $(".Cust_droppable").droppable({
            drop: PutInOrder_handleDropEvent
        });
        $(this).removeClass('PIOmouseOverFig');
    });

    function PutInOrder_ShowSolution(PutInOrderObj) {
        if ($('#PutInOrder_sentenceInput').text().trim() != PutInOrderObj.sentence)
        {
            $('#PutInOrder_sentenceInput').css('background-color', 'red');
        }
        else
        {
            $('#PutInOrder_sentenceInput').css('background-color', 'green');
        }
    }

    function PutInOrder_sendInput() {
        let StudAns = $('#PutInOrder_sentenceInput').text().trim();

        sendAnswer(StudAns);
    }

    function PutInOrder_handleDropEvent(event, ui) {
        let $self = $(this);
        let $item = ui.draggable;
        $self.empty();
        $item.appendTo($self).attr("style", "");
        $item.draggable("destroy");
        setTimeout(() => {
            PutInOrder_allItemsDraggedCheck();
        }, 1);
    }

    function PutInOrder_allItemsDraggedCheck(){
        if ($('#PutInOrder_ItemsContainer').children().length === 0) {
            PutInOrder_sendInput();
        }
    }

                                                        /* ___PUT_IN_ORDER_PART_END___ */

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                                                        /* ___FILL_MISSING_WORDS_PART_START___ */


    $('#MainContainer').on('mouseover', '.FMWmouseOverFig', function() {
        $(".Cust_draggable").draggable({
            revert: "invalid",             //return to original position if not dropped into droppable
            helper: 'clone' // Use a clone of the draggable element as the helper
        });
        
        $(".Cust_droppable").droppable({
            drop: FMW_handleDropEvent
        });
        $(this).removeClass('FMWmouseOverFig');
    });
    
    function FillMissingWords_ShowSolution(FillMissingWordsObj) {
        let k = 0;
        $('#MainContainer').find('.PIO_wordCont').each(function() {
            if ($(this).text().trim() != FillMissingWordsObj.missedWords[k])
            {
                $(this).css('background-color', 'red');
            }
            else
            {
                $(this).css('background-color', 'green');
            }
            k++;
        });
    }

    function FillMissingWords_sendInput() {
        let wordsOrder = $('#FMW_sentenceInput').find(`.Cust_draggable`).map(function() {           
            return $(this).text().trim();
        }).get();
        sendAnswer(wordsOrder);
    }

    function FMW_handleDropEvent(event, ui) {
        var $self = $(this);
        var $item = ui.draggable;
        $self.empty();
        $item.appendTo($self).attr("style", "");
        $item.draggable("destroy");
        setTimeout(() => {
            FMW_allItemsDraggedCheck();
        }, 1);
      }
    
    function FMW_allItemsDraggedCheck(){
        if ($('#FMW_ItemsContainer').children().length === 0) {
            FillMissingWords_sendInput();
        }
    }


                                                        /* ___FILL_MISSING_WORDS_PART_END___ */

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                                                        /* ___TERM_TO_DEF_PART_START___ */


    $('#MainContainer').on('mouseover', '.TTDmouseOverFig', function() {
        colArr = randColArrGenerator($('.termBlock').length);
        $(this).removeClass('TTDmouseOverFig');
    });

    function TermToDef_ShowSolution(TermToDefObj) {
        $('#MainContainer').find(`.blockcol`).css('background-color', `rgba(156, 155, 156, 0.3)`);
        for (let i=0; i<TermToDefObj.paired.length; i++)
        {
            $('#MainContainer').find(`.termBlock:contains("${TermToDefObj.paired[i].term}")`).css('background-color', `${colArr[i]}`);
            $('#MainContainer').find(`.defBlock:contains("${TermToDefObj.paired[i].def}")`).css('background-color', `${colArr[i]}`);
        }
    }

    function TermToDef_sendInput() {
        var pairedArr = new Array();
        var singleTermsArr = new Array();
        var singleDefsArr = new Array();

        for(let i=1; i<=AnswerTermToDefPairsNum; i++)
        {
            let theTerm = $('#MainContainer').find(`.t${i}`).map(function() {           
                return $(this).text().trim();
                }).get();
    
            let theDef = $('#MainContainer').find(`.d${i}`).map(function() {           
                return $(this).text().trim();
                }).get();
    
            let newTermToDef = new TermToDefItem(theTerm[0], theDef[0]);        //since the map function always returns arrays even if only single value is found
    
            pairedArr.push(newTermToDef);
        }
    
        $('#MainContainer').find('.t0').each(function() {
            let newTermToDef = new TermToDefItem($(this).text().trim(), null);
            singleTermsArr.push(newTermToDef);
            })
        
        $('#MainContainer').find('.d0').each(function() {
            let newTermToDef = new TermToDefItem(null, $(this).text().trim());
            singleDefsArr.push(newTermToDef);
            })
    
        let TermToDefColl = new TermToDefCollection(pairedArr, singleTermsArr, singleDefsArr);

        sendAnswer(TermToDefColl);
    }

    function randColArrGenerator(num) {
        let colArr = new Array();
        let spacing = 360/Number(num);
        for (let hue = spacing; hue <= 360; hue+=spacing){
            let newRandCol = `hsl(${hue}, 100%, 35%)`;
            colArr.push(newRandCol);
        }
        return(colArr);
    }

    $("#MainContainer").on('click', '.termClickable', function() {

        $(this).css('background-color', colArr[AnswerTermToDefPairsNum]);
        if (defClicked == false)
        {
            if (termClicked != false)
            {
                $(termClicked).css('background-color', '#9c9b9c4d');
            }

            if ($(termClicked).attr('id') == $(this).attr('id'))
            {
                termClicked = false;
            }
            else
            {
                termClicked = $(this);
            }
        }
        else
        {
            AnswerTermToDefPairsNum++;               
            
            $(defClicked).addClass(`d${AnswerTermToDefPairsNum}`);
            $(this).addClass(`t${AnswerTermToDefPairsNum}`);
            $(defClicked).removeClass('d0');
            $(this).removeClass('t0');

            $(defClicked).removeClass('defClickable');
            $(this).removeClass('termClickable');
            termClicked = false;
            defClicked = false;

            if (AnswerTermToDefPairsNum==Number(metadata))
            {
                $('#TermToDefContainer').css('pointer-events', 'none');
                setTimeout(function()
                {
                    TermToDef_sendInput()
                }, 1000);
            }
        }
        
    })

    $("#MainContainer").on('click', '.defClickable', function() {

        $(this).css('background-color', colArr[AnswerTermToDefPairsNum]);
        if (termClicked == false)
        {
            if (defClicked != false)
            {
                $(defClicked).css('background-color', '#9c9b9c4d');
            }

            if ($(defClicked).attr('id') == $(this).attr('id'))
            {
                defClicked = false;
            }
            else
            {
                defClicked = $(this);
            }
        }
        else
        {   
            AnswerTermToDefPairsNum++;

            $(termClicked).addClass(`t${AnswerTermToDefPairsNum}`);
            $(this).addClass(`d${AnswerTermToDefPairsNum}`);
            $(termClicked).removeClass('t0');
            $(this).removeClass('d0');

            $(termClicked).removeClass('termClickable');
            $(this).removeClass('defClickable');
            termClicked = false;
            defClicked = false;

            if (AnswerTermToDefPairsNum==metadata)
            {
                $('#TermToDefContainer').css('pointer-events', 'none');
                setTimeout(function()
                {
                    TermToDef_sendInput()
                }, 1000);
            }
        }
    });


                                                        /* ___TERM_TO_DEF_PART_END___ */

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
});