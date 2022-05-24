$(document).ready(function () {
            
    $(".sideBarli").removeClass("activeLi");
    $(".reviewsSideA").addClass("activeLi");

    $('#reviewTable').dataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        "aaSorting": [
            [0, "desc"]
        ],
        'columnDefs': [{
            'targets': [1, 2], 
            'orderable': false,

         
        }],
        'ajax': {
            'url': `${dominUrl}fetchAllReview`,
            'data': function(data) {

            }
        }
    });

    $("#reviewTable").on("click", ".deleteitem", function(event) {

        event.preventDefault();



        swal({
                title: `${app.sure}`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal(`${app.Yourreviewhasbeendelete}`, {
                        icon: "success",
                    });

                    if (user_type == "1") {
                        var element = $(this).parent();

                        var id = $(this).attr("rel");
                        var delete_cat_url = `${dominUrl}deleteReview` + "/" + id;

                        $.getJSON(delete_cat_url).done(function(data) {
                            console.log(data);
                        });

                        $('#reviewTable').DataTable().ajax.reload(null, false);

                    } else {
                        iziToast.error({
                            title: `${app.Error}!`,
                            message: `${app.testerUser}`,
                            position: 'topRight'
                        });
                    }

                } else {
                    swal(`${app.Yourreviewissafe}`);
                }
            });


    });

    $('#reviewTable').on("change", ".feacherd", function(event) {

event.preventDefault();


swal({
title: `${app.sure}`,
icon: "warning",
buttons: true,
dangerMode: true,
})
.then((willDelete) => {
if (willDelete) {
    swal(`${app.Reviewaddedsuccessfully}`, {
        icon: "success",
    });

    if (user_type == "1") {



$id = $(this).attr("rel");

if ($(this).prop("checked") == true) {
swal(`${app.Yourreviewisfeaacherd}`, {
        icon: "success",
    });
$value = 1;
} else {

swal(`${app.YourreviewAddinfeartued}`, {
        icon: "success",
    });

$value = 0;
}
$.post(`${dominUrl}updateReview`, {
id: $id,
feacherd: $value
},
function(returnedData) {
console.log(returnedData);
$('#reviewTable').DataTable().ajax.reload(null, false);

}).fail(function() {
console.log("error");
});

} else {
        iziToast.error({
            title: `${app.Error}!`,
            message: `${app.testerUser}`,
                            position: 'topRight'
        });
    }

} else {
    $('#reviewTable').DataTable().ajax.reload(null, false);
    
    swal(`${app.YourreviewNotAddinferatured}`);
}
});


});

});