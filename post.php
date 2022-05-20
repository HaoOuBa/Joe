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
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/joe.post.min.css'); ?>">
    <script src="<?php $this->options->themeUrl('assets/js/joe.post_page.min.js'); ?>"></script>
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
                    <?php $this->need('public/batten.php'); ?>
                    <?php if ($this->options->JOverdue && $this->options->JOverdue !== 'off' && floor((time() - ($this->modified)) / 86400) > $this->options->JOverdue) : ?>
                        <div class="joe_detail__overdue">
                            <div class="joe_detail__overdue-wrapper">
                                <div class="title">
                                    <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                                        <path d="M0 512c0 282.778 229.222 512 512 512s512-229.222 512-512S794.778 0 512 0 0 229.222 0 512z" fill="#FF8C00" fill-opacity=".51" />
                                        <path d="M462.473 756.326a45.039 45.039 0 0 0 41.762 28.74 45.039 45.039 0 0 0 41.779-28.74h-83.541zm119.09 0c-7.73 35.909-39.372 62.874-77.311 62.874-37.957 0-69.598-26.965-77.33-62.874H292.404a51.2 51.2 0 0 1-42.564-79.65l23.723-35.498V484.88a234.394 234.394 0 0 1 167.492-224.614c3.635-31.95 30.498-56.815 63.18-56.815 31.984 0 58.386 23.808 62.925 54.733A234.394 234.394 0 0 1 742.093 484.88v155.512l24.15 36.454a51.2 51.2 0 0 1-42.668 79.48H581.564zm-47.957-485.922c.069-.904.12-1.809.12-2.73 0-16.657-13.26-30.089-29.491-30.089-16.214 0-29.474 13.432-29.474 30.089 0 1.245.085 2.491.221 3.703l1.81 15.155-14.849 3.499a200.226 200.226 0 0 0-154.265 194.85v166.656l-29.457 44.1a17.067 17.067 0 0 0 14.182 26.556h431.155a17.067 17.067 0 0 0 14.234-26.487l-29.815-45.04V484.882A200.21 200.21 0 0 0 547.26 288.614l-14.985-2.986 1.331-15.224z" fill="#FFF" />
                                        <path d="M612.864 322.697c0 30.378 24.303 55.022 54.272 55.022 30.003 0 54.323-24.644 54.323-55.022 0-30.38-24.32-55.023-54.306-55.023s-54.306 24.644-54.306 55.023z" fill="#FA5252" />
                                    </svg>
                                    <span class="text">温馨提示：</span>
                                </div>
                                <div class="content">
                                    本文最后更新于<?php echo date('Y年m月d日', $this->modified); ?>，已超过<?php echo floor((time() - ($this->modified)) / 86400); ?>天没有更新，若内容或图片失效，请留言反馈。
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php $this->need('public/article.php'); ?>
                    <?php $this->need('public/handle.php'); ?>
                    <?php $this->need('public/operate.php'); ?>
                    <?php $this->need('public/copyright.php'); ?>
                    <?php $this->need('public/related.php'); ?>
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