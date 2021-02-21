<script>
	localStorage.getItem("data-night") && document.querySelector("html").setAttribute("data-night", "night");
	window.Joe = {
		LIVE2D: '<?php $this->options->JLive2d() ?>',
		BASE_API: '<?php echo $this->options->rewrite == 0 ? '/index.php/joe/api' : '/joe/api' ?>',
		DYNAMIC_BACKGROUND: '<?php $this->options->JDynamic_Background() ?>',
		WALLPAPER_BACKGROUND_PC: '<?php $this->options->JWallpaper_Background_PC() ?>',
		IS_MOBILE: /windows phone|iphone|android/gi.test(window.navigator.userAgent),
		BAIDU_PUSH: <?php echo $this->options->JBaiduToken ? 'true' : 'false' ?>,
		DOCUMENT_TITLE: '<?php $this->options->JDocumentTitle() ?>',
		LAZY_LOAD: '<?php _getLazyload() ?>',
		BIRTHDAY: '<?php $this->options->JBirthDay() ?>',
	}
	function detectIE(){var n=window.navigator.userAgent,e=n.indexOf("MSIE ");if(e>0){return parseInt(n.substring(e+5,n.indexOf(".",e)),10)}if(n.indexOf("Trident/")>0){var r=n.indexOf("rv:");return parseInt(n.substring(r+3,n.indexOf(".",r)),10)}var i=n.indexOf("Edge/");return i>0&&parseInt(n.substring(i+5,n.indexOf(".",i)),10)};
  detectIE() && (alert('当前站点不支持IE浏览器或您开启了兼容模式，请使用其他浏览器访问或关闭兼容模式。'), (location.href = 'https://www.baidu.com'))
</script>
<style>
	body::before {
		background: <?php if (_isMobile()) {
						echo $this->options->JWallpaper_Background_WAP ? "url(" . $this->options->JWallpaper_Background_WAP . ")" : "#f5f5f5";
					} else {
						echo $this->options->JWallpaper_Background_PC ? "url(" . $this->options->JWallpaper_Background_PC . ")" : "#f5f5f5";
					} ?>;
		background-position: center 0;
		background-repeat: no-repeat;
		background-size: cover;
	}
	<?php $this->options->JCustomCSS() ?>
</style>
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
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/joe.mode.css'); ?>">
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
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/plugin/scroll/joe.scroll.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lazysizes@5.3.0/lazysizes.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/plugin/sketchpad/joe.sketchpad.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/plugin/qmsg/qmsg.js"></script>
<script src="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/js/joe.extend.js"></script>
<script src="<?php $this->options->themeUrl('assets/js/joe.global.js'); ?>"></script>
<script async src="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/plugin/smooth/joe.smooth.js"></script>
<?php if ($this->options->JCursorEffects && $this->options->JCursorEffects !== 'off') : ?>
	<script async src="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/cursor/<?php $this->options->JCursorEffects() ?>"></script>
<?php endif; ?>