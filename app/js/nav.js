var navOpen = false;
var navBar = document.querySelector(".navbar");

function toggleNav(){
    console.log(navBar);
    
    navOpen = !navOpen;
    if(navOpen){
        navBar.classList.add("active");
    } else {
        navBar.classList.remove("active");
    }
}