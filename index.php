<?php

require('mailsender/MailSender.php');
require('userData.php');

$mailSenderConfig = array(

    'report_email'       => 'yura@saytum.ru',
    'sorting_key'        => 'date_registration',
    'sorting_ascending'  => true,
    'domain_restriction' => true,
    'allow_domains'      => array('saytum.ru'),
    'time_restriction'   => true,
    'allow_time'         => array('start' => '10:00', 'end' => '22:00'),
    'age_restriction'    => true,
    'allow_age'          => array('min' => '18', 'max' => '150'),
);

Saytum\MailSender\MailSender::getInstance()
                                ->configure($mailSenderConfig)
                                ->run($users);
?>

