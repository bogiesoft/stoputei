<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row filter-tour">
    <span class="back-to-main">
        <i class="glyphicon glyphicon-menu-right hide"></i>
    </span>
    <div class="col-md-9 left-data">
        <div class="col-md-4 create-tour inactive">
        <?=$responseForm;?>
        </div>
        <div class="col-md-8 user-tour-container">
            <div class="loader-bg hide"><img src="/images/loader.gif"></div>
            <div id="user-tour-response">
                <?=$userTours;?>
            </div>
        </div>
    </div>
    <div class="col-md-3 right-data">
        <div class="main-data">
            Statistics
        </div>
        <div id="right-data-response">

        </div>
    </div>
    <div class="col-xs-12 full-hotel-information hide">

    </div>
    <?= Html::a('', Url::toRoute(['tour/ajax-hotels-autocomplete-manager']), ['class' => 'ajax-hotel-autocomplete-manager']);?>
</div>