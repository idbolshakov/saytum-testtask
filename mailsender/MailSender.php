<?php

namespace Saytum\MailSender;

require('UserArrayCompare.php');
require('UserDataValidator.php');

require('exceptions/MailSenderNotConfigureException.php');

require('templates/UserTemplate.php');
require('templates/ReportTemplate.php');

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

    private static $instance = null;

    private $config            = null;
    private $userDataValidator = null;

    private $sendedCount       = 0;

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

        if (is_null(self::$instance)) {

            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * configure
     *
     * сохраняем конфигурацию
     * MailSender'a
     *
     * формат массива с конфигурационной информацией
     *
     * array(
     *   // адрес для отправки отчета по рассылке
     *   'report_email'       => {email address string}
     *
     *   // ключ по которому будем сортировать массив пользователей
     *   'sorting_key'        => 'date_registration',
     *
     *   // true - по возрастанию, false - по убыванию
     *   'sorting_ascending'  => 'true',
     *
     *   // true - включаем ограничение на рассылку, false - выключаем
     *   'domain_restriction' => 'true',
     *   
     *   // разрешенные домены
     *   // испoльзуется если domain_restriction = true
     *   'allow_domains'      => array('gmail.com', 'saytum.ru'),
     *   
     *   // true - включаем ограничения на время рассылки, false - выключаем
     *   'time_restriction'   => {boolean},
     *
     *   // диапазон времени, в который разрешена рассылка
     *   // используется если time_restriction=true
     *   'allow_time'         => array('start' => {HH:MM}, 'end' => {HH:MM}),
     *
     *   // true - включаем ограничения по возрасту 
     *   'age_restriction'    => {boolean},
     *
     *   // диапазон разрешенного для рассылки возраста
     *   // используется если age_restriction=true
     *   'allow_age'          => array('min' => {int}, 'max' => {int}),
     * );
     *
     * @param @config - массив с конфигом 
     */
    public function configure($config) {

        $this->config            = $config;
        $this->userDataValidator = new UserDataValidator($config); 

        return $this;
    }

    /**
     * run
     *
     * метод отвечает за 
     * запуск автоматической
     * рассылки писем
     *
     * проверяем задана ли конфигурация
     *
     * сортируем массив в соответствии конфигурации
     *
     * пробегаем массив пользователей, валидируем, если все ок отправляем, 
     * если нет - добавляем в массив с ошибками.
     *
     * после пробега всего массива отправляем отчет об ошибках
     *
     * @param $array - массив с данными пользователей включенных в рассылку
     * @throw MailSenderNotConfigureException - когда нет конфигурации
     */
    public function run($array) {

        $this->checkConfiguration();

        $this->sortArray($array);

        $this->sendedCount = 0;

        for ($i=0, $l=count($array); $i<$l; $i++) {

            $this->sendEmailIfValid($array[$i]);
        }

        $this->sendReport();
    }

    private function checkConfiguration() {

        if (\is_null($this->config)) {

            throw new Saytum\MailSender\Exceptions\MailSenderNotConfigureException();
        }
    }

    private function sortArray($array) {

        $key        = $this->config['sorting_key'];
        $ascending  = $this->config['sorting_ascending'];

        $comparator = new UserArrayCompare($key, $ascending);

        \usort($array, array($comparator, 'compare'));
    }

    private function sendEmailIfValid($data) {

        if ($this->userDataValidator->validate($data)) {

            $this->sendEmail($data);
        }
    }

    private function sendEmail($data) {

        $template = new Templates\UserTemplate($data);

       \mail(
            $template->getTo(), 
            $template->getSubject(), 
            $template->getMessage(), 
            $template->getHeaders());

        $this->sendedCount += 1;
    }

    private function sendReport() {
        
        $config            = $this->config;
        $sendedCount       = $this->sendedCount;
        $invalidUsersArray = $this->userDataValidator->getInvalidUsersArray();

        $template = new Templates\ReportTemplate(
                                                $config, 
                                                $sendedCount, 
                                                $invalidUsersArray
        );
        
        \mail(
            $template->getTo(), 
            $template->getSubject(), 
            $template->getMessage(), 
            $template->getHeaders());
    }
}
?>
