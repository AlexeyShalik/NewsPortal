$(document).ready(function() {
    $('#category>a').removeAttr("href");
    var category = $('ul.menu_level_1');
    category.css({
        marginLeft: '15px'
    });
    $('#category>a').bind('click', function(){

        category.attr('hidden',!category.attr('hidden') );
    });
});
