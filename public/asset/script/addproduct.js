var img;
var productimages = [];
$(document).ready(function() {

$currencies = $('.currencies').text();
    $(".sideBarli").removeClass("activeLi");
$(".productSideA").addClass("activeLi");



    $(document).on('change', '#productimages', function() {

        var imgElement = "";
        var input = $('#productimages')[0];
        var placeToInsertImagePreview = $('#photo_gallery2');


        for (let x = 0; x < $('#productimages')[0].files.length; x++) {
            productimages.push($('#productimages')[0].files[x]);
        }

        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.jfif|\.webp)$/i;

        console.log(productimages);

        for (let i = 0; i < $('#productimages')[0].files.length; i++) {

            console.log($('#productimages')[0].files[i]);

            if (!allowedExtensions.exec(input.value)) {
                iziToast.error({
                    title: `${app.Error}!`,
                    message: `${app.imageFileExtensions}`,
                    position: 'topRight'
                });
                input.value = '';
                return false;
            } else {

                var reader = new FileReader();

                reader.onload = function(event) {
                    $(placeToInsertImagePreview).append(
                        `
                                                                                                                                                                    <div class="borderwrap2 " data-href="">
                                                                                                                                                                        <div class="filenameupload2">
                                                                                                                                                                        <img class="rounded " src="${event.target.result}"
                                                                                                                                                                                width="130" height="130">
                                                                                                                                                                            <div data-pos="${input.files[i].name}" data-imgid="" class="middle"><i
                                                                                                                                                                                    class="material-icons remove_img2">cancel</i>
                                                                                                                                                                            </div>
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                                                                `
                    );
                }

                reader.readAsDataURL(input.files[i]);
            }


        }

    });
    $(document).on('click', '.remove_img2', function() {

        var pos = $(this).parent().attr('data-pos');
        $(this).closest("div").parent().parent().remove();
        var fileArr = Array.from(productimages);

        var i = 0;

        console.log(productimages);
        console.log(fileArr);

        for (let x = 0; x < productimages.length; x++) {
            console.log(pos);
            if (pos == productimages[x].name) {
                fileArr.splice(x, 1);
            }
        }


        productimages = fileArr;

        console.log(productimages);

        console.log(productimages.length);

    });


    $.getJSON(`${dominUrl}category`).done(function(data) {

        console.log(data);



        $.each(data.cats, function(index, cat) {
            var element;
            var parent = $('#select_cat');


            element = `
                                <option value="${cat.id}">${cat.title}</option>`;

            parent.append(element);


        });

    });

    $.getJSON(`${dominUrl}getunit`).done(function(data) {

        console.log(data);


        $.each(data.units, function(index, unit) {
            var element;
            var parent = $('.select_unit');


            element = `
                                    <option value="${unit.id}">${unit.title}</option>`;

            parent.append(element);




        });

    });



    $('#addnewpricelist').on('click',function(e) {
        e.preventDefault();


        var x = $('.selectstoretag').html()




        var inputlink = `      <div class="form-row" >

                               
                        <div class="form-group col-md-2 mr-0">
                            <label>${app.Unit}</label>
                            <input type="number"  step="0.01" name="unit" placeholder="${app.Unit}" class="form-control unit" required>
                        </div>

                        <div class="form-group col-md-2 ml-0 selectstoretag">
                            <label>&nbsp;</label>
                            <select class="form-control select_unit unit_id" required>

                                ${x}

                            </select>
                        </div>

                       
                     

                        <div class="form-group col-md-7">
                            <label for="product_price">${app.SalePrice}</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">${$currencies}</div>
                                </div>
                                <input type="number"  step="0.01" name="sale_price" placeholder="${app.SalePrice}"
                                    class="form-control  sale_price" value="" required>
                            </div>
                        </div>

                        <div class="form-group col-md-1">
                                    <label>${app.Remove}</label>
                                    <p href=""  id="removeprice" class="btn btn-danger mt-1"><i class="fas fa-minus"></i></p>

                                </div>


                                </div>`;

        $('#afteraddlink').append(inputlink);

    });



    $("#addProduct").on("click", "#removeprice", function() {
        $(this).parent().parent().remove();
    });










    $("#addProduct").on('submit',function(event) {

        event.preventDefault();
        $('.loader').show();

        if(productimages.length == 0){
            
                        $('.loader').hide();
                        iziToast.error({
                            title: `${app.Error}!`,
                            message: `${app.imageFileExtensions}`,
                            position: 'topRight'
                        });
                    

        }else{

        

        var units = [];

        $(".unit").each(function() {
            var input = $(this);
            units.push(input.val());
        });

        var unit_id = [];

        $(".unit_id").each(function() {
            var input = $(this);
            unit_id.push(input.val());
        });

        var price = [];

        $(".price").each(function() {
            var input = $(this);
            price.push(input.val());
        });
        var sale_price = [];

        $(".sale_price").each(function() {
            var input = $(this);
            sale_price.push(input.val());
        });


        

        if (user_type == "1") {
            var formdata = new FormData();




            for (let x = 0; x < productimages.length; x++) {

                formdata.append('image[' + x + ']', productimages[x]);

            }

            for (let x = 0; x < unit_id.length; x++) {

                formdata.append('unit_id[' + x + ']', unit_id[x]);

            }

            for (let x = 0; x < units.length; x++) {

                formdata.append('units[' + x + ']', units[x]);

            }


            for (let x = 0; x < sale_price.length; x++) {

                formdata.append('sale_price[' + x + ']', sale_price[x]);

            }

            for (let x = 0; x < price.length; x++) {

                formdata.append('price[' + x + ']', price[x]);

            }


            formdata.append('category_id', $('#select_cat').val());
            formdata.append('name', $('#name').val());
            formdata.append('description', $('#discription').val());
            formdata.append('a', $("input[name=_token]").val());


            console.log(formdata);

            $.ajax({
                url: `${dominUrl}addProductindb`,
                type: 'POST',
                data: formdata,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    console.log(response);

                    if (response.status) {

                        window.location.href = `${dominUrl}product`;
                    } else {
                        $('.loader').hide();
                        iziToast.error({
                            title: `${app.Error}!`,
                            message: `${app.SalePriceNotVaild}`,
                            position: 'topRight'
                        });
                    }


                },
                error: (error) => {
                    console.log(JSON.stringify(error));
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

        

        }


    });


});
