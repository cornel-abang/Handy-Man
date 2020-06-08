(function ($) {
    "use strict";

    var url = window.location;
    var element = $('.sidebar-menu li .dropdown-menu li a').filter(function() {
        return this.href == url;
    }).addClass('active');

    $(document).on('click', '.sidebar-menu li a.list-group-item-action', function(e){
        var $that = $(this);

        var hasDropdown = $that.siblings('.dropdown-menu').length;
        if (hasDropdown){
            e.preventDefault();
        }

        if ( ! $that.closest('li').hasClass('active')) {
            $that.siblings('ul').slideToggle();
            $that.find('.arrow i').toggleClass('open-icon');
        }
    });

    $(document).on('change', '.country_to_state', function(e){
        e.preventDefault();

        var country_id = $(this).val();
        $.ajax({
            type : 'POST',
            url : page_data.routes.get_state_option_by_country,
            data : {country_id : country_id, _token : page_data.csrf_token},
            success: function(data){
                $('.state_options').html(data.state_options);
            }
        });
    });

    if (jQuery().datepicker){
        $('.date_picker').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            startDate: new Date(),
            autoclose: true
        });
    }
    if (jQuery().tooltip) {
        $('[data-toggle="tooltip"]').tooltip();
    }

    $(document).on('click','.category_delete', function (e) {
        if (!confirm("Are you sure? its can't be undone")) {
            e.preventDefault();
            return false;
        }

        var selector = $(this);
        var data_id = $(this).data('id');

        $.ajax({
            type: 'POST',
            url : page_data.routes.delete_categories,
            data: {data_id: data_id, _token: page_data.csrf_token},
            success: function (data) {
                if (data.success == 1) {
                    selector.closest('tr').remove();
                }
            }
        });
    });

    $(document).on('change', '#acct_id', function(e){
        e.preventDefault();
        document.querySelector('#loaderImg').removeAttribute('style');

        var acct_id = $(this).val();
        $.ajax({
            type : "GET",
            url : page_data.routes.get_account,
            data : {acct_id : acct_id, _token : page_data.csrf_token},
            success: function(data){
                document.querySelector('#loaderImg').style.display = 'none';
                //console.log(data.acct);
                //check for when provided acct_id is empty
                $('#user_id_area').html(data.acct);
                findServices(data.id);
            },
            error: function(data){
                $('#user_id_area').html('');
            }
        });
    });

    $(document).on('click', '.del_invoice_from_edit', function(e){
        e.preventDefault();
        //You could try removing the <tr> element ($(this).parent('tr').remove)MAYBE on delete from all temp
        var res = confirm("Are you sure?");
        if (res) {
            var inv_id = $(this).attr('id');
            $.ajax({
                type : "GET",
                url : page_data.routes.delete_invoice,
                data : {invoice_id : inv_id, _token : page_data.csrf_token},
                success: function(data){
                    window.location=data;
                }
            });
        }
        
    });

    /*
    Delete invoice from all invoices template
     */
    $(document).on('click', '.del_invoice_from_all', function(e){
        e.preventDefault();
        //You could try removing the <tr> element ($(this).parent('tr').remove)MAYBE on delete from all temp
        var res = confirm("Are you sure?");
        if (res) {
            //remove the the row it belongs to
            $(this).closest('tr').remove();

            var inv_id = $(this).attr('id');
            $.ajax({
                type : "GET",
                url : page_data.routes.delete_invoice_from_all,
                data : {invoice_id : inv_id, _token : page_data.csrf_token},
                success: function(data){
                    alert("Invoice deleted");
                }
            });
        }
        
    });

    function findServices(user_id){
        document.querySelector('#loaderImg2').removeAttribute('style');
        $.ajax({
            type : "GET",
            url : page_data.routes.get_services,
            data : {user_id : user_id, _token : page_data.csrf_token},
            success: function(data){
                document.querySelector('#loaderImg2').style.display = 'none';
                if (data.acct.length > 0) {
                    $('#job').empty();
                    $('#job').attr('disabled',false);
                    data.acct.forEach(function(val){
                   $('#job').append('<option value="'+val.id+'">'+val.category+'</option>');
                    });
                }else{
                    $('#job').empty();
                    $('#job').append('<option value="" class="la la-frown-o">No data</option>');
                    $('#job').attr('disabled',true);
                }
            }
        });
    }

    $(document).ready(function() {
        var max_fields      = 100;
        var wrapper         = $(".newItem");
        var add_button      = $(".add_form_field");
     
        var x = 1;
        $(add_button).click(function(e){
            e.preventDefault();
            
            if(x < max_fields){
                x++;
                $(wrapper).append('<div class="form-group row" ><label class="col-sm-3 control-label" for="item">Item *</label><div class="col-sm-3"><input type="text" name="item_name[]" id="item_name" class="form-control" placeholder="Name - Ex: Rim of Wire" /></div><div class="col-sm-2"><input type="number" name="item_price[]" id="item_price" class="form-control" placeholder="Price/Unit " /></div><div class="col-sm-2"><input type="number" name="item_qty[]" id="item_qty" class="form-control" placeholder="Quantity" /></div><a href="#" class="delete" style="color: red;"> <span class="fa fa-times-circle"></a></div>');
            }
      else
      {
      alert('You Reached the limits')
      }
        });
     
        $(wrapper).on("click",".delete", function(e){
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })

        /*######################
        Add new items while editting
         */
     
        var i = 1;
        var max_fields           = 500;
        var wrapper_edit         = $(".new_item_edit");
        var add_button_edit      = $(".add_form_field_edit");
        
        $(add_button_edit).click(function(e){
            e.preventDefault();
            
            var no_items = document.querySelector('.no'); 
            if (no_items) {
                no_items.style.display = 'none';    
            }
            
            if(i < max_fields){
                i++;
                $(wrapper_edit).append('<div class="form-group row" ><label class="col-sm-3 control-label" for="item">Item *</label><div class="col-sm-3"><input type="text" name="item_name_new[]" id="item_name" class="form-control" placeholder="Name - Ex: Rim of Wire" /></div><div class="col-sm-2"><input type="number" name="item_price_new[]" id="item_price" class="form-control" placeholder="Price/Unit " /></div><div class="col-sm-2"><input type="number" name="item_qty_new[]" id="item_qty" class="form-control" placeholder="Quantity" /></div><a href="#" class="delete" style="color: red;"> <span class="fa fa-times-circle"></a></div>');
            }
            else
              {
              alert('You Reached the limits')
              }
            });
     
        $(wrapper_edit).on("click",".delete", function(e){
            e.preventDefault(); 
            if (i > 1) {
                $(this).parent('div').remove(); x--;
            }else{
                alert("There must be atleast one item in the invoice");
            }
        })


        //Ajax Delete Item on Edit
        $('.itemEdit').on("click",".delete", function(e){
            e.preventDefault(); 
            //$(this).parent('div').remove();
            //get the value of clicked element id attribute which has been uniquely set
            //var item_id = $(this).attr('id');
            /*swal({
              title: "Are you sure?",
              text: "This is an irriversible action",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                $(this).parent('div').remove();
                $.ajax({
                    type : "GET",
                    url : page_data.routes.delete_edit_invoice_item,
                    data : {id : item_id, _token : page_data.csrf_token},
                    success: function(data){

                    }
                });
            swal("Invoice item deleted", {
            icon: "success",
                });
              } //else {
               // swal("Your imaginary file is safe!");
              //}
            });*/
            //check if theres only one item left in the invoice 
            if (document.querySelectorAll("#item").length === 1) {
                alert("There has to be atleast one item on the invoice");
            }else{
                var res = confirm("Are you sure?");
                if (res) {

                    var item_id = $(this).attr('id');
                    $(this).parent('div').remove();

                    $.ajax({
                        type : "GET",
                        url : page_data.routes.delete_edit_invoice_item,
                        data : {id : item_id, _token : page_data.csrf_token},
                        success: function(data){
                            alert("Item deleted!");
                        }
                    });
                }
            }
            
        })

    });




    /**
     * Settings Panel
     */
    $('.ajax-updating input[type="checkbox"], input[type="radio"]').click(function(){
        var input_name = $(this).attr('name');
        var input_value = 0;
        if ($(this).prop('checked')){
            input_value = $(this).val();
        }
        $.ajax({
            url : page_data.routes.save_settings,
            type: "POST",
            data: { [input_name]: input_value, _token: page_data.csrf_token},
        });
    });
    $('.ajax-updating input[name="date_format"]').click(function(){
        $('#date_format_custom').val($(this).val());
    });
    $('.ajax-updating input[name="time_format"]').click(function(){
        $('#time_format_custom').val($(this).val());
    });
    /**
     * Send settings option value to server
     */
    $('.ajax-updating #settings_save_btn').click(function(e){
        e.preventDefault();

        var $that = $(this);

        var form_data = $that.closest('form').serialize();
        $.ajax({
            url : page_data.routes.save_settings,
            type: "POST",
            data: form_data,
            beforeSend : function () {
                $that.attr('disabled', 'disabled');
                $that.addClass('updating-btn');
            },
            success : function (data) {

            },
            complete: function () {
                $that.removeClass('updating-btn');
                $that.removeAttr('disabled');
            }
        });
    });

    /**
     * show or hide stripe and paypal settings wrap
     */
    $('#enable_paypal').click(function(){
        if ($(this).prop('checked')){
            $('#paypal_settings_wrap').slideDown();
        }else{
            $('#paypal_settings_wrap').slideUp();
        }
    });
    $('#enable_stripe').click(function(){
        if ($(this).prop('checked')){
            $('#stripe_settings_wrap').slideDown();
        }else{
            $('#stripe_settings_wrap').slideUp();
        }
    });

    $('#enable_bank_transfer').click(function(){
        if ($(this).prop('checked')){
            $('.bankPaymetWrap').slideDown();
        }else{
            $('.bankPaymetWrap').slideUp();
        }
    });


})( jQuery );