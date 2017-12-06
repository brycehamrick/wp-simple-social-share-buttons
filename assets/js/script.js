jQuery(window).scroll(function() {
    var y = jQuery(this).scrollTop();
    if (y > 300) {
        jQuery('#sharer-float').css("opacity", 1);
    } else {
        jQuery('#sharer-float').css("opacity", 0);
    }
});