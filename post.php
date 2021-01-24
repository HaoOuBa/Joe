<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php $this->need('public/include.php'); ?>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/joe.post.css'); ?>">
    <script src="<?php $this->options->themeUrl('assets/js/joe.post&page.js'); ?>"></script>
</head>

<body>
    <div id="Joe">
        <?php $this->need('public/header.php'); ?>

        <!-- Post Bread -->
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

                    <!-- Post Category -->
                    <?php if (sizeof($this->categories) > 0) : ?>
                        <div class="joe_detail__category">
                            <?php foreach (array_slice($this->categories, 0, 5) as $key => $item) : ?>
                                <a href="<?php echo $item['permalink']; ?>" class="item item-<?php echo $key ?>" title="<?php echo $item['name']; ?>"><?php echo $item['name']; ?></a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Post Article -->
                    <?php $this->need('public/article.php'); ?>
                </div>
            </div>
            <?php $this->need('public/aside.php'); ?>
        </div>

        <?php $this->need('public/footer.php'); ?>
    </div>
</body>

</html>