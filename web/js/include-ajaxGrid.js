$(document).ready(
   $("#content-tbody").ajaxGrid({
       dataUrl: 'http://localhost:8000/moderator/showArticles',
       sortableColumns: ['id','news', 'author'],
       filterableColumns: ['id', 'news', 'author', 'year']
   }),
    $('#filter').focus(function () {
        if($('#filter-field-value').val() == 'year') {
            $('#tooltip').show();
        }
    }),
    $('#filter').blur(
        function () {
            $('#tooltip').hide();
    })
);
