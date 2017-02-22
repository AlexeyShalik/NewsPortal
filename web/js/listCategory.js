$(document).ready(function() {
$('#category>a').removeAttr("href");
    $('#category>a').bind('click', function(){
        var category = $('ul.menu_level_1');
        category.attr('hidden',!category.attr('hidden') );
    });
});


