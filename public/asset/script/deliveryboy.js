
$(document).ready(function () {
    $(".adddbmodalBtn").on("click", function (event) {
        event.preventDefault();
  
$('#addDeliveryBoyForm')[0].reset();

    });
    $(".sideBarli").removeClass("activeLi");
    $(".deliveryBoySideA").addClass("activeLi");


$('#deliveryBoyTable').dataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        "aaSorting": [
            [0, "desc"]
        ],
        'columnDefs': [{
            'targets': [0,2,3,4,5], 
            'orderable': false,

        }],
        'ajax': {
            'url': `${dominUrl}fetchAllDbList`,
            'data': function(data) {

            }
        }
    });

    $("#addDeliveryBoyForm").on('submit',function(event) {
        event.preventDefault();
        $('.loader').show();


        if (user_type == "1") {

            var formdata = new FormData($("#addDeliveryBoyForm")[0]);
            console.log(formdata);


            $.ajax({
                url: `${dominUrl}addDeliveryBoy`,
                type: 'POST',
                data: formdata,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    console.log(response);

                    if (response.status == true) {
                        $('#deliveryBoyTable').DataTable().ajax.reload(null, false);
                        $('.loader').hide();
                        $('#addDeliveryBoyModal').modal('hide');
                        $('#addDeliveryBoyForm')[0].reset();

                    }else {
                        $('.loader').hide();
                        iziToast.error({
                            title: `${app.Error}!`,
                            message: `${app.Delivery_Boy}${app.Already_Exists}`,
                            position: 'topRight'
                        });
                    }

                },
                error: function(err) {
                    $('.loader').hide();

                    console.log(JSON.stringify(err));
                   
                        $('.loader').hide();
                        iziToast.error({
                            title: `${app.Error}!`,
                            message: `${app.EnvalidNumber}`,
                            position: 'topRight'
                        });



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


    $(document).on("click", ".edititem", function(event) {
        $('#editDeliveryBoyForm')[0].reset();



        $('.id').val($(this).attr('rel'));
        var id = $(this).attr("rel");
        var url2 = `${dominUrl}getDbById`+"/"+id;

        $.getJSON(url2).done(function(data) {

            var data2 = data['datas'];
            
            $('.number').val(data2['number']);
            $('.fullname').val(data2['fullname']);
            $('.username').val(data2['username']);
            $('.password').val(data2['password']);
           
        });

        $('#editdbmodal').modal('show');
    });


    $("#editDeliveryBoyForm").on('submit',function(event) {
        event.preventDefault();
        $('.loader').show();


        if (user_type == "1") {

            var formdata = new FormData($("#editDeliveryBoyForm")[0]);
            console.log(formdata);


            $.ajax({
                url: `${dominUrl}editDeliveryBoy`,
                type: 'POST',
                data: formdata,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    console.log(response);

                    if (response.status == true) {
                        $('#deliveryBoyTable').DataTable().ajax.reload(null, false);
                        $('.loader').hide();
                        $('#editdbmodal').modal('hide');
                      
                        $('#editDeliveryBoyForm')[0].reset();

                    }else {
                        $('.loader').hide();
                        iziToast.error({
                            title: `${app.Error}!`,
                            message: `${app.Delivery_Boy}${app.Already_Exists}`,
                            position: 'topRight'
                        });
                    }

                },
                error: function(err) {
                    $('.loader').hide();

                    console.log(JSON.stringify(err));
                   
                        $('.loader').hide();
                        iziToast.error({
                            title: `${app.Error}!`,
                            message: `${app.EnvalidNumber}`,
                            position: 'topRight'
                        });



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


    $("#deliveryBoyTable").on("click",".delete-item",function(event) {

event.preventDefault();



swal({
title:`${app.sure}`,
icon: "warning",
buttons: true,
dangerMode: true,
})
.then((willDelete) => {
if (willDelete) {
    swal(`${app.DeliveryBoyhasbeendeleted}`, {
        icon: "success",
    });

    if (user_type == "1") {
        var element = $(this).parent();

        var id = $(this).attr("rel");
        var delete_cat_url = `${dominUrl}deleteDeliveryBoy`+"/"+id;

        $.getJSON(delete_cat_url).done(function(data) {
            console.log(data);
        });

        $('#deliveryBoyTable').DataTable().ajax.reload(null, false);
    
    } else {
        iziToast.error({
            title: `${app.Error}!`,
            message: `${app.testerUser}`,
                position: 'topRight'
        });
    }

} else {
    swal(`${app.DeliveryBoyissafe}`);
}
});


});



});

