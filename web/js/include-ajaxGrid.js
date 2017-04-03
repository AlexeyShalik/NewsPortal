$(document).ready(
   $("#content-tbody").ajaxGrid({
       dataUrl: document.location.href + '/data',
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
