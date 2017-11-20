function testimonialsTab(evt, Tab_name) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" current", "");
    }
    document.getElementById(Tab_name).style.display = "block";
    evt.currentTarget.className += " current";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();


function testimonialsLeftTab(evt, Physcian_left_content_name) {
    var i, left_tabcontent, left_tablinks;
    left_tabcontent = document.getElementsByClassName("left_tabcontent");
    for (i = 0; i < left_tabcontent.length; i++) {
        left_tabcontent[i].style.display = "none";
    }
    left_tablinks = document.getElementsByClassName("left_tablinks");
    for (i = 0; i < left_tablinks.length; i++) {
        left_tablinks[i].className = left_tablinks[i].className.replace(" active", "");
    }
    document.getElementById(Physcian_left_content_name).style.display = "block";
    evt.currentTarget.className += " active";
}
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpenleft").click();