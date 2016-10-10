<?php

namespace Saytum\MailSender\Templates;

/**
 * ReportTemplate
 *
 * класс отвечает 
 * за формирование
 * шаблона письма
 * с отчетом по 
 * рассылке
 *
 * @version 1.0.0
 * @author idbolshakov@gmail.com
 */
class ReportTemplate {

    private $config;
    private $sendedCount;
    private $invalidUsersArray;

    /**
     * конструктор
     *
     * @param $config            - конфиг отработанной рассылки
     * @param $sendedCount       - количество отправленных писем
     * @param $invalidUsersArray - пользователи не попавшие в рассылку
     */
    public function __construct($config, $sendedCount, $invalidUsersArray) {

        $this->config            = $config;
        $this->sendedCount       = $sendedCount;
        $this->invalidUsersArray = $invalidUsersArray;
    }

    /**
     * getTo
     *
     * @return email адрес получателя
     */
    public function getTo() {

        return $this->config['report_email'];
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

        $subject     = $this->getSubject();

        $sendedCount  = $this->sendedCount;
        $config       = \var_export($this->config, true);
        $invalidUsers = \var_export($this->invalidUsersArray, true);

        return "
            <html>\n
                <head>\n
                    <title>'$subject</title>\n
                </head>\n
                
                <body>\n
                    <h1>Результаты рассылки</h1>\n

                    <table>\n
                        <tr>\n
                            <td>конфиг рассылки:</td>\n
                            <td>$config</td>\n
                        </tr>\n

                        <tr>\n
                            <td>Количество отправленных писем: </td>\n
                            <td>$sendedCount</td>\n
                        </tr>\n

                         <tr>\n
                            <td>пользователи не попавшие в рассылку</td>\n
                            <td>$invalidUsers</td>\n
                        </tr>\n
 
                    </table>\n
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
