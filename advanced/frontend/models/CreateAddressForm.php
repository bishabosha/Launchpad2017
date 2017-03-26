<?php

namespace frontend\models;

use common\models\Address;
use yii\base\Model;

class CreateAddressForm extends Model {
    public $name;
    public $street1;
    public $street2;
    public $city;
    public $postcode;

    public function rules()
    {
        return [
            [['name', 'street1', 'city', 'postcode'], 'required'],
            [['name', 'street1', 'street2', 'city', 'postcode'], 'string', 'max' => 255]
        ];
    }

    public function create() {
        if (!$this->validate()) {
            return null;
        }

        $address = new Address();

        $address->name = $this->name;
        $address->street1 = $this->street1;
        $address->street2 = $this->street2;
        $address->city = $this->city;
        $address->postcode = $this->postcode;

        $address->userId = \Yii::$app->user->id;

        return $address->save() ? $address : null;
    }
}