<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\AutoComplete;
use dosamigos\datepicker\DatePicker;
use yii\web\JsExpression;
?>
<div class="row filter-tour">
    <span class="back-to-main">
        <i class="glyphicon glyphicon-menu-right hide"></i>
    </span>
    <div class="col-md-9 left-data">
        <div class="col-md-4 filter">
            <?php $form = ActiveForm::begin([
                'id' => 'get-tour-form',
                'action' => Url::toRoute(['tour/submit-tour-user']),
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-xs-11 col-xs-offset-1 \">{input}</div>\n<div class=\"col-xs-11 col-xs-offset-1\">{error}</div>",
                    'labelOptions' => ['class' => 'col-xs-11 col-xs-offset-1 control-label label-get-tour'],
                ],
            ]); ?>

            <?= $form->field($GetTourForm, 'destination')->dropDownList($destinationDropdown,['prompt' => Yii::t('app','Choose destination')]);?>

            <?= $form->field($GetTourForm, 'resort')->dropDownList([],['prompt' => Yii::t('app','Choose destination')]);?>

            <?= $form->field($GetTourForm, 'hotel', ['template' => '{label}<div class="col-xs-11 col-xs-offset-1 ">{input}<i class="glyphicon glyphicon-remove-circle remove-hotel-name"></i></div>'])->input('text') ?>

            <?= $form->field($GetTourForm, 'hotel_id')->dropDownList([], ['multiple' => true])->label('');?>

            <?= Html::a('', Url::toRoute(['tour/ajax-hotels-autocomplete']), ['class' => 'ajax-hotel-autocomplete']);?>


            <?= $form->field($GetTourForm, 'stars')->checkboxList([404 => '', 403 => '', 402 => '', 401 => '', 400 => ''],
                ['item' => function($index, $label, $name, $checked, $value){
                    if($value == 404){
                        $checked = true;
                        $span = Html::tag('span', '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i>', ['class' => 'star']);
                    }elseif($value == 403){
                        $span = Html::tag('span', '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i>', ['class' => 'star']);
                    }elseif($value == 402){
                        $checked = true;
                        $span = Html::tag('span', '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i>', ['class' => 'star']);
                    }elseif($value == 401){
                        $span = Html::tag('span', '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i>', ['class' => 'star']);
                    }elseif($value == 400){
                        $span = Html::tag('span', '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i>', ['class' => 'star']);
                    }
                $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
                return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox']);
            }]);?>
            <?= $form->field($GetTourForm, 'nutrition')->checkboxList([0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => ''],
                ['item' => function($index, $label, $name, $checked, $value){
                    if($value == 0){
                        $checked = true;
                        $span = Html::tag('span', Yii::t('app','RO'), ['class' => 'type-name']);
                    }elseif($value == 1){
                        $span = Html::tag('span', Yii::t('app','BB'), ['class' => 'line-name']);
                    }elseif($value == 2){
                        $span = Html::tag('span', Yii::t('app','HB'), ['class' => 'line-name']);
                    }elseif($value == 3){
                        $span = Html::tag('span', Yii::t('app','HB+'), ['class' => 'line-name']);
                    }elseif($value == 4){
                        $span = Html::tag('span', Yii::t('app','FB+'), ['class' => 'line-name']);
                    }elseif($value == 5){
                        $span = Html::tag('span', Yii::t('app','AL'), ['class' => 'line-name']);
                    }elseif($value == 6){
                        $span = Html::tag('span', Yii::t('app','UAL'), ['class' => 'line-name']);
                    }
                    $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
                    return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one col-xs-6']);
                }]);?>
            <?= $form->field($GetTourForm, 'beach_line')->checkboxList([0 => '', 1 => '', 2 => '', 3 => ''],
                ['item' => function($index, $label, $name, $checked, $value){
                    if($value == 0){
                        $checked = true;
                        $span = Html::tag('span', Yii::t('app','Any line'), ['class' => 'line-name']);
                    }elseif($value == 1){
                        $span = Html::tag('span', Yii::t('app','First line'), ['class' => 'line-name']);
                    }elseif($value == 2){
                        $span = Html::tag('span', Yii::t('app','Second line'), ['class' => 'line-name']);
                    }elseif($value == 3){
                        $span = Html::tag('span', Yii::t('app','Third line'), ['class' => 'line-name']);
                    }
                    $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
                    return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one']);
                }]);?>
            <?= $form->field($GetTourForm, 'hotel_type')->checkboxList([0 => '', 1 => '', 2 => '', 3 => '', 4 => ''],
                ['item' => function($index, $label, $name, $checked, $value){
                    if($value == 0){
                        $checked = true;
                        $span = Html::tag('span', Yii::t('app','Any type'), ['class' => 'type-name']);
                    }elseif($value == 1){
                        $span = Html::tag('span', Yii::t('app','Teen'), ['class' => 'line-name']);
                    }elseif($value == 2){
                        $span = Html::tag('span', Yii::t('app','Family'), ['class' => 'line-name']);
                    }elseif($value == 3){
                        $span = Html::tag('span', Yii::t('app','Urban'), ['class' => 'line-name']);
                    }elseif($value == 4){
                        $span = Html::tag('span', Yii::t('app','Health'), ['class' => 'line-name']);
                    }
                    $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
                    return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one']);
                }]);?>
            <div class="form-group">
                <label class="col-xs-11 col-xs-offset-1 control-label label-get-tour" for="gettourform-hotel_type"><?=Yii::t('app', 'Amount of nights');?></label>
                <?= $form->field($GetTourForm, 'night_min', ['options' => ['class' => 'col-xs-6']], ['template' => '{label}<div class="col-xs-5">{input}</div>', 'labelOptions' => ['class' => 'col-xs-2 control-label label-night']])->dropDownList([1 => 1, 2 => 2]);?>
                <?= $form->field($GetTourForm, 'night_max', ['options' => ['class' => 'col-xs-6']], ['template' => '{label}<div class="col-xs-5">{input}</div>', 'labelOptions' => ['class' => 'col-xs-2 control-label label-night']])->dropDownList([1 => 1, 2 => 2]);?>
            </div>
             <?= $form->field($GetTourForm, 'room_type')->checkboxList([0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '', 7 => ''],
                ['item' => function($index, $label, $name, $checked, $value){
                    if($value == 0){
                        $checked = true;
                        $span = Html::tag('span', Yii::t('app','Standart'), ['class' => 'type-name']);
                    }elseif($value == 1){
                        $span = Html::tag('span', Yii::t('app','Family'), ['class' => 'line-name']);
                    }elseif($value == 2){
                        $span = Html::tag('span', Yii::t('app','Deluxe'), ['class' => 'line-name']);
                    }elseif($value == 3){
                        $span = Html::tag('span', Yii::t('app','Suite'), ['class' => 'line-name']);
                    }elseif($value == 4){
                        $span = Html::tag('span', Yii::t('app','Villa'), ['class' => 'line-name']);
                    }elseif($value == 5){
                        $span = Html::tag('span', Yii::t('app','Apartaments'), ['class' => 'line-name']);
                    }elseif($value == 6){
                        $span = Html::tag('span', Yii::t('app','Duplex'), ['class' => 'line-name']);
                    }elseif($value == 7){
                        $span = Html::tag('span', Yii::t('app','Club'), ['class' => 'line-name']);
                    }
                    $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
                    return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one col-xs-6']);
                }]);?>
            <?= $form->field($GetTourForm, 'adult_amount')->dropDownList([1 => 1, 2 => 2]);?>
            <?= $form->field($GetTourForm, 'children_under_12_amount')->dropDownList([0 => 0, 1 => 1, 2 => 2]);?>
            <?= $form->field($GetTourForm, 'children_under_2_amount')->dropDownList([0 => 0, 1 => 1, 2 => 2]);?>
            <?= $form->field($GetTourForm, 'room_count')->dropDownList([1 => 1, 2 => 2]);?>
            <?= $form->field($GetTourForm, 'flight_included')->checkbox();?>

            <?= $form->field($GetTourForm, 'depart_city')->dropDownList($departCityDropdown);?>

                <?= $form->field($GetTourForm, 'from_date')->widget(
                    DatePicker::className(), [
                    'inline' => false,
                    'options' => ['placeholder' => Yii::t('app', date('Y-M-d'))],
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-m-d',
                        'todayHighlight' => true,
                        'startDate' => date('Y-M-d', strtotime('+2 days')),
                    ]
                ]);?>

                <?= $form->field($GetTourForm, 'to_date')->widget(
                    DatePicker::className(), [
                    'inline' => false,
                    'options' => ['placeholder' => Yii::t('app', 'To date')],
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-m-d',
                        'todayHighlight' => true,
                        'startDate' => date('Y-M-d', strtotime('+4 days'))
                    ]
                ]);?>

            <?= $form->field($GetTourForm, 'budget')->input('number', ['min' => 1000, 'max' => 90000000, 'step' => 200]);?>

            <?= $form->field($GetTourForm, 'add_info')->textarea(['class' => 'add-info']);?>

            <?= Html::a('', Url::toRoute(['tour/ajax-resorts-dropdown']), ['class' => 'ajax-resort']);?>
            <?= Html::a('', Url::toRoute(['tour/get-hotel-list']), ['class' => 'ajax-tour-list']);?>

            <div class="form-group">
                <div class="col-xs-11 col-xs-offset-1">
                    <?= Html::submitButton(Yii::t('app','Get a tour'), ['class' => 'btn btn-success col-xs-12', 'name' => 'get-tour-button', 'id' => 'submit-tour']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-8 hotels-container">
            <div class="loader-bg hide"><img src="/images/loader.gif"></div>
            <div id="hotel-response">

            </div>
        </div>
    </div>
    <div class="col-md-3 right-data">
        TOP HOTELS
    </div>
</div>