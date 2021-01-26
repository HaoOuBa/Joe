<?php

/* 继承方法函数 */
require_once('widget.php');

/* 公用函数 */
require_once('function.php');

/* 过滤内容函数 */
require_once('parse.php');

/* 主题内置开放API */
require_once('api.php');

/* 页面加载计时 */
_startCountTime();


/* 主题初始化 */
function themeInit($self)
{
    /* 强奸用户关闭反垃圾保护 */
    Helper::options()->commentsAntiSpam = false;
    /* 强奸用户关闭检查来源URL */
    Helper::options()->commentsCheckReferer = false;
    /* 强奸用户强制要求填写邮箱 */
    Helper::options()->commentsRequireMail = true;
    /* 强奸用户强制要求无需填写url */
    Helper::options()->commentsRequireURL = false;
    /* 强制用户开启评论回复 */
    Helper::options()->commentsThreaded = true;
    /* 强制显示一页12篇文章 */
    $self->parameter->pageSize = 12;

    /* 主题开放API 路由规则 */
    $path_info = $self->request->getPathinfo();
    if ($path_info === "/joe/api") {
        switch ($self->request->routeType) {
            case 'aside_ranking':
                _getRanking($self);
                break;
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
        };
    }
}

/* 增加自定义字段 */
function themeFields($layout)
{
    $aside = new Typecho_Widget_Helper_Form_Element_Radio(
        'aside',
        array(
            'on' => '开启',
            'off' => '关闭'
        ),
        'on',
        '是否开启当前页面的侧边栏',
        '介绍：用于单独设置当前页侧边栏的开启状态 <br /> 
         注意：只有在外观设置侧边栏开启状态下生效'
    );
    $layout->addItem($aside);

    $thumb = new Typecho_Widget_Helper_Form_Element_Textarea(
        'thumb',
        NULL,
        NULL,
        '自定义文章缩略图',
        '填写时：将会显示填写的文章缩略图 <br>
         不填写时：<br>
            1、若文章有图片则取文章内图片 <br>
            2、若文章无图片，并且外观设置里未填写·自定义缩略图·选项，则取模板自带图片 <br>
            3、若文章无图片，并且外观设置里填写了·自定义缩略图·选项，则取自定义缩略图图片'
    );
    $layout->addItem($thumb);

    $abstract = new Typecho_Widget_Helper_Form_Element_Textarea(
        'abstract',
        NULL,
        NULL,
        '自定义文章摘要',
        '填写时：将会显示填写的摘要 <br>
         不填写时：默认取文章里的内容'
    );
    $layout->addItem($abstract);
}
