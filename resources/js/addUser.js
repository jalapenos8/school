import { SpawnAlert, Alert } from './alert.js';

$(document).ready(function () {
    SpawnAlert();
    
    function emptyCheck (a, b){
        if ((a!='' && a!=null)&&(b!='' && b!=null))
        {  
            return true;
        }
        else
        {
            alert("Please enter login and password");
            return false;
        }
    }

    function lengthCheck (a, b){
        if ((a.length>=7)&&(b.length>=7))
        {  
            return true;
        }
        else
        {
            Alert("Login and password have to contain at least 7 characters");
            return false;
        }
    }

    $("#sendFormBtn").click(function (e) {
        e.preventDefault();

        let a = $("#Login").val(); 
        let b = $("#Password").val(); 
        if (emptyCheck(a,b) && lengthCheck(a,b))
        {
            let xhr = new XMLHttpRequest();
        
            xhr.open('POST', 'php/addUserSQL.php', true);
        
            xhr.onload = function () {
                let response = xhr.response;
            }
        
            let formData = new FormData();
            formData.append('Login', a);
            formData.append('Password', b);
        
            xhr.send(formData);
        }
    });
});


