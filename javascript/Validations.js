var fname = document.getElementById('firstName');
var lname = document.getElementById('lastName');
var useraddress = document.getElementById('address');
var userbday = document.getElementById('bDay');
var gender = document.getElementById('gender');
var usermail = document.getElementById('email');
var tel= document.getElementById('telephoneNo');
var pass= document.getElementById('password');
var cmfpass =  document.getElementById('confirmPassword');
var agree = document.getElementById('agreement');
var agreeStatement = document.getElementById('agreementStatement');
var formWarnings = document.getElementsByClassName('warning');



function validate_update(){
    normalizeFields();
    var fill = fname.value.length !=0 && lname.value.length !=0 && useraddress.value.length !=0 && userbday.value.length !=0 && usermail.value.length !=0
        && tel.value.length !=0 && gender.selectedIndex !=0;
    if(!fill){
        alert("Please fill all the details !");
        return false;
    }

    var fnameCheck = false;
    if(isAlpha(fname.value)){
        fnameCheck = true;
    }else {
        fnameCheck = false;
        errorCss(fname);
        formWarnings[0].innerText = "first name only contain letters";
    }

    var lnameCheck = false;
    if(isAlpha(lname.value)){
        lnameCheck = true;
    }else {
        lnameCheck = false;
        errorCss(lname);
        formWarnings[0].innerText = "last name only contain letters";
    }


    //Email Validate
    var mailCheck = false;
    if(usermail.value.indexOf('@')>-1){
        if(usermail.value.indexOf('gmail.com')>-1){
            mailCheck = true;
        }else if(fill){
            mailCheck = false;
            errorCss(usermail);
            formWarnings[1].innerText = "please use gmail addresses !";
            //alert("Please use GMAIL address !");
        }
    }
    else if(fill){
        mailCheck = false;
        errorCss(usermail);
        formWarnings[1].innerText = "email must contain @ sign";
        //alert("Invalid Email Address !");
    }

    //Tele Validate
    var telCheck =false;
    if(tel.value.length >0 && tel.value.length==10){
        if(isNumeric(tel.value)) {
            telCheck = true;
        }else {
            formWarnings[3].innerText = "telephone only contain numbers";
            errorCss(tel);
            telCheck = false;
        }
    }else if(fill){
        telCheck = false;
        errorCss(tel);
        formWarnings[2].style.color = "red";
       // alert("Invalid Telephone Number !");
    }



    return fill &&fnameCheck && lnameCheck && mailCheck && telCheck;

    /*if(fill &&fnameCheck && lnameCheck && mailCheck && telCheck && passCheck && agreeCheck){
        document.getElementById('id01').style.display='block';
    }else {
        pass.value = "";
        cmfpass.value = "";
        agree.checked = false;
        innerJump("signup");
    }*/

}

function validate_signup(validated){
    var fill = validated && pass.value.length !=0 && cmfpass.value.length !=0;
    if(pass.value.length ==0 && cmfpass.value.length ==0){
        alert("Please fill all the details !");
        return false;
    }

    // Password == Con Pass
    var passCheck = false;
    if(pass.value.length>=8) {
        if (pass.value === cmfpass.value) {
            passCheck = true;
        } else if (fill) {
            passCheck = false;
            errorCss(pass);
            errorCss(cmfpass);
            formWarnings[4].innerText = "password mismatched !";
            //alert("Password mismatched !");
        }
    }else {
        passCheck = false;
        errorCss(pass);
        errorCss(cmfpass);
        formWarnings[4].innerText = "password must have 8-16 digits !";
        //alert("Password must have 8-16 digits !");
    }

    var agreeCheck;
    if(agree.checked){
        agreeCheck = true;
    }
    else if(fill){
        agreeCheck = false;
        agreeStatement.style.color = '#ff0000';
    }

    if(fill && passCheck && agreeCheck){
        document.getElementById('id01').style.display='block';
    }else {
        pass.value = "";
        cmfpass.value = "";
        agree.checked = false;
        errorCss(pass);
        errorCss(cmfpass);
        agreeStatement.style.color = '#ff0000';
        innerJump("signup");
    }
}

function errorCss(tagId){
    tagId.style.borderColor = "red";
    tagId.style.boxShadow = "red";
}

function normalizeFields() {
     fname.style.borderColor = "";
     fname.style.boxShadow = "";

    lname.style.borderColor = "";
    lname.style.boxShadow = "";

    useraddress.style.borderColor = "";
    useraddress.style.boxShadow = "";

    userbday.style.borderColor = "";
    userbday.style.boxShadow = "";

    usermail.style.borderColor = "";
    usermail.style.boxShadow = "";

    tel.style.borderColor = "";
    tel.style.boxShadow = "";

    pass.style.borderColor = "";
    pass.style.boxShadow = "";

    cmfpass.style.borderColor = "";
    cmfpass.style.boxShadow = "";

    gender.style.borderColor = "";
    gender.style.boxShadow = "";

    agreeStatement.style.color = "";

    for(var i =0;i<formWarnings.length;i++){
        if(i!=2) {
            formWarnings[i].innerText = '';
        }else {
            formWarnings[i].style.color = 'black';
        }
    }

}

function isNumeric(input) {
    return !isNaN(parseFloat(input)) && isFinite(input);
}

function isAlpha(input){
   return /^[a-zA-Z]*$/.test(input);
}

function innerJump(id){
    var url = location.href;               //Save down the URL without hash.
    location.href = "#"+id;                 //Go to the target element.
    history.replaceState(null,null,url);   //Don't like hashes. Changing it back.
}