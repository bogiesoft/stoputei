<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class UserFlightForm extends Model
{
    public $destination;
    public $resort;
    public $way_ticket;
    public $depart_city;
    public $depart_country;
    public $date_city_to_since;
    public $date_city_to_until;
    public $date_city_from_since;
    public $date_city_from_until;
    public $adult_count_senior_24;
    public $adult_count_under_24;
    public $children_under_12_amount;
    public $children_under_2_amount;
    public $flight_class;
    public $regular_flight;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['destination', 'resort', 'depart_city', 'date_city_to_since', 'date_city_to_until', 'adult_count_senior_24'], 'required'],
            ['date_city_to_since', 'compare', 'compareAttribute' => 'date_city_to_until', 'operator'=>'<'],
            ['date_city_from_since', 'compare', 'compareAttribute' => 'date_city_from_until', 'operator'=>'<'],
            [['flight_class', 'regular_flight', 'way_ticket', 'adult_count_under_24', 'children_under_12_amount', 'children_under_2_amount'], 'default', 'value' => 0],
            [['way_ticket'], 'default', 'value' => 1],
            [['date_city_from_since', 'date_city_from_until'], 'required', 'message' => Yii::t('app','{attribute} must be checked.'), 'when' => function ($model) {
                return $model->way_ticket == 2;
            }, 'whenClient' => "function (attribute, value) {
                return $('[name=\"ManagerFlightForm[way_ticket]\"]').val() == 2;
            }"],
            [['date_city_from_since', 'date_city_from_until', 'depart_country'], 'default', 'value' => null]
        ];
    }


    public function attributeLabels()
    {
        return [
            'destination' => Yii::t('app', 'Destination'),
            'resort' => Yii::t('app', 'Resort/City'),
            'way_ticket' => Yii::t('app', 'Way ticket'),
            'depart_city' => Yii::t('app', 'Depart city'),
            'depart_country' => Yii::t('app', 'Depart country'),
            'date_city_to_since' => Yii::t('app', 'Flight to since'),
            'date_city_to_until' => Yii::t('app', 'Flight to until'),
            'date_city_from_since' => Yii::t('app', 'Flight from since'),
            'date_city_from_until' => Yii::t('app', 'Flight from until'),
            'adult_count_senior_24' => Yii::t('app', 'Amount of adult senior 24 years old'),
            'adult_count_under_24' => Yii::t('app', 'Amount of adult under 24 years old'),
            'children_under_12_amount' => Yii::t('app', 'Amount of children (under 12 years old)'),
            'children_under_2_amount' => Yii::t('app', 'Amount of children (under 2 years old)'),
            'flight_class' => Yii::t('app', 'Flight class'),
            'regular_flight' => Yii::t('app', 'Only regular flight'),
        ];
    }
}
