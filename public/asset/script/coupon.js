$(document).ready(function () {


    $(".addcouponbtn").on("click", function (event) {
        event.preventDefault();
        $('#addCoupon')[0].reset();
    });


    $(".sideBarli").removeClass("activeLi");
    $(".couponsSideA").addClass("activeLi");

        $("#addCoupon").on('submit',function(event) {
            event.preventDefault();
            $('.loader').show();


            if (user_type == "1") {

                var formdata = new FormData($("#addCoupon")[0]);
                console.log(formdata);


                $.ajax({
                    url: `${dominUrl}addCoupon`,
                    type: 'POST',
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);

                        if (response.status == true) {
                            $('#coupontable').DataTable().ajax.reload(null, false);
                            $('.loader').hide();
                            $('#couponModal').modal('hide');
                            $('#addCoupon')[0].reset();

                        } else {
                            $('.loader').hide();
                            $('#coupon_code').focus();
                            
                            iziToast.error({
                                title: `${app.Error}!`,
                                message: `${app.Coupon}${app.Already_Exists}`,
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


        $('#coupontable').dataTable({
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
                'url': `${dominUrl}fetchAllCoupon`,
                'data': function(data) {

                }
            }
        });


        $(document).on("click", ".editcoupan", function(event) {
            $('#editCoupon')[0].reset();

    

            $('#editcoupon_id').val($(this).attr('rel'));
            var id = $(this).attr("rel");
            var url2 = `${dominUrl}getCoupanbyid`+"/"+id;

            $.getJSON(url2).done(function(data) {

                var data2 = data['coupons'];
                
                $('#editmin_amount').val(data2['minamount']);
                $('#editcoupon_discount').val(data2['discount']);
                $('#editdescription').val(data2['description']);
                $('#editcoupon_code').val(data2['coupon_code']);

                var ele;
                var trueAns = data2['type']
              

                var ansSelector = $('#editdiscount_type');
                ansSelector.empty();
                ansSelector.append(
                    `<option ${ trueAns == 1 ? "selected" : '' } value="1">${app.FlatDiscount}</option>`);
                ansSelector.append(
                    `<option ${ trueAns == 2 ? "selected" : '' } value="2">${app.UptoDiscount}</option>`
                    );
               
            });

            $('#edit_unit_modal').modal('show');
        });


        $("#editCoupon").on('submit',function(event) {
            event.preventDefault();
            $('.loader').show();


            if (user_type == "1") {


                var formdata = new FormData($("#editCoupon")[0]);
                console.log(formdata);


                $.ajax({
                    url: `${dominUrl}updateCoupon`,
                    type: 'POST',
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);

                        if (response.status == true) {
                            $('#coupontable').DataTable().ajax.reload(null, false);
                            $('#editCoupon')[0].reset();
                            $('.loader').hide();
                            $('#edit_unit_modal').modal('hide');

                        } else {
                            $('.loader').hide();
                            iziToast.error({
                                title: `${app.Error}!`,
                                message: `${app.Coupon}${app.Already_Exists}`,
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

        $("#coupontable").on("click",".deleteCoupon",function(event) {

            event.preventDefault();



            swal({
                    title:  `${app.sure}`,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal( `${app.YourCouponHasBeenDeleted}`, {
                            icon: "success",
                        });

                        if (user_type == "1") {
                            var element = $(this).parent();

                            var id = $(this).attr("rel");
                            var delete_cat_url = `${dominUrl}deleteCoupan`+"/"+id;
                
                            $.getJSON(delete_cat_url).done(function(data) {
                                console.log(data);
                            });

                            $('#coupontable').DataTable().ajax.reload(null, false);
                        
                        } else {
                            iziToast.error({
                                title: `${app.Error}!`,
                                message: `${app.testerUser}`,
                                position: 'topRight'
                            });
                        }

                    } else {
                        swal( `${app.YourCouponIsSafe}`);
                    }
                });


            });
});