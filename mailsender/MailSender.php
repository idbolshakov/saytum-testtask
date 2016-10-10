<?php

namespace Saytum\MailSender;

require('UserArrayCompare.php');
require('MailSenderNotConfigureException.php');

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

    private $config          = null;
    private $invalidUsers    = null;


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
     *   'allow_time'         => array('min' => {time}, 'end' => {time}),
     *
     *   // true - включаем ограничения по возрасту 
     *   'age_restriction'    => {boolean},
     *
     *   // диапазон разрешенного для рассылки возраста
     *   // используется если age_restriction=true
     *   'allow_age'          => array('age' => {int}, 'max' => {int}),
     * );
     *
     * @param @config - массив с конфигом 
     */
    public function configure($config) {

        $this->config = $config;

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

        for ($i=0, $l=count($array); $i<$l; $i++) {

            $this->sendToNextUserIfValid($array[$i]);
        }

        $this->sendReport();
    }

    private function checkConfiguration() {

        if (\is_null($this->config)) {

            throw new Saytum\MailSender\MailSenderNotConfigureException();
        }
    }

    private function sortArray($array) {

        $key        = $this->config['sorting_key'];
        $ascending  = $this->config['sorting_ascending'];

        $comparator = new UserArrayCompare($key, $ascending);

        \usort($array, array($comparator, 'compare'));

        foreach($array as $k => $value) {

            echo $value[$key]."<br><br>";
        }
    }

    private function sendToNextUserIfValid($data) {

        if ($this->validateEmail($data)) {

        }
    }

    private function validateEmail($data) {

        if ( !\filter_var($data['email'], FILTER_VALIDATE_EMAIL) ) {

            $this->invalidUsers[] = array(

                'userdata' => $data, 
                'error'    => 'invalid email format'
            ); 

            return false;
        }

        return true;
    }

    private function sendEmail($data) {

    }

    private function sendReport() {

        for ($i=0, $l=count($this->invalidUsers); $i<$l; $i++) {

            $user = $this->invalidUsers[$i];

            echo $user['userdata']['email'].' - '.$user['error'].'<br>';
        }
    }
}
?>
