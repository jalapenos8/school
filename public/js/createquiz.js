function SpawnAlert()
{
    let theCdo = `
    <input type="checkbox" checked='false' id="alertCheckBox">
    <label for="alertCheckBox" id="AlertWindow">
    Error!
    <p>You must have no empty fields!</p>
    </div>`;
    $('body').append(theCdo);
}
function Alert(textik)
{
    $('#AlertWindow p').text(textik);
    $('#alertCheckBox').prop('checked', false);
    setTimeout(() => {
        $('#alertCheckBox').prop('checked', true);
    }, 2500);
}
$(document).ready(function () {
    class Task{
        constructor(Name, TaskObj, Timer=15){
            this.Name = Name;
            this.TaskObj = TaskObj;  
            this.Timer = Timer;
        }
    }
    class TestQuestion{
        constructor(quest, opts, ans){
            this.quest = quest;
            this.opts = opts;       //array
            this.ans = ans;         //array
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
    
    /* GENERAL VARIABLES */
    var quizType;
    var QuestArr = new Array();
    var NewTaskBeingAdded = false;
    var count = 0;


    /* SPECIFIC VARIABLES */
    var groupNum = 2; //GS
    // TTD
    var colArr = ColArrGenerator(12);
    var PairNum = 0;

    

                                                        /* ___GENERAL_PART_START___ */                                  
function BtnsDisplay() {
    if (NewTaskBeingAdded)
    {
        $('#Add_btn').hide();
        $('#Save_btn').show();
    }
    else
    {
        $('#Add_btn').show();
        $('#Save_btn').hide();
    }
}

function saveBtn(save){
    save.Timer = $('#timerInp').val();
    console.log(save);
    if (NewTaskBeingAdded)
    {
        QuestArr.push(save);

        NewTaskBeingAdded = false;
        let OutType;
        switch(quizType)
        {
            case "TestQuestion":
                OutType = 'Test Question';
                break;
            case "GroupSort":
                OutType = 'Group Sorting';
                break;
            case "PutInOrder":
                OutType = 'Put In Order';
                break;
            case "FillMissingWords":
                OutType = 'Fill Missing Words';
                break;
            case "TermToDef":
                OutType = 'Term to Definition';
                break;
        }
        $('#createdQuestionsContainer').find('ol').append(`<li>${OutType}</li>`);
        
        NewTaskBeingAdded = false;
    }
    else
    {
        QuestArr[count] = save;
    }
    
    NewTaskBeingAdded = false;


    $('body').find('#MainContainer').empty();
    BtnsDisplay();
    console.log(QuestArr);
    $('.createQuizContainer').hide();
}

function pageTransition(){
    $('#MainContainer').empty();

    quizType = QuestArr[count].Name;
    let url = `/storage/quiztypes/${quizType}.html`;
    $('#MainContainer').load(url, function(){
        let InitCodeStr = `
        ${quizType}_InitCode();
        `;
        eval(InitCodeStr);
    });
    $('#QuestionNum').text(`Question ${count+1}`);

    BtnsDisplay();
    $('.createQuizContainer').css('display', 'flex');
}

function defaultVals() {
    groupNum = 2; 
    contentChanged = false; //PIO
    colArr = ColArrGenerator(12);
    PairNum = 0;
}

function checkEmptyInp(obj) {
    let boo = true;
    let style;
    obj.find('textarea, input[type="text"]').each(function() {
        if ($(this).val().trim()==0)
        {
            style = $(this).attr('style');
            boo = false;
            $(this).css('background-color', '#b22f2f');
            setTimeout(() => {
                if (style)
                {
                    $(this).attr('style', style);
                }
                else
                {   
                    $(this).removeAttr('style');
                }
            }, 2000);
        }
    });
    obj.find('div[contenteditable="true"]').each(function() {
        if ($(this).text().trim()==0)
        {   
            style = $(this).attr('style');
            boo = false;
            $(this).css('background-color', '#b22f2f');
            setTimeout(() => {
                if (style)
                {
                    $(this).attr('style', style);
                }
                else
                {   
                    $(this).removeAttr('style');
                }
            }, 2000);
        }
    });
    if (!boo)
    {
        Alert('All input fields must be filled');
    }
    return boo;
}


/* GENERAL EVENTS */
SpawnAlert();

$("#toolsSection").on('click', '.newTaskClicked', function() {
    quizType = $(this).attr("id");
    NewTaskBeingAdded = true;
    let url = `/storage/quiztypes/${quizType}.html`;

    $('#MainContainer').load(url, function(){
        let InitCodeStr = `
        ${quizType}_InitCode();
        `;
        eval(InitCodeStr);
    });
    $('#QuestionNum').text(`Question ${QuestArr.length+1}`);
    
    BtnsDisplay();
    $('.createQuizContainer').css('display', 'flex');
});

$("#toolsSection").on('click', '#Save_btn', function() {
    if (checkEmptyInp($('#MainContainer')))
    {
        let SaveCodeStr = `
        saveBtn(${quizType}_saveInput());
        `;
        eval(SaveCodeStr);
    }
});  


$(".contHeadPart").on('click', '#Del_btn', function() {
    if (NewTaskBeingAdded)
    {
        $('#MainContainer').empty();
    }
    else
    {
        QuestArr.splice(count, 1);
        $('#createdQuestionsContainer').find('ol').children().eq(count).remove();
        $('#MainContainer').empty();
    }
    NewTaskBeingAdded = false;
    BtnsDisplay();
    $('.createQuizContainer').hide();
});

$("#createdQuestionsContainer").on('click', 'li', function() {
    count = $(this).index();
    NewTaskBeingAdded = false;
    pageTransition();
    $('#Add_btn').hide();
    $('#Save_btn').show();
}); 

$("#toolsSection").on('click', '#Exit_btn', function() {
    window.open(route('units.show', [subjectID, unitID]), "_self");
});

$("#toolsSection").on('click', '#Finish_btn', function() {
    if ($('#createdQuestionsContainer ol').children().length != 0)
    {
        $('.createQuiz_MainContainer').hide();
        $('.PostQuizContainer').css('display', 'flex');
    }
    else
    {
        Alert('No task created');
    }
});

$("#toolsSection").on('click', '#Back_btn', function() {
    $('.createQuiz_MainContainer').show();
    $('.PostQuizContainer').hide();
});
   

$('#Post_btn').click(function (e) { 
    e.preventDefault();
    
    if (checkEmptyInp($('#PostQuizFormContainer')))
    {
        let QuizName = $('#QuizName').val().trim();
        let QuizDescription = $('#QuizDescription').val().trim();
        let token = $('input[name="_token"]').val().trim();
    
        var xhr = new XMLHttpRequest();
        xhr.open('POST', route('quizzes.createSQL', [subjectID, unitID]), true);
        xhr.onload = function () {
            let response = xhr.response
            console.log(response);
            if (response.includes('Success'))
            {
                setTimeout(window.open(route('units.show', [subjectID, unitID]), "_self"), 2000);
            }
            else
            {
                Alert('Unexpected error');
            }
        }
        let formData = new FormData();
        formData.append('name', QuizName);
        formData.append('description', QuizDescription);
        formData.append('content', JSON.stringify(QuestArr));
        formData.append('max', QuestArr.length);
        console.log(formData);
        xhr.setRequestHeader('X-CSRF-Token', token);
        xhr.send(formData);
    }
});

BtnsDisplay();
                                                        /* ___GENERAL_PART_END___ */
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                                                        /* ___TEST_QUESTION_PART_START___ */
/* FUNCTIONS */
function TestQuestion_saveInput() {
    let quest = $("#question").val().trim();
    let opts = new Array();
    for (let i=1; i<=$('.TestQuestionOption').length; i++)
    {
        opts.push($(`#txt${i}`).val().trim());
    }
    let ans = $('input[type="checkbox"]:checked').parents('.TestQuestionOption').find('.TestQuestionOptionTextarea').map(function() {
        return $(this).val().trim();
        }).get();

    let newQuestTask = new TestQuestion(quest, opts, ans);

    let NewTask = new Task('TestQuestion', newQuestTask);

    return(NewTask);
}

function TestQuestion_InitCode() {
    if (!NewTaskBeingAdded)
    {
        let TestQuestionObject = QuestArr[count].TaskObj;

        $("#question").val(TestQuestionObject.quest);
        for (let i=1; i<=TestQuestionObject.opts.length; i++)
        {
            $('#AddNewOptionBtn').click();
            $(`#txt${i}`).val(TestQuestionObject.opts[i-1]);
        }
        for (let i=0; i<TestQuestionObject.ans.length; i++)
        {
            $('.TestQuestionOptionTextarea').filter(function() {
                return $(this).val() == TestQuestionObject.ans[i];
            }).parents('.TestQuestionOption').find('input[type="checkbox"]').prop("checked", true);
        }

        if ($('.TestQuestionOption').length>3)
        {
            $(this).hide();
        }
    }
    else
    {
        $('#AddNewOptionBtn').click();
        $('#AddNewOptionBtn').click();
    }
};


/* EVENTS */
$("#MainContainer").on('click', '.TestDeleteBtn', function() {
    if ($('.TestQuestionOption').length==2)
    {
        Alert('There has to be at least two options');
    }
    else
    {
        $(this).parents('.TestQuestionOption').remove();
        $('#AddNewOptionBtn').show();
    }
});

$("#MainContainer").on('click', '#AddNewOptionBtn', function() {
    let letArr = ['A', 'B', 'C', 'D'];
    let curNumTestOpts = $('.TestQuestionOption').length;
    curNumTestOpts++;
    let newOption = `
    <div class="TestQuestionOption" id="Ans${curNumTestOpts}">
        <div class="custom_checkbox">
            <input type="checkbox" id="c${curNumTestOpts}">
            <label for="c${curNumTestOpts}">
                <span>
                </span>
            </label>
        </div>
        <button class="TestDeleteBtn DelBtnHanging"></button>
        <p class="TestQuestionOptionLetterLabel">${letArr[curNumTestOpts-1]}</p>
        <textarea id="txt${curNumTestOpts}" maxlength="100" class="TestQuestionOptionTextarea" placeholder="Add an option"></textarea>
    </div>
    `;
    $("#options").append(newOption);

    if (curNumTestOpts>3)
    {
        $(this).hide();
    }
});
                                                        /* ___TEST_QUESTION_PART_END___ */

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                                                        /* ___GROUP_SORT_PART_START___ */
/* FUNCTIONS */
function GroupSort_saveInput() {
    let CorrectAnsArray = new Array();

    $('#MainContainer').find('.colGroupContainer').each(function() {
        let grName = $(this).find('.GroupName').val().trim();
        let grItems = $(this).find('.GroupItem').map(function() {            //return items groups as array
            return $(this).val().trim();
            }).get();
        let grObj = new GroupSort(grName, grItems);
        CorrectAnsArray.push(grObj);
        });
    
    let NewTask = new Task('GroupSort', CorrectAnsArray);
    
    return(NewTask);
    }


function GroupSort_InitCode() {
    if (!NewTaskBeingAdded)
    {
        let GroupSortArray = QuestArr[count].TaskObj;
        GroupSortArray.forEach(element => {
            retrieveInputedGroup(element);
        });
    
        if (GroupSortArray.length==4)
        {
            $('#AddNewGroupBtn').hide();
        }
    }
    else
    {
        addNewGroup();
        addNewGroup();
    } 
    }
    
function retrieveInputedGroup(GroupSort) {
    let itemsCode = '';
    GroupSort.items.forEach(element => {
        itemsCode += `<textarea class="col-10 GroupItem shadow" maxlength="30">${element}</textarea>`;
    });
    let addInputedGroup = `
    <div class="col-sm-6 col-12 colGroupContainer">
        <div class="GroupCard">
            <input type="text" maxlength="30" class="GroupName" placeholder="Group Name" value='${GroupSort.group}'>
            <hr>
            <div class="ItemsContainer">     
                ${itemsCode}
            </div>
        </div>
        <div class="btn-group GroupCardBtns">
            <button type="button" class="btn DeleteGroupBtn"></button>
            <hr>
            <button type="button" class="btn AddNewItemBtn"></button>
            <hr>
            <button type="button" class="btn RemoveItemBtn"></button>
        </div>
    </div> 
    `;
    $("#GroupsContainer").append(addInputedGroup);
    }

function addNewGroup() {
    let addNewGroup = `
    <div class="col-sm-6 col-12 colGroupContainer">
        <div class="GroupCard">
            <input type="text" class="GroupName" placeholder="Group Name">
            <hr>
            <div class="ItemsContainer">     
                <textarea class="col-10 GroupItem shadow" maxlength="30"></textarea>
            </div>
        </div>
        <div class="btn-group GroupCardBtns">
            <button type="button" class="btn DeleteGroupBtn"></button>
            <hr>
            <button type="button" class="btn AddNewItemBtn"></button>
            <hr>
            <button type="button" class="btn RemoveItemBtn"></button>
        </div>
    </div>
    `
    $("#GroupsContainer").append(addNewGroup);
    }


/* EVENTS */
$("#MainContainer").on('click', '#AddNewGroupBtn', function() {        
    addNewGroup();
    groupNum++;
    if (groupNum>=4)
    {
        $(this).hide();
    }
});

$("#MainContainer").on('click', '.DeleteGroupBtn', function() {
    if (groupNum <= 2)
    {
        Alert("There has to be at least two groups");
    }
    else
    {
        $(this).parents('.colGroupContainer').remove();
        groupNum--;
        $("#AddNewGroupBtn").show();
    }
});

$("#MainContainer").on('click', '.AddNewItemBtn', function() {
    let newItem = `<textarea class="col-10 GroupItem shadow" maxlength="30"></textarea>`;

    $(this).parents(".colGroupContainer").find(".ItemsContainer").append(newItem);
});

$("#MainContainer").on('click', '.RemoveItemBtn', function() {
    if ($(this).parents(".colGroupContainer").find(".GroupItem").length !=0)
    {
        $(this).parents(".colGroupContainer").find(".GroupItem").last().remove();
    }
    else
    {
        Alert("No item in the group")
    }
});
                                                        /* ___GROUP_SORT_PART_END___ */

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                                                        /* ___PUT_IN_ORDER_PART_START___ */
/* FUNCTIONS */
function PutInOrder_saveInput() {
    let sentence = $('#sentenceInput').val().trim();
    let thePutInOrderAns = new PutInOrder(sentence, splitWords(sentence));

    let NewTask = new Task('PutInOrder', thePutInOrderAns);

    return(NewTask);
    }
    
function PutInOrder_InitCode() {
    if (!NewTaskBeingAdded)
    {
        var PutInOrder = QuestArr[count].TaskObj;
        $('#sentenceInput').val(PutInOrder.sentence);
        $("#sentenceInput").trigger("input");
    }
    }

function splitWords(str) {
    var wordsArr = str.split(/\s+/);
    var wordsArrProp = new Array();
    var tempHolder = '';
    for (let i=0; i<wordsArr.length; i++)
    {
        if (tempHolder != '')
        {
            tempHolder += ' ';
        }
        tempHolder += wordsArr[i];
        if(tempHolder.length>=3 || i==wordsArr.length-1)
        {
            wordsArrProp.push(tempHolder);
            tempHolder = '';
        }
    }
    return (wordsArrProp);
    }

/* EVENTS */
$("#MainContainer").on('click', '#sentenceInput.PIOInit', function() {
    if ($('#sentenceInput').text().trim()=='Sample text')
    {
        $('#sentenceInput').text('');
        $('#sentenceOutput').html('');
    }
    $('#sentenceInput').removeClass('PIOInit');
});
$("#MainContainer").on("input", "#sentenceInput", function() {
    let theText = '';
    let initTextArr = splitWords($('#sentenceInput').val().trim());
    initTextArr.forEach(element => {
        theText += `<span>${element}</span> `;
    });
    $('#sentenceOutput').html(theText.trim());
});
                                                        /* ___PUT_IN_ORDER_PART_END___ */

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                                                        /* ___FILL_MISSING_WORDS_PART_START___ */
/* FUNCTIONS */
function FillMissingWords_saveInput() {
    let CompleteText = $('#FMW_InputText').text().trim();

    if ($('#FMW_InputText span').length==0)
    {
        let text = $('#FMW_InputText').text();
        let firstWord = /\b\w+\b/;
        let replacedText = text.replace(firstWord, function(match) {
            return '<span>' + match + '</span>';
        });
        $('#FMW_InputText').html(replacedText);
    }

    let Items = $('#FMW_InputText').find('span').map(function() {
        if ($(this).text()!='') {
            return $(this).text();
        }
        }).get();

    $('#FMW_InputText').find('span').before('_____');
    $('#FMW_InputText').find('span').remove();
    
    let IncompleteText = $('#FMW_InputText').text().trim();

    let theFillMissingWordsTask = new FillMissingWords(CompleteText, Items, IncompleteText);

    let NewTask = new Task('FillMissingWords', theFillMissingWordsTask);
    
    return(NewTask);
}

function FillMissingWords_InitCode() {
    if (!NewTaskBeingAdded)
    {
        $('#FMW_SaveInputTextBtn').removeAttr('disabled');
        let FillMissingWordsObj = QuestArr[count].TaskObj;
        retrieveInputedText(FillMissingWordsObj);
    }
}
    
function retrieveInputedText(FillMissingWords) {
    let theText =  FillMissingWords.incompleteText;
    FillMissingWords.missedWords.forEach(element => {
        let spanEl = `<span>${element}</span>`;
        theText = replaceSubstring(theText, '_____', spanEl);
    });

    $('#FMW_InputText').html(theText);
    $('#FMW_OutputText').html(theText);
    $('#FMW_SaveInputTextBtn').click();
}
    

// Function to ensure that a text was selected
function getSelectedText() {
    let text = '';
    if (window.getSelection) {
        text = window.getSelection().toString();
    } else if (document.selection && document.selection.type !== 'Control') {
        text = document.selection.createRange().text;
    }
    return text;
}
// Function to highlight the selected text
function highlightSelectedText() {
    let selection = window.getSelection();
    if (selection.rangeCount > 0) {
        let range = selection.getRangeAt(0);
        let startNode = range.startContainer;
        let endNode = range.endContainer;
        let startOffset = range.startOffset;
        let endOffset = range.endOffset;
        [startOffset, endOffset] = startEndWord(startNode, endNode, startOffset, endOffset);

        range.setStart(startNode, startOffset);
        range.setEnd(endNode, endOffset);

        let selectedText = range.toString();
        console.log(startOffset, endOffset);
        console.log(selectedText);
        let newNode = $('<span>').text(selectedText);
        
        range.deleteContents();
        range.insertNode(newNode[0]);
        selection.removeAllRanges();
    }
}
function startEndWord (startNode, endNode, startOffset, endOffset) {
    let wordbreakers = [' ', '.', ',', '-', ':', ';', '!','?', '\n']
    if(startOffset!=0)
    {
        let firstChar = startNode.textContent.charAt(startOffset-1);    //we need a word start at startoffset, so wordbreaker is before it
        while (!wordbreakers.includes(firstChar))
        {
            startOffset--;
            if (startOffset==0)
            {
                break;
            }
            firstChar = startNode.textContent.charAt(startOffset-1);
        }
    }
    if(endOffset!=endNode.length)
    { 
        let lastChar = endNode.textContent.charAt(endOffset);         //endOffset is not inclusive
        while (!wordbreakers.includes(lastChar))
        {
            endOffset++;
            if (endOffset==endNode.length)
            {
                break;
            }
            lastChar = endNode.textContent.charAt(endOffset);
        }
    }
    return [startOffset, endOffset];
}

function replaceSubstring(originalString, substringToReplace, newSubstring) {
    let index = originalString.indexOf(substringToReplace);
    if (index !== -1) {
        let modifiedString = originalString.substring(0, index) + newSubstring + originalString.substring(index + substringToReplace.length);
        return modifiedString;
    }
    return originalString; // Substring not found, return the original string
    }


/* EVENTS */
$("#MainContainer").on('click', '#FMW_InputText.FMWInit', function() {
    if ($('#FMW_InputText').text().trim()=='Sample text')
    {
        $('#FMW_InputText').text('');
        $('#FMW_OutputText').html($('#FMW_InputText').html());
    }
    $(this).removeClass('FMWInit');
    $('#FMW_SaveInputTextBtn').removeAttr('disabled');
});

$("#MainContainer").on('click', '#FMW_SaveInputTextBtn', function() {
    if ($('#FMW_InputText').text().trim().length!=0)
    {
        $('#FMW_InputText').removeAttr('contenteditable');
        $(this).hide();
        $('#FMW_EditInputTextBtn').show();
        let selection = window.getSelection();
        selection.removeAllRanges();
        $('#FMW_InputText').css('border-color', '#0092c2')
    }
});
$("#MainContainer").on('click', '#FMW_EditInputTextBtn', function() {
    $('#FMW_InputText').attr('contenteditable', true);
    $(this).hide();
    $('#FMW_SaveInputTextBtn').show();
    $('#FMW_InputText').css('border-color', '#00C270')
});

$("#MainContainer").on("input", "#FMW_InputText", function() {
    $('#FMW_OutputText').html($('#FMW_InputText').html());
});

$("#MainContainer").on('mouseup', '#FMW_InputText:not([contenteditable="true"])', function() {
    if (getSelectedText() !== '') {
        highlightSelectedText();
    }
    $('#FMW_OutputText').html($('#FMW_InputText').html());
});

$("#MainContainer").on('click', '#FMW_InputText:not([contenteditable="true"]) span', function() {
    $(this).before($(this).text());
    $(this).remove();
    $('#FMW_OutputText').html($('#FMW_InputText').html());
});
                                                        /* ___FILL_MISSING_WORDS_PART_END___ */

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                                                        /* ___TERM_TO_DEF_PART_START___ */
/* FUNCTIONS */
function TermToDef_saveInput() {
    let pairedArr = new Array();
    let singleTermsArr = new Array();
    let singleDefsArr = new Array();
    
    for(let i=1; i<=6; i++)
    {
        let theTerm = $('#MainContainer').find(`.t${i}`).val();

        let theDef = $('#MainContainer').find(`.d${i}`).val();

        if (theTerm && theDef)
        {
            let newTermToDefPaired = new TermToDefItem(theTerm.trim(), theDef.trim());    
            pairedArr.push(newTermToDefPaired);
        }
    }

    $('#MainContainer .t0').each(function() {
        let newTerm = $(this).val().trim();
        let ttdobj = new TermToDefItem(newTerm, null);
        singleTermsArr.push(ttdobj);
        })
    
    $('#MainContainer .d0').each(function() {
        let newDef = $(this).val().trim();
        let ttdobj = new TermToDefItem(null, newDef);
        singleDefsArr.push(ttdobj);
        })

    let theTermToDefAns = new TermToDefCollection(pairedArr, singleTermsArr, singleDefsArr);
    let NewTask = new Task('TermToDef', theTermToDefAns);
    
    return(NewTask);
}

function TermToDef_InitCode() {
    if (!NewTaskBeingAdded)
    {
        let TermToDefColl = QuestArr[count].TaskObj;
        retrieveTermsAndDefs(TermToDefColl);
        PairNum = TermToDefColl.paired.length;
    }
    else
    {
        $('#addPairBtn').click();
    }
}

function addTermBlock(num=0, styler='') {
    let newTermBlock = `<textarea class="blockcol termBlock t${num}" maxlength="100" ${styler}></textarea>`;

    $('#termPart').append(newTermBlock);
}
function addDefBlock(num=0, styler='') {
    let newDefBlock = `<textarea class="blockcol defBlock d${num}" maxlength="100" ${styler}></textarea>`;

    $('#defPart').append(newDefBlock);
}
function TTDbuttonCheck() { 
    $('#addTermBtn').removeAttr('disabled');
    $('#addDefBtn').removeAttr('disabled');
    $('#addPairBtn').removeAttr('disabled');

    let termNum = $('.termBlock').length;
    let defNum = $('.defBlock').length;
    if (termNum>=6)
    {
        $('#addTermBtn').attr('disabled', 'true');
        $('#addPairBtn').attr('disabled', 'true');
    }
    if (defNum>=6)
    {
        $('#addDefBtn').attr('disabled', 'true');
        $('#addPairBtn').attr('disabled', 'true');
    }
}

function ColArrGenerator(num) {
    let colArr = new Array();
    let spacing = 360/Number(num);
    for (let hue = spacing; hue <= 360; hue=hue+spacing){
        let newRandCol = `hsl(${hue}, 100%, 35%)`;
        colArr.push(newRandCol);
    }
    return(colArr);
}
 
function retrieveTermsAndDefs(termToDefColl) 
{
    let i = 1;
    termToDefColl.paired.forEach(element => {
        let newTermBlock = `<textarea class="blockcol termBlock t${i}" maxlength="100" style="background-color: ${colArr[i-1]}">${element.term}</textarea>`;
        $('#termPart').append(newTermBlock);

        let newDefBlock = `<textarea class="blockcol defBlock d${i}" maxlength="100" style="background-color: ${colArr[i-1]}">${element.def}</textarea>`;
        $('#defPart').append(newDefBlock);

        i++;
    })

    termToDefColl.singleTerms.forEach(element => {
        let newTermBlock = `<textarea class="blockcol termBlock t0" maxlength="100">${element.term}</textarea>`;
        $('#termPart').append(newTermBlock);
    });
    termToDefColl.singleDefs.forEach(element => {
        let newDefBlock = `<textarea class="blockcol defBlock t0" maxlength="100">${element.def}</textarea>`;
        $('#defPart').append(newDefBlock);
    }); 
}


/* EVENTS */
$("#MainContainer").on('click', '#addTermBtn', function() {
    addTermBlock();
    TTDbuttonCheck();
});

$("#MainContainer").on('click', '#addDefBtn', function() {
    addDefBlock();
    TTDbuttonCheck();
});

$("#MainContainer").on('click', '#addPairBtn', function() {
    let styler = `style="background-color: ${colArr[PairNum]}"`;
    PairNum++;
    addTermBlock(PairNum, styler);
    addDefBlock(PairNum, styler);
    TTDbuttonCheck();
});


                                                        /* ___TERM_TO_DEF_PART_END___ */

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


});