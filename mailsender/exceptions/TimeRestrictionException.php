<?php

namespace Saytum\MailSender\Exceptions;

/**
 * TimeRestrictionException
 *
 * класс кастомного исключения
 * вызывается, когда 
 * пользователь пытается
 * отправить рассылку 
 * в запрещенное время
 */
class TimeRestrictionException extends \Exception {

    public function __construct() {

        parent::__construct('Time restriction exception', 1);
    } 
}
?>

