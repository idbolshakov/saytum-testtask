<?php

namespace Saytum\MailSender;

/**
 * UserArrayCompare
 *
 * отвечает за сортировку
 * элементов массива 
 *
 * @version 1.0.0
 * @author idbolshakov@gmail.com
 */
class UserArrayCompare {

    private $key;
    private $ascending;

    /**
     * конструктор
     *
     * @param $key - ключ по которому будем сортировать
     * @param $ascending - true - по возрастанию, false - по убыванию
     */
    public function __construct($key, $ascending) {

        $this->key       = $key;
        $this->ascending = $ascending;
    }

    /**
     * compare
     *
     * функция сравнения,
     * принмает два элемента массива
     * сравнивает их по ключу $this-key 
     * в зависимости от $this-ascending 
     * по убыванию или возрастанию
     *
     * необходима для usort
     *
     * @link php.net/manual/ru/function.usort.php
     * @param elemA - первый элемент для сравнения
     * @param elemB - второй элемент для сравнения
     */
    public function compare($elemA, $elemB) {

        if ($this->ascending) {

            $a = $elemA;
            $b = $elemB;

        } else {

            $a = $elemB;
            $b = $elemA;
        }

        if ($a[$this->key] > $b[$this->key]) {

            return 1;
        }
        
        if ($a[$this->key] < $b[$this->key]) {

            return -1;
        }

        return 0;
    }
}
?>

