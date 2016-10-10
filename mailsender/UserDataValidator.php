<?php

namespace Saytum\MailSender;

require('exceptions/TimeRestrictionException.php');

/**
 * UserDataValidator
 *
 * отвечает за валидацию пользовательских данных
 * и сохранение массива пользователей с невалидными
 * данными 
 *
 * @version 1.0.0
 * @author idbolshakov@gmail.com
 */
class UserDataValidator {

    private $config            = null;
    private $invalidUsersArray = array();

    /**
     * конструктор
     *
     * @param $config - массив с настройками валидации
     */
    public function __construct($config) {

        $this->config = $config;
    }

    /**
     * validate
     *
     * проверяем пользовательские данные
     * на валидность, если они не валидны,
     * то сохраняем их в массив $this->invalidUsersArray
     *
     * @return true - данные валидны, false - данные не валидны
     * @throw TimeRestrictionException - в конфигурациизаданы интервалы в 
     * которые разрешается отправлять рассылку и мы в них не попали
     */
    public function validate($userData) {

        if (!$this->validateTimeRestriction() || 
            !$this->validateEmail($userData) ||
            !$this->validateDomainRestriction($userData) ||
            !$this->validateAgeRestriction($userData)
        ) {

            return false;
        } 

        return true;
    }

    private function validateTimeRestriction() {

        $minTime = \strtotime($this->config['allow_time']['start']);
        $maxTime = \strtotime($this->config['allow_time']['end']);
        $now     = \time();

        if ($now > $minTime && $now < $maxTime) {

            return true;
        } 

        throw new \Saytum\MailSender\Exceptions\TimeRestrictionException();

        return false;
    }

    private function validateEmail($data) {

        if ( !\filter_var($data['email'], FILTER_VALIDATE_EMAIL) ) {

            $this->invalidUsersArray[] = array(

                'userdata' => $data, 
                'error'    => 'invalid email format'
            ); 

            return false;
        }

        return true;
    }

    private function validateDomainRestriction($data) {

        $domain = $this->getDomain($data['email']);
    
        if ( 
            $this->config['domain_restriction'] && 
            !\in_array($domain, $this->config['allow_domains'])
        ) { 

            $this->invalidUsersArray[] = array(

                'userdata' => $data, 
                'error'    => 'the domain prohibited'
            ); 

            return false;
        }

        return true;
    }

    private function getDomain($email) {

        $emailPartsArray = \explode('@', $email);
        $domain = '';

        if (\count($emailPartsArray) > 1) {

            $domain = $emailPartsArray[1];
        }

        return $domain;
    }

    private function validateAgeRestriction($data) {

        $age     = $data['age'];
        $min     = $this->config['allow_age']['min'];
        $max     = $this->config['allow_age']['max'];

        if ( $this->config['age_restriction'] && ($age<$min || $age>$max) ) {

            $this->invalidUsersArray[] = array(

                'userdata' => $data, 
                'error'    => 'the age prohibited'
            ); 

            return false;
        }

        return true;
    }


    /**
     * getInvalidUsersArray
     *
     * возвращает массив с данными невалидных пользователей
     *
     * формат элемента массива:
     *
     * array(
     *     
     *     'userData' => array()  // данные пользователя
     *     'error'    => {string} // тип ошибки
     * );
     *
     */
    public function getInvalidUsersArray() {

        return $this->invalidUsersArray;
    }
}
?>

