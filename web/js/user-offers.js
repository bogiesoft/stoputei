$(function(){
    //##################### USER OFFERS ######################
    //filter user's offers
    $(document).on('change', '#touroffersform-destination', function(){
        var destination = ($(this).val() != '')?$(this).val():'all';
        var resort_url = $('.ajax-resort-for-filter').attr('href');
        $.get(resort_url,{'country_id':destination}).done(function(response){
            var data = $.parseJSON(response);
            var select_resort = '';
            for (var i in data) {
                select_resort += '<option value="'+data[i].city_id+'">'+data[i].city_name+'</option>';
            }
            $('#touroffersform-resort').html(select_resort);
            getUserOffersList();
        });
    });

    //search list of hotels in offers
    var getUserOffersList = function(){
        var url = $('.ajax-get-offers-list').attr('href');
        var data = $('#user-offers-tour-form').serialize();
        $('.user-offer-list .loader-bg').removeClass('hide');
        $.get(url, data).done(function(response){
            var data = $.parseJSON(response);
            $('.user-offer-list .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                console.log(data.model);
                console.log(data.stars);
                $('#user-tour-response-list .list-data').html(data.tours);
                $('.offers-tab.tab-badge.user-offers').text(data.count);
            }else{
                $('#user-tour-response-list .list-data').html(data.message);
                $('.offers-tab.tab-badge.user-offers').text(data.count);
                console.log(data.stars);
            }
        });
    }

    $(document).on('click', '#touroffersform-resort', function(){
        getUserOffersList();
    });
    $(document).on('change', '#touroffersform-night_count', function(){
        getUserOffersList();
    });
    $(document).on('change', '#touroffersform-depart_city', function(){
        getUserOffersList();
    });
    $(document).on('change', '[name="TourOffersForm[stars][]"]', function(){
        getUserOffersList();
    });

    var autocomplete_url_manager = $('.ajax-hotel-autocomplete-offer').attr('href');
    $(document).on('input', '#touroffersform-hotel', function(){
        var country_id = $('#touroffersform-destination').val();
        var resort_id = $('#touroffersform-resort').val();
        var query = $('#touroffersform-hotel').val();
        var url = autocomplete_url_manager+'?country_id='+country_id+'&resort_id='+resort_id+'&query='+query;
        $.get(url).done(function(response){
            var data = $.parseJSON(response);
            $('.user-offer-list .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                var list_hotels = '';
                for (var i in data.hotels) {
                    list_hotels += '<option value="'+data.hotels[i].hotel_id+'">'+data.hotels[i].hotel_name+'</option>';
                }
                $('#touroffersform-hotel_id').html(list_hotels).show();
            }else{
            }
        });
    });

    //choose filed from autocomplete for offers
    $(document).on('click', '#touroffersform-hotel_id', function(){
        var hotel_id = $(this).val();
        var hotel_name = $('#touroffersform-hotel_id option:selected').text();
        $('#touroffersform-hotel').val(hotel_name);
        $(this).hide();
        getUserOffersList();
    });

    //clear hotel name user offers
    $(document).on('click' ,'.remove-hotel-name-user-offer', function(){
        $('#touroffersform-hotel').val('');
        $('#touroffersform-hotel_id').val('');
        getUserOffersList();
    });

    //open user's tour with full information
    $(document).on('click', '.tour-more-info-user', function(){
        var url = $('.ajax-user-tour-full-info').attr('href');
        var user_tour_id = $(this).attr('data-tour-id');
        url = url+'?filter_type=user-response';
        $('.user-tour-container .loader-bg').removeClass('hide');
        $.get(url, {'user_tour_id' : user_tour_id}).done(function(response){
            var data = $.parseJSON(response);
            $('.user-tour-container .loader-bg').addClass('hide');
            if(data.status == 'ok') {
                console.log(data);
                $('.right-data .main-data').hide();
                $('#right-data-response').html(data.html);
                $('a[href="#tour-from-user"]').text(data.tab_name);
                $('#user-tour-response .list-data').empty().html(data.hotels);
                $('[data-toggle="tooltip"]').tooltip();
                $('.create-tour').removeClass('inactive').empty().html(data.form);
            }else{
                $('#right-data-response').text(data.message);
            }
        });
    });
});