<?php
$this->title = "Nearby Meals";
/* @var $event common\models\Event */
?>

<div class="row">
    <div class="col-md-9">
        <?php foreach ($events as $event): ?>
            <?php
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $event->timestamp);
                $host = $event->host;
            ?>
            <div>
                <h3><?= $event->name ?></h3>
                <h5>Host: <?= $host->firstname ?> <?=$host->lastname?></h5>
                <h5>Rating: <?=$host->rating ?></h5>
                <h5>Date: <?= $date->format('d-n-Y H:i') ?></h5>
                <h5>Points Per Person: <?= $event->price / $event->capacity ?></h5>
                <a href=<?= \yii\helpers\Url::to(["event/view", 'id' => $event->eventId]) ?> class="btn btn-info" role="button">View More</a>
            </div>
            <hr/>
        <?php endforeach; ?>
    </div>
</div>
