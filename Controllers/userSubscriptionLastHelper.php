<?php

require('./models/userSubscriptionModel.php');

$subs = new userSubscriptionModel();

$languages = $subs->getLanguages();