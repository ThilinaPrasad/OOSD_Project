
function validate_general(fname,lname,useraddress,userbday,gender,usermail,tel){

    var fill = fname.value.length !=0 && lname.value.length !=0 && useraddress.value.length !=0 && userbday.value.length !=0 && usermail.value.length !=0
        && tel.value.length !=0 && gender.selectedIndex !=0;
    console.log(fname.value);

    if(!fill){
        alert("Please fill all the details !");
        return false;
    }

    normalizeFields_general();

    var fnameCheck = false;
    if(isAlpha(fname.value)){
        fnameCheck = true;
    }else {
        fnameCheck = false;
        fieldColorChange(fname,"red");
        formWarnings[0].innerText = "first name only contain letters";
    }

    var lnameCheck = false;
    if(isAlpha(lname.value)){
        lnameCheck = true;
    }else {
        lnameCheck = false;
        fieldColorChange(lname,"red");
        formWarnings[0].innerText = "last name only contain letters";
    }


    //Email Validate
    var mailCheck = false;
    if(usermail.value.indexOf('@')>-1){
        if(usermail.value.indexOf('gmail.com')>-1){
            mailCheck = true;
        }else if(fill){
            mailCheck = false;
            fieldColorChange(usermail,"red");
            formWarnings[1].innerText = "please use gmail addresses !";
            //alert("Please use GMAIL address !");
        }
    }
    else if(fill){
        mailCheck = false;
        fieldColorChange(usermail,"red");
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
            fieldColorChange(tel,"red");
            telCheck = false;
        }
    }else if(fill){
        telCheck = false;
        fieldColorChange(tel,"red");
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

function validate_signup(validated,pass,cmfpass,agree,agreeStatement){
    normalizeFields_signup();
    var fill = validated && pass.value.length !=0 && cmfpass.value.length !=0;
    if(fill && pass.value.length ==0 && cmfpass.value.length ==0){
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
            fieldColorChange(pass,"red");
            fieldColorChange(cmfpass,"red");
            formWarnings[4].innerText = "password mismatched !";
            //alert("Password mismatched !");
        }
    }else {
        passCheck = false;
        fieldColorChange(pass,"red");
        fieldColorChange(cmfpass,"red");
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
        fieldColorChange(pass,"red");
        fieldColorChange(cmfpass,"red");
        agreeStatement.style.color = '#ff0000';
        innerJump("signup");
    }
}

function validate_update(validated,jumpLink){
    if(validated){
        document.getElementById('id01').style.display='block';
    }else {
        innerJump(jumpLink);
    }
}

function fieldColorChange(tagId,color){
    tagId.style.borderColor = color;
    tagId.style.boxShadow = color;
}

function normalizeFields_general() {
     fieldColorChange(fname,"");
    fieldColorChange(lname,"");
    fieldColorChange(useraddress,"");
    fieldColorChange(userbday,"");
    fieldColorChange(usermail,"");
    fieldColorChange(tel,"");
    fieldColorChange(gender,"");


    for(var i =0;i<formWarnings.length;i++){
        if(i!=2) {
            formWarnings[i].innerText = '';
        }else {
            formWarnings[i].style.color = 'black';
        }
    }

}

function normalizeFields_signup(){
    fieldColorChange(pass,"");

    fieldColorChange(cmfpass,"");

    agreeStatement.style.color = "";
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