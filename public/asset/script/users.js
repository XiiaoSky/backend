$(document).ready(function () {

    $(".sideBarli").removeClass("activeLi");
    $(".usersSideA").addClass("activeLi");
    $('#UsersTable').dataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            "aaSorting": [[ 0, "desc" ]],
            'columnDefs': [{
                'targets': [0,2],
                 'orderable': false, 
        
            }],
            'ajax': {
                'url': `${dominUrl}fetchAllUsers`,
                'data': function(data) {
           
                }
            }
        });
});