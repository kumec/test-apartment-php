<?php

namespace app\models;

use components\MailHelper;
use Yii;

/**
 * This is the model class for table "apartment".
 *
 * @property int $id
 * @property int $count_rooms
 * @property int $count_bathrooms
 * @property int $square
 * @property bool $has_parking
 * @property string $comment
 * @property string $unit
 * @property string $building
 * @property string $street
 * @property string $city
 * @property string $region
 * @property string $country
 * @property string $zip_code
 * @property string $access_token
 * @property string $owner_email
 */
class Apartment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'apartment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count_rooms', 'count_bathrooms', 'square', 'has_parking', 'building', 'street', 'city', 'region', 'country', 'zip_code', 'access_token', 'owner_email'], 'required'],
            [['count_rooms', 'count_bathrooms', 'square'], 'default', 'value' => null],
            [['count_rooms', 'count_bathrooms', 'square'], 'integer'],
            [['has_parking'], 'boolean'],
            [['comment'], 'string'],
            [['unit', 'building'], 'string', 'max' => 10],
            [['street', 'city', 'region', 'country'], 'string', 'max' => 50],
            [['zip_code'], 'string', 'max' => 6],
            [['access_token'], 'string', 'max' => 32],
            [['owner_email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'count_rooms' => 'Count Rooms',
            'count_bathrooms' => 'Count Bathrooms',
            'square' => 'Square',
            'has_parking' => 'Has Parking',
            'comment' => 'Comment',
            'unit' => 'Unit',
            'building' => 'Building',
            'street' => 'Street',
            'city' => 'City',
            'region' => 'Region',
            'country' => 'Country',
            'zip_code' => 'Zip Code',
            'access_token' => 'Access Token',
            'owner_email' => 'Owner Email',
        ];
    }

    /**
     * @inheritdoc
     */
    public function sendAttributes()
    {
        return [
            'id',
            'count_rooms',
            'count_bathrooms',
            'square',
            'has_parking',
            'comment',
            'unit',
            'building',
            'street',
            'city',
            'region',
            'country',
            'zip_code',
            'owner_email',
        ];
    }

    public function beforeValidate()
    {
        if(!$this->id){
            $this->access_token = Yii::$app->security->generateRandomString();
        }
        return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($insert){
            $mailHelper = new MailHelper();
            $mailHelper->addApartment($this);
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}