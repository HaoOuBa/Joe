<?php

Typecho_Plugin::factory('admin/write-post.php')->bottom = array('Editor', 'edit');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('Editor', 'edit');

class Editor
{
    public static function edit()
    {
        echo "<link rel='stylesheet' href='" . Helper::options()->themeUrl . '/typecho/editor/joe.editor.css' . "'>";
        echo "<script src='" . Helper::options()->themeUrl . '/typecho/editor/joe.extend.js' . "'></script>";
        echo "<script src='" . Helper::options()->themeUrl . '/typecho/editor/joe.editor.js' . "'></script>";
    }
}
