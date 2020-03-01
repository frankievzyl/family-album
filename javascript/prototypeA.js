function display_signup() {
    var popup = document.getElementsByClassName("popup-layer-1").item(0);
    var cover = document.getElementsByClassName("cover").item(0);
    popup.style.display = "flex";
    cover.style.display = "block";
}

function hide_signup() {
    var popup = document.getElementsByClassName("popup-layer-1").item(0);
    var cover = document.getElementsByClassName("cover").item(0);
    popup.style.display = "none";
    cover.style.display = "none";
}

function set_page_title(new_title) {
    document.title = new_title;
} 

function zoom_folder_icons(slider, classname) {
    
    var new_dimension = (slider.value * 0.25).toString() + "rem";
    var album_icons = document.getElementsByClassName(classname);

    for (var x = 0; x < album_icons.length; x++) {
        album_icons.item(x).style.width = new_dimension;
        album_icons.item(x).style.height = new_dimension; 
    }
    
}