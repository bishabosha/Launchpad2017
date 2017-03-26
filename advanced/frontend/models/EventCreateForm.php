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
            [['howMany', 'address'], 'integer'],
            ['price', 'double'],
            [['name', 'description'], 'string', 'max' => 255],
            [['address'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address' => 'addressId']],
        ];
    }

    public function create() {

        if (!$this->validate()) {
            return null;
        }

        $event = new Event();
        $event->name = $this->name;

        $tempTime = \DateTime::createFromFormat('d-n-Y H:i', $this->when);
        $event->timestamp = $tempTime->format('Y-m-d H:i:s');

        $event->price = round($this->price * 100);
        $event->capacity = $this->howMany;
        $event->addressId = $this->address;
        $event->description = $this->description;
        $event->hostId = \yii::$app->user->id;
        $event->attending = "[]";
        $event->requests = "[]";

        return $event->save() ? $event : null;
    }
}