/**
 * Created by user on 7/8/2017.
 */

var fileSub = document.getElementById('uploadResultSub');
var fileFile = document.getElementById('uploadResultFile');

function uploadResultsOnClick(){
    fieldColorChange(fileSub,'');
    fieldColorChange(fileFile,'');

    var fileSubCheck = false;
    if(fileSub.selectedIndex>0){
        fileSubCheck = true;
    }else {
        fileSubCheck = false;
        fieldColorChange(fileSub,'red');
    }

    var fileFileCheck = false;
    if(fileFile.value !=""){
        fileFileCheck = true;
    }else {
        fileFileCheck = false;
        document.getElementById('fileWarning').style.color = 'red';
    }

    if(fileSubCheck && fileFileCheck){
        document.getElementById('fileUploadPassword').style.display = 'block';
    }

    return false;

}

var oBoSub = document.getElementById('resultSub_one');
var oBoIndex = document.getElementById('resultIndex_one');
var oBoName = document.getElementById('resultName_one');
var oBoMark = document.getElementById('resultMark_one');

function uploadResults_oneOnclick(){
    fieldColorChange(oBoSub,'');
    fieldColorChange(oBoIndex,'');
    fieldColorChange(oBoName,'');
    fieldColorChange(oBoMark,'');

    var oBoSubCheck = false;
    if(oBoSub.selectedIndex>0){
        oBoSubCheck = true;
    }else {
        oBoSubCheck = false;
        fieldColorChange(oBoSub,'red');
    }

    var oBoIndexCheck = false;
    if(oBoIndex.value.trim().length>0){
        oBoIndexCheck = true;
    }else {
        oBoIndexCheck = false;
        fieldColorChange(oBoIndex,'red');
    }

    var oBoNameCheck = false;
    if(oBoName.value.trim().length>0){
        oBoNameCheck = true;
    }else {
        oBoNameCheck = false;
        fieldColorChange(oBoName,'red');
    }

    var oBoMarkCheck = false;
    if(oBoMark.value.trim().length>0){
        oBoMarkCheck = true;
    }else {
        oBoMarkCheck = false;
        fieldColorChange(oBoMark,'red');
    }

    if(oBoSubCheck && oBoIndexCheck && oBoNameCheck && oBoMarkCheck){
        document.getElementById('resultUploadPassword').style.display = 'block';
    }
}