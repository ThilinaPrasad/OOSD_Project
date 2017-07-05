/**
 * Created by user on 7/6/2017.
 */
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