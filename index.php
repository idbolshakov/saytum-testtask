<?php

require('mailsender/MailSender.php');
require('userData.php');


$mailSenderConfig = array(

    'sorting_key'        => 'date_registration',
    'sorting_ascending'  => 'true'
);

Saytum\MailSender\MailSender::getInstance()
                                ->configure($mailSenderConfig)
                                ->run($users);
?>

