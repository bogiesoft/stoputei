$(function(){
    //get a depart city from depart country
    $(document).on('change', '#gettourform-depart_country', function(){
        var destination = $(this).val();
        var resort_url = $('.ajax-depart-cities-dropdown').attr('href');
        $.get(resort_url,{'country_id':destination}).done(function(response){
            var data = $.parseJSON(response);
            var select_resort = '';
            for (var i in data) {
                select_resort += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
            }
            $('#gettourform-depart_city').html(select_resort);
        });
    });

    //change fields after add hotel to filter
    function addHotelToFilter(hotel_star){
        var hotel_star = hotel_star;
        $('.field-gettourform-hotel_type, .field-gettourform-beach_line, .field-gettourform-stars, #gettourform-budget').addClass('disabled');
        $('[name="GetTourForm[beach_line][]"]').attr('disabled', 'disabled').attr('checked', false);
        $('[name="GetTourForm[hotel_type]"]').attr('disabled', 'disabled').attr('checked', false);
        $('#gettourform-stars [name="GetTourForm[stars][]"]').attr('disabled', 'disabled').prop('checked', false);
        $('#gettourform-stars [name="GetTourForm[stars][]"]').filter(function () {
            return $(this).val() == hotel_star;
        }).prop('checked', true);
        $('#gettourform-budget').attr('disabled', 'disabled').val('');
    }
    function removeHotelFromFilter(){
        $('.field-gettourform-hotel_type, .field-gettourform-beach_line, .field-gettourform-stars').removeClass('disabled');
        $('#gettourform-beach_line [name="GetTourForm[beach_line][]"]').attr('disabled', false).prop('checked', false);
        $('#gettourform-hotel_type [name="GetTourForm[hotel_type]"]').attr('disabled', false).prop('checked', false);
        $('#gettourform-room_type [name="GetTourForm[room_type][]"]').attr('disabled', false).prop('checked', false);
        $('#gettourform-nutrition [name="GetTourForm[nutrition][]"]').attr('disabled', false).prop('checked', false);
        $('#gettourform-stars [name="GetTourForm[stars][]"]').attr('disabled', false).prop('checked', false);
        $('#gettourform-budget').removeAttr('disabled');
    }

    //get a tour on ajax(destination)
    $(document).on('change', '#gettourform-destination', function(){
        var destination = $(this).val();
        var resort_url = $('.ajax-resort').attr('href');
        $('#gettourform-hotel_id').html('');
        $('#gettourform-hotel').val('');
        $.get(resort_url,{'country_id':destination}).done(function(response){
            var data = $.parseJSON(response);
            var select_resort = '';
            for (var i in data) {
                select_resort += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
            }
            $('#gettourform-resort').html(select_resort);
            getHotelList();
            removeHotelFromFilter();
        });
    });

    //get a tour on ajax(resort)
    $(document).on('change', '#gettourform-resort', function(){
        $('#gettourform-hotel').val('');
        $('#gettourform-hotel_id').val('');
        getHotelList();
        removeHotelFromFilter();
    });

    //get a tour on ajax(stars)
    $(document).on('change', '#gettourform-stars .checkbox', function(){
        getHotelList();
    });

    //search list of hotels
    var getHotelList = function(){
        var url = $('.ajax-tour-list').attr('href');
        var data = $('#get-tour-form').serialize();
        $('.hotels-container .loader-bg').removeClass('hide');
        $.get(url, data).done(function(response){
            var data = $.parseJSON(response);
            $('.hotels-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                $('#hotel-response').html(data.html);
                $('.offers-tab.tab-badge.get-tour').text(data.count);
            }else{
                $('#hotel-response').text(data.message);
                $('.offers-tab.tab-badge.get-tour').text(data.count);
            }
        });
        //imagePreview();
    }

    //create route to autocomplete
    var autocomplete_url = $('.ajax-hotel-autocomplete').attr('href');
    $(document).on('input', '#gettourform-hotel', function(){
        var country_id = $('#gettourform-destination').val();
        var resort_id = $('#gettourform-resort').val();
        var query = $('#gettourform-hotel').val();
        var url = autocomplete_url+'?country_id='+country_id+'&resort_id='+resort_id+'&query='+query;
        $.get(url).done(function(response){
            var data = $.parseJSON(response);
            $('.hotels-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                var list_hotels = '';
                for (var i in data.hotels) {
                    list_hotels += '<option value="'+data.hotels[i].hotel_id+'">'+data.hotels[i].hotel_name+'</option>';
                }
                $('#gettourform-hotel_id').html(list_hotels).show();
            }else{
            }
        });
    });

    //check flight included and disable fields
    /*$(document).on('change', '#gettourform-flight_included', function(){
        var is_checked = ($('#gettourform-flight_included').attr("checked"))?true:false;
        if(is_checked){
            $('[name="GetTourForm[flight_included]"]').removeAttr('checked');
            $('[name="GetTourForm[flight_included]"]').val(0);
            $('#gettourform-depart_country, #gettourform-depart_city, #gettourform-from_date, #gettourform-to_date').attr('disabled', true);
        }else{
            $('[name="GetTourForm[flight_included]"]').val(1);
            $('[name="GetTourForm[flight_included]"]').attr('checked', true);
            $('#gettourform-depart_country, #gettourform-depart_city, #gettourform-from_date, #gettourform-to_date').attr('disabled', false);
        }
    });*/

    //choose filed from autocomplete
    $(document).on('click', '#gettourform-hotel_id', function(){
        var hotel_id = $(this).val();
        var hotel_name = $('#gettourform-hotel_id option:selected').text();
        $('#gettourform-hotel').val(hotel_name);
        if(hotel_name.length > 20) {
            $('#gettourform-hotel').attr('data-toggle', 'tooltip').attr('title', hotel_name).attr('data-original-title', hotel_name);
            $('[data-toggle="tooltip"]').tooltip();
        }
        //disable beach type & hotel type
        $('.field-gettourform-hotel_type, .field-gettourform-beach_line').addClass('disabled');
        $('[name="GetTourForm[beach_line]"]').attr('disabled', 'disabled');
        $('[name="GetTourForm[hotel_type]"]').attr('disabled', 'disabled');
        $(this).hide();
        getHotelList();
        addHotelToFilter($('.add-to-filter').attr('data-hotel-star'));
    });

    $('.filter').on('click', function(){
        $('#gettourform-hotel_id').hide();
    });

    //Add hotel to filter by USER or MANAGER
    $(document).on('click', '.add-to-filter.user-type', function(e){
        e.preventDefault();
        var hotel_id = $(this).attr('data-hotel-id');
        var hotel_name = $(this).attr('data-hotel-name');
        var hotel_star = $(this).attr('data-hotel-star');
        var option = '<option value="'+hotel_id+'">'+hotel_name+'</option>';
            $('#gettourform-hotel_id').html(option);
            $("#gettourform-hotel_id option").filter(function () {
                return $(this).val() == hotel_id;
            }).attr('selected', true);
            $('#gettourform-hotel').val(hotel_name);
            if(hotel_name.length > 20) {
                $('#gettourform-hotel').attr('data-toggle', 'tooltip').attr('title', hotel_name).attr('data-original-title', hotel_name);
                $('[data-toggle="tooltip"]').tooltip();
            }
        getHotelList();
        addHotelToFilter(hotel_star);
    });

    //submit user tour form
    $(document).on('click', '#submit-tour', function(e){
        e.preventDefault();
        var url = $('#get-tour-form').attr('action');
        var data = $('#get-tour-form').serialize();
        $('.hotels-container .loader-bg').removeClass('hide');
        $.post(url, data).done(function(response){
            var data = $.parseJSON(response);
            $('.hotels-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                console.log(data.message);
                $('#modal-container .modal-content').html(data.popup);
                $('#modal-container').modal({backdrop: 'static', keyboard: false});
                $('#modal-container').modal('show');
            }else{
                console.log(data.model);
                $('.form-group .help-block').text('');
                for (var i in data.errors) {
                    $('.field-gettourform-'+i+' .help-block').text(data.errors[i]);
                    $('.field-gettourform-'+i).removeClass('has-success').addClass('has-error');
                }
            }
        });
    });

    //handling modal window USER TOUR
    $(document).on('click', '.create-one-more-tour', function(){
        $('.hotels-container .loader-bg').removeClass('hide');
        clearGetTourForm();
        $('#hotel-response').empty();
        $('.badge.tab-badge.get-tour').text('0');
        $('.hotels-container .loader-bg').addClass('hide');
    });

    function clearGetTourForm(){
        $('[name*="GetTourForm"]:not([type="checkbox"])').val('');
        $('select[name*="GetTourForm"]').val(1);
        $('select[name="GetTourForm[exactly_date]"] option').filter(function () {
            return $(this).val() == 0;
        }).attr('selected', true);
        $('select[name*="GetTourForm"] option').filter(function () {
            return $(this).val() == '';
        }).attr('selected', true);
        $('#get-tour-form input.disabled').removeClass('disabled').attr('disabled', false);
        $('#get-tour-form [type="checkbox"]').attr('checked', false);
        $('#get-tour-form [type="radio"]').attr('checked', false);
    }

    //clear hotel name user request
    $(document).on('click' ,'.remove-hotel-name-user-request', function(){
        $('#gettourform-hotel').val('');
        $('#gettourform-hotel_id').val('');
        getHotelList();
        removeHotelFromFilter();
    });

    //check all or not checkbox
    $(document).on('change', '#gettourform-nutrition [name="GetTourForm[nutrition][]"]', function(){
        var val = $(this).val();
        var is_checked = ($(this).prop('checked'))?true:false;
        if((val == 0) && is_checked){
            $('[name="GetTourForm[nutrition][]"]').not(this).prop('checked', false);
            $(this).closest('.checkbox-one').removeClass('not-any-check').addClass('any-check');
        }else if((val == 0) && !is_checked){
            $('[name="GetTourForm[nutrition][]"]').not(this).prop('checked', true);
            $(this).closest('.checkbox-one').removeClass('any-check').addClass('not-any-check');
        }else if((val != 0) && is_checked){
            $('[name="GetTourForm[nutrition][]"]:first').prop('checked', false).closest('.checkbox-one').removeClass('any-check not-any-check');;
        }
    });
    $(document).on('change', '#gettourform-room_type [name="GetTourForm[room_type][]"]', function(){
        var val = $(this).val();
        var is_checked = ($(this).prop('checked'))?true:false;
        if((val == 0) && is_checked){
            $('[name="GetTourForm[room_type][]"]').not(this).prop('checked', false);
            $(this).closest('.checkbox-one').removeClass('not-any-check').addClass('any-check');
        }else if((val == 0) && !is_checked){
            $('[name="GetTourForm[room_type][]"]').not(this).prop('checked', true);
            $(this).closest('.checkbox-one').removeClass('any-check').addClass('not-any-check');
        }else if((val != 0) && is_checked){
            $('[name="GetTourForm[room_type][]"]:first').prop('checked', false).closest('.checkbox-one').removeClass('any-check not-any-check');
        }
    });
    $(document).on('change', '#gettourform-beach_line [name="GetTourForm[beach_line][]"]', function(){
        var val = $(this).val();
        var is_checked = ($(this).prop('checked'))?true:false;
        if((val == 0) && is_checked){
            $('[name="GetTourForm[beach_line][]"]').not(this).prop('checked', false);
            $(this).closest('.checkbox-one').removeClass('not-any-check').addClass('any-check');
        }else if((val == 0) && !is_checked){
            $('[name="GetTourForm[beach_line][]"]').not(this).prop('checked', true);
            $(this).closest('.checkbox-one').removeClass('any-check').addClass('not-any-check');
        }else if((val != 0) && is_checked){
            $('[name="GetTourForm[beach_line][]"]:first').prop('checked', false).closest('.checkbox-one').removeClass('any-check not-any-check');
        }
    });

    $(document).on('change', '#gettourform-letter_filter [name="GetTourForm[letter_filter][]"]', function(){
        $(this).closest('.checkbox-one').toggleClass('active');
        getHotelList();
    });
});