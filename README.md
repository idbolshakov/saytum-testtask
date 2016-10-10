konturMatrixCalc
================

v 1.0.0

Реализация тестового задания от Saytum.ru 

Задание
-----------------------

1) Имеется массив с Emails пользователей.
В себя включает: Имя, Email, Возраст, Дата регистрации, Отключение рассылки

2) Нужно создать функцию автоматической рассылки Email писем (с аргументами: содержимое письма, почта пользователя и др. если нужно), при этом:

0. Сделать проверку Email на корректность, в случае некорректого Email отправлять об этом сообщение, сообщив Имя пользователя (в отчет (см. пункт 3.3))

1. Формат письма должен быть в HTML
2. В теле письма должен быть заголовок h1 с приветствием и именем

3) Создать рассылку писем по пользователям из массива $users задействовав нашу функцию.

-1. У рассылки должна быть возможность ограничить рассылку по почтовому домену, например: saytum.ru
0. Рассылка не должна срабатывать позже 22 часов и раньше 10 утра.
1. Пользователь должен быть совершеннолетним
2. Рассылка должна происходить по дате регистрации пользователя, тот кто зарегистрирован раньше должен получить письмо первым.
3. После завершения рассылки отправить отчет о завершении рассылки и количестве отправленных писем и об ошибках (если имеются) на почту yura@saytum.ru


Файловая структура
-----------------------

* userData.php - данные пользователей
* index.php    - скрипт рассылки
* mailsender/  - модуль рассылки
