$(document).ready(function () {
    


    $(".sideBarli").removeClass("activeLi");
    $(".ordersSideA").addClass("activeLi");


    $(document).on("click", ".confirmOrder", function(event) {


        $('.id').val($(this).attr('rel'));



        $.getJSON(`${dominUrl}getDelivryBoy`).done(function(data) {

            $('.select_delivery option').remove();
            $('.select_delivery').html(`<option disabled selected value="">${app.Select}</option>`);

            $.each(data.boys, function(index, item) {
                var element;
                var parent = $('.select_delivery');



                element = `
                            <option value="${item.id}">${item.username}</option>`;

                parent.append(element);


            });

        });

       



    });

    $("#deliveryfrom").on('submit',function(event) {
            event.preventDefault();
            $('.loader').show();


            if (user_type == "1") {

                var formdata = new FormData($("#deliveryfrom")[0]);
                console.log(formdata);


                $.ajax({
                    url: `${dominUrl}confirmOrder`,
                    type: 'POST',
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);

                        if (response.status == true) {
                            $('#allOrderTable').DataTable().ajax.reload(null, false);
                            $('#CancelledTable').DataTable().ajax.reload(null, false);
                            $('#CompletedTable').DataTable().ajax.reload(null, false);
                            $('#holdTable').DataTable().ajax.reload(null, false);
                            $('#ConfirmedTable').DataTable().ajax.reload(null, false);
                            $('#ProcessingTable').DataTable().ajax.reload(null, false);
                            $('.loader').hide();
                            $('#deliveryBoyModal').modal('hide');
                         
                            iziToast.success({
                                title: `${app.Success}!`,
                                message: `${app.ConfirmSuccessfully}`,
                                position: 'topRight'
                            });
                        }


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


        $('#ProcessingTable').dataTable({
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
                'url': `${dominUrl}fetchAllProcessingOrder`,
                'data': function(data) {

                }
            }
        });


        
        $('#ConfirmedTable').dataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            "aaSorting": [
                [0, "desc"]
            ],
            'columnDefs': [{
                'targets': [1, 2, 3, 4, 5], 
                'orderable': false,

            
            }],
            'ajax': {
                'url': `${dominUrl}fetchAllConfirmedOrder`,
                'data': function(data) {

                }
            }
        });


        $('#holdTable').dataTable({
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
                'url': `${dominUrl}fetchAllHoldOrder`,
                'data': function(data) {

                }
            }
        });

        $('#CompletedTable').dataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            "aaSorting": [
                [0, "desc"]
            ],
            'columnDefs': [{
                'targets': [1, 2, 3, 4, 5], 
                'orderable': false,

            }],
            'ajax': {
                'url': `${dominUrl}fetchAllCompletedOrder`,
                'data': function(data) {

                }
            }
        });


        $('#CancelledTable').dataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            "aaSorting": [
                [0, "desc"]
            ],
            'columnDefs': [{
                'targets': [1, 2, 3, 4, 5], 
                'orderable': false,

            }],
            'ajax': {
                'url': `${dominUrl}fetchAllCancelledOrder`,
                'data': function(data) {

                }
            }
        });

        $('#allOrderTable').dataTable({
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
                'url': `${dominUrl}fetchAllOrder`,
                'data': function(data) {

                }
            }
        });


        $(document).on("click", ".deleteOrder", function(event) {

            event.preventDefault();



            swal({
                    title: `${app.sure}`,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal(`${app.Yourorderhasbeendeleted}`, {
                            icon: "success",
                        });

                        if (user_type == "1") {
                            var element = $(this).parent();

                            var id = $(this).attr("rel");
                            var delete_cat_url = `${dominUrl}deleteOrder` + "/" + id;

                            $.getJSON(delete_cat_url).done(function(data) {
                                console.log(data);
                            });

                            $('#allOrderTable').DataTable().ajax.reload(null, false);
                            $('#CancelledTable').DataTable().ajax.reload(null, false);
                            $('#CompletedTable').DataTable().ajax.reload(null, false);
                            $('#holdTable').DataTable().ajax.reload(null, false);
                            $('#ConfirmedTable').DataTable().ajax.reload(null, false);
                            $('#ProcessingTable').DataTable().ajax.reload(null, false);

                        } else {
                            iziToast.error({
                                title: `${app.Error}!`,
                                        message: `${app.testerUser}`,
                                position: 'topRight'
                            });
                        }

                    } else {
                        swal(`${app.YourOrderIsSafe}`);
                    }
                });


        });

});