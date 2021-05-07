<?php

/**
 * 视频
 * 
 * @package custom 
 * 
 **/

?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php $this->need('public/include.php'); ?>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/joe.video.min.css'); ?>">
    <script src="<?php $this->options->themeUrl('assets/js/joe.video.min.js'); ?>"></script>
</head>

<body>
    <div id="Joe">
        <?php $this->need('public/header.php'); ?>
        <div class="joe_container">
            <div class="joe_main">
                <?php if (isset($_GET['vod_id'])) : ?>
                    <div class="joe_video__detail joe_video__contain">
                        <div class="joe_video__contain-title">影片简介</div>
                        <div class="joe_video__detail-info">
                            <p class="error">正在拼命加载中...</p>
                        </div>
                    </div>
                    <div class="joe_video__player joe_video__contain">
                        <div class="joe_video__contain-title">正在播放：</div>
                        <iframe allowfullscreen="true" class="joe_video__player-play" data-player="<?php $this->options->JCustomPlayer ? $this->options->JCustomPlayer() : Helper::options()->themeUrl('library/player.php?url=') ?>"></iframe>
                    </div>
                <?php else : ?>
                    <div class="joe_video__type joe_video__contain">
                        <div class="joe_video__contain-title">视频分类</div>
                        <ul class="joe_video__type-list">
                            <li class="error">正在拼命加载中...</li>
                        </ul>
                    </div>
                    <div class="joe_video__list joe_video__contain">
                        <div class="joe_video__contain-title">视频列表</div>
                        <div class="joe_video__list-search">
                            <input class="input" type="text" placeholder="请输入影片名称...">
                            <button class="button">搜 索</button>
                        </div>
                        <div class="joe_video__list-item"></div>
                    </div>
                    <ul class="joe_video__pagination"></ul>
                <?php endif; ?>
            </div>
            <?php $this->need('public/aside.php'); ?>
        </div>
        <?php $this->need('public/footer.php'); ?>
    </div>
</body>

</html>