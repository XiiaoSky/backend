$(document).ready(function () {

    $id = $('#idFromView').val();

  $('#allProductTable').dataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            "aaSorting": [
                [0, "desc"]
            ],
            'columnDefs': [{
                'targets': [1,2,3,4], 
                'orderable': false,

            }],
            'ajax': {
                'url': `${dominUrl}fetchAllCatProduct`,
                'data': {
                    'id':$id 
                }
            }
        });
                    
        $('#outofstocktable').dataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            "aaSorting": [
                [0, "desc"]
            ],
            'columnDefs': [{
                'targets': [1,2,3,4], 
                'orderable': false,

            }],
            'ajax': {
                'url': `${dominUrl}fetchAllOfsCatProduct`,
                'data': {
                    'id':$id 
                }
            }
        });
                   
        $(".sideBarli").removeClass("activeLi");
        $(".categoriesSideA").addClass("activeLi");
        
        $('#allProductTable').on("change", ".stock", function(event) {

event.preventDefault();


swal({
        title: `${app.sure}`,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            swal(`${app.YourProductAddOfS}`, {
                icon: "success",
            });

            if (user_type == "1") {



$id = $(this).attr("rel");

if ($(this).prop("checked") == true) {
    swal(`${app.YourProductAddInStock}`, {
                icon: "success",
            });
    $value = 1;
} else {

    swal(`${app.YourProductAddOutStock}`, {
                icon: "success",
            });
  
    $value = 0;
}
$.post(`${dominUrl}updateStock`, {
        id: $id,
        stock: $value
    },
    function(returnedData) {
        console.log(returnedData);
        $('#allProductTable').DataTable().ajax.reload(null, false);
        $('#outofstocktable').DataTable().ajax.reload(null, false);
    }).fail(function() {
    console.log("error");
});

    } else {
                iziToast.error({
                    title: `${app.Error}!`,
            message: `${app.testerUser}`,
            position: 'topRight'
                });
            }

        } else {
            $('#allProductTable').DataTable().ajax.reload(null, false);
            $('#outofstocktable').DataTable().ajax.reload(null, false);
            swal(`${app.YourProductIsSafe}`);
        }
    });


});


$('#outofstocktable').on("change", ".stock", function(event) {

event.preventDefault();


swal({
        title: `${app.sure}`,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            swal(`${app.YourProductAddInStock}`, {
                icon: "success",
            });

            if (user_type == "1") {



$id = $(this).attr("rel");

if ($(this).prop("checked") == true) {
    $value = 1;
} else {
  
    $value = 0;
    
}
$.post(`${dominUrl}updateStock`, {
        id: $id,
        stock: $value
    },
    function(returnedData) {
        console.log(returnedData);
        $('#allProductTable').DataTable().ajax.reload(null, false);
        $('#outofstocktable').DataTable().ajax.reload(null, false);
    }).fail(function() {
    console.log("error");
});

    } else {
                iziToast.error({
                    title: `${app.Error}!`,
                    message: `${app.testerUser}`,
                    position: 'topRight'
                });
            }

        } else {
            $('#allProductTable').DataTable().ajax.reload(null, false);
            $('#outofstocktable').DataTable().ajax.reload(null, false);
            swal(`${app.YourProductAddInStock}`);
        }
    });


});

$("#allProductTable").on("click", ".deleteproduct", function(event) {

event.preventDefault();



swal({
        title: `${app.sure}`,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            swal(`${app.YourProducthasbeenDeleted}`, {
                icon: "success",
            });

            if (user_type == "1") {
                var element = $(this).parent();

                var id = $(this).attr("rel");
                var delete_cat_url = `${dominUrl}deleteProduct`+ "/" + id;

                $.getJSON(delete_cat_url).done(function(data) {
                    console.log(data);
                });

                $('#allProductTable').DataTable().ajax.reload(null, false);
                $('#outofstocktable').DataTable().ajax.reload(null, false);

            } else {
                iziToast.error({
                    title: `${app.Error}!`,
                    message: `${app.testerUser}`,
                    position: 'topRight'
                });
            }

        } else {
            swal(`${app.YourProductIsSafe}`);
        }
    });


});

$("#outofstocktable").on("click", ".deleteproduct", function(event) {

event.preventDefault();



swal({
        title: `${app.sure}`,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            swal(`${app.YourProducthasbeenDeleted}`, {
                icon: "success",
            });

            if (user_type == "1") {
                var element = $(this).parent();

                var id = $(this).attr("rel");
                var delete_cat_url = `${dominUrl}deleteProduct` + "/" + id;

                $.getJSON(delete_cat_url).done(function(data) {
                    console.log(data);
                });

                $('#allProductTable').DataTable().ajax.reload(null, false);
                $('#outofstocktable').DataTable().ajax.reload(null, false);

            } else {
                iziToast.error({
                    title: `${app.Error}!`,
                    message: `${app.testerUser}`,
                    position: 'topRight'
                });
            }

        } else {
            swal(`${app.YourProductIsSafe}`);
        }
    });


});
    
    });