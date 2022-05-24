$(document).ready(function () {
    $(".addnotimodalbtn").on("click", function (event) {
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
    
    var imageInput = $("#editimage");
                imageInput.on("change", function() {
                    if (imageInput[0].files && imageInput[0].files[0]) {
                        var reader = new FileReader();
    
                        reader.onload = function(e) {
                            $('#editshow_img')
                                .attr('src', e.target.result)
                                .width(150)
                                .height(150);
                        };
                        reader.readAsDataURL(imageInput[0].files[0]);
                        console.log(imageInput[0].files[0]);
                    }
                })
    
        
        $(".sideBarli").removeClass("activeLi");
                $(".notificationSideA").addClass("activeLi");
    
        $(document).on("click", ".editnoti", function(event) {
                    $('#editnotiform')[0].reset();
    
            
    
                    $('#editcatid').val($(this).attr('rel'));
                    var id = $(this).attr("rel");
            
                    var url2 = `${dominUrl}getNotiById`+"/"+id;
    
                    $.getJSON(url2).done(function(data) {
    
                        var data2 = data['notis'];
                        console.log(data2)
                        
                        $('#message').val(data2['message']);
    
                        if(data2['image'] == null){
                            $image = `${dominUrl}asset/image/default.png`;
                         
                        }else{
                            $image = `${dominUrl}public/storage/${data2['image']}`;
                        }
                    
                        $('#editshow_img').attr('src',$image);
                        $('#edit_title').val(data2['title']);
                      
                     
                       
                    });
    
                    $('#edit_unit_modal').modal('show');
                });
    
    
                
        $("#editnotiform").on('submit',function(event) {
        event.preventDefault();
        $('.loader').show();
     
    
        if (user_type == "1") {
    
            var formdata = new FormData($("#editnotiform")[0]);
            console.log(formdata);
    
    
            $.ajax({
                url: `${dominUrl}updateNoti`,
                type: 'POST',
                data: formdata,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    console.log(response);
    
                    if(response.status == true){
                    $('#notificationtable').DataTable().ajax.reload(null, false);
                    $('.loader').hide();
                    $('#edit_cat_modal').modal('hide');
                        $('#editnotiform')[0].reset(); 
                
                    }
                    else{
                        $('.loader').hide();
                        iziToast.error({
                            title: `${app.Error}!`,
                            message: `${app.Notification}${app.Already_Exists}`,
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
    
        $("#addForm").on('submit',function(event) {
        event.preventDefault();
        $('.loader').show();
     
    
        if (user_type == "1") {
    
            var formdata = new FormData($("#addForm")[0]);
            console.log(formdata);
    
    
            $.ajax({
                url: `${dominUrl}addNotification`,
                type: 'POST',
                data: formdata,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    console.log(response);
    
                    if(response.status == true){
                    $('#notificationtable').DataTable().ajax.reload(null, false);
                    $('.loader').hide();
                    $('#addNotificationmodal').modal('hide');
                        $('#addForm')[0].reset(); 
                
                    }
                    else{
                        $('.loader').hide();
                        iziToast.error({
                            title: `${app.Error}!`,
                            message: `${app.Notification}${app.Already_Exists}`,
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
    
            $('#notificationtable').dataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                "aaSorting": [[ 0, "desc" ]],
                'columnDefs': [{
                    'targets': [0,2,3,4], 
                     'orderable': false, 
            
                }],
                'ajax': {
                    'url': `${dominUrl}fetchAllNoti`,
                    'data': function(data) {
               
                    }
                }
            });
    
            $("#notificationtable").on("click",".delete-noti",function(event) {
    
    event.preventDefault();
    
    
    
    swal({
            title: `${app.sure}`,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                swal( `${app.Yournotificationhasbeendeleted}`, {
                    icon: "success",
                });
    
                if (user_type == "1") {
                    var element = $(this).parent();
    
                    var cat_id = $(this).attr("rel");
                    var delete_cat_url = `${dominUrl}deleteNoti`+"/"+cat_id;
        
                    $.getJSON(delete_cat_url).done(function(data) {
                        console.log(data);
                    });
    
                    $('#notificationtable').DataTable().ajax.reload(null, false);
                  
                } else {
                    iziToast.error({
                        title: `${app.Error}!`,
                         message: `${app.testerUser}`, 
                                        position: 'topRight'
                    });
                }
    
            } else {
                swal( `${app.Yournotificationissafe}`);
            }
        });
    
    
    });
    
    
   
    
});