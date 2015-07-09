<?php
use yii\helpers\BaseFileHelper;
$photos_dir = 'uploads/hotel/images/small/'.$hotel->hotel_id;
$photos = [];
$photos_show = [];
$stop_photo = 2;
if(file_exists($photos_dir) && is_dir($photos_dir)){
    $photos = BaseFileHelper::findFiles($photos_dir);
}
foreach($photos as $key => $one){
    $photos_show[] = '/'.$one;
    if($key == $stop_photo){break;};
}
$star = '';
switch($hotel->star_id){
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
$rate = '';
if($hotel->hotel_rate == 0){
    $rate .= '<span class="status">'.Yii::t('app', 'No rate').'</span>';
}else{
    $rate .= '<span class="status">'.Yii::t('app', 'Rate').':</span><span class="number">'.$hotel->hotel_rate.'</span>';
}
?>
<div class="col-xs-12 hotel-list-wrap">
    <div class="hotel-title">
        <span class="name"><?= $hotel->name;?></span>
        <span class="star"><?= $star;?></span>
    </div>
    <div class="row hotel-body">
        <div class="col-xs-6 images">
            <?php foreach($photos_show as $img):?>
                <img src="<?=$img;?>" class="img-responsive hotel-img">
            <?php endforeach;?>
        </div>
        <div class="col-xs-6 information">
            <div class="col-xs-6 info">
                <span class="rate">
                    <?=$rate;?>
                </span>
                <span class="country"><?=$hotel->country_name;?></span>
                <span class="city"><?=$hotel->resort;?></span>
            </div>
            <div class="col-xs-6 buttons">
                <a href="#" class="more-hotel-info btn btn-primary" data-hotel-id="<?=$hotel->hotel_id;?>"><?= Yii::t('app', 'More');?></a>
                <a href="#" class="add-to-filter btn btn-default" data-hotel-id="<?=$hotel->hotel_id;?>" data-hotel-name="<?=$hotel->name;?>"><?= Yii::t('app', 'Choose');?></a>
            </div>
        </div>
    </div>
</div>
