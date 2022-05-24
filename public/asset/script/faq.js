$(document).ready(function () {
    
    $(".faqModalBtn").on("click", function (event) {
        event.preventDefault();
        
        $('#addForm')[0].reset();
    });


    
    $(".sideBarli").removeClass("activeLi");
    $(".faqsSideA").addClass("activeLi");

    $('#faqTable').dataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        "aaSorting": [
            [0, "desc"]
        ],
        'columnDefs': [{
            'targets': [2], 
            'orderable': false,

        }],
        'ajax': {
            'url': `${dominUrl}fetchAllFaq`,
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
                url: `${dominUrl}addfaq`,
                type: 'POST',
                data: formdata,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    console.log(response);

                    if (response.status == true) {
                        $('#faqTable').DataTable().ajax.reload(null, false);
                        $('.loader').hide();
                        $('#addcat').modal('hide');
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

    $("#faqTable").on("click", ".editfaq", function(event) {



        $('#editcatid').val($(this).attr('data-id'));
        var id = $(this).attr("data-id");


        var url2 = `${dominUrl}getFaqid`+ "/" + id;

        $.getJSON(url2).done(function(data) {

            var data2 = data['faqs'];

            $('#editanswer').val(data2['answer']);
            $('#editquestion').val(data2['question']);




        });
    });


    $("#editFaq").on('submit',function(event) {
        event.preventDefault();
        $('.loader').show();


        if (user_type == "1") {

            var formdata = new FormData($("#editFaq")[0]);
            console.log(formdata);


            $.ajax({
                url: `${dominUrl}updateFaq`,
                type: 'POST',
                data: formdata,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    console.log(response);

                    if (response.status == true) {
                        $('#faqTable').DataTable().ajax.reload(null, false);
                        $('.loader').hide();
                        $('#edit_cat_modal').modal('hide');

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

    $("#faqTable").on("click", ".deletefaq", function(event) {

        event.preventDefault();



        swal({
                title:`${app.sure}`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal(`${app.YourFAQshasbeendeleted}`, {
                        icon: "success",
                    });

                    if (user_type == "1") {
                        var element = $(this).parent();

                        var cat_id = $(this).attr("rel");
                        var delete_cat_url = `${dominUrl}deleteFaq` + "/" + cat_id;

                        $.getJSON(delete_cat_url).done(function(data) {
                            console.log(data);
                        });

                        $('#faqTable').DataTable().ajax.reload(null, false);

                    } else {
                        iziToast.error({
                            title: `${app.Error}!`,
                            message: `${app.testerUser}`,
                            position: 'topRight'
                        });
                    }

                } else {
                    swal(`${app.YourFAQsissafe}`);
                }
            });


    });

});