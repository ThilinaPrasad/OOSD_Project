/**
 * Created by user on 7/6/2017.
 */

/////////////////// Validations for Update Data////////////////////////////////

var fname = document.getElementById('ofirstName');
var lname = document.getElementById('olastName');
var useraddress = document.getElementById('oaddress');
var userbday = document.getElementById('obDay');
var gender = document.getElementById('ogender');
var usermail = document.getElementById('oemail');
var tel= document.getElementById('otelephoneNo');
var formWarnings = document.getElementsByClassName('warning');

function updateValidationOnclick() {
    validate_update(validate_general(fname,lname,useraddress,userbday,gender,usermail,tel),"oupdateDetails");
}

/////////////////// Validations for Update Data////////////////////////////////

/////////////////// Validations for courses////////////////////////////////
var sub = document.getElementById('subject');
var teach = document.getElementById('teacherSelect');
function addCourseOnClick(){

    fieldColorChange(sub,"");
    fieldColorChange(teach,"");

    var subCheck = false;
    if(sub.value.trim().length>0){
        subCheck = true;
    }else{
        subCheck = false;
        fieldColorChange(sub,"red");
    }

    var teaCheck = false;
    if(teach.selectedIndex>0){
       teaCheck=true;
    }else{
        teaCheck = false;
        fieldColorChange(teach,"red");
    }

    if(subCheck && teaCheck){
        document.getElementById('validateAddCourse').style.display='block';
    }
}


////////////////////////////// Delete btn onclick///////////////////////

var delSub = document.getElementById('deleteSub');
var delTeach = document.getElementById('deleteTeacher');
var delDay = document.getElementById('deleteDay');

function deleteOnClick() {

    fieldColorChange(delSub,"");
    fieldColorChange(delTeach,"");
    fieldColorChange(delDay,"");

    var delSubCheck = false;
    if(delSub.selectedIndex>0){
        delSubCheck = true;
    }else{
        delSubCheck = false;
        fieldColorChange(delSub,"red");
    }

    var delTeachCheck = false;
    if(delTeach.selectedIndex>0){
        delTeachCheck = true;
    }else{
        delTeachCheck = false;
        fieldColorChange(delTeach,"red");
    }

    var delDayCheck = false;
    if(delDay.selectedIndex>0){
        delDayCheck = true;
    }else{
        delDayCheck = false;
        fieldColorChange(delDay,"red");
    }

    if(delSubCheck && delTeachCheck && delDayCheck){
        document.getElementById('deleteCourse').style.display='block';
    }
}

////////////////////////////// Delete btn///////////////////////

/////////////////// Validations for courses////////////////////////////////