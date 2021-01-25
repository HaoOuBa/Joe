<?php

/**
 * 友联
 * 
 * @package custom 
 * 
 **/

?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php $this->need('public/include.php'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism-tomorrow.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/prism.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="<?php $this->options->themeUrl('assets/js/joe.post&page.js'); ?>"></script>
</head>

<body>
    <div id="Joe">
        <?php $this->need('public/header.php'); ?>
        <div class="joe_container">
            <div class="joe_main">
                <div class="joe_detail" data-cid="<?php echo $this->cid ?>">
                    <?php $this->need('public/article.php'); ?>

                    <?php
                    $friends = [];
                    $friends_color = [
                        '#0396ff',
                        '#ea5455',
                        '#7367f0',
                        '#28c76f',
                        '#9f44d3',
                        '#6fa3ef',
                        '#bc99c4',
                        '#46c47c',
                        '#f9bb3c',
                        '#e8583d',
                        '#f68e5f',
                        '#67c23a',
                        '#e6a23c',
                        '#f56c6c'
                    ];
                    $friends_text = $this->options->JFriends;
                    if ($friends_text) {
                        $friends_arr = explode("\r\n", $friends_text);
                        if (count($friends_arr) > 0) {
                            for ($i = 0; $i < count($friends_arr); $i++) {
                                $name = explode("||", $friends_arr[$i])[0];
                                $url = explode("||", $friends_arr[$i])[1];
                                $avatar = explode("||", $friends_arr[$i])[2];
                                $desc = explode("||", $friends_arr[$i])[3];
                                $friends[] = array("name" => trim($name), "url" => trim($url), "avatar" => trim($avatar), "desc" => trim($desc));
                            };
                        }
                    }
                    ?>
                    <?php if (sizeof($friends) > 0) : ?>
                        <ul class="joe_detail__friends">
                            <?php foreach ($friends as $item) : ?>
                                <li class="joe_detail__friends-item">
                                    <a class="contain" href="http://ae.js.cn" target="_blank" rel="noopener noreferrer" style="background: <?php echo $friends_color[rand(0, count($friends_color) - 1)] ?>">
                                        <span class="title"><?php echo $item['name']; ?></span>
                                        <div class="content">
                                            <p class="desc"><?php echo $item['desc']; ?></p>
                                            <img class="avatar" src="<?php echo $item['avatar']; ?>" alt="<?php echo $item['name']; ?>" />
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <?php $this->need('public/handle.php'); ?>
                    <?php $this->need('public/copyright.php'); ?>
                </div>
            </div>
            <?php $this->need('public/aside.php'); ?>
        </div>
        <?php $this->need('public/footer.php'); ?>
    </div>
</body>

</html>