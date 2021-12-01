<?php

/* 继承方法函数 */
require_once('widget.php');

/* 公用函数 */
require_once('function.php');

/* 过滤内容函数 */
require_once('parse.php');

/* 主题内置开放API */
require_once('route.php');

/* 插件方法 */
require_once('factory.php');

/* 页面加载计时 */
_startCountTime();

/* 主题初始化 */
function themeInit($self)
{
    /* 强制用户要求填写邮箱 */
    Helper::options()->commentsRequireMail = true;
    /* 强制用户要求无需填写url */
    Helper::options()->commentsRequireURL = false;
    /* 强制用户开启评论回复 */
    Helper::options()->commentsThreaded = true;
    /* 强制回复楼层最高999层 */
    Helper::options()->commentsMaxNestingLevels = 999;

    /* 主题开放API 路由规则 */
    if ($self->request->getPathInfo() == "/joe/api") {
        switch ($self->request->routeType) {
            case 'publish_list':
                _getPost($self);
                break;
            case 'baidu_record':
                _getRecord($self);
                break;
            case 'baidu_push':
                _pushRecord($self);
                break;
            case 'handle_views':
                _handleViews($self);
                break;
            case 'handle_agree':
                _handleAgree($self);
                break;
            case 'wallpaper_type':
                _getWallpaperType($self);
                break;
            case 'wallpaper_list':
                _getWallpaperList($self);
                break;
            case 'maccms_list':
                _getMaccmsList($self);
                break;
            case 'huya_list':
                _getHuyaList($self);
                break;
            case 'server_status':
                _getServerStatus($self);
                break;
            case 'comment_lately':
                _getCommentLately($self);
                break;
            case 'article_filing':
                _getArticleFiling($self);
                break;
        };
    }


    /* 增加自定义SiteMap功能 */
    if (Helper::options()->JSiteMap && Helper::options()->JSiteMap !== 'off') {
        if (strpos($self->request->getRequestUri(), 'sitemap.xml') !== false) {
            $self->response->setStatus(200);
            $self->setThemeFile("library/sitemap.php");
        }
    }
}

/* 增加自定义字段 */
function themeFields($layout)
{
    $mode = new Typecho_Widget_Helper_Form_Element_Select(
        'mode',
        array(
            'default' => '默认模式',
            'single' => '大图模式',
            'multiple' => '三图模式',
            'none' => '无图模式'
        ),
        'default',
        '文章显示方式',
        '介绍：用于设置当前文章在首页和搜索页的显示方式 <br /> 
         注意：独立页面该功能不会生效'
    );
    $layout->addItem($mode);

    $keywords = new Typecho_Widget_Helper_Form_Element_Text(
        'keywords',
        NULL,
        NULL,
        'SEO关键词（非常重要！）',
        '介绍：用于设置当前页SEO关键词 <br />
         注意：多个关键词使用英文逗号进行隔开 <br />
         例如：Typecho,Typecho主题,Typecho模板 <br />
         其他：如果不填写此项，则默认取文章标签'
    );
    $layout->addItem($keywords);

    $description = new Typecho_Widget_Helper_Form_Element_Textarea(
        'description',
        NULL,
        NULL,
        'SEO描述语（非常重要！）',
        '介绍：用于设置当前页SEO描述语 <br />
         注意：SEO描述语不应当过长也不应当过少 <br />
         其他：如果不填写此项，则默认截取文章片段'
    );
    $layout->addItem($description);

    $abstract = new Typecho_Widget_Helper_Form_Element_Textarea(
        'abstract',
        NULL,
        NULL,
        '自定义摘要（非必填）',
        '填写时：将会显示填写的摘要 <br>
         不填写时：默认取文章里的内容'
    );
    $layout->addItem($abstract);

    $thumb = new Typecho_Widget_Helper_Form_Element_Textarea(
        'thumb',
        NULL,
        NULL,
        '自定义缩略图（非必填）',
        '填写时：将会显示填写的文章缩略图 <br>
         不填写时：<br>
            1、若文章有图片则取文章内图片 <br>
            2、若文章无图片，并且外观设置里未填写·自定义缩略图·选项，则取模板自带图片 <br>
            3、若文章无图片，并且外观设置里填写了·自定义缩略图·选项，则取自定义缩略图图片 <br>
         注意：多个缩略图时换行填写，一行一个（仅在三图模式下生效）'
    );
    $layout->addItem($thumb);

    $video = new Typecho_Widget_Helper_Form_Element_Textarea(
        'video',
        NULL,
        NULL,
        'M3U8或MP4地址（非必填）',
        '填写后，文章会插入一个视频模板 <br>
         格式：视频名称$视频地址。如果有多个，换行写即可 <br>
         例如：<br>
            第01集$https://iqiyi.cdn9-okzy.com/20201104/17638_8f3022ce/index.m3u8 <br>
            第02集$https://iqiyi.cdn9-okzy.com/20201104/17639_5dcb8a3b/index.m3u8 
        '
    );
    $layout->addItem($video);
}
