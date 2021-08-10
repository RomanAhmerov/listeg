<?php
 /**
 * Данная функция нужна для создания ленивого подключения к БД MySQL (для проверки пока используем пользователя root)
 */
 function connectDB($hostname = 'localhost', $username = 'root', $password = 'root', $db = 'task_manager_db') {
    static $connection = null;

    if ($connection == null) {
        $connection = mysqli_connect($hostname, $username, $password, $db);
    }

    return $connection;
 }

/**
 * Данная функция возвращает данные пользователя (ассоциативный массив) по его логину
 */
function getUserByLogin($login, $db) {
    // Делаем экранирование данных
    $loginEscaped = mysqli_real_escape_string($db, $login);

    // Выполняем запрос к базе данных
    $query = "SELECT * FROM `users` WHERE `email` = '$loginEscaped'";

    $result = mysqli_query($db, $query);

    // Приводим в нормальный вид массив данных и возвращаем его
    return mysqli_fetch_assoc($result);
}

/**
 * Данная функция возвращает данные пользователя (ассоциативный массив) по его Email без названия и описания групп
 */
function getProfInfoByEmail($email, $db) {
    // Делаем экранирование данных
    $emailEscaped = mysqli_real_escape_string($db, $email);

    $queryProfInfo = "
        SELECT `login`, `name`, `email`, `phone`, `flag_notification`, count(*) as `count_groups`
        FROM `users` AS `u`
        LEFT JOIN `group_user` AS `g_u` ON u.id = g_u.user_id
        WHERE `u`.`email` = '$emailEscaped'
        GROUP BY `id`
    ";

    // Выполнение запроса
    $resultProfInfo = mysqli_query($db, $queryProfInfo);

    // Возврат ассоциативного массива
    return mysqli_fetch_assoc($resultProfInfo);
}

/**
 * Данная функция возвращает результат запроса (не ассоциативный массив) (в каких группах состоит пользователь) по его Email
 */
function getProfInfoByGroup($email, $db) {
    // Делаем экранирование данных
    $emailEscaped = mysqli_real_escape_string($db, $email);

    $queryProfInfoGroup = "
        SELECT `g`.`name`, `g`.`description`
        FROM `users` AS `u`
        LEFT JOIN `group_user` AS `g_u` ON `u`.`id` = `g_u`.`user_id`
        LEFT JOIN `groups` AS `g` ON  `g_u`.`group_id` = `g`.`id`
        WHERE `u`.`email` = '$emailEscaped'
    ";

    // Выполнение и возврат результата запроса
    return mysqli_query($db, $queryProfInfoGroup);
}