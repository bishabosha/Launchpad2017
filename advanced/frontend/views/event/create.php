<?php
$this->title = "Create Event";
?>

<div class='row'>
    <div class="'col-md-9">

        <?php use yii\helpers\Html; ?>

        <h1><?= Html::encode($this->title) ?></h1>

        <br/>

        <?php

        $form = \yii\bootstrap\ActiveForm::begin(); ?>

            <?= $form->field($model, 'name') ?>

            <?= $form->field($model, 'when')->widget(\kartik\datetime\DateTimePicker::className(), [
                'name' => 'datetime_10',
                'convertFormat' => true,
                'pluginOptions' => [
                    'format' => 'd-M-yyyy HH:mm',
                    'todayHighlight' => true
                ]
            ]) ?>

            <?= $form->field($model, 'price')->label('Cost') ?>

            <?= $form->field($model, 'howMany')->label('How many are you cooking for?') ?>

            <?= $form->field($model, 'address')->dropDownList($addresses)->label('Choose address') ?>

            <?= $form->field($model, 'description')->textarea()->label('Give a short description') ?>

            <div class="form-group">
                <?= Html::submitButton('Create', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
            </div>

        <?php \yii\bootstrap\ActiveForm::end(); ?>
    </div>
</div>
