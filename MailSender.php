<?php

namespace Saytum;

/**
 * MailSender
 *
 * отвечает за автоматическую
 * рассылку Email писем
 *
 * @version 1.0.0
 * @author idbolshakov@gmail.com
 */
class MailSender {

    private $instance;

    private function __construct() {}

    protected function __clone() {}

    /**
     * getInstance
     *
     * метод отвечает за доступ 
     * к синглтон-объекту MailSender
     *
     * @return синглтон-объект MailSender
     */
    static public function getInstance() {

        if (is_null($this->instance) {

            $this->instance = new Saytum\MailSender();
        }

        return $this->instance;
    }
}
?>
