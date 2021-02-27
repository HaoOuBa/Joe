<?php $this->need('public/config.php'); ?>
<meta charset="utf-8" />
<meta name="renderer" content="webkit" />
<meta name="format-detection" content="email=no" />
<meta name="format-detection" content="telephone=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
<meta itemprop="image" content="<?php $this->options->JShare_QQ_Image() ?>" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, shrink-to-fit=no, viewport-fit=cover">
<link rel="shortcut icon" href="<?php $this->options->JFavicon() ?>" />
<title><?php $this->archiveTitle(array('category' => '分类 %s 下的文章', 'search' => '包含关键字 %s 的文章', 'tag' => '标签 %s 下的文章', 'author' => '%s 发布的文章'), '', ' - '); ?><?php $this->options->title(); ?></title>
<?php if ($this->is('single')) : ?>
	<meta name="keywords" content="<?php echo $this->fields->keywords ? $this->fields->keywords : htmlspecialchars($this->_keywords); ?>" />
	<meta name="description" content="<?php echo $this->fields->description ? $this->fields->description : htmlspecialchars($this->_description); ?>" />
	<?php $this->header('keywords=&description='); ?>
<?php else : ?>
	<?php $this->header(); ?>
<?php endif; ?>
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/joe.mode.css?update=20210222'); ?>">
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/joe.normalize.css'); ?>">
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/joe.global.css'); ?>">
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/joe.responsive.css'); ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/plugin/qmsg/qmsg.css" />
<?php if ($this->options->JAside && in_array('weather', $this->options->JAside) && $this->options->JAside_Weather_Key) : ?>
	<link rel="stylesheet" href="https://apip.weatherdt.com/standard/static/css/weather-standard.css">
<?php endif; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@3.7.2/animate.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/plyr@3.6.4/dist/plyr.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/plugin/scroll/joe.scroll.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lazysizes@5.3.0/lazysizes.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/plugin/sketchpad/joe.sketchpad.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/plugin/qmsg/qmsg.js"></script>
<script src="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/js/joe.extend.js"></script>
<script src="https://cdn.jsdelivr.net/npm/plyr@3.6.4/dist/plyr.min.js"></script>
<script src="<?php $this->options->themeUrl('assets/js/joe.global.js?update=20210224'); ?>"></script>
<script async src="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/plugin/smooth/joe.smooth.js"></script>
<?php if ($this->options->JCursorEffects && $this->options->JCursorEffects !== 'off') : ?>
	<script async src="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/cursor/<?php $this->options->JCursorEffects() ?>"></script>
<?php endif; ?>
<?php $this->options->JCustomHeadEnd() ?>