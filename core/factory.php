<?php

/* 加强评论拦截功能 */
Typecho_Plugin::factory('Widget_Feedback')->comment = array('Intercept', 'message');
class Intercept
{
    public static function message($comment)
    {
        /* 校验验证码是否正确 */
        $num1 = (int)Typecho_Request::getInstance()->num1;
        $num2 = (int)Typecho_Request::getInstance()->num2;
        $sum = (int)Typecho_Request::getInstance()->sum;
        if ($num1 + $num2 !== $sum) throw new Typecho_Widget_Exception('计算结果有误，请检查！', 403);

        /* 用户输入内容画图模式 */
        if (preg_match('/\{!\{(.*)\}!\}/', $comment['text'], $matches)) {
            /* 如果判断是否有双引号，如果有双引号，则禁止评论 */
            if (strpos($matches[1], '"') !== false || _checkXSS($matches[1])) {
                $comment['status'] = 'waiting';
            }
            /* 普通评论 */
        } else {
            /* 判断用户输入是否大于字符 */
            if (Helper::options()->JTextLimit && strlen($comment['text']) > Helper::options()->JTextLimit) {
                $comment['status'] = 'waiting';
            } else {
                /* 判断评论内容是否包含敏感词 */
                if (Helper::options()->JSensitiveWords) {
                    if (_checkSensitiveWords(Helper::options()->JSensitiveWords, $comment['text'])) {
                        $comment['status'] = 'waiting';
                    }
                }
                /* 判断评论是否至少包含一个中文 */
                if (Helper::options()->JLimitOneChinese === "on") {
                    if (preg_match("/[\x{4e00}-\x{9fa5}]/u", $comment['text']) == 0) {
                        $comment['status'] = 'waiting';
                    }
                }
            }
        }
        Typecho_Cookie::delete('__typecho_remember_text');
        return $comment;
    }
}

/* 加强后台编辑器功能 */
if (Helper::options()->JEditor !== 'off') {
    Typecho_Plugin::factory('admin/write-post.php')->richEditor  = array('Editor', 'Edit');
    Typecho_Plugin::factory('admin/write-page.php')->richEditor  = array('Editor', 'Edit');
}

class Editor
{
    public static function Edit()
    {
?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aplayer@1.10.1/dist/APlayer.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism-tomorrow.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php Helper::options()->themeUrl('typecho/write/css/joe.write.min.css?v=20210506') ?>">
        <script>
            window.JoeConfig = {
                uploadAPI: '<?php Helper::security()->index('/action/upload'); ?>',
                emojiAPI: '<?php Helper::options()->themeUrl('typecho/write/json/emoji.json') ?>',
                expressionAPI: '<?php Helper::options()->themeUrl('typecho/write/json/expression.json') ?>',
                characterAPI: '<?php Helper::options()->themeUrl('typecho/write/json/character.json') ?>',
                playerAPI: '<?php Helper::options()->JCustomPlayer ? Helper::options()->JCustomPlayer() : Helper::options()->themeUrl('library/player.php?url=') ?>',
                autoSave: <?php Helper::options()->autoSave(); ?>,
                themeURL: '<?php Helper::options()->themeUrl(); ?>',
                canPreview: false
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/aplayer@1.10.1/dist/APlayer.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/typecho-joe-next@6.2.4/plugin/prism/prism.min.js"></script>
        <script src="<?php Helper::options()->themeUrl('typecho/write/js/joe.parse.min.js') ?>"></script>
        <script src="<?php Helper::options()->themeUrl('typecho/write/js/joe.write.chunk.js?v=20210507') ?>"></script>
        <script src="<?php Helper::options()->themeUrl('assets/js/joe.short.min.js') ?>"></script>
<?php
    }
}
