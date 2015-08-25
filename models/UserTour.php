<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;

class UserTour extends ActiveRecord
{
    public static function tableName(){
        return 'user_tour';
    }

    public function getCountry(){
        return $this->hasOne(Country::className(), ['country_id' => 'country_id']);
    }

    public function getCity(){
        return $this->hasOne(City::className(), ['city_id' => 'resort_id']);
    }

    public function getHotel(){
        return $this->hasOne(Hotel::className(), ['hotel_id' => 'hotel_id']);
    }

    public function getDepartCity(){
        return $this->hasOne(DepartCity::className(), ['city_id' => 'depart_city_id']);
    }

    public function getCategories(){
        return $this->hasMany(HotelCategory::className(), ['star_id' => 'category_id'])
            ->viaTable(UserTourCategories::tableName(), ['tour_id' => 'id']);
    }

    public function getNutritions(){
        return $this->hasMany(HotelNutrition::className(), ['nutrition_id' => 'nutrition_id'])
            ->viaTable(UserTourNutritions::tableName(), ['tour_id' => 'id']);
    }

    public function getBeachLines(){
        return $this->hasMany(HotelBeachLine::className(), ['line_id' => 'beach_line_id'])
            ->viaTable(UserTourBeachLines::tableName(), ['tour_id' => 'id']);
    }

    public function getRooms(){
        return $this->hasMany(HotelRoom::className(), ['type_id' => 'room_id'])
            ->viaTable(UserTourRooms::tableName(), ['tour_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->updated_at = time();
            }
            if($this->isNewRecord){
                $this->created_at = time();
            }
            return true;
        }
        return false;
    }

    public static function getNutritionName($nutrition){
        switch($nutrition){
            case 0:
                return \Yii::t('app', 'RO');
            case 1:
                return \Yii::t('app', 'BB');
            case 2:
                return \Yii::t('app', 'HB');
            case 3:
                return \Yii::t('app', 'HB+');
            case 4:
                return \Yii::t('app', 'FB+');
            case 5:
                return \Yii::t('app', 'AL');
            case 6:
                return \Yii::t('app', 'UAL');
            case 7:
                return \Yii::t('app', 'Soft AL');
            default:
                return \Yii::t('app', 'Any nutrition');
        }
    }

    public static function getLocationName($location){
        switch($location){
            case 0:
                return \Yii::t('app', 'SGL');
            case 1:
                return \Yii::t('app', 'DBL');
            case 2:
                return \Yii::t('app', 'TRP');
            case 3:
                return \Yii::t('app', 'QTRL');
            default:
                return \Yii::t('app', 'SGL');
            default:
                return \Yii::t('app', 'Any type');
        }
    }

    public static function getRoomName($room){
        switch($room){
            case 0:
                return \Yii::t('app', 'Any type');
            case 1:
                return \Yii::t('app', 'Standart');
            case 2:
                return \Yii::t('app', 'Family');
            case 3:
                return \Yii::t('app', 'Deluxe');
            case 4:
                return \Yii::t('app', 'Suite');
            case 5:
                return \Yii::t('app', 'Villa');
            case 6:
                return \Yii::t('app', 'Economy');
            case 7:
                return \Yii::t('app', 'Apartments');
            case 8:
                return \Yii::t('app', 'Club');
            case 9:
                return \Yii::t('app', 'Studio');
            case 10:
                return \Yii::t('app', 'Bungalow');
            case 11:
                return \Yii::t('app', 'Superior');
            case 12:
                return \Yii::t('app', 'Eco');
            default:
                return \Yii::t('app', 'Any type');
        }
    }

    public static function getHotelType($hotel_type){
        switch($hotel_type) {
            case 0:
                return \Yii::t('app', 'Teen');
            case 1:
                return \Yii::t('app', 'Family');
            case 2:
                return \Yii::t('app', 'Urban');
            case 3:
                return \Yii::t('app', 'Health');
            default:
                return \Yii::t('app', 'Any type');
        }
    }

    public static function getRoomView($room_view){
        switch($room_view) {
            case 0:
                return \Yii::t('app', 'Land view');
            case 1:
                return \Yii::t('app', 'Sea view');
            case 2:
                return \Yii::t('app', 'Pool view');
            case 3:
                return \Yii::t('app', 'Garden view');
            default:
                return \Yii::t('app', 'Any type');
        }
    }

    public static function getBeachLine($beach_line){
        switch($beach_line) {
            case 0:
                return \Yii::t('app', 'First');
            case 1:
                return \Yii::t('app', 'Second');
            case 2:
                return \Yii::t('app', 'Third');
            case 3:
                return \Yii::t('app', 'Fourth');
            case 4:
                return \Yii::t('app', 'Fifth');
            case 5:
                return \Yii::t('app', 'Other');
            default:
                return \Yii::t('app', 'Other');
        }
    }
}