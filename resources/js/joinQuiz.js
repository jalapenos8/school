import { SpawnAlert, Alert } from './alert.js';

$(document).ready(function () {
    SpawnAlert();

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

    $("#joinBtn").click(function (e) { 
        e.preventDefault();

        if (checkEmptyInp($('#JoinQuiz_Block')))
        {
            let QuizCode = $("#QuizCode").val().trim();

            let xhr = new XMLHttpRequest();

            xhr.open('GET', 'php/joinQuizSQL.php?QuizCode=' + QuizCode, true);

            xhr.onload = function () {
                let response = xhr.response;

                if (!response.includes('Error!'))
                {
                    window.open("quizInterface.php?QuizCode=" + QuizCode, "_self");
                }
                else
                {
                    Alert(response);
                }
            }

            xhr.send();
        }
    });
});