<?php
    // Подключение массива с даннами каждого элемента меню
    include $_SERVER['DOCUMENT_ROOT'] . '/mainMenu/main_menu.php';
?>

<!-- Фрагмент верстки меню (для шапки и подвала сайта) -->
<ul class="main-menu <?=$position?>" style="font-size: <?=$fontSize?>">
            <?php 
                $headerMenuArray = arraySort($menuArray, 'title', $sort);
                foreach ($headerMenuArray as $itemArray) {
            ?>

            <li><a href="
                <?php
                if (isset($_SESSION['login']) && $_SESSION['login']) {
                    echo $itemArray['path'];
                } else {
                    echo '/';
                }?>" 
                
                <?php if ($_SERVER['REQUEST_URI'] == $itemArray['path']) {?>
                    style="text-decoration: underline"
                <?php }?>>

                <?=cutString($itemArray['title']);?>
            </a></li>

            <?php }?>
</ul>