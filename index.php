<?php

require('mailsender/MailSender.php');
require('userData.php');

$mailSenderConfig = array(

    'sorting_key'        => 'date_registration',
    'sorting_ascending'  => 'true',
    'domain_restriction' => 'true',
    'allow_domains'      => array('gmail.com', 'saytum.ru'),
    'time_restriction'   => 'true',
    'allow_time'         => array('start' => '10:00', 'end' => '23:00'),
    'age_restriction'    => 'true',
    'allow_age'          => array('min' => '18', 'max' => '150'),
);

Saytum\MailSender\MailSender::getInstance()
                                ->configure($mailSenderConfig)
                                ->run($users);
?>

