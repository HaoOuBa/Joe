<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php $this->need('public/include.php'); ?>
    <!-- 文章页需要用到的CSS及JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism-tomorrow.css">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/joe.post.css'); ?>">
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.6/dist/clipboard.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/plugin/prism/prism.js"></script>
    <script src="<?php $this->options->themeUrl('assets/js/joe.post&page.js'); ?>"></script>
</head>

<body>
    <div id="Joe">
        <?php $this->need('public/header.php'); ?>

        <div class="joe_container joe_bread">
            <ul class="joe_bread__bread">
                <li class="item">
                    <svg class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M 307.867 805.441 h 408.266 v -229.649 c 0 -15.31 29.3441 -22.0464 44.6541 -22.0464 c 15.3355 0 27.7621 12.4266 27.7621 27.7621 v 277.544 c 0 15.3355 -12.4266 27.7621 -27.7621 27.7621 H 261.197 c -15.31 0 -27.7621 -12.4266 -27.7621 -27.7621 V 581.507 c 0 -15.31 12.4266 -27.7621 27.7621 -27.7621 c 15.31 0 46.67 6.71087 46.67 22.0464 v 229.649 Z M 205.8 524.758 c -10.8445 10.8445 -56.8511 3.92956 -67.6957 -6.88949 a 27.7621 27.7621 0 0 1 -0.0255172 -39.2956 L 491.332 125.346 a 27.7621 27.7621 0 0 1 39.2956 0 L 883.931 478.573 a 27.8132 27.8132 0 0 1 -12.4777 46.4914 c -9.56878 2.55167 -46.2362 6.68536 -53.2532 -0.331716 L 512 218.559 L 205.8 524.758 Z" p-id="9359"></path>
                    </svg>
                    <a href="<?php $this->options->siteUrl(); ?>" class="link" title="首页">首页</a>
                </li>
                <li class="line">/</li>
                <?php if (sizeof($this->categories) > 0) : ?>
                    <li class="item">
                        <a class="link" href="<?php echo $this->categories[0]['permalink']; ?>" title="<?php echo $this->categories[0]['name']; ?>"><?php echo $this->categories[0]['name']; ?></a>
                    </li>
                    <li class="line">/</li>
                <?php endif; ?>
                <li class="item">正文</li>
            </ul>
        </div>

        <div class="joe_container">
            <div class="joe_main joe_post">
                <div class="joe_detail" data-cid="<?php echo $this->cid ?>">
                    <?php $this->need('public/article.php'); ?>
                    <?php $this->need('public/handle.php'); ?>
                    <?php $this->need('public/copyright.php'); ?>
                </div>
                <ul class="joe_post__pagination">
                    <?php $this->theNext('<li class="joe_post__pagination-item prev">%s</li>', '', ['title' => '上一篇']); ?>
                    <?php $this->thePrev('<li class="joe_post__pagination-item next">%s</li>', '', ['title' => '下一篇']); ?>
                </ul>
                <?php $this->need('public/comment.php'); ?>
            </div>
            <?php $this->need('public/aside.php'); ?>
        </div>

        <?php $this->need('public/footer.php'); ?>
    </div>
</body>

</html>