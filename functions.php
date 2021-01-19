<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
require_once("core/core.php");
function themeConfig($form)
{
    $_db = Typecho_Db::get();
    $_prefix = $_db->getPrefix();
    try {
        if (!array_key_exists('view', $_db->fetchRow($_db->select()->from('table.contents')->page(1, 1)))) {
            $_db->query('ALTER TABLE `' . $_prefix . 'contents` ADD `view` INT DEFAULT 0;');
        }
        if (!array_key_exists('agree', $_db->fetchRow($_db->select()->from('table.contents')->page(1, 1)))) {
            $_db->query('ALTER TABLE `' . $_prefix . 'contents` ADD `agree` INT DEFAULT 0;');
        }
    } catch (Exception $e) {
    }
?>
    <link rel="stylesheet" href="<?php Helper::options()->themeUrl('assets/css/joe.config.css') ?>">
    <script src="<?php Helper::options()->themeUrl('assets/js/joe.config.js') ?>"></script>
    <div class="joe_config">
        <div>
            <div class="joe_config__aside">
                <div class="logo">Joe <?php echo _getVersion() ?></div>
                <ul class="tabs">
                    <li class="item" data-current="joe_notice">最新公告</li>
                    <li class="item" data-current="joe_global">全局设置</li>
                    <li class="item" data-current="joe_image">图片设置</li>
                    <li class="item" data-current="joe_post">文章设置</li>
                    <li class="item" data-current="joe_aside">侧栏设置</li>
                    <li class="item" data-current="joe_index">首页设置</li>
                    <li class="item" data-current="joe_other">其他设置</li>
                </ul>
                <?php require_once('core/backup.php'); ?>
            </div>
        </div>
        <div class="joe_config__notice">请求数据中...</div>
    <?php
    $JFavicon = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JFavicon',
        NULL,
        'https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/img/favicon.ico',
        '网站 Favicon 设置（非必填）',
        '介绍：用于设置网站 Favicon，一个好的 Favicon 可以给用户一种很专业的观感 <br />
         格式：图片 URL地址 或 Base64 地址 <br />
         其他：免费转换 Favicon 网站 <a target="_blank" href="//tool.lu/favicon">tool.lu/favicon</a>'
    );
    $JFavicon->setAttribute('class', 'joe_content joe_image');
    $form->addInput($JFavicon);

    $JLogo = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JLogo',
        NULL,
        'https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/img/logo.png',
        '网站 Logo 设置（非必填）',
        '介绍：用于设置网站 Logo，一个好的 Logo 能为网站带来有效的流量 <br />
         格式：图片 URL地址 或 Base64 地址 <br />
         其他：免费制作 logo 网站 <a target="_blank" href="//www.uugai.com">www.uugai.com</a>'
    );
    $JLogo->setAttribute('class', 'joe_content joe_image');
    $form->addInput($JLogo);
} ?>