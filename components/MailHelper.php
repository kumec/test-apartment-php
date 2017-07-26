<?php

namespace components;

use app\models\Apartment;

class MailHelper extends \yii\base\Object
{

    /**
     * @return MailHelper
     */
    public static function get()
    {
        return new self();
    }

    /**
     * @param string $template
     * @param array $params
     * @return \yii\mail\MessageInterface
     */
    private static function mail($template, $params = [])
    {
        return \Yii::$app->mailer->compose($template, $params)
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name]);
    }

    /**
     * @param \app\models\Apartment $user
     * @return bool
     */
    public function addApartment($apartment)
    {
        return self::mail('add-apartment', ['apartment' => $apartment])
            ->setTo($apartment->email)
            ->setSubject('Added new appartment')
            ->send();
    }
}
