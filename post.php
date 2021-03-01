<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php $this->need('public/include.php'); ?>
    <!-- 文章页需要用到的CSS及JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism-tomorrow.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/plyr@3.6.4/dist/plyr.min.css">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/joe.post.css?update=20210301'); ?>">
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.6/dist/clipboard.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/plugin/prism/prism.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/plyr@3.6.4/dist/plyr.min.js"></script>
    <script src="<?php $this->options->themeUrl('assets/js/joe.post&page.js?update=20210301'); ?>"></script>
</head>

<body>
    <div id="Joe">
        <?php $this->need('public/header.php'); ?>

        <div class="joe_container joe_bread">
            <ul class="joe_bread__bread">
                <li class="item">
                    <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                        <path d="M307.867 805.441h408.266V575.792c0-15.31 29.344-22.046 44.654-22.046 15.336 0 27.762 12.426 27.762 27.762v277.544c0 15.335-12.426 27.762-27.762 27.762h-499.59c-15.31 0-27.762-12.427-27.762-27.762V581.507c0-15.31 12.426-27.762 27.762-27.762 15.31 0 46.67 6.71 46.67 22.046v229.65zM205.8 524.758c-10.845 10.845-56.851 3.93-67.696-6.89a27.762 27.762 0 0 1-.025-39.295l353.253-353.227a27.762 27.762 0 0 1 39.296 0L883.93 478.573a27.813 27.813 0 0 1-12.478 46.491c-9.568 2.552-46.236 6.686-53.253-.331L512 218.559 205.8 524.758z" />
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