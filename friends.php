<?php

/**
 * 友链
 * 
 * @package custom 
 * 
 **/

?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php $this->need('public/include.php'); ?>
    <?php if ($this->options->JPrismTheme) : ?>
        <link rel="stylesheet" href="<?php $this->options->JPrismTheme() ?>">
    <?php else : ?>
        <link rel="stylesheet" href="https://fastly.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.min.css">
    <?php endif; ?>
    <script src="https://fastly.jsdelivr.net/npm/clipboard@2.0.6/dist/clipboard.min.js"></script>
    <script src="https://fastly.jsdelivr.net/npm/typecho-joe-next@6.2.4/plugin/prism/prism.min.js"></script>
    <script src="<?php $this->options->themeUrl('assets/js/joe.post_page.min.js'); ?>"></script>
</head>

<body>
    <div id="Joe">
        <?php $this->need('public/header.php'); ?>
        <div class="joe_container">
            <div class="joe_main">
                <div class="joe_detail" data-cid="<?php echo $this->cid ?>">
                    <?php $this->need('public/batten.php'); ?>
                    <?php $this->need('public/article.php'); ?>

                    <?php
                    $friends = [];
                    $friends_color = [
                        '#F8D800',
                        '#0396FF',
                        '#EA5455',
                        '#7367F0',
                        '#32CCBC',
                        '#F6416C',
                        '#28C76F',
                        '#9F44D3',
                        '#F55555',
                        '#736EFE',
                        '#E96D71',
                        '#DE4313',
                        '#D939CD',
                        '#4C83FF',
                        '#F072B6',
                        '#C346C2',
                        '#5961F9',
                        '#FD6585',
                        '#465EFB',
                        '#FFC600',
                        '#FA742B',
                        '#5151E5',
                        '#BB4E75',
                        '#FF52E5',
                        '#49C628',
                        '#00EAFF',
                        '#F067B4',
                        '#F067B4',
                        '#ff9a9e',
                        '#00f2fe',
                        '#4facfe',
                        '#f093fb',
                        '#6fa3ef',
                        '#bc99c4',
                        '#46c47c',
                        '#f9bb3c',
                        '#e8583d',
                        '#f68e5f',
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
                                    <a class="contain" href="<?php echo $item['url']; ?>" target="_blank" rel="noopener noreferrer" style="background: <?php echo $friends_color[mt_rand(0, count($friends_color) - 1)] ?>">
                                        <span class="title"><?php echo $item['name']; ?></span>
                                        <div class="content">
                                            <div class="desc"><?php echo $item['desc']; ?></div>
                                            <img width="40" height="40" class="avatar lazyload" src="<?php _getAvatarLazyload(); ?>" data-src="<?php echo $item['avatar']; ?>" alt="<?php echo $item['name']; ?>" />
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <?php $this->need('public/handle.php'); ?>
                    <?php $this->need('public/copyright.php'); ?>
                </div>
                <?php $this->need('public/comment.php'); ?>
            </div>
            <?php $this->need('public/aside.php'); ?>
        </div>
        <?php $this->need('public/footer.php'); ?>
    </div>
</body>

</html>