<meta charset="utf-8" />
<meta name="renderer" content="webkit" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, shrink-to-fit=no, viewport-fit=cover">
<link rel="shortcut icon" href="<?php $this->options->JFavicon() ?>" />
<?php $this->header(); ?>
<title><?php $this->archiveTitle(array('category' => '分类 %s 下的文章', 'search' => '包含关键字 %s 的文章', 'tag' => '标签 %s 下的文章', 'author' => '%s 发布的文章'), '', ' - '); ?><?php $this->options->title(); ?></title>
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/joe.normalize.css'); ?>">
<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/joe.global.css'); ?>">
<link rel="stylesheet" href="https://apip.weatherdt.com/standard/static/css/weather-standard.css">
<script>
    window.Joe = {
        LIVE2D: '<?php $this->options->JLive2d() ?>', // Live2d
        BASE_API: '/index.php/joe/api', // 请求基准URL
        DYNAMIC_BACKGROUND: '<?php $this->options->JDynamic_Background() ?>', // 动态背景
        WALLPAPER_BACKGROUND_PC: '<?php $this->options->JWallpaper_Background_PC() ?>', // 是否填写了PC端静态壁纸
        IS_MOBILE: /windows phone|iphone|android/gi.test(window.navigator.userAgent), // 是否是手机端
        encryption: str => window.btoa(unescape(encodeURIComponent(str))), // 加密字符串
        decrypt: str => decodeURIComponent(escape(window.atob(str))), // 解密字符串
    }
</script>
<style>
    body::before {
        background: <?php
                    if (_isMobile()) {
                        echo $this->options->JWallpaper_Background_WAP ? "url(" . $this->options->JWallpaper_Background_WAP . ")" : "#f5f5f5";
                    } else {
                        echo $this->options->JWallpaper_Background_PC ? "url(" . $this->options->JWallpaper_Background_PC . ")" : "#f5f5f5";
                    }
                    ?>;
        background-position: center 0;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/js/joe.scroll.js"></script>
<script src="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/js/joe.lazyload.js"></script>
<script src="<?php $this->options->themeUrl('assets/js/joe.global.js'); ?>"></script>
<script async src="https://apip.weatherdt.com/standard/static/js/weather-standard.js?v=2.0"></script>
<script async src="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/js/joe.smooth.js"></script>