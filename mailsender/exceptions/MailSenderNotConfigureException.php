<?php

namespace Saytum\MailSender\Exceptions;

/**
 * MailSenderNotConfigureException
 *
 * класс кастомного исключения
 * вызывается, когда
 * запускается несконфигурированный MailSender (не вызван метод configure)
 */
class MailSenderNotConfigureException extends \Exception {

    public function __construct() {

        parent::__construct('MailSender not configure', 0);
    } 
}
?>

