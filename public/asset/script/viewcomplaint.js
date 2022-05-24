$(document).ready(function () {
    
    
    $(".sideBarli").removeClass("activeLi");
    $(".complaintsSideA").addClass("activeLi");

    $(document).on("click", ".move", function(event) {



var id = $(this).attr("rel");


$('#comid').val(id);
var urljk = `${dominUrl}getComplaintForWeb`+ "/" + id;

$.getJSON(urljk).done(function(data) {


$('#question').val(data.description);
$('#title').val(data.title);

});


});

    $("#ansForm").on('submit',function(event) {
event.preventDefault();
$('.loader').show();


if (user_type == "1") {

    var formdata = new FormData($("#ansForm")[0]);
    console.log(formdata);


    $.ajax({
        url: `${dominUrl}moveToClose`,
        type: 'POST',
        data: formdata,
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function(response) {
            console.log(response);

           
                $('.loader').hide();
                
                $('#ansModel').modal('hide');
              
                iziToast.success({
                    title: `${app.Success}`,
                message:`${app.Answeredaddedsuccessfully}`,
                    position: 'topRight'
                });
                location.reload();
            


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