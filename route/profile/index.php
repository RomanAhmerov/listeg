<?php
    // Подключение файла
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';

    // Проверка доступа к странице
    if (isset($_SESSION['login']) && !$_SESSION['login']) {
        include $_SERVER['DOCUMENT_ROOT'] . '/templates/accessError.php';
        exit();
    }

    // Работа с БД
    // Подключение к БД происходит в файле header.php
    // Информация о пользователе без групп (ассоциативный массив)
    $profInfo = getProfInfoByEmail($email, $connectDB);

    // Результат запроса (в каких группах состоит пользователь (не ассоциативный массив)
    $resultProfInfoGroup = getProfInfoByGroup($email, $connectDB);

    // Закрываем соединение
    mysqli_close($connectDB);
?>


    <!-- Верстка основной части сайта -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
    	<tr>
        	<td class="left-collum-index">
				<h1>Ваш профиль</h1>

				<ul>
                    <li>
                        <span class="title-item_profile">Статус:</span>
                        <span class="green"><?=$profInfo['login']?></span>
                    </li>

                    <li>
                        <span class="title-item_profile">Имя пользователя:</span>
                        <?=$profInfo['name']?>
                    </li>

                    <li>
                        <span class="title-item_profile">Email:</span>
                        <?=$profInfo['email']?>
                    </li>

                    <li>
                        <span class="title-item_profile">Телефон:</span>
                        <?=$profInfo['phone']?>
                    </li>

                    <li>
                        <span class="title-item_profile">Согласие на уведомление:</span>
                        <?=$profInfo['flag_notification']?>
                    </li>

                    <li>
                        <span class="title-item_profile">Количество групп в которых состоит пользователь:</span>
                        <?=$profInfo['count_groups']?>
                    </li>

                    <li>
                        <span class="title-item_profile">Группы пользователя:</span>
                            <ol>
                                <?php while ($profInfoGroupRow = mysqli_fetch_assoc($resultProfInfoGroup)){?>
                                    <li class="li-with-style">
                                        <p class="title-group"><?=$profInfoGroupRow['name']?></p>
                                        <span class="description-group"><?=$profInfoGroupRow['description']?></span>
                                    </li>
                                <?php }?>
                            </ol>
                    </li>
                </ul>
			</td>
            <td class="right-collum-index">
				
				<div class="project-folders-menu">
					<ul class="project-folders-v">
                        <li class="project-folders-v-active"><a href="
                        <?php 
                            if (isset($_SESSION['login']) && $_SESSION['login']) {
                                echo "/?login=no";
                            } else {
                                echo "?login=yes";
                            }
                        ?>">
                            <?php
                                if (isset($_SESSION['login']) && $_SESSION['login']) {
                                    echo 'Выйти';
                                } else {
                                    echo 'Авторизация';
                                }
                            ?>
                        </a></li>
    					<li><a href="#">Регистрация</a></li>
    					<li><a href="#">Забыли пароль?</a></li>
					</ul>
				    <div class="clearfix"></div>
				</div>
			</td>
        </tr>
    </table>

<?php  
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
?>
    
   