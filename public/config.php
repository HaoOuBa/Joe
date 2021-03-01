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
        MOTTO: '<?php _getAsideAuthorMotto() ?>'
    }

    function detectIE() {
        var n = window.navigator.userAgent,
            e = n.indexOf("MSIE ");
        if (e > 0) {
            return parseInt(n.substring(e + 5, n.indexOf(".", e)), 10)
        }
        if (n.indexOf("Trident/") > 0) {
            var r = n.indexOf("rv:");
            return parseInt(n.substring(r + 3, n.indexOf(".", r)), 10)
        }
        var i = n.indexOf("Edge/");
        return i > 0 && parseInt(n.substring(i + 5, n.indexOf(".", i)), 10)
    };
    detectIE() && (alert('当前站点不支持IE浏览器或您开启了兼容模式，请使用其他浏览器访问或关闭兼容模式。'), (location.href = 'https://www.baidu.com'))
</script>
<?php
$format = null;
if (strpos($this->options->JCustomFont, 'woff2') !== false) {
    $format = 'woff2';
} elseif (strpos($this->options->JCustomFont, 'woff') !== false) {
    $format = 'woff';
} elseif (strpos($this->options->JCustomFont, 'ttf') !== false) {
    $format = 'truetype';
} elseif (strpos($this->options->JCustomFont, 'eot') !== false) {
    $format = 'embedded-opentype';
} elseif (strpos($this->options->JCustomFont, 'svg') !== false) {
    $format = 'svg';
}
?>
<style>
    @font-face {
        font-family: 'Joe Font';
        font-weight: 400;
        font-style: normal;
        font-display: swap;
        src: url('<?php $this->options->JCustomFont() ?>');
        <?php if ($format) echo "src: url('{$this->options->JCustomFont}') fromat('{$format}');" ?>
    }

    body {
        <?php if ($this->options->JCustomFont) : ?>font-family: 'Joe Font';
        <?php else : ?>font-family: 'Helvetica Neue', Helvetica, 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', '微软雅黑', Arial, sans-serif;
        <?php endif; ?>
    }

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