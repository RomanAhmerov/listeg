<?php  
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>

    <!-- Верстка основной части сайта -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
    	<tr>
        	<td class="left-collum-index">
				<h1>
                    <?php 
                        foreach ($menuArray as $item) {
                            if (isCurrentUrl() == $item['path']) {
                                echo $item['title'];
                            }
                        }
                    ?>
                </h1>
                
				<p>Вести свои личные списки, например покупки в магазине, цели, задачи и многое другое. Делится списками с друзьями и просматривать списки друзей.</p>
				
			</td>
            <td class="right-collum-index">
				
				<div class="project-folders-menu">
					<ul class="project-folders-v">
    					<li class="project-folders-v-active"><a href=
                        <?php 
                            if (isset($_SESSION['login']) && $_SESSION['login']) {
                                echo "/?login=no";
                            } else {
                                echo "?login=yes";
                            }
                        ?>>
                        
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
                
                <?php if (isset($_GET['login'])) :?>
                    <?php if ($_GET['login'] == 'yes') {?>
                        <div class="index-auth">
                            <?php 
                                if ($success) {
                                    include $_SERVER['DOCUMENT_ROOT'] . '/include/success.php';
                                }
                            ?>

                            <form action="?login=yes" method="POST" class=
                                <?php 
                                    if ($success) {
                                        echo 'wrapper-invisible';
                                    }
                                ?>>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr class=
                                    <?php
                                        if (isset($_COOKIE['login'])) {
                                            echo "wrapper-invisible";
                                        }
                                    ?>>
                                        <td class="iat">
                                            <label for="login_id">Ваш e-mail:</label>
                                            <input id="login_id" size="30" name="login" value=
                                            <?php 
                                                if (isset($_COOKIE['login'])) {
                                                    echo $_COOKIE['login'];
                                                } else {
                                                    echo $userLogin;
                                                }
                                            ?>>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="iat">
                                            <label for="password_id">Ваш пароль:</label>
                                            <input id="password_id" size="30" name="password" type="password" value=<?=$userPassword?>>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <input type="submit" value="Войти">

                                        <?php if ($error) {?>
                                            <span style="margin-left: 10px; color: red">Неверный логин или пароль</span>
                                        <?php }?>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    <?php }?>
                <?php endif?>
			</td>
        </tr>
    </table>

<?php  
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
?>
    
   