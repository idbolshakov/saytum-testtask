<?php

namespace Saytum\MailSender\Templates;

/**
 * UserTemplate
 *
 * класс отвечает 
 * за формирование
 * шаблона письма
 * для пользователя
 *
 * @version 1.0.0
 * @author idbolshakov@gmail.com
 */
class UserTemplate {

    private $userData;

    /**
     * конструктор
     *
     * @param @userData - данные о пользователе
     */
    public function __construct($userData) {

        $this->userData = $userData;
    }

    /**
     * getTo
     *
     * @return email адрес получателя
     */
    public function getTo() {

        return $this->userData['email'];
    }

    /**
     * getSubject
     *
     * @return тема письма
     */
    public function getSubject() {

        return 'Saytum test task';
    }

    /**
     * getMessage
     *
     * @return само письмо
     */
    public function getMessage() {

        $subject = $this->getSubject();
        $name   =  $this->userData['name'];

        return "
            <html>\n
                <head>\n
                    <title>'$subject</title>\n
                </head>\n
                
                <body>\n
                    <h1>Привет, $name !</h1>\n
                </body>\n
            </html>\n
        ";
    }

    /**
     * getHeaders
     *
     * @return  заголовки письма
     */
    public function getHeaders() {

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

        return $headers;
    }

}
?>
