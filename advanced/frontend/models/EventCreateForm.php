<?php
namespace frontend\models;

use common\models\Address;
use common\models\Event;
use yii\base\Model;

class EventCreateForm extends Model {

    public $name;
    public $when;
    public $price;
    public $howMany;
    public $address;
    public $description;

    public function rules(){
        return [
            [['name', 'price', 'howMany', 'address', 'description', 'when'], 'required'],
            [['howMany', 'addressId'], 'integer'],
            ['price', 'double'],
            [['name', 'description'], 'string', 'max' => 255],
            [['addressId'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['addressId' => 'addressId']],
        ];
    }

    public function create() {

        if (!$this->validate()) {
            return null;
        }

        $event = new Event();
        $event->name = $this->name;
        $event->timestamp = $this->when;
        $event->price = $this->price;
        $event->capacity = $this->howMany;
        $event->addressId = $this->address;
        $event->description = $this->description;
        $event->hostId = \yii::$app->user->id;

        return $event->save() ? $event : null;
    }
}