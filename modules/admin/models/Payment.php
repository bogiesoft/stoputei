<?php
namespace app\modules\admin\models;

use yii\db\ActiveRecord;
use Yii;
use app\models\Country;
use yii\db\Expression;

class Payment extends ActiveRecord
{
    public static function tableName()
    {
        return 'payments';
    }

    public function attributeLabels()
    {
        return [
            'country_id' => Yii::t('app', 'Country'),
            'country.name' => Yii::t('app', 'Country'),
            'single_region_cost' => Yii::t('app', 'Single region cost'),
            'multiple_region_cost' => Yii::t('app', 'Multiple region cost'),
            'currency' => Yii::t('app', 'Currency'),
        ];
    }

    public function getCountry(){
        return $this->hasOne(Country::className(), ['country_id' => 'country_id']);
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
}