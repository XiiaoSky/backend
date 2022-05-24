$(document).ready(function () {
    
    $(".sideBarli").removeClass("activeLi");
    $(".ordersSideA").addClass("activeLi");
$(document).on("click",".confirmOrder",function(event) {


   $('.id').val($(this).attr('rel'));



$.getJSON(`${dominUrl}getDelivryBoy`).done(function(data) {

$('.select_delivery option').remove();
$('.select_delivery').html( `<option disabled selected value="">${app.Select}</option>`);

   $.each(data.boys, function(index, item) {
       var element;
       var parent = $('.select_delivery');



       element = `
                       <option value="${item.id}">${item.username}</option>`;

       parent.append(element);


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

           if(response.status == true){
 
           $('.loader').hide();
           $('#deliveryBoyModal').modal('hide');
           
           iziToast.success({
            title: `${app.Success}!`,
            message: `${app.ConfirmSuccessfully}`,
                 position: 'topRight'
                });

             location.reload();   
          
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
});