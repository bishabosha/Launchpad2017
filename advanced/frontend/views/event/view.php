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
<?php
$date = DateTime::createFromFormat('Y-m-d H:i:s', $event->timestamp);
$userId = \yii::$app->user->id;
?>

<div class="page-header">
    <h3>Time</h3>
    <p><?= $date->format('d-n-Y H:i') ?></p>
</div>

<?php if (in_array($userId, $event->attendingArray)):?>

    <span style="font-size: 1em;" class="label label-success">You've been accepted by <?=$event->host->getFullName()?>.</span>


    <div class="page-header">
        <h3>Location</h3>
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
                zoom: 15,
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

<?php elseif ($userId != $event->hostId && in_array($userId, $event->requestArray)): ?>

    <span style="font-size: 1em;" class="label label-warning">You have a pending invitation.</span>

    <div class="page-header">
        <h3>Location</h3>
        <p>You'll get the location when your invitation is accepted.</p>
    </div>

<?php elseif ($userId != $event->hostId && !in_array($userId, $event->requestArray)) : ?>

    <a href='<?= \yii\helpers\Url::to(["event/subscribe", 'id' => $event->eventId]) ?>' class="btn btn-info" role="button">Ask To Join</a>

    <div class="page-header">
        <h3>Location</h3>
        <p>You'll get the location when your invitation is accepted.</p>
    </div>

<?php else: ?>

    <span style="font-size: 1em;" class="label label-default">You're hosting the meal.</span>

    <div class="page-header">
        <h3>Location</h3>
        <p>You'll get the location when your invitation is accepted.</p>
    </div>

<?php endif; ?>

<div class="page-header">
    <h3>Description</h3>
    <p><?= $event->description?></p>
</div>

<div class = "page-header">
    <h3>Extra Info</h3>
    <p><?= "Points per person: ". $event->price / $event->capacity ?></p>
    <p><?= "Capacity: ". $event->capacity?></p>
    <p><?= "Spaces Left: ". ($event->capacity - count($event->attendingArray)) ?></p>
</div>




