<?php
use common\models\Event;
/**
 * @var $event common\models\Event
 */
?>

<div class="page-header text-center">
    <h1><?= $event->name ?></h1>
    <p2><?=$event->host->getFullName()?></p2>
</div>
<button type="button" class="btn pull-right btn-primary">Ask To Join</button>

<div class = "address-div">
    <div class="page-header">
        <h3>Location</h3>
    </div>
    <p> <?= $event->address->getFullFormat()?></p>
</div>
<style>
    #map {
        height: 400px;
        width: 100%;
    }
</style>
<div id="map"></div>
<script>
    function initMap() {
        var uluru = <?= $event->address->latlng ?>;
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 4,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?=\Yii::$app->params['googleAPIKey'] ?>&callback=initMap">
</script>

<div class = "description-div">
    <div class="page-header">
        <h3>Description</h3>
    </div>
    <p> <?= $event->description?></p>
    <p><?= "Price: ". $event->price?>  </br>  <?= "Capacity: ". $event->capacity?>  </p>
</div>




