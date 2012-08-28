$(document).ready(function() {
    new_rule();
});

function new_rule() {
    var heading = (window.location.hash).replace(':', "\\:");
    $('.selected_heading').removeClass('selected_heading');
    if($(heading).parent().hasClass('section_rules')) {
        $(heading).addClass('selected_heading');
    }
}

window.onhashchange = new_rule;