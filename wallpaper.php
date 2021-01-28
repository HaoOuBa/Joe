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
    <!-- 壁纸页面需要用到的CSS及JS -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/joe.wallpaper.css'); ?>">
    <script src="<?php $this->options->themeUrl('assets/js/joe.wallpaper.js'); ?>"></script>
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
                <div class="joe_wallpaper__loading">
                    <svg width="57" height="57" viewBox="0 0 57 57" xmlns="http://www.w3.org/2000/svg" stroke="#409eff">
                        <g fill="none" fill-rule="evenodd">
                            <g transform="translate(1 1)" stroke-width="2">
                                <circle cx="5" cy="50" r="5">
                                    <animate attributeName="cy" begin="0s" dur="2.2s" values="50;5;50;50" calcMode="linear" repeatCount="indefinite" />
                                    <animate attributeName="cx" begin="0s" dur="2.2s" values="5;27;49;5" calcMode="linear" repeatCount="indefinite" />
                                </circle>
                                <circle cx="27" cy="5" r="5">
                                    <animate attributeName="cy" begin="0s" dur="2.2s" from="5" to="5" values="5;50;50;5" calcMode="linear" repeatCount="indefinite" />
                                    <animate attributeName="cx" begin="0s" dur="2.2s" from="27" to="27" values="27;49;5;27" calcMode="linear" repeatCount="indefinite" />
                                </circle>
                                <circle cx="49" cy="50" r="5">
                                    <animate attributeName="cy" begin="0s" dur="2.2s" values="50;50;5;50" calcMode="linear" repeatCount="indefinite" />
                                    <animate attributeName="cx" from="49" to="49" begin="0s" dur="2.2s" values="49;5;27;49" calcMode="linear" repeatCount="indefinite" />
                                </circle>
                            </g>
                        </g>
                    </svg>
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