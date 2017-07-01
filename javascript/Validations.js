var fname = document.getElementById('firstName');
var lname = document.getElementById('lastName');
var useraddress = document.getElementById('address');
var userbday = document.getElementById('bDay');
var usermail = document.getElementById('email');
var tel= document.getElementById('telephoneNo');
var pass= document.getElementById('password');
var cmfpass =  document.getElementById('confirmPassword');
var agree = document.getElementById('agreement');
var gender = document.getElementById('gender');
var indexNo = document.getElementById('index');

function submitOnclick(){

    var fill = fname.value.length !=0 && lname.value.length !=0 && useraddress.value.length !=0 && userbday.value.length !=0 && usermail.value.length !=0
        && tel.value.length !=0 && pass.value.length !=0 && cmfpass.value.length !=0 && gender.selectedIndex !=0 && indexNo.value.length !=0;
    if(!fill){
        alert("Please fill all the details !");
    }

    //Email Validate
    var mailCheck = false;
    if(usermail.value.indexOf('@')>-1){
        if(usermail.value.indexOf('gmail.com')>-1){
            mailCheck = true;
        }else if(fill){
            mailCheck = false;
            errorCss(usermail);
            alert("Please use GMAIL address !");
        }
    }
    else if(fill){
        mailCheck = false;
        errorCss(usermail);
        alert("Invalid Email Address !");
    }

    //Tele Validate
    var telCheck =false;
    if(tel.value.length >0 && tel.value.length==10){
        telCheck = true;
    }else if(fill){
        telCheck = false;
        errorCss(tel);

        alert("Invalid Telephone Number !\n(Must contain 10 digits)");
    }


    // Password == Con Pass
    var passCheck = false;
    if(pass.value === cmfpass.value){
        passCheck = true;
    }else if(fill){
        passCheck = false;
        errorCss(pass);
        errorCss(cmfpass);
        alert("Invalid Password !");
    }

    var agreeCheck;
    if(agree.checked){
        agreeCheck = true;
    }
    else if(fill){
        agreeCheck = false;
        errorCss(agree);
    }

    return (fill && mailCheck && telCheck && passCheck && agreeCheck);

}

function errorCss(tagId){
    tagId.value = "";
    tagId.style.borderColor = "red";
    tagId.style.boxShadow = "red";

}
