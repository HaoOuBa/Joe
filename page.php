<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php $this->need('public/include.php'); ?>
    <script src="<?php $this->options->themeUrl('assets/js/joe.post&page.js'); ?>"></script>
</head>

<body>
    <div id="Joe">
        <?php $this->need('public/header.php'); ?>

        <div class="joe_container">
            <div class="joe_main">
                <div class="joe_detail" data-cid="<?php echo $this->cid ?>">
                    <!-- Page Article -->
                    <?php $this->need('public/article.php'); ?>
                </div>
            </div>
            <?php $this->need('public/aside.php'); ?>
        </div>

        <?php $this->need('public/footer.php'); ?>
    </div>
</body>

</html>