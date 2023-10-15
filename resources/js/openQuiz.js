import { SpawnAlert, Alert } from './alert.js';

$(document).ready(function () {
    SpawnAlert();

    function retrieveQuizInfoRow(quizID, quizAssoc) {
        let dis = '';
        let btntype = 'button1';
        if (!quizAssoc.QuizCode)
        {
            dis = 'disabled'
            btntype = 'button2';
        }
        let QuizRow = `
        <div class="row">
            <div class="col Header3">
                ${quizAssoc.Name}
            </div>
            <div class="col Regular">
                ${quizAssoc.Description}
            </div>
            <div class="col Regular">
                ${quizAssoc.NumberOfQuestions}
            </div>
            <div class="col">
                <button class="button3 Regular getCodeBtn">Get a code</button>
                <button class="${btntype} Regular resultsBtn" ${dis}>Results</button>
            </div>
            <div class="col">
                <span class="QuizId">${quizID}</span>
                <span class="QuizCode">${quizAssoc.QuizCode}</span>
            </div>
        </div>
        `;
        return QuizRow;
    }

    function checkEmptyInp(obj) {
        let boo = true;
        obj.find('textarea, input[type="text"]').each(function() {
            if ($(this).val().trim()==0)
            {
                boo = false;
                $(this).css('background-color', '#b22f2f');
                setTimeout(() => {
                    $(this).css('background-color', 'transparent');
                }, 2000);
            }
        });
        if (!boo)
        {
            Alert('All input fields must be filled');
        }
        return boo;
    }

    $('#refreshRandBtn').click(function (e) { 
        e.preventDefault();
        
        let xhr = new XMLHttpRequest();

        xhr.open('GET', 'php/openQuizSQL1.php', true);

        xhr.onload = function () {
            if (!xhr.response.includes('No quiz found') && !xhr.response.includes('Error'))
            {
                let response = JSON.parse(xhr.response);
                let updatedRes = '';
                for (let quizID in response) {
                    if (response.hasOwnProperty(quizID)) {
                        let quiz = response[quizID];
                        updatedRes += retrieveQuizInfoRow(quizID, quiz);
                    }
                }

                $('#quizInfoTable').html(updatedRes);
            }
            else
            {
                $('#quizInfoTable').html(`<div class="FontWarning text-white"><i>Nothing found</i></div>`);
            }
        }
        xhr.send();
    });
    
    $('#searchBtn').click(function (e) { 
        e.preventDefault();
        
        if (checkEmptyInp($('#searchField')))
        {
            let QuizSearch = $('#searchQuiz').val();

            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'php/openQuizSQL0.php', true);
            xhr.onload = function () {
                if (!xhr.response.includes('No quiz found') && !xhr.response.includes('Error'))
                {
                    let response = JSON.parse(xhr.response);
                    let updatedRes = '';
                    for (let quizID in response) {
                        if (response.hasOwnProperty(quizID)) {
                            let quiz = response[quizID];
                            updatedRes += retrieveQuizInfoRow(quizID, quiz);
                        }
                    }
                    $('#quizInfoTable').html(updatedRes);
                }
                else
                {
                    $('#quizInfoTable').html(`<div class="FontWarning text-white"><i>Nothing found</i></div>`);
                }
            }
            let formData = new FormData();
            formData.append('QuizName', QuizSearch);
            xhr.send(formData);
        }
    });


    
    $('#quizInfoTable').on('click', '.getCodeBtn', function() {
        let quizID = $(this).parents('.row').find('.QuizId').text().trim();
        $('.ShowQuizWrapper').addClass('d-flex');
        $('.OpenQuiz_MainContainer').hide(); 
        if (!$(this).parents('.row').find('.QuizCode').text().trim())
        {
            let xhr = new XMLHttpRequest();
            let thisBtn = $(this);
    
            xhr.open('POST', 'php/openQuizSQL.php', true);
    
            xhr.onload = function () {
                let code = xhr.response;
                if (!code.includes('Error') && !code.includes('No quiz found'))
                {
                    $(thisBtn).parents('.row').find('.QuizCode').text(code);

                    thisBtn.parents('.row').find('.resultsBtn').removeAttr('disabled');
                    thisBtn.parents('.row').find('.resultsBtn').removeClass('button2');
                    thisBtn.parents('.row').find('.resultsBtn').addClass('button1');

                    $('#QuizCodeHolder').text(code);
                }
            }
            let formData = new FormData();
            formData.append('QuizID', quizID);
            xhr.send(formData);
        }
        else
        {
            let code = $(thisBtn).parents('.row').find('.QuizCode').text().trim();
            $('#QuizCodeHolder').text(code);                                        //copied bcs asynchoronous
        }
    });


    $('#ShowQuizBackBtn').click(function (e) { 
        e.preventDefault();
        
        $('.ShowQuizWrapper').removeClass('d-flex');
        $('.OpenQuiz_MainContainer').show();
    });


    
    $('#quizInfoTable').on('click', '.resultsBtn', function() {
        let code = $(this).parents('.row').find('.QuizCode').text();
        if (code!='')
        {
            window.open(`resultsForTeacher.php?QuizCode=${code}`, "_self");
        }
    }); 

    $('#refreshRandBtn').click();
});