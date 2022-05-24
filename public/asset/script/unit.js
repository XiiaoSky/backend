$(document).ready(function () {
    $(".addunitModalBtn").on("click", function (event) {
        event.preventDefault();
        $('#addForm')[0].reset();
    });


        $(".sideBarli").removeClass("activeLi");
        $(".unitsSideA").addClass("activeLi");
                    $('#unitshowtable').dataTable({
                            'processing': true,
                            'serverSide': true,
                            'serverMethod': 'post',
                            "aaSorting": [[ 0, "desc" ]],
                            'columnDefs': [{
                                'targets': [1], 
                                'orderable': false, 
                            }],
                            'ajax': {
                                'url': `${dominUrl}fetchAllUnits`,
                                'data': function(data) {
                        
                                }
                            }
                        });


                        $("#addForm").on('submit',function(event) {
                    event.preventDefault();
                    $('.loader').show();
                

                    if (user_type == "1") {

                        var formdata = new FormData($("#addForm")[0]);
                        console.log(formdata);


                        $.ajax({
                            url: `${dominUrl}addUnit`,
                            type: 'POST',
                            data: formdata,
                            dataType: "json",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(response) {
                                console.log(response);

                                if(response.status == true){
                                $('#unitshowtable').DataTable().ajax.reload(null, false);
                                $('.loader').hide();
                                $('#addunitmodel').modal('hide');
                                    $('#addForm')[0].reset(); 

                                }
                                else{
                                    $('.loader').hide();
                                    iziToast.error({
                                        title: `${app.Error}!`,
                                        message: `${app.Unit}${app.Already_Exists}`,
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

                $("#unitshowtable").on("click",".edit_units",function(event) {
                        $('#edit_cat')[0].reset();

                        $('#edit_title').val($(this).data('id'));
                        $('#editunitid').val($(this).attr('id'));
                    
                          $('#edit_unit_modal').modal('show');
              });


              $("#edit_cat").on('submit',function(event) {
        event.preventDefault();
        $('.loader').show();


        if (user_type == "1") {
            

            var formdata = new FormData($("#edit_cat")[0]);
            console.log(formdata);


            $.ajax({
                url: `${dominUrl}updateUnit`,
                type: 'POST',
                data: formdata,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                console.log(response);

                if(response.status == true){
                $('#unitshowtable').DataTable().ajax.reload(null, false);
                 $('#edit_cat')[0].reset(); 
                $('.loader').hide();
                $('#edit_unit_modal').modal('hide');

                 }
                else{
                    $('.loader').hide();
                    iziToast.error({
                        title: `${app.Error}!`,
                        message: `${app.Unit}${app.Already_Exists}`,
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

    $("#unitshowtable").on("click",".delete-unit",function(event) {

event.preventDefault();



swal({
        title: `${app.sure}`,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            swal(`${app.YourUnitHasBeenDelete}`, {
                icon: "success",
            });

            if (user_type == "1") {
                var element = $(this).parent();

                var id = $(this).attr("rel");
                var delete_cat_url = `${dominUrl}deleteUnit`+"/"+id;
    
                $.getJSON(delete_cat_url).done(function(data) {
                    console.log(data);
                });

                $('#unitshowtable').DataTable().ajax.reload(null, false);
              
            } else {
                iziToast.error({
                    title: `${app.Error}!`,
                    message: `${app.testerUser}`,
                    position: 'topRight'
                });
            }

        } else {
            swal(`${app.YourUnitIsSafe}`);
        }
    });


});


});


