<?php
use common\models\Event;
/**
 * @var $event common\models\Event
 */
?>

<div class="page-header text-center">
    <h1><?= $event->name ?></h1>
<!--    <p1> By </br></p1>-->
    <p2><?=$event->host->getFullName()?></p2>
</div>

<div class = "address-div">
    <div class="page-header">
        <h3>Location</h3>
    </div>
    <p> <?= $event->address->getFullFormat()?></p>
</div>

<div class = "description-div">
    <div class="page-header">
        <h3>Description</h3>
    </div>
    <p> <?= $event->description?></p>
    <p><?= "Price: ". $event->price?>  </br>  <?= "Capacity: ". $event->capacity?>  </p>
</div>
