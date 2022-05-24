

    
    
     $(document).ready(function () {


        $(".addbannerModalBtn").on("click", function (event) {
            event.preventDefault();
          
              $('#addForm')[0].reset();
            $('#defaultimg').attr('src', `${dominUrl}asset/image/default.png`);
        });
        
        
        
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
        
                reader.onload = function(e) {
                    $('#defaultimg').attr('src', e.target.result);
                }
        
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        $("#file").on("change",function() {
            readURL(this);
        });
        
        var imageInput = $("#editimagefile");
                    imageInput.on("change", function() {
                        if (imageInput[0].files && imageInput[0].files[0]) {
                            var reader = new FileReader();
        
                            reader.onload = function(e) {
                                $('#editdefaultimg')
                                    .attr('src', e.target.result)
                                    .width(150)
                                    .height(150);
                            };
                            reader.readAsDataURL(imageInput[0].files[0]);
                            console.log(imageInput[0].files[0]);
                        }
                    })
                 
    
        $(".sideBarli").removeClass("activeLi");
            $(".bannersSideA").addClass("activeLi");
    
                    $("#bannerTable").on("click",".edit_banner",function(event) {
                        $('#editbanner')[0].reset();
                        var rel_image = $(this).attr('data-id');
                        var image = `${dominUrl}public/storage/${rel_image}`;
                        $('#editBannerid').val($(this).attr('rel'));
                        $('#editdefaultimg').attr('src', image);
                        $('#edit_unit_modal').modal('show');
                    });
    
                  
         
              $("#addForm").on('submit',function(event) {
                event.preventDefault();
                $('.loader').show();
            
    
                if (user_type == "1") {
    
                    var formdata = new FormData($("#addForm")[0]);
                    console.log(formdata);
    
    
                    $.ajax({
                        url: `${dominUrl}addBanner`,
                        type: 'POST',
                        data: formdata,
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(response) {
                            console.log(response);
    
                            if(response.status == true){
                            $('#bannerTable').DataTable().ajax.reload(null, false);
                            $('.loader').hide();
                            $('#addBannermodel').modal('hide');
                                $('#addForm')[0].reset(); 
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
    
            $('#bannerTable').dataTable({
                                'processing': true,
                                'serverSide': true,
                                'serverMethod': 'post',
                                "aaSorting": [[ 0, "desc" ]],
                                'columnDefs': [{
                                    'targets': [1,2], 
                                    'orderable': false, 
                            
                                }],
                                'ajax': {
                                    'url': `${dominUrl}fetchAllBanner`,
                                    'data': function(data) {
                            
                                    }
                                }
                            });
    
    
                            $("#editbanner").on('submit',function(event) {
            event.preventDefault();
            $('.loader').show();
    
    
            if (user_type == "1") {
                
    
                var formdata = new FormData($("#editbanner")[0]);
                console.log(formdata);
    
    
                $.ajax({
                    url: `${dominUrl}updateBanner`,
                    type: 'POST',
                    data: formdata,
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                    console.log(response);
    
                    if(response.status == true){
                    $('#bannerTable').DataTable().ajax.reload(null, false);
                     $('#editbanner')[0].reset(); 
                    $('.loader').hide();
                    $('#edit_unit_modal').modal('hide');
    
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
    
        $("#bannerTable").on("click",".delete-Banner",function(event) {
    
    event.preventDefault();
    
    
    
    swal({
            title: `${app.sure}`,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                swal(`${app.YourBannerhasDeleted}`, {
                    icon: "success",
                });
    
                if (user_type == "1") {
                    var element = $(this).parent();
    
                    var id = $(this).attr("rel");
                    var delete_cat_url = `${dominUrl}deleteBanner`+"/"+id;
        
                    $.getJSON(delete_cat_url).done(function(data) {
                        console.log(data);
                    });
    
                    $('#bannerTable').DataTable().ajax.reload(null, false);
                  
                } else {
                    iziToast.error({
                        title: `${app.Error}!`,
            message: `${app.testerUser}`,
            position: 'topRight'
                    });
                }
    
            } else {
                swal(`${app.YourBannerIssafe}`);
            }
        });
    
    
    });
    
    
     });
    