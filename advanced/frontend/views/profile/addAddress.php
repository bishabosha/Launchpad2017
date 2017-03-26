<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\CreateAddressForm */
/* @var $form ActiveForm */

$this->title = "Add Address";
?>

<div class="addAddress">

    <h1><?=Html::encode($this->title)?></h1>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'street1') ?>
        <?= $form->field($model, 'street2') ?>
        <?= $form->field($model, 'city') ?>
        <?= $form->field($model, 'postcode') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- addAddress -->
