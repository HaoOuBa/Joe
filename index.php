<?php

/**
 * “ Eternity is not a distance but a decision - Joe ” <br /> “ 环境要求：PHP 5.4 ~ 7.2 ”
 * @package Typecho Joe Theme
 * @author Joe
 * @link https://ae.js.cn
 */

?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php $this->need('public/include.php'); ?>
</head>

<body>
    <div id="Joe">
        <?php $this->need('public/header.php'); ?>
        <div class="joe_container">
            <div class="joe_main">
                <?php timerStop() ?>
            </div>
            <?php $this->need('public/aside.php'); ?>
        </div>
        <?php $this->need('public/footer.php'); ?>
    </div>
</body>

</html>