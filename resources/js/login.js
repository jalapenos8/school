import { SpawnAlert, Alert } from './alert.js';

$(document).ready(function () {
    SpawnAlert();
    console.log('do');

    function emptyCheck (a){
        if (a!='' && a!=null)
        {  
            return true;
        }
        else
        {
            Alert("Please enter login");
            return false;
        }
    }


    $("#loginBtn").click(function (e) { 
        e.preventDefault();
        const urlParams = new URLSearchParams(window.location.search);
        const table = urlParams.get('user') + 's';                             //take value from url

        let a = $("#Loggg").val();

        if (emptyCheck(a)) 
        {
            var xhr = new XMLHttpRequest();
        
            xhr.open('POST', 'php/loginSQL.php', true);
        
            xhr.onload = function () {
                let response = xhr.response;
                if (!response.includes("Error!"))
                {
                    response = JSON.parse(response);
                    sessionStorage.setItem('ID', response.ID);
                    sessionStorage.setItem('Login', response.Login);
                    
                    if (table == "teachers")                     //open another html page
                    {
                        window.open("menuTeacher.php", "_self");  
                    }
                    else
                    {
                        window.open("joinQuiz.php", "_self");  
                    }
                }
                else
                {
                    Alert(response);
                }
            }
        
            let formData = new FormData();
            formData.append('Login', $('#Loggg').val());  
            formData.append('Password', $('#Password').val());  
            formData.append('Table', table);        //https://developer.mozilla.org/en-US/docs/Web/API/FormData/Using_FormData_Objects
        
            xhr.send(formData);
        }
    });

    $('#backBtn').click(function (e) { 
        e.preventDefault();
        
        window.open("index.php", "_self");  
    });
});