<?php

require('./models/userSubscriptionModel.php');

$subs = new userSubscriptionModel();

$countries = $subs->getCountries();