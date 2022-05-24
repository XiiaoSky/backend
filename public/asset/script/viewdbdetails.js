$(document).ready(function() {


    $id = $('#idFromView').val();
    $(document).on("click", "#paymentResolve", function(event) {

        event.preventDefault();



        swal({
                title: `${app.sure}`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal( `${app.PaymentResolve}`, {
                        icon: "success",
                    });

                    if (user_type == "1") {
                        var element = $(this).parent();

                        var id = $(this).attr("rel");
                        var delete_cat_url = `${dominUrl}updatePayment`+ "/" + id;

                        $.getJSON(delete_cat_url).done(function(data) {
                            console.log(data);
                        });

                        location.reload();

                    } else {
                        iziToast.error({
                            title: `${app.Error}!`,
                            message: `${app.testerUser}`,
                            position: 'topRight'
                        });
                    }

                } else {
                    swal( `${app.PaymentResolveNot}`);
                }
            });


    });


    $('#dbCompleteOrderTable').dataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        "aaSorting": [
            [0, "desc"]
        ],
        'columnDefs': [{
            'targets': [1, 2, 3, 4, 5, 6], 
            'orderable': false,

        }],
        'ajax': {
            'url': `${dominUrl}fetchAllDeliveryBoyCompletedOrder`,
            "data": {
                     "dbid":  $id 
              },
              error:(e)=>{console.log(e)}
        }
    });


    $('#cofirmorderTable').dataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        "aaSorting": [
            [0, "desc"]
        ],
        'columnDefs': [{
            'targets': [1, 2, 3, 4, 5, 6], 
            'orderable': false,

        
        }],
        'ajax': {
            'url': `${dominUrl}fetchAllDeliveryBoyConfirmOrder`,
            "data": {
                     "dbid":  $id 
              }
        }
    });


    
    $(".sideBarli").removeClass("activeLi");
    $(".deliveryBoySideA").addClass("activeLi");
                    $('#holdOrderTable').dataTable({
                        'processing': true,
                        'serverSide': true,
                        'serverMethod': 'post',
                        "aaSorting": [
                            [0, "desc"]
                        ],
                        'columnDefs': [{
                            'targets': [1, 2, 3, 4, 5, 6], 
                            'orderable': false,

                        }],
                        'ajax': {
                            'url': `${dominUrl}fetchAllDeliveryBoyHoldOrder`,
                            "data": {
                                     "dbid":  $id 
                              }
                        }
                    });

});
