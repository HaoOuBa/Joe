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
        'https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/favicon.ico',
        '网站 Favicon 设置',
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
        '网站 Logo 设置',
        '介绍：用于设置网站 Logo，一个好的 Logo 能为网站带来有效的流量 <br />
         格式：图片 URL地址 或 Base64 地址 <br />
         其他：免费制作 logo 网站 <a target="_blank" href="//www.uugai.com">www.uugai.com</a>'
    );
    $JLogo->setAttribute('class', 'joe_content joe_image');
    $form->addInput($JLogo);

    $JNavMaxNum = new Typecho_Widget_Helper_Form_Element_Select(
        'JNavMaxNum',
        array(
            '3' => '3个（默认）',
            '4' => '4个',
            '5' => '5个',
            '6' => '6个',
            '7' => '7个',
        ),
        '3',
        '选择导航栏最大显示的个数',
        '介绍：用于设置最大多少个后，以更多下拉框显示'
    );
    $JNavMaxNum->setAttribute('class', 'joe_content joe_global');
    $form->addInput($JNavMaxNum->multiMode());

    $JAside = new Typecho_Widget_Helper_Form_Element_Checkbox(
        'JAside',
        array(
            'author' => '作者栏',
            'timelife' => '计时栏',
            'weather' => '天气栏（需先在下方填写KEY值）',
            'hot' => '热门文章栏'
        ),
        null,
        '选择首页需要显示的侧边栏栏目',
        '介绍：用于控制首页侧边栏的栏目显示规则 <br>
         注意：如果全部未选，则表示不开启侧边栏'
    );
    $JAside->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside->multiMode());

    $JAside_Author_Image = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JAside_Author_Image',
        NULL,
        "https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/img/aside_author_image.jpg",
        '作者栏 —— 背景',
        '介绍：用于修改作者栏的背景图片 <br/>
         格式：图片地址 <br />
         注意：不填写时，则显示默认背景'
    );
    $JAside_Author_Image->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Author_Image);

    $JAside_Author_Link = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JAside_Author_Link',
        NULL,
        "https://ae.js.cn",
        '作者栏 —— 跳转链接',
        '介绍：用于修改作者栏的跳转链接'
    );
    $JAside_Author_Link->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Author_Link);

    $JAside_Author_Motto = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JAside_Author_Motto',
        NULL,
        "有钱终成眷属，没钱亲眼目睹",
        '作者栏 —— 座右铭',
        '介绍：用于显示在侧边栏作者信息的座右铭。<br />
         格式：可以填写多行也可以填写一行，填写多行时，每次随机显示其中的某一条'
    );
    $JAside_Author_Motto->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Author_Motto);

    $JAside_Author_Nav = new Typecho_Widget_Helper_Form_Element_Select(
        'JAside_Author_Nav',
        array(
            'off' => '关闭（默认）',
            '3' => '开启，并显示3条最新文章',
            '4' => '开启，并显示4条最新文章',
            '5' => '开启，并显示5条最新文章',
            '6' => '开启，并显示6条最新文章',
            '7' => '开启，并显示7条最新文章',
            '8' => '开启，并显示8条最新文章',
            '9' => '开启，并显示9条最新文章',
            '10' => '开启，并显示10条最新文章'
        ),
        'off',
        '作者栏 —— 随机文章数目',
        '介绍：用于控制作者栏的随机文章条数'
    );
    $JAside_Author_Nav->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Author_Nav->multiMode());

    $JAside_Weather_Key = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JAside_Weather_Key',
        NULL,
        NULL,
        '天气栏 —— 天气KEY值',
        '介绍：用于初始化天气栏 <br/>
         注意：填写时请填写正确的KEY值！<br />
         其他：免费申请地址：<a href="//cj.weather.com.cn">cj.weather.com.cn</a>'
    );
    $JAside_Weather_Key->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Weather_Key);

    $JAside_Weather_Style = new Typecho_Widget_Helper_Form_Element_Select(
        'JAside_Weather_Style',
        array(
            '1' => '自动（默认）',
            '2' => '浅色',
            '3' => '深色'
        ),
        '1',
        '天气栏 —— 天气风格样式',
        '介绍：选择一款您所喜爱的天气风格 <br />
         注意：需要先填写天气的KEY值'
    );
    $JAside_Weather_Style->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Weather_Style->multiMode());

    $JAside_Hot_Num = new Typecho_Widget_Helper_Form_Element_Select(
        'JAside_Hot_Num',
        array(
            '3' => '显示3条（默认）',
            '4' => '显示4条',
            '5' => '显示5条',
            '6' => '显示6条',
            '7' => '显示7条',
            '8' => '显示8条',
            '9' => '显示9条',
            '10' => '显示10条',
        ),
        '3',
        '热门文章栏 —— 文章数',
        '介绍：用于控制热门文章栏目的数量'
    );
    $JAside_Hot_Num->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Hot_Num->multiMode());

    $JThumbnail = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JThumbnail',
        NULL,
        NULL,
        '自定义缩略图（非必填）',
        '介绍：用于修改主题默认缩略图 <br/>
         格式：图片地址，一行一个 <br />
         注意：不填写时，则使用主题内置的默认缩略图
         '
    );
    $JThumbnail->setAttribute('class', 'joe_content joe_image');
    $form->addInput($JThumbnail);

    $JLazyload = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JLazyload',
        NULL,
        "https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/img/lazyload.jpg",
        '自定义懒加载图（非必填）',
        '介绍：用于修改主题默认懒加载图 <br/>
         格式：图片地址'
    );
    $JLazyload->setAttribute('class', 'joe_content joe_image');
    $form->addInput($JLazyload);
} ?>