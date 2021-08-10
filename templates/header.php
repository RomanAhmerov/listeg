<?php

// Устанавливаем значения настроек конфигурации
// Проверка на ошибки
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);

// Изменение папки сохранения файлов сессии
ini_set('session.save_path', $_SERVER['DOCUMENT_ROOT'] . '/session');

// Изменение имени сессии, используемое как название куки
ini_set('session.name', 'session_id');

// Изменение времени жизни сессии
ini_set('session.gc_maxlifetime', '1200');


// Подключение файлов
include $_SERVER['DOCUMENT_ROOT'] . '/mainMenu/main_menu.php';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/helperMenu.php';
// Подключенияе файла для создания подключения к БД
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/helperDB.php';


// Авторизация пользователя
// Объявление переменных для дальнейшей работы с ними в разных частях кода
$userLogin = '';
$userPassword = '';
$error = false;
$success = false;


// Создание переменной для подключения к БД (для проверки пока используем пользователя root)
$connectDB = connectDB();

// Функционал авторизации пользователя
if (!empty($_POST)) {
    // Данные переменные предназначены для авторизации пользователей и для устранения SQl иньекций
    $login = mysqli_real_escape_string($connectDB, trim($_POST['login']));
    $pass = mysqli_real_escape_string($connectDB, trim($_POST['password']));;

    // Данные пользователя (ассоциативный массив)
    $user = getUserByLogin($login, $connectDB);

    // Изменение статуса пользователя на (активен)
    mysqli_query($connectDB,
    "UPDATE `users` SET `login` = 'активен' WHERE `email` = '$login'");


    // закрываем соединение с базой
    mysqli_close($connectDB);

    // Присвоение переменным значений при неправильнном вводе логина или пароля
    if (!isset($user)) {
        $user['email'] = '';
        $user['pass'] = '';
    }

    // Проверка совпадения пары логина и пароля пользователя (авторизация пользователя)
    if ($login == $user['email'] && password_verify($pass, $user['pass'])) {
        $success = true;
    } else {
        $userLogin = $_POST['login'];
        $userPassword = $_POST['password'];
        $error = true;
    }
}

// Работа с сессией и куками
// Включение (старт) сессии
session_start();

// Вход в аккаунт
if (isset($_SESSION['login']) && ($success || $_SESSION['login'])) {
    $_SESSION['login'] = true;
} else {
    $_SESSION['login'] = false;
}

// Создание переменной, которая будет использоваться как индификатор пользователя при работе с БД
if (isset($_COOKIE['login']) && $_COOKIE['login']) {
    $email = $_COOKIE['login'];
}

// Выход из аккаунта
if (isset($_GET['login']) && $_GET['login'] == 'no') {

    // Выполняем запрос к базе данных
    $query = "UPDATE `users` SET `login` = 'неактивен' WHERE `email` = '$email'";
    mysqli_query($connectDB, $query);

    // закрываем соединение с базой
    mysqli_close($connectDB);

    // Производим очищение и удаление сессии
    unset($_SESSION['login']);
    session_destroy();
    setcookie('session_id', '', 1);
}

// Создание куки на два месяца
if (isset($_POST['login']) && $success) {
    setcookie('login', $_POST['login'], time() + 2 * 30 * 24 * 60 * 60, '/');
}

// Обновление куки при каждом хите
if (isset($_COOKIE['login'])) {
    setcookie('login', $_COOKIE['login'], time() + 2 * 30 * 24 * 60 * 60, '/');
}
?>


<!-- Верстка шапки -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="/styles.css" rel="stylesheet">
    <title>Project - ведение списков</title>
</head>

<body>
    <div class="header">
        <a href="/">
    	    <div class="logo"><img src="/i/logo.png" width="68" height="23" alt="Project"></div>
        </a>


        <a class="lk
        <?php
        if (isset($_SESSION['login']) && $_SESSION['login']) {
            echo "visible";
        }
        ?>" href="/route/profile">
            Личный кабинет >
        </a>

        <!--<div class="clearfix"></div>-->
    </div>

    <div class="clear">
        <?php showMenu('16px');?>
    </div>
