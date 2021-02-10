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
                <!-- 播放页 -->
                <?php if (isset($_GET['profileRoom'])) : ?>
                    <div class="joe_live__contain joe_live__play">
                        <div class="joe_live__contain-title joe_live__play-title">正在播放：<?php echo $_GET['title'] ?></div>
                        <?php ini_set('user_agent', 'Mozilla/5.0 (Linux; U; Android 2.3.7; en-us; Nexus One Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1'); ?>
                        <iframe class="joe_live__play-player lazyload" data-src="<?php echo 'https://liveshare.huya.com/iframe/' . $_GET['profileRoom']  ?>"></iframe>
                    </div>
                <?php else : ?>
                    <!-- 列表页 -->
                    <div class="joe_live__type joe_live__contain">
                        <div class="joe_live__type-title joe_live__contain-title">
                            <div class="text">直播分类</div>
                            <svg class="icon" viewBox="0 0 1229 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="15" height="15">
                                <path d="M292.64896 475.648a51.4048 51.4048 0 1 1-72.704 72.704l-204.8-204.8a51.2 51.2 0 0 1 0-72.704l204.8-204.8a51.4048 51.4048 0 1 1 72.704 72.704L123.68896 307.2l168.96 168.448zM51.49696 358.4a51.2 51.2 0 0 1 0-102.4h614.4a51.2 51.2 0 0 1 0 102.4h-614.4z m885.248 189.952a51.4048 51.4048 0 1 1 72.704-72.704l204.8 204.8a51.2 51.2 0 0 1 0 72.704l-204.8 204.8a51.4048 51.4048 0 1 1-72.704-72.704L1105.70496 716.8l-168.96-168.448zM1177.89696 665.6a51.2 51.2 0 1 1 0 102.4h-614.4a51.2 51.2 0 0 1 0-102.4h614.4z" p-id="12828"></path>
                            </svg>
                        </div>
                        <div class="joe_live__type-list">
                            <li class="error">正在拼命加载中...</li>
                        </div>
                    </div>
                    <div class="joe_live__list"></div>
                    <ul class="joe_live__pagination"></ul>
                <?php endif; ?>
            </div>
            <?php $this->need('public/aside.php'); ?>
        </div>
        <?php $this->need('public/footer.php'); ?>
    </div>
</body>

</html>