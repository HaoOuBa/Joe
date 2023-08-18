<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <?php $this->need('public/include.php'); ?>
  <?php if ($this->options->JPrismTheme) : ?>
    <link href="<?php $this->options->JPrismTheme() ?>" rel="stylesheet">
  <?php else : ?>
    <link href="<?php _getAssets('assets/lib/prism/prism.min.css'); ?>" rel="stylesheet">
  <?php endif; ?>
  <script src="<?php _getAssets('assets/lib/clipboard@2.0.11/clipboard.min.js'); ?>"></script>
  <script src="<?php _getAssets('assets/lib/prism/prism.min.js'); ?>"></script>
  <script src="<?php _getAssets('assets/js/joe.post_page.min.js'); ?>"></script>
</head>

<body>
  <div id="Joe">
    <?php $this->need('public/header.php'); ?>
    <div class="joe_container">
      <div class="joe_main">
        <div class="joe_detail" data-cid="<?php echo $this->cid ?>">
          <?php $this->need('public/batten.php'); ?>
          <?php $this->need('public/article.php'); ?>
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