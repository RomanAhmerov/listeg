<?php 

/**
 * Данная функция делает сортировку массива по возрастанию или по убыванию
 * @return array
 */
function arraySort(array $array, $key, $sort = 'SORT_ASC') : array {
    $newArray = [];
    $indexItemArray = [];

    foreach ($array as $item) {
        $indexItemArray[] = $item[$key];
    }
 
    if ($sort == 'SORT_DESC') {
        arsort($indexItemArray);
    } else {
        asort($indexItemArray);
    }

    foreach ($indexItemArray as $index => $value) {
        $newArray[] = $array[$index];
    }

    return $newArray;
}

/**
 * Данная функция обрезает строку, если та имеет более 15 символов и добавляет значение переменной $appends в конец
 * @return string
 */
function cutString($line, $length = 15, $appends = '...') : string {
    return mb_strimwidth($line, 0, $length, $appends);
}

/**
 * Данная функция выводит меню
 */
function showMenu($fontSize, $sort = 'SORT_ASC', $position ='') {
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/menu.php';
}

/**
 * Данная функция выводит URL открытой в данной момент страницы (без GET параметров)
 * @return string
 */
function isCurrentUrl() : string {
    return parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
}




