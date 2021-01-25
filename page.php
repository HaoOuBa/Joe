<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php $this->need('public/include.php'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism-tomorrow.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/joe.post.css'); ?>">
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