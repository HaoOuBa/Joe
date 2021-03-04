<?php

/**
 * 壁纸
 * 
 * @package custom 
 * 
 **/

?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php $this->need('public/include.php'); ?>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/joe.wallpaper.min.css'); ?>">
    <script src="<?php $this->options->themeUrl('assets/js/joe.wallpaper.min.js'); ?>"></script>
</head>

<body>
    <div id="Joe">
        <?php $this->need('public/header.php'); ?>
        <div class="joe_container">
            <div class="joe_main">
                <div class="joe_wallpaper__type">
                    <div class="joe_wallpaper__type-title">壁纸分类</div>
                    <ul class="joe_wallpaper__type-list">
                        <li class="error">正在拼命加载中...</li>
                    </ul>
                </div>
                <div class="joe_wallpaper__list"></div>
                <ul class="joe_wallpaper__pagination"></ul>
            </div>
            <?php $this->need('public/aside.php'); ?>
        </div>
        <?php $this->need('public/footer.php'); ?>
    </div>
</body>

</html>