(function ($) {
    "use strict";


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

    $(document).on('input', '#search_term', function(e){
        e.preventDefault();

        var term = $(this).val();
        if (term !== '') {
            $.ajax({
                type : 'GET',
                url : page_data.routes.search_category,
                data : {term : term, _token : page_data.csrf_token},
                success: function(data){
                    $('#suggestions').empty();
                    data.forEach(function(x){
                        $("#suggestions").append('<tr id="sug-item"><td>'+x.category_name+'</td></tr>');
                    });
                }
            });
        }
    });


    $(document).on('click', '#sug-item', function(e){
        e.preventDefault();

        var sel = $(this).text();
        $('#suggestions').empty();
        $('#search_term').val(sel);
        //document.querySelector('#search_form').submit();
    });

    $(document).on('input', '#add-new', function(e){
        e.preventDefault();

        var cat = $(this).val();
        //$('#new-cat_show').empty();
        if (cat !== '') {
            $("#new-cat_show").html('<tr id="new-cat"><td>'+cat+'</td></tr>');
        }
    });

     $(document).on('click', '#new-cat', function(e){
        e.preventDefault();

        var cat = $(this).text();
        $('#new-cat_show').empty();
        $('#add-new').val(cat);
    });


    if (page_data.jobModalOpen){
        $('#applyJobModal').modal('show');
    }
    if (page_data.flag_job_validation_fails){
        $('#jobFlagModal').modal('show');
    }
    if (page_data.share_job_validation_fails){
        $('#shareByEMail').modal('show');
    }


    $(document).on('click', '.employer-follow-button', function(e){
        e.preventDefault();

        var $that = $(this);
        var employer_id = $that.attr('data-employer-id');

        $.ajax({
            type : 'POST',
            url : page_data.routes.follow_unfollow,
            data : {employer_id : employer_id, _token : page_data.csrf_token},
            beforeSend: function () {
                $that.addClass('updating-btn');
            },
            success: function(data){
                if (data.success){
                    if(typeof data.btn_text !== 'undefined'){
                        $that.html(data.btn_text);
                    }
                }else{
                    if(typeof data.login_url !== 'undefined'){
                        location.href = data.login_url;
                    }
                }
            },
            complete:function () {
                $that.removeClass('updating-btn');
            }
        });
    });

    //updating-btn

})( jQuery );