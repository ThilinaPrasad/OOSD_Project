/**
 * Created by user on 6/30/2017.
 */
function closeNotifi(index){
    document.getElementsByClassName("notification")[index].style.display = "none";
}

function openNav() {
    document.getElementById("myNav").style.width = "100%";
    document.getElementById("nav_noti").className = "active";
}

function closeNav() {
    document.getElementById("myNav").style.width = "0%";
    document.getElementById("nav_noti").className = "";
}