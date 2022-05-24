$(document).ready(function () {
    
$(".sideBarli").removeClass("activeLi");
$(".complaintsSideA").addClass("activeLi");
$(document).on("click", ".move", function(event) {



var id = $(this).attr("rel");


$('#comid').val(id);
var urljk = `${dominUrl}getComplaintForWeb`+ "/" + id;

$.getJSON(urljk).done(function(data) {


$('#question').val(data.description);
$('#title').val(data.title);

});


});


$("#ansForm").on('submit',function(event) {
event.preventDefault();
$('.loader').show();


if (user_type == "1") {

var formdata = new FormData($("#ansForm")[0]);
console.log(formdata);


$.ajax({
    url: `${dominUrl}moveToClose`,
    type: 'POST',
    data: formdata,
    dataType: "json",
    contentType: false,
    cache: false,
    processData: false,
    success: function(response) {
        console.log(response);

            $('#closeComplaintTable').DataTable().ajax.reload(null, false);
            $('#openComplaintTable').DataTable().ajax.reload(null, false);

            $('.loader').hide();
            $('#ansModel').modal('hide');
          
            iziToast.success({
                title: `${app.Success}`,
                message:`${app.Answeredaddedsuccessfully}`,
                position: 'topRight'
            });
           
        


    },
    error: function(err) {
        $('.loader').hide();

        console.log(JSON.stringify(err));


    }

});
} else {

$('.loader').hide();
iziToast.error({
    title: `${app.Error}!`,
    message: `${app.testerUser}`,
    position: 'topRight'
});
}

});



$('#openComplaintTable').dataTable({
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    "aaSorting": [
        [0, "desc"]
    ],
    'columnDefs': [{
        'targets': [0, 1],
    
        'orderable': false,
    }],
    'ajax': {
        'url': `${dominUrl}fetchAllComplaint`,
        'data': function(data) {

        },
        error: function(err) {


            console.log(JSON.stringify(err));


        }

    }
});

$('#closeComplaintTable').dataTable({
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    "aaSorting": [
        [0, "desc"]
    ],
    'columnDefs': [{
        'targets': [0, 1],
    
        'orderable': false,
       
    }],
    'ajax': {
        'url': `${dominUrl}fetchAllCloseComplaint`,
        'data': function(data) {

        },
        error: function(err) {


            console.log(JSON.stringify(err));


        }

    }
});


$("#openComplaintTable").on("click", ".deleteComplaint", function(event) {

    event.preventDefault();



    swal({
            title:  `${app.sure}`,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                swal(`${app.Yourcomplainthasbeendelete}`, {
                    icon: "success",
                });

                if (user_type == "1") {
                    var element = $(this).parent();

                    var id = $(this).attr("rel");
                    var delete_cat_url =`${dominUrl}deleteComplaint`+ "/" + id;

                    $.getJSON(delete_cat_url).done(function(data) {
                        console.log(data);
                    });

                    $('#openComplaintTable').DataTable().ajax.reload(null, false);
                    $('#closeComplaintTable').DataTable().ajax.reload(null, false);

                } else {
                    iziToast.error({
                        title: `${app.Error}!`,
                        message: `${app.testerUser}`,
                        position: 'topRight'
                    });
                }

            } else {
                swal(`${app.Yourcomplaintissafe}`);
            }
        });


});

$("#closeComplaintTable").on("click", ".deleteComplaint", function(event) {

    event.preventDefault();



    swal({
            title: `${app.sure}`,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                swal(`${app.Yourcomplainthasbeendelete}`, {
                    icon: "success",
                });

                if (user_type == "1") {
                    var element = $(this).parent();

                    var id = $(this).attr("rel");
                    var delete_cat_url =`${dominUrl}deleteComplaint`+ "/" + id;

                    $.getJSON(delete_cat_url).done(function(data) {
                        console.log(data);
                    });

                    $('#openComplaintTable').DataTable().ajax.reload(null, false);
                    $('#closeComplaintTable').DataTable().ajax.reload(null, false);

                } else {
                    iziToast.error({
                        title: `${app.Error}!`,
                        message: `${app.testerUser}`,
                        position: 'topRight'
                    });
                }

            } else {
                swal(`${app.Yourcomplaintissafe}`);
            }
        });


});

});