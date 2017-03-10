(function($) {

    var box = {
        pages: null,
        pageNumber: 1,
        html: '',
        data: null,
        filterableColumns: null,
        sortableColumns: null,
        sortTypeColumns: null,
        headersSortableColumns: [],
        headersFilterableColumns: [],
        options: {},
        sortVal:null,
        filterVal:null,
        sortType:'asc',
        filterField: null,
        urlForPaginator: null,
        methods: {
            createTableContent: function() {
                box.html = '';
                for (var key in box.data) {
                    box.html += "<tr><td>"+box.data[key].id +"</td>"+
                        "<td>"+box.data[key].news+"</td>"+
                        "<td>"+box.data[key].category.name+"</td>"+
                        "<td>"+box.data[key].author+"</td>"+
                        "<td>"+box.data[key].shortDescription +"</td>"+
                        "<td>"+box.methods.dateFormat(box.data[key].year) +"</td>"+
                        "<td><a class='btn btn-default' href='/moderator/" + box.data[key].id + "/edit'>" +
                        "<i class='icon-pencil'></i> </a>"+
                        "<a class='btn btn-default' href='/moderator/" + box.data[key].id + "/remove'>"+
                        "<i class='icon-trash'></i></a>"+
                        "</td></tr>"
                }
            },

            getDataOfJSON: function(json) {
                box.pages = JSON.parse(json[1]);
                box.data = JSON.parse(json[0], function(key, value) {
                    if (key == 'year') return new Date(value);
                    return value;
                });
            },

            dateFormat: function(data) {
                var month = function (monthData) {
                    if(monthData < 10)
                        return '0' + (monthData + 1);
                    else return monthData + 1;
                };

                var day = function (dayData) {
                    if(dayData < 10)
                        return '0' + dayData;
                    else return dayData;
                };

                return data.getFullYear() + '/' + month(data.getMonth()) + '/' + day(data.getDate());
            },

            pages: function () {
                if(box.pages == null)
                    return 4;
                else
                    return box.pages;
            },

            paginator: function() {
                $('#page-selection').bootpag({
                    total: box.methods.pages()
                }).on("page", function(event, page){
                    box.pageNumber = page;
                    var url =
                        box.urlForPaginator.substring(box.urlForPaginator.indexOf('?') + 1,
                            box.urlForPaginator.indexOf('page'));

                    box.methods.request(url);
                });
            },

            ajaxQuery: function(url) {
                $.ajax({
                    type: 'GET',
                    url: url,
                    beforeSend: function() {
                        box.urlForPaginator = url;
                        $('#content').hide();
                        $('#loader').fadeTo("slow", 1);
                    },
                    complete: function() {
                        $('#loader').hide();
                    },
                    success: function (json) {
                        box.methods.success(json);

                        $('#page-selection').bootpag({total: box.methods.pages()});
                    }
                })
            },

            success: function (json) {
                box.methods.getDataOfJSON(json);
                box.methods.createTableContent();

                $('#content-tbody').html(box.html);
                $('#content').fadeTo(1000, 1);

            },

            initGrid: function () {
               box.filterableColumns = $('#filter-field-value');
               box.sortableColumns = $('#sort-by-value');
               box.headersSortableColumns = box.options.sortableColumns;
               box.headersFilterableColumns = box.options.filterableColumns;
               box.sortTypeColumns = $('#sort-order-value');
               box.methods.handleParamsChange();
           },

            initSettings: function() {
                var sortBy = "<option value='none'>no sort</option>",
                    filterBy = "<option value='none'>no filter</option>",
                    header = "";
                for(var i = 0; i < box.headersSortableColumns.length; i++) {
                    header = box.headersSortableColumns[i].toLowerCase();
                    sortBy += "<option value='"+header+"'>"+header+"</option>";
                }
                for(i = 0; i < box.headersFilterableColumns.length; i++) {
                    header = box.headersFilterableColumns[i].toLowerCase();
                    filterBy += "<option value='"+header+"'>"+header+"</option>";
                }

                box.sortableColumns.html(sortBy);
                box.filterableColumns.html(filterBy);
            },

            handleParamsChange: function() {
                box.methods.filtering();
                box.methods.sorting();
                box.methods.sortingType();
                box.methods.filterField();
            },

            filterField: function () {
                $('.filter').submit( function () {
                    box.filterField = $('#filter').val();
                    box.methods.requestFilter();
                    return false;
                } );
            },

            filtering: function(){
                box.filterableColumns.on('change', function(){
                box.filterVal = $('#filter-field-value').val();
                });
            },

            sorting: function() {
                box.sortableColumns.on('change', function(){
                    box.sortVal = $('#sort-by-value').val();
                    box.methods.requestSort();
                });
            },

            sortingType:function(){
                box.sortTypeColumns.on('change', function(){
                    box.sortType = $('#sort-order-value').val();
                    box.methods.requestSort();
                });
            },

            requestFilter: function () {
                if(box.filterField == null || box.filterField == 'none'){
                    var urlFilter = '';
                }
                else
                    urlFilter = 'filter=' + box.filterField + '&';

                if(box.filterVal == null || box.filterVal == 'none'){
                    var urlFilterVal = '';
                }
                else
                    urlFilterVal = 'sort=' + box.filterVal + '&' + 'direction=asc&';
                box.pageNumber = 1;
                box.methods.request(urlFilter + urlFilterVal);
            },

            requestSort: function () {
                if(box.sortVal == null || box.sortVal == 'none'){
                    var urlSort = '';
                }
                else
                    urlSort = 'sort=news.' + box.sortVal + '&';

                var urlSortType = 'direction=' + box.sortType + '&';

                box.methods.request(urlSort + urlSortType);
            },

            request: function (urlRequest) {
                if(urlRequest == undefined)
                    var url = box.options.dataUrl + '?' + 'page=' + box.pageNumber;
                else
                     url = box.options.dataUrl + '?' + urlRequest + 'page=' + box.pageNumber;
                box.methods. ajaxQuery(url);
            }
        }
    };

    $.fn.ajaxGrid = function(options) {
        box.options = options;
        box.methods.initGrid();
        box.methods.initSettings();
        box.methods.request('');
        box.methods.paginator();

        return this;
    }

})(jQuery);
