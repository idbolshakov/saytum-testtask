<?php

namespace Saytum\MailSender;

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
     */
    public function validate($userData) {

        if ( 
            $this->validateEmail($userData) &&
            $this->validateDomainRestriction($userData)
        ) {

            return true;
        }

        return false;
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

    private function validateDomainRestriction($data) {

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

