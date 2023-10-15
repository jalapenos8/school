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
            this.ans = ans;         //No. (position) of correct answer
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


    let urlParams = new URLSearchParams(window.location.search);
    let QuizCode = urlParams.get('QuizCode');
    let CorrectAnswers;
    let count = 0;
    let QuestArr = new Array();
    let QuizName;

    class StandartizedStudentAnswerRecord {
        constructor (login, scores){
            this.login = login;
            this.scores = scores;
            this.score = 0;
            for (let i=0; i<scores.length; i++)
            {
                if (this.scores[i]==1)
                {
                    this.score++;
                }
            }
        }
    }

    let xhr = new XMLHttpRequest();
    
    xhr.open('POST', 'php/resultsForTeacherSQL1.php', true);

    xhr.onload = function () {
        if (xhr.response.includes('Error!'))
        {
            throw new Error();
        }
        let response = JSON.parse(xhr.response);
        QuizName = response['QuizName'];
        $("#QuizName").text('Results of ' + QuizName);
        CorrectAnswers = JSON.parse(response['QuizJSON']);
        
        console.log(CorrectAnswers);
    }
    let formData = new FormData();
    formData.append('QuizCode', QuizCode);
    xhr.send(formData);


    window.setInterval(refreshResult, 500);
    refreshResult();
    function refreshResult () { 
        let xhr = new XMLHttpRequest();
    
        xhr.open('POST', 'php/resultsForTeacherSQL2.php', true);

        xhr.onload = function () {
            let allRecordsArray = new Array(); 
            if (xhr.response.includes('Error!'))
            {
                throw new Error();
            }
            else if (xhr.response.includes('No answers yet'))
            {
                $("#QuizName").text("Current Results: No answers yet");
            }
            else
            {
                let StudentObjectsArray = JSON.parse(xhr.response);
                $("#QuizName").text('Results of ' + QuizName);
                StudentObjectsArray.forEach(element => {
                    let StudentAnswerRecord = new StandartizedStudentAnswerRecord(element['login'], element['scores']);
                    
                    allRecordsArray.push(StudentAnswerRecord);
                });

                allRecordsArray.sort((a,b) => {b.score - a.score});     //sorting by descending score

                let allRows = '';

                //from here outputting answer result
                allRecordsArray.forEach((record) =>{
                    let questionsRes = '';
                    for (let i = 0; i<record.scores.length; i++)
                    {
                        let classAns = `wrongAnswer`;
                        if (record.scores[i]==1)
                        {
                            classAns='rightAnswer';
                        }

                        questionsRes += `
                            <div class="${classAns}">${i+1}</div>
                            `;
                    }

                    let resultRow = `
                    <div class="row">
                        <div class="col">
                            ${record.login}
                        </div>
                        <div class="col">
                            ${questionsRes}
                        </div>
                        <div class="col">
                            ${record.score}
                        </div>
                        <div class="col Link">
                            <a id='${record.login}' class="Details">Details</a>
                        </div>
                    </div>`;

                    allRows += resultRow;
                });
                $('#ResultsTable').find('.row:not(:first-child)').replaceWith(allRows);
            }
        }
        let formData = new FormData();
        formData.append('QuizCode', QuizCode);
        xhr.send(formData);
     }

    $('#ResultsTable').on('click', '.Details', function() { 
        count = 0;
        QuestArr = [];
        let Login = $(this).attr('id').trim();
        let xml = new XMLHttpRequest();
        
        xml.open('POST', 'php/resultsForTeacherSQL3.php', true);

        xml.onload = function () {
            console.log(xml.response);
            if (xml.response.includes('Error!') || xml.response.includes('No answer found'))
            {
                alert('Error');
            }
            else
            {
                let response = JSON.parse(xml.response);
                response.forEach(element => {
                    QuestArr.push(JSON.parse(element));
                });
                $('#MainContainer').css('display', 'flex')
                $('.ResForTeacher_MainContainer').hide();
                $('#hideCorBtn').hide();
                pageTransition();
            }
        }
        let formData = new FormData();
        formData.append('Login', Login);
        formData.append('QuizCode', QuizCode);
        xml.send(formData);
    });

    function pageTransition(QuestArrF = QuestArr) {
        console.log(QuestArrF[count]);
        if(QuestArrF[count]!=null)
        {
            let url = `quizresults/${QuestArrF[count].Name}.html`;
            
            $('#DetailsContainer').load(url, function(){
            let InitCodeStr = `${QuestArrF[count].Name}_InitCode(QuestArrF);`;
            eval(InitCodeStr);
            });
            $('#DetailsContainer').removeClass('d-none');
        }
        else
        {
            console.log('null yooo');
            $('#DetailsContainer').html(`<div class="Header1 text-white" style="font-size: 3.5rem;">No answer</div>`);
        }

        
        if (count==0)
        {
            $("#prevBtn").hide();
            $("#nextBtn").show();
        }
        else if (count==QuestArr.length-1)
        {
            $("#nextBtn").hide();
            $("#prevBtn").show();
        }
        else
        {
            $("#prevBtn").show();
            $("#nextBtn").show();
        }
    }

    $('#backBtn').click(function (e) { 
        e.preventDefault();
        
        $('#MainContainer').css('display', 'none');
        $('#DetailsContainer').empty();
        $('.ResForTeacher_MainContainer').removeAttr('style');  //to remove hide() effect
        count = 0;
    });

    $('#showCorBtn').click(function (e) { 
        e.preventDefault();

        $('#DetailsContainer').addClass('d-none');
        $('#DetailsContainer').empty();

        pageTransition(CorrectAnswers);

        $(this).hide();
        $('#hideCorBtn').show();
    });

    $('#hideCorBtn').click(function (e) { 
        e.preventDefault();

        $('#DetailsContainer').empty();
        pageTransition();

        $(this).hide();
        $('#showCorBtn').show();
    });

    $('#prevBtn').click(function (e) { 
        e.preventDefault();
        
        $('#DetailsContainer').empty();
        $('#hideCorBtn').hide();
        $('#showCorBtn').show();

        count--;
        pageTransition();
    });

    $('#nextBtn').click(function (e) { 
        e.preventDefault();
        
        $('#DetailsContainer').empty();
        $('#hideCorBtn').hide();
        $('#showCorBtn').show();

        count++;
        pageTransition();
    });



    function TestQuestion_InitCode(QuestArrF) {
        $('#timeRes').text(QuestArrF[count].Timer+'s');
        let TestQuestObj = QuestArrF[count].TaskObj;
        let Letters = ['A','B','C','D'];

        $(".TestQuestionQuestionTextarea").text(TestQuestObj.quest);             //set question text
        for (let j=0; j<TestQuestObj.opts.length; j++)
        {
            let OptionHTML = `
            <div class="TestQuestionOption">
                <p class="TestQuestionOptionLetterLabel">${Letters[j]}</p>
                <p class="TestQuestionOptionTextarea">${TestQuestObj.opts[j]}</p>
            </div>`;

            $("#options").append(OptionHTML);
        }

        TestQuestObj.ans.forEach(element => {
            let col = 'green';
            let anss = element;
            if (Array.isArray(element))
            {
                if (!element[1])
                {
                    col = 'red';
                }
                anss = element[0];
            }
            $('#MainContainer').find(`.TestQuestionOptionTextarea:contains("${anss}")`).each(function () { 
                $(this).parents('.TestQuestionOption').css('background', col);
            });
        });
    }

    function GroupSort_InitCode(QuestArrF) {
        $('#timeRes').text(QuestArrF[count].Timer+'s');
        let GroupSortArray = QuestArrF[count].TaskObj;
        GroupSortArray.forEach(GroupSort => {
            let itemsCode = '';
            GroupSort.items.forEach(Item => {
                let col = 'green;';
                let InsertedItem;
                if (!Array.isArray(Item))
                {
                    InsertedItem = Item;
                }
                else
                {
                    if (!Item[1])
                    {
                        col = 'red;';
                    }
                    InsertedItem = Item[0];
                }
                
                let color = `style="background-color: ${col};"`;
                itemsCode += `<div class="GroupItem shadow" ${color}>${InsertedItem}</div>`;
            });
            let addInputedGroup = `
            <div class="GroupCard">
                <p class="GroupName">${GroupSort.group}</p>
                <hr>
                <div class="ItemsContainer">  
                    ${itemsCode}
                </div>
            </div>`
            $("#GroupSort_thisContainer").append(addInputedGroup);
        });
    }
 
    function PutInOrder_InitCode(QuestArrF) { 
        $('#timeRes').text(QuestArrF[count].Timer+'s');   
        let PutInOrder = QuestArrF[count].TaskObj;
        let col = 'green';
        if (!Array.isArray(PutInOrder.sentence))
        {
            $('#sentenceInput').text(PutInOrder.sentence);
        }
        else
        {
            $('#sentenceInput').text(PutInOrder.sentence[0]);
            if (!PutInOrder.sentence[1])
            {
                col = 'red';
            }
        }
        $('#sentenceInput').css('background', col);
    }

    function FillMissingWords_InitCode(QuestArrF) {
        $('#timeRes').text(QuestArrF[count].Timer+'s');
        let FillMissingWordsObj = QuestArrF[count].TaskObj;
        FMWText = FillMissingWordsObj.incompleteText;
        FillMissingWordsObj.missedWords.forEach(element => {
            let underlined = 'style="color: green"';
            let emptyElHTML;
            if (!Array.isArray(element))
            {
                emptyElHTML = `<span class="textPiece" ${underlined}}>${element}</span>`;
            }
            else
            {
                if (!element[1])
                {
                    underlined = 'style="text-decoration: underline; color: red"';
                }
                emptyElHTML = `<span class="textPiece" ${underlined}}>${element[0]}</span>`;
            } 
            FMWText = FMWText.replace('_____', emptyElHTML);
        });
        $('#FMW_InputText').html(FMWText);
    }

    function randColArrGenerator(num) {
        let colArr = new Array();
        for (let i = 0; i < num; i++){
            let red = Math.floor(Math.random() * 255);
            let green = Math.floor(Math.random() * 255);
            let blue = Math.floor(Math.random() * 255);
            let newRandCol = `rgb(${red},${green},${blue})`;
            colArr.push(newRandCol);
        }
        return(colArr);
    }

    function TermToDef_InitCode(QuestArrF) {
        $('#timeRes').text(QuestArrF[count].Timer+'s');
        let termToDefColl = QuestArrF[count].TaskObj;
        console.log(termToDefColl);
        let i = 0;
        colArr = randColArrGenerator(termToDefColl.paired.length + termToDefColl.singleTerms.length); //not really important if singleTerms or singleDefs
        termToDefColl.paired.forEach(element => {
            let newTermBlock = `
            <div class="blockcol termBlock" style="background-color: ${colArr[i]}">${element.term}</div>`;
            $('#termPart').append(newTermBlock);

            let newDefBlock = `
            <div class="blockcol defBlock" style="background-color: ${colArr[i]}">${element.def}</div>`;
            $('#defPart').append(newDefBlock);
            i++;
        })
        termToDefColl.singleTerms.forEach(element => {
            let newTermBlock = `<div class="blockcol termBlock">${element.term}</div>`;
            $('#termPart').append(newTermBlock);
        });
        termToDefColl.singleDefs.forEach(element => {
            let newDefBlock = `<div class="blockcol defBlock">${element.def}</div>`;
            $('#defPart').append(newDefBlock);
        });
    }

});