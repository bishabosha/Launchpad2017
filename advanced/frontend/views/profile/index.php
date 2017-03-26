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
            echo "<p> Balance: ".$user->balance."</p>";
            echo "<p> Events Hosted: ".$user->events_hosted."</p>";
            echo "<p> Events Attended: ".$user->events_attended."</p>";
            echo "<p> Rating: ". $user->rating."</p>";
            echo "<p> Date Joined: ". substr($user->joined, 0, 10)."</p>";
        ?>
    </div>



    <div id="bio-section">
        <div class="page-header">
            <h3>Bio</h3>
        </div>
        <p> <?= $user->bio ?> </p>
    </div>

    <div id="address-section">
        <div class="page-header">
            <h3>Addresses</h3>
        </div>
        <?php $addresses = $user->getAddresses()->all(); ?>
        <?php foreach ($addresses as $address):?>
            <p><?= $address->name." ". $address->street1. ", ". $address->city.", ".$address->postcode?></p>
        <?php endforeach;?>
    </div>

    <div class="page-header">
        <h3>Upcoming Events</h3>
    </div>

    <div class="list-group">
        <?php $events = $user->getEvents(); ?>
        <?php foreach ($events as $event):?>
            <a href="#" class="list-group-item"><?= $event->name ?></a>
        <?php endforeach;?>
    </div>

</body>
