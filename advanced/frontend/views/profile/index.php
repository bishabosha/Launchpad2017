<?php
/**
 * @var $user common\models\User
 */
$this->title = 'Profile';
use common\models\User;

?>


<div class="page-header text-center">
    <h1 > <?= $user ->firstname ." ". $user->lastname ?></h1>
</div>

<body>

    <div class="page-header">
        <h3>Stats</h3>
        <?php
        echo '<label class="control-label">Rating</label>';
        echo \kartik\rating\StarRating::widget([
            'name' => 'rating_1',
            'value' => $user->rating,
            'pluginOptions' => [
                'displayOnly' => true,
                'size' => 'xs',
            ]
        ]);
        echo '<label class="control-label">Date Joined</label>';
        echo "<p>". substr($user->joined, 0, 10)."</p>";
        echo '<label class="control-label">Balance</label>';
        echo "<p>".$user->balance."</p>";
        echo '<label class="control-label">Events Hosted</label>';
        echo "<p>".$user->events_hosted."</p>";
        echo '<label class="control-label">Events Attended</label>';
        echo "<p>".$user->events_attended."</p>";
        ?>
    </div>



    <div class="page-header">
        <h3>Bio</h3>
        <p> <?= $user->bio ?> </p>
    </div>

    <div class="page-header">
        <h3>Addresses</h3>
        <?php $addresses = $user->getAddresses()->all(); ?>
        <?php foreach ($addresses as $address):?>
            <p><?= $address->name." ". $address->street1. ", ". $address->city.", ".$address->postcode?></p>
        <?php endforeach;?>
        <a href=<?= \yii\helpers\Url::to(["profile/add-address"]) ?> class="btn btn-info" role="button">Add Address</a>
    </div>

    <div class="page-header">
        <h3>Upcoming Events</h3>
    </div>

    <div class="list-group">
        <?php $events = $user->getEvents(); ?>
        <?php foreach ($events as $event):?>
            <a href="<?= \yii\helpers\Url::to(["event/view", "id" => $event->eventId]) ?>" class="list-group-item"><?= $event->name ?></a>
        <?php endforeach;?>
    </div>

    <div class="page-header">
        <h3>Pending Requests</h3>
    </div>

    <div class="list-group">
        <?php $requests = \common\models\Event::getRequestsFlat($user->id); ?>
        <?php foreach ($requests as $pair):?>
            <?php
            $user = $pair['user'];
            $event = $pair['event'];
            ?>
            <p>Name: <?= $user->firstname . ' ' . $user->lastname ?></p>
            <p>Rating: <?= $user->rating ?></p>
            <p>Event: <?= $event->name ?></p>
            <a href="<?= \yii\helpers\Url::to(["event/accept", "eventId" => $event->eventId, 'userId' => $user->id]) ?>" class="btn btn-info"><span class="glyphicon glyphicon-ok"></span></a>
            <hr/>
        <?php endforeach;?>
    </div>

</body>
