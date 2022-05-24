$(document).ready(function () {

                
    $(".sideBarli").removeClass("activeLi");
    $(".otherSideA").addClass("activeLi");
    $("#shippingchargeFrom").on('submit',function(event) {
            event.preventDefault();
            $('.loader').show();
        

            if (user_type == "1") {

                var formdata = new FormData($("#shippingchargeFrom")[0]);
                console.log(formdata);


                $.ajax({
                    url: `${dominUrl}updateCharg`,
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
      
        $("#idsFrom").on('submit',function(event) {
            event.preventDefault();
            $('.loader').show();
        

            if (user_type == "1") {

                var formdata = new FormData($("#idsFrom")[0]);
                console.log(formdata);


                $.ajax({
                    url: `${dominUrl}updateIds`,
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