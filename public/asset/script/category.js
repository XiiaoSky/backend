$(document).ready(function () {


    $(".categoryaddModalbtn").on("click", function (event) {
        event.preventDefault();
        $('#addForm')[0].reset();
        $('#defaultimg').attr('src', `${dominUrl}asset/image/default.png`);
    });
    
    $('#categorytable').dataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                "aaSorting": [[ 0, "desc" ]],
                'columnDefs': [{
                    'targets': [0,2,3,4], 
                     'orderable': false, 
            
                }],
                'ajax': {
                    'url': `${dominUrl}fetchAllCategory`,
                    'data': function(data) {
               
                    }
                }
            });

    
    $("#categorytable").on("click",".edit_cats",function(event) {
        $('#edit_cat')[0].reset();
        var rel_image = $(this).attr('rel');
        var image = `${dominUrl}public/storage/${rel_image}`;
        $('#editcat_title').val($(this).data('id'));
        $('#editcatid').val($(this).attr('id'));
        $('#editshow_img').attr('src', image);
        $('#edit_cat_modal').modal('show');
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

$("#file").on('change',function() {
    readURL(this);
});



            var imageInput = $("#editcat_image");
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
        $(".categoriesSideA").addClass("activeLi");

    $("#edit_cat").on('submit',function(event) {
        event.preventDefault();
        $('.loader').show();


        if (user_type == "1") {
            

            var formdata = new FormData($("#edit_cat")[0]);
            console.log(formdata);


            $.ajax({
                url: `${dominUrl}updatecat`,
                type: 'POST',
                data: formdata,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                console.log(response);

                if(response.status == true){
                $('#categorytable').DataTable().ajax.reload(null, false);
                 $('#edit_cat')[0].reset(); 
                $('.loader').hide();
                $('#edit_cat_modal').modal('hide');

                 }
                else{
                    $('.loader').hide();
                    iziToast.error({
                        title: `${app.Error}!`,
                        message: `${app.Category}${app.Already_Exists}`,
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
            url: `${dominUrl}addcat`,
            type: 'POST',
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                console.log(response);

                if(response.status == true){
                $('#categorytable').DataTable().ajax.reload(null, false);
                $('.loader').hide();
                $('#addcat').modal('hide');
                    $('#addForm')[0].reset(); 
                
                $('#cat_title').val('');
                $('.add_image5').val('');
                }
                else{
                    $('.loader').hide();
                    iziToast.error({
                        title: `${app.Error}!`,
                        message: `${app.Category}${app.Already_Exists}`,
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



    $("#categorytable").on("click",".delete-cat",function(event) {

        event.preventDefault();
        


        swal({
                title: `${app.sure}`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal(`${app.YourcategoryhasDeleted}`, {
                        icon: "success",
                    });

                    if (user_type == "1") {
                        var element = $(this).parent();

                        var cat_id = $(this).attr("rel");
                        var delete_cat_url = `${dominUrl}deletecat`+"/"+cat_id;
            
                        $.getJSON(delete_cat_url).done(function(data) {
                          
                        });

                        $('#categorytable').DataTable().ajax.reload(null, false);
                      
                    } else {
                        iziToast.error({
                            title: `${app.Error}!`,
                            message: `${app.testerUser}`,
                            position: 'topRight'
                        });
                    }

                } else {
                    swal(`${app.YourCategoryIssafe}`);
                }
            });


    });



});