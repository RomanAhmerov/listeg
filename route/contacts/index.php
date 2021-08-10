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
    
   