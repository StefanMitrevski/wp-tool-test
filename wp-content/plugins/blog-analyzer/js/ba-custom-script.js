jQuery(document).ready(function($) {
    $("#post-analysis-table").DataTable({
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });
});