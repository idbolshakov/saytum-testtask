<?php

require('mailsender/MailSender.php');
require('userData.php');


$mailSenderConfig = array(

    'sorting_key'        => 'date_registration',
    'sorting_ascending'  => 'true',
    'domain_restriction' => 'true',
    'allow_domains'      => array('gmail.com', 'saytum.ru'),
    'time_restriction'   => 'true',
    'allow_time'         => array('min_time' => 'time', 'max_time' => 'time'),
    'age_restriction'    => 'true',
    'allow_age'          => array('min_age' => 'age', 'max_age' => 'age'),
);

Saytum\MailSender\MailSender::getInstance()
                                ->configure($mailSenderConfig)
                                ->run($users);
?>

