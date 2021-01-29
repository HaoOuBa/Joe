<?php

/**
 * 直播
 * 
 * @package custom 
 * 
 **/

?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php $this->need('public/include.php'); ?>
    <!-- 直播页面需要用到的CSS及JS -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/joe.live.css'); ?>">
    <script src="<?php $this->options->themeUrl('assets/js/joe.live.js'); ?>"></script>
</head>

<body>
    <div id="Joe">
        <?php $this->need('public/header.php'); ?>
        <div class="joe_container">
            <div class="joe_main">
                <div class="joe_live__type">
                    <div class="joe_live__type-title">直播分类</div>
                    <ul class="joe_live__type-list">
                        <li class="error">正在拼命加载中...</li>
                    </ul>
                </div>
            </div>
            <?php $this->need('public/aside.php'); ?>
        </div>
        <?php $this->need('public/footer.php'); ?>
    </div>
</body>

</html>