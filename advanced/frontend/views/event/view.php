<?php
use common\models\Event;
/**
 * @var $event common\models\Event
 * @var $address common\models\Address
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
    <p> <?= $event->description?></p>
    <p><?= "Price: ". $event->price?>  </br>  <?= "Capacity: ". $event->capacity?>  </p>
</div>

<!--    <div>-->
<!--        <strong>Results</strong>-->
<!--    </div>-->
<!--    <div id="output"></div>-->
<!--</div>-->
<!--<div id="map"></div>-->
<!--Replace the value of the key parameter with your own API key. -->
<!--<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkUOdZ5y7hMm0yrcCQoCvLwzdM6M8s5qk&callback=initMap">-->
<!--    ['query' => [-->
<!--    'address' => $address->fullFormat,-->
<!--    'key' => \yii::$app->params['googleAPIKey']-->
<!---->
<!--</script>-->

<!--    <script>-->
<!--        function initMap() {-->
<!--            var bounds = new google.maps.LatLngBounds;-->
<!--            var markersArray = [];-->
<!---->
<!---->
<!---->
<!--            var destinationIcon = 'https://chart.googleapis.com/chart?' +-->
<!--                'chst=d_map_pin_letter&chld=D|FF0000|000000';-->
<!--            var originIcon = 'https://chart.googleapis.com/chart?' +-->
<!--                'chst=d_map_pin_letter&chld=O|FFFF00|000000';-->
<!--            var map = new google.maps.Map(document.getElementById('map'), {-->
<!--                center: {-->
<!--                    lat: 51.3761045,-->
<!--                    lng: -2.3619776-->
<!--                },-->
<!--                zoom: 10-->
<!--            });-->
<!--            var geocoder = new google.maps.Geocoder;-->
<!---->
<!--            var service = new google.maps.DistanceMatrixService;-->
<!--            service.getDistanceMatrix({-->
<!--                origins: [origin1],-->
<!--                destinations: [google.maps.LatLng objects, or google.maps.Place objects],-->
<!--                travelMode: 'DRIVING',-->
<!--                unitSystem: google.maps.UnitSystem.METRIC,-->
<!--                avoidHighways: false,-->
<!--                avoidTolls: false-->
<!--            }, function(response, status) {-->
<!--                if (status !== 'OK') {-->
<!--                    alert('Error was: ' + status);-->
<!--                } else {-->
<!--                    var originList = response.originAddresses;-->
<!--                    var destinationList = response.destinationAddresses;-->
<!--                    var outputDiv = document.getElementById('output');-->
<!--                    outputDiv.innerHTML = '';-->
<!--                    deleteMarkers(markersArray);-->
<!---->
<!--                    var showGeocodedAddressOnMap = function(asDestination) {-->
<!--                        var icon = asDestination ? destinationIcon : originIcon;-->
<!--                        return function(results, status) {-->
<!--                            if (status === 'OK') {-->
<!--                                map.fitBounds(bounds.extend(results[0].geometry.location));-->
<!--                                markersArray.push(new google.maps.Marker({-->
<!--                                    map: map,-->
<!--                                    position: results[0].geometry.location,-->
<!--                                    icon: icon-->
<!--                                }));-->
<!--                            } else {-->
<!--                                alert('Geocode was not successful due to: ' + status);-->
<!--                            }-->
<!--                        };-->
<!--                    };-->
<!---->
<!--                    for (var i = 0; i < originList.length; i++) {-->
<!--                        var results = response.rows[i].elements;-->
<!--                        geocoder.geocode({-->
<!--                                'address': originList[i]-->
<!--                            },-->
<!--                            showGeocodedAddressOnMap(false));-->
<!--                        for (var j = 0; j < results.length; j++) {-->
<!--                            if (results[j].distance.value < OUR_CUTOFF_DISTANCE_IN_METERS) {-->
<!--                                geocoder.geocode({-->
<!--                                        'address': destinationList[j]-->
<!--                                    },-->
<!--                                    showGeocodedAddressOnMap(true));-->
<!--                                outputDiv.innerHTML += originList[i] + ' to ' + destinationList[j] +-->
<!--                                    ': ' + results[j].distance.text + ' in ' +-->
<!--                                    results[j].duration.text + '<br>';-->
<!--                            }-->
<!--                        }-->
<!--                    }-->
<!--                }-->
<!--            });-->
<!--        }-->
<!--    </script>-->
