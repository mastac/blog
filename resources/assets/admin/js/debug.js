(function (window, $) {
    window.LaravelDataTables = window.LaravelDataTables || {};
    window.LaravelDataTables["dataTableBuilder"] = $("#dataTableBuilder").DataTable({
        "serverSide": true,
        "processing": true,
        "ajax": "",
        "columns": [{
            "name": "posts.id",
            "data": "posts.id",
            "title": "Posts Id",
            "orderable": true,
            "searchable": true
        }, {
            "name": "posts.name",
            "data": "posts.name",
            "title": "Posts Name",
            "orderable": true,
            "searchable": true
        }, {"name": "text", "data": "text", "title": "Text", "orderable": true, "searchable": true}, {
            "name": "author",
            "data": "author",
            "searchable": false,
            "title": "Author",
            "orderable": true
        }, {
            "name": "likes",
            "data": "likes",
            "searchable": false,
            "title": "Like \/ Dislike",
            "orderable": false,
            "width": "100px"
        }, {
            "name": "posts.created_at",
            "data": "posts.created_at",
            "width": "100px",
            "title": "Posts Created At",
            "orderable": true,
            "searchable": true
        }, {
            "defaultContent": "",
            "data": "action",
            "name": "action",
            "title": "Action",
            "render": null,
            "orderable": false,
            "searchable": false,
            "width": "100px"
        }],
        "order": [[0, "desc"]],
        "dom": "<'row'<'col-sm-6'Br><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'li><'col-sm-7'p>>",
        "buttons": ["create"]
    });
})(window, jQuery);