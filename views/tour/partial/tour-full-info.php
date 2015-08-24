<?php
use yii\helpers\BaseFileHelper;
$date = date(('d.m.Y H:i:s'), $tour->created_at);
$star = '';
switch($tour->hotel->star_id){
    case 400:
        $star .= '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i>';
        break;
    case 401:
        $star .= '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i>';
        break;
    case 402:
        $star .= '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i>';
        break;
    case 403:
        $star .= '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i>';
        break;
    case 404:
        $star .= '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i>';
        break;
}

//hotel images
$path_to_images = 'uploads/hotel/images/';
$photos_dir = 'uploads/hotel/images/small/'.$tour->hotel->hotel_id;
$photos = [];
if(file_exists($photos_dir) && is_dir($photos_dir)){
    $photos = BaseFileHelper::findFiles($photos_dir);
}else{
    $photos = [];
}
$photo_count = count($photos) -1;

if(!empty($photos)){
    $big_photo = $photos[rand(0, $photo_count)];
    $big_photo = '<img src="'.$big_photo.'" class="img-responsive big-photo">';
    $gallery = [];
    foreach($photos as $key => $photo){
        if($key > 6){
            $class = 'hide';
        }else{
            $class = '';
        }
        $gallery[] = [
            'url' => $path_to_images.'big/'.$tour->hotel->hotel_id.'/'.$key.'.jpg',
            'src' => $photos_dir.'/'.$key.'.jpg',
            'options' => [
                'title' => $tour->hotel->name,
                'class' => 'one-gallery-img '.$class,
                'alt' => $tour->hotel->name
            ]
        ];
    }
}else{
    $gallery = [];
    $big_photo = '<span class="empty-img"><i class="glyphicon glyphicon-camera"></i></span>';
}

if($tour->from_date) {
    $from_date = date('d.m.Y', strtotime($tour->from_date));
}
if($tour->to_date) {
    $to_date = date('d.m.Y', strtotime($tour->to_date));
}

?>

<script type="text/javascript">
    function initialize() {
        //point position
        var myLatLng = new google.maps.LatLng(<?=$tour->hotel->latitude;?>, <?=$tour->hotel->longitude;?>)
        var mapOptions = {
            zoom: 11,
            center: myLatLng
        };

        var map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: "<?=$tour->hotel->name;?>"
        });
    }

    function loadScript() {
        $('#map-api-script').remove();
        $('script[src*="https://maps.gstatic.com/maps-api-v3/api"]').remove();
        var script1 = document.createElement('script');
        script1.type = 'text/javascript';
        script1.id = 'map-api-script';
        script1.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAH-z5yA2rub-VCGI8DfRg4CGsJKyCrpks&callback=initialize';

        document.body.appendChild(script1);
    }

    setTimeout(loadScript, 1000);
</script>
<div class="tour-full-info">
    <div class="row">
        <div class="header col-xs-12">
            <div class="col-xs-6">
                <span class="offer-number">
                    <?=Yii::t('app', 'Order').' № '.$tour->id;?>
                </span>
                <span class="created">
                    <?=$date;?>
                </span>
            </div>
        </div>

        <div class="hotel-header col-xs-12">
            <div class="col-xs-6">
                <span class="name">
                    <?=$tour->hotel->name;?>
                </span>
                <span class="stars">
                    <?=$star;?>
                </span>
                <span class="rate">
                    <?= Yii::t('app', 'Rate');?> : <?=$tour->hotel->hotel_rate;?>
                </span>
            </div>
        </div>

        <div class="col-xs-6 body-hotel">
            <div class="col-xs-12"><?=$big_photo;?></div>
            <div class="col-xs-12">
                <?= dosamigos\gallery\Gallery::widget([
                    'items' => $gallery,
                    'id' => 'gallery-widget'
                ]);?>
            </div>
            <div class="col-xs-12">
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs-tour" role="tablist">
                        <li role="presentation" class="active col-xs-4"><a href="#description" aria-controls="description" role="tab" data-toggle="tab"><?= Yii::t('app', 'Description');?></a></li>
                        <li role="presentation" class="col-xs-4"><a href="#testimonials" aria-controls="testimonials" role="tab" data-toggle="tab"><?= Yii::t('app', 'Testimonials');?> (<?=count($tour->testimonials);?>)</a></li>
                        <li role="presentation" class="col-xs-4"><a href="#facilities" aria-controls="facilities" role="tab" data-toggle="tab"><?= Yii::t('app', 'Facilities');?> (<?=count($tour->hotel->facilities);?>)</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="description">
                            <?php if(!empty($tour->hotel->description)):?>
                                <?= $tour->hotel->description;?>
                            <?php else:?>
                                <?= Yii::t('app', 'Hotel description coming soon.');?>
                            <?php endif;?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="testimonials">
                            <?php if(!empty($tour->testimonials)):?>
                                <?php foreach($tour->testimonials as $testimonial):?>
                                <div class="testimonial">
                                    <div class="header col-xs-12">
                                        <span class="name"><?=$testimonial->user_name;?></span>
                                        <span class="date"><?=$testimonial->start_rest_formatted;?></span>
                                    </div>
                                    <div class="body">
                                        <?= (!empty($testimonial->negative))?$testimonial->negative:$testimonial->positive;?>
                                    </div>
                                </div>
                                <?php endforeach;?>
                            <?php else:?>
                                <?= Yii::t('app', 'Testimonials are absent.');?>
                            <?php endif;?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="facilities">
                            <?php if(!empty($tour->hotel->facilities)):?>
                                <ul class="hotel-facilities">
                                    <?php foreach($tour->hotel->facilities as $facility):?>
                                        <li>
                                            <i class="glyphicon glyphicon-tag"></i>
                                            <?=$facility->name;?>
                                            <?php if(!empty($facility->hint)):?>
                                                <span class="hint">
                                            ( <?=$facility->hint;?> )
                                        </span>
                                            <?php endif;?>
                                        </li>
                                    <?php endforeach;?>
                                </ul>
                            <?php else:?>
                                <?= Yii::t('app', 'Hotel hasn\'t facilities.');?>
                            <?php endif;?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xs-6 body-tour">
            <div id="map-canvas" class="col-xs-12"></div>
            <div class="col-xs-6 fields left">
                <div>
                    <span class="field"><?=Yii::t('app', 'Destination');?> : </span>
                    <span class="value"><?=$tour->country->name;?></span>
                </div>
                <div>
                    <span class="field"><?=Yii::t('app', 'Resort');?> : </span>
                    <span class="value"><?=$tour->city->name;?></span>
                </div>
                <div>
                    <span class="field"><?=Yii::t('app', 'Hotel');?> : </span>
                    <span class="value"><?=$tour->hotel->name;?></span>
                </div>
                <div>
                    <span class="field"><?=Yii::t('app', 'Hotel type');?> : </span>
                    <span class="value"><?=\app\models\TourResponse::getHotelType($tour->hotel_type);?></span>
                </div>
                <div>
                    <span class="field"><?=Yii::t('app', 'Room type');?> : </span>
                    <span class="value"><?=\app\models\TourResponse::getRoomName($tour->room_type)?></span>
                </div>
                <div>
                    <span class="field"><?=Yii::t('app', 'Room view');?> : </span>
                    <span class="value"><?=\app\models\TourResponse::getRoomView($tour->room_view);?></span>
                </div>
                <br>

                <div>
                    <span class="field"><?=Yii::t('app', 'Amount of adult');?> : </span>
                    <span class="value"><?=$tour->adult_amount;?></span>
                </div>
                <div>
                    <span class="field"><?=Yii::t('app', 'Amount of children (under 12 years old)');?> : </span>
                    <span class="value"><?=$tour->children_under_12_amount;?></span>
                </div>
                <div>
                    <span class="field"><?=Yii::t('app', 'Amount of children (under 2 years old)');?> : </span>
                    <span class="value"><?=$tour->children_under_2_amount;?></span>
                </div>
                <br>

                <div>
                    <span class="field"><?=Yii::t('app', 'Amount of room');?> : </span>
                    <span class="value"><?=$tour->room_count;?></span>
                </div>
                <br>

                <?php if($tour->flight_included == 1):?>
                    <div>
                        <span class="field"><?=Yii::t('app', 'Flight');?> : </span>
                        <span class="value"><?=Yii::t('app', 'Included');?></span>
                    </div>
                    <br>

                    <?php if(!is_null($tour->departCityThere)):?>
                    <div>
                        <span class="field"><?=Yii::t('app', 'Depart city there');?> : </span>
                        <span class="value"><?=$tour->departCityThere->name;?></span>
                    </div>
                    <?php endif;?>
                    <div>
                        <span class="field"><?=Yii::t('app', 'From date');?> : </span>
                        <span class="value"><?=$from_date;?></span>
                    </div>

                    <?php if(!is_null($tour->voyage_there)):?>
                        <?php if(!is_null($tour->voyageThroughCityThere)):?>
                        <div>
                            <span class="field"><?=Yii::t('app', 'Voyage through');?> : </span>
                            <span class="value"><?=$tour->voyageThroughCityThere->name;?></span>
                        </div>
                        <?php endif;?>
                    <?php endif;?>

                    <?php if(!is_null($tour->departCityFromThere)):?>
                    <div>
                        <span class="field"><?=Yii::t('app', 'Depart city from there');?> : </span>
                        <span class="value"><?=$tour->departCityFromThere->name;?></span>
                    </div>
                    <?php endif;?>
                    <div>
                        <span class="field"><?=Yii::t('app', 'To date');?> : </span>
                        <span class="value"><?=$to_date;?></span>
                    </div>
                    <?php if(!is_null($tour->voyage_from_there)):?>
                        <?php if(!is_null($tour->voyageThroughCityFromThere)):?>
                        <div>
                            <span class="field"><?=Yii::t('app', 'Voyage through');?> : </span>
                            <span class="value"><?=$tour->voyageThroughCityFromThere->name;?></span>
                        </div>
                        <?php endif;?>
                    <?php endif;?>
                <?php else:?>
                    <div>
                        <span class="field"><?=Yii::t('app', 'Flight');?> : </span>
                        <span class="value"><?=Yii::t('app', 'not included');?></span>
                    </div>
                <?php endif;?>
                <br>

                <div>
                    <span class="field"><?=Yii::t('app', 'Tickets exist');?> : </span>
                    <?php if($tour->tickets_exist == 1):?>
                        <span class="value"><?=Yii::t('app', 'Lot of');?></span>
                    <?php else:?>
                        <span class="value"><?=Yii::t('app', 'Little');?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="col-xs-6 fields right">

                <div>
                    <span class="field"><?=Yii::t('app', 'Night count');?> : </span>
                    <span class="value"><?=$tour->night_count;?></span>
                </div>
                <div>
                    <span class="field"><?=Yii::t('app', 'Location');?> : </span>
                    <span class="value"><?=\app\models\TourResponse::getLocationName($tour->location);?></span>
                </div>
                <div>
                    <span class="field"><?=Yii::t('app', 'Nutrition');?> : </span>
                    <span class="value"><?=\app\models\TourResponse::getNutritionName($tour->nutrition);?></span>
                </div>
                <div>
                    <span class="field"><?=Yii::t('app', 'Beach line');?> : </span>
                    <span class="value"><?=\app\models\TourResponse::getBeachLine($tour->beach_line);?></span>
                </div>
                <br>

                <?php if($tour->add_payment == 1):?>
                    <div>
                        <span class="field"><?=Yii::t('app', 'Visa');?> : </span>
                        <span class="value"><?=$tour->visa;?></span>
                    </div>
                    <div>
                        <span class="field"><?=Yii::t('app', 'Oil tax');?> : </span>
                        <span class="value"><?=$tour->oil_tax;?></span>
                    </div>
                 <?php else:?>
                <div>
                    <span class="field"><?=Yii::t('app', 'Add payment');?> : </span>
                    <span class="value"><?=Yii::t('app', 'Payment is absent');?></span>
                </div>
                <?php endif;?>
                <br>

                <div>
                    <span class="field"><?=Yii::t('app', 'Medicine insurance');?> : </span>
                    <?php if($tour->medicine_insurance == 1):?>
                        <span class="value"><?=Yii::t('app', 'Yes');?></span>
                    <?php else:?>
                        <span class="value"><?=Yii::t('app', 'No');?></span>
                    <?php endif;?>
                </div>
                <div>
                    <span class="field"><?=Yii::t('app', 'Manager\'s charge');?> : </span>
                    <?php if($tour->charge_manager == 1):?>
                        <span class="value"><?=Yii::t('app', 'Yes');?></span>
                    <?php else:?>
                        <span class="value"><?=Yii::t('app', 'No');?></span>
                    <?php endif;?>
                </div>
                <br>

                <div class="company">
                <div class="col-xs-12">
                    <?=$tour->owner->company_name;?>
                </div>
                <div class="col-xs-12">
                    <?=$tour->owner->company_phone;?>
                </div>
                <?php if(!is_null($tour->owner->company_address)):?>
                <div class="col-xs-12">
                    <?=$tour->owner->company_address;?>
                </div>
                <?php endif;?>
                <?php if(!is_null($tour->owner->company_street)):?>
                <div class="col-xs-12">
                    <?=$tour->owner->company_street;?>
                </div>
                <?php endif;?>

                <?php if(!is_null($tour->owner->company_underground)):?>
                <div class="col-xs-12">
                    <?=$tour->owner->company_underground;?>
                </div>
                <?php endif;?>
                </div>

            </div>
        </div>
    </div>
</div>