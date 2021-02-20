<?php


/* 加强后台编辑器功能 */
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('Editor', 'edit');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('Editor', 'edit');

class Editor
{
    public static function edit()
    {
        echo "<link rel='stylesheet' href='" . Helper::options()->themeUrl . '/typecho/editor/joe.editor.css' . "'>";
        echo "<script src='" . Helper::options()->themeUrl . '/typecho/editor/joe.extend.js' . "'></script>";
        echo "<script src='" . Helper::options()->themeUrl . '/typecho/editor/joe.owo.js' . "'></script>";
        echo "<script src='" . Helper::options()->themeUrl . '/typecho/editor/joe.editor.js' . "'></script>";
    }
}


/* 加强评论拦截功能 */
Typecho_Plugin::factory('Widget_Feedback')->comment = array('Intercept', 'message');
class Intercept
{
    public static function message($comment)
    {
        /* 判断评论内容是否包含敏感词 */
        if (Helper::options()->JSensitiveWords) {
            if (_checkSensitiveWords(Helper::options()->JSensitiveWords, $comment['text'])) {
                throw new Typecho_Widget_Exception("评论内容包含敏感词汇！", 403);
            }
        }
        /* 判断评论是否至少包含一个中文 */
        if (Helper::options()->JLimitOneChinese === "on") {
            if (!preg_match("/\{!\{.{0,}/", $comment['text']) && preg_match("/[\x{4e00}-\x{9fa5}]/u", $comment['text']) == 0) {
                throw new Typecho_Widget_Exception("评论至少包含一个中文！", 403);
            }
        }
        return $comment;
    }
}
