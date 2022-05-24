$(document).ready(function () {

    $(".sideBarli").removeClass("activeLi");
    $(".addressSideA").addClass("activeLi");

    $(".citymodalbtn").on("click", function (event) {
        event.preventDefault();
        $('#addAreaForm')[0].reset();
        $('#addAreaForm')[0].reset();
    });

    $(".areamodalbtn").on("click", function (event) {
        event.preventDefault();
        $('#addAreaForm')[0].reset();
        $('#addAreaForm')[0].reset();
    });

    $("#editCityForm").on('submit',function(event) {
    event.preventDefault();
    $('.loader').show();


    if (user_type == "1") {
        

        var formdata = new FormData($("#editCityForm")[0]);
        console.log(formdata);


        $.ajax({
            url: `${dominUrl}updateCity`,
            type: 'POST',
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
            console.log(response);

            if(response.status == true){
            $('#allCity').DataTable().ajax.reload(null, false);
            $('#AllArea').DataTable().ajax.reload(null, false);
             $('#editCityForm')[0].reset(); 
            $('.loader').hide();
            $('#editCityModel').modal('hide');

             }
            else{
                $('.loader').hide();
                iziToast.error({
                  title: `${app.Error}!`,
                  message: `${app.City}${app.Already_Exists}`,
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

    $("#allCity").on("click",".editcity",function(event) {
                    $('#editCityForm')[0].reset();

                    $('.name').val($(this).data('id'));
                    $('.editcityid').val($(this).attr('id'));
                
                      $('#edit_unit_modal').modal('show');
          });



            $("#editAreaForm").on('submit',function(event) {
            event.preventDefault();
            $('.loader').show();
    
    
            if (user_type == "1") {
                
    
                var formdata = new FormData($("#editAreaForm")[0]);
                console.log(formdata);
    
    
                $.ajax({
                    url: `${dominUrl}updateArea`,
                    type: 'POST',
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                    console.log(response);
    
                    if(response.status == true){
                    $('#AllArea').DataTable().ajax.reload(null, false);
                     $('#editAreaForm')[0].reset(); 
                    $('.loader').hide();
                    $('#editAreaModel').modal('hide');
    
                     }
                    else{
                        $('.loader').hide();
                        iziToast.error({
                            title: `${app.Error}!`,
                            message: `${app.Area}${app.Already_Exists}`,
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
            $("#AllArea").on("click",".editarea",function(event) {
                            $('#editAreaForm')[0].reset();
    
                            $('#edit_name').val($(this).data('id'));
    
                           $cityid = $(this).data('pos');
    
                            
            $.getJSON(`${dominUrl}getCity`).done(function(data) {
    
                        console.log(data);
    
                        $("#editselect_city option").remove();
                        $.each(data.citys, function(index, city) {
                            var element;
                            var parent = $('#editselect_city');
                            if($cityid == city.id){
    
    
                            element = `
                                                <option value="${city.id}" selected> ${city.name}</option>`;
                            }else{
                                
    
                            element = `
                                                <option value="${city.id}" > ${city.name}</option>`;
                            }
    
                            parent.append(element);
    
    
    
    
                          });
                        });
                            
                            $('.editareaid').val($(this).attr('id'));
                        
                              $('#editAreaModel').modal('show');
                  });
               
                    
                    
                    
                            $.getJSON(`${dominUrl}getCity`).done(function(data) {
                    
                    console.log(data);
                    
                    
                    $.each(data.citys, function(index, city) {
                        var element;
                        var parent = $('#select_city');
                    
                    
                        element = `
                                            <option value="${city.id}">${city.name}</option>`;
                    
                        parent.append(element);
                    
                    
                    
                    
                    });
                    
                    });
                    
                    
                            $("#addAreaForm").on('submit',function(event) {
                                        event.preventDefault();
                                        $('.loader').show();
                                    
                    
                                        if (user_type == "1") {
                    
                                            var formdata = new FormData($("#addAreaForm")[0]);
                                            console.log(formdata);
                    
                    
                                            $.ajax({
                                                url: `${dominUrl}addArea`,
                                                type: 'POST',
                                                data: formdata,
                                                dataType: "json",
                                                contentType: false,
                                                cache: false,
                                                processData: false,
                                                success: function(response) {
                                                    console.log(response);
                    
                                                    if(response.status == true){
                                                    $('#AllArea').DataTable().ajax.reload(null, false);
                                                    $('.loader').hide();
                                                    $('#addAreaModel').modal('hide');
                                                        $('#addAreaForm')[0].reset(); 
                                                
                                                    }
                                                    else{
                                                        $('.loader').hide();
                                                        iziToast.error({
                                                            title: `${app.Error}!`,
                                                            message: `${app.Area}${app.Already_Exists}`,
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
                    
                            $("#allCity").on("click",".deletecity",function(event) {
                    
                    event.preventDefault();
                    
                    
                    
                    swal({
                            title: `${app.sure}`,
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                swal(`${app.Yourcityhasbeendeleted}`, {
                                    icon: "success",
                                });
                    
                                if (user_type == "1") {
                                    var element = $(this).parent();
                    
                                    var id = $(this).attr("rel");
                                    var delete_cat_url =`${dominUrl}deleteCity`+"/"+id;
                        
                                    $.getJSON(delete_cat_url).done(function(data) {
                                        console.log(data);
                                    });
                                    location.reload();
                    
                    
                                    $('#allCity').DataTable().ajax.reload(null, false);
                                    $('#AllArea').DataTable().ajax.reload(null, false);
                                  
                                } else {
                                    iziToast.error({
                                        title: `${app.Error}!`,
            message: `${app.testerUser}`,
            position: 'topRight'
                                    });
                                }
                    
                            } else {
                                swal(`${app.Yourcityissafe}`);
                            }
                        });
                    
                    
                    });
                    
                    $("#AllArea").on("click",".deletearea",function(event) {
                    
                    event.preventDefault();
                    
                    
                    
                    swal({
                            title: `${app.sure}`,
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                swal(`${app.Yourareahasbeendeleted}`, {
                                    icon: "success",
                                });
                    
                                if (user_type == "1") {
                                    var element = $(this).parent();
                    
                                    var id = $(this).attr("rel");
                                    var delete_cat_url = `${dominUrl}deleteArea`+"/"+id;
                        
                                    $.getJSON(delete_cat_url).done(function(data) {
                                        console.log(data);
                                    });
                                    $('#AllArea').DataTable().ajax.reload(null, false);
                                  
                                } else {
                                    iziToast.error({
                                        title: `${app.Error}!`,
                                        message: `${app.testerUser}`,
                                        position: 'topRight'
                                    });
                                }
                    
                            } else {
                                swal(`${app.YourAreasafe}`);
                            }
                        });
                    
                    
                    });
                    
                    
                                       $('#allCity').dataTable({
                                                'processing': true,
                                                'serverSide': true,
                                                'serverMethod': 'post',
                                                "aaSorting": [[ 0, "desc" ]],
                                                'columnDefs': [{
                                                    'targets': [1,2], 
                                                    'orderable': false
                                                }],
                                                'ajax': {
                                                    'url': `${dominUrl}fetchAllCity`,
                                                    'data': function(data) {
                                            
                                                    }
                                                }
                                            });
                    
                                            $('#AllArea').dataTable({
                                                'processing': true,
                                                'serverSide': true,
                                                'serverMethod': 'post',
                                                "aaSorting": [[ 0, "desc" ]],
                                                'columnDefs': [{
                                                    'targets': [1,2],
                                                    'orderable': false, 
                                            
                                                }],
                                                'ajax': {
                                                    'url': `${dominUrl}fetchAllArea`,
                                                    'data': function(data) {
                                            
                                                    }
                                                }
                                            });
                    
                    
                            $("#addCityForm").on('submit',function(event) {
                                        event.preventDefault();
                                        $('.loader').show();
                                    
                    
                                        if (user_type == "1") {
                    
                                            var formdata = new FormData($("#addCityForm")[0]);
                                            console.log(formdata);
                    
                    
                                            $.ajax({
                                                url: `${dominUrl}addCity`,
                                                type: 'POST',
                                                data: formdata,
                                                dataType: "json",
                                                contentType: false,
                                                cache: false,
                                                processData: false,
                                                success: function(response) {
                                                    console.log(response);
                    
                                                    if(response.status == true){
                                           
                                                    location.reload();
                    
                                                    }
                                                    else{
                                                        $('.loader').hide();
                                                        iziToast.error({
                                                           title: `${app.Error}!`,
                                                         message: `${app.City}${app.Already_Exists}`,
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
                    
});