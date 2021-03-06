<?php

function _parseContent($post, $login)
{
    /* 优先判断文章内是否有回复可见的内容 */
    $content = $post->content;
    /* 过滤表情 */
    $content = _parseReply($content);
    /* 过滤默认卡片 */
    if (strpos($content, '{card-default') !== false) {
        $content = preg_replace('/{card-default(.*)}/SU', '<joe-card $1>', $content);
        $content = preg_replace('/{\/card-default}/SU', '</joe-card>', $content);
    }
    /* 过滤回复可见 */
    if (strpos($content, '{hide') !== false) {
        $db = Typecho_Db::get();
        $hasComment = $db->fetchAll($db->select()->from('table.comments')->where('cid = ?', $post->cid)->where('mail = ?', $post->remember('mail', true))->limit(1));
        if ($hasComment || $login) {
            $content = strtr($content, array("{hide}" => "<joe-show>", "{/hide}" => "</joe-show>"));
        } else {
            $content = strtr($content, array("{hide}" => "<joe-hide>", "{/hide}" => "</joe-hide>"));
        }
    }
    /* 过滤网易云音乐 */
    if (strpos($content, '{music') !== false) {
        $content = preg_replace('/{music-list(.*)\/}/SU', '<joe-mlist $1></joe-mlist>', $content);
        $content = preg_replace('/{music(.*)\/}/SU', '<joe-music $1></joe-music>', $content);
    }
    /* 过滤完成任务勾选 */
    if (strpos($content, '{x}') !== false || strpos($content, '{ }') !== false) {
        $content = strtr($content, array(
            "{x}" => '<input type="checkbox" class="joe_detail__article-checkbox" checked disabled></input>',
            "{ }" => '<input type="checkbox" class="joe_detail__article-checkbox" disabled></input>'
        ));
    }
    /* 过滤dplayer播放器 */
    if (strpos($content, '{dplayer') !== false) {
        $player = Helper::options()->JCustomPlayer ? Helper::options()->JCustomPlayer : '/usr/themes/Joe/library/player.php?url=';
        $content = preg_replace('/{dplayer(.*)\/}/SU', '<joe-dplayer player="' . $player . '" $1></joe-dplayer>', $content);
    }
    /* 过滤bilibili播放器 */
    if (strpos($content, '{bilibili') !== false) {
        $content = preg_replace('/{bilibili(.*)\/}/SU', '<joe-bilibili $1></joe-bilibili>', $content);
    }
    /* 过滤复制粘贴功能 */
    if (strpos($content, '{copy') !== false) {
        $content = preg_replace('/{copy(.*)}/SU', '<joe-copy $1>', $content);
        $content = preg_replace('/{\/copy}/SU', '</joe-copy>', $content);
    }
    /* 过滤居中标题 */
    if (strpos($content, '{mtitle') !== false) {
        $content = strtr($content, array("{mtitle}" => '<joe-mtitle>', "{/mtitle}" => '</joe-mtitle>'));
    }
    /* 过滤消息提示 */
    if (strpos($content, '{message') !== false) {
        $content = preg_replace('/{message(.*)}/SU', '<joe-message $1>', $content);
        $content = preg_replace('/{\/message}/SU', '</joe-message>', $content);
    }
    /* 标签按钮 */
    if (strpos($content, '{anote') !== false) {
        $content = preg_replace('/{anote(.*)}/SU', '<joe-anote $1>', $content);
        $content = preg_replace('/{\/anote}/SU', '</joe-anote>', $content);
    }
    /* 多彩按钮 */
    if (strpos($content, '{abtn') !== false) {
        $content = preg_replace('/{abtn(.*)}/SU', '<joe-abtn $1>', $content);
        $content = preg_replace('/{\/abtn}/SU', '</joe-abtn>', $content);
    }
    /* 多彩按钮 */
    if (strpos($content, '{timeline') !== false) {
        $content = strtr($content, array("{timeline}" => '<joe-timeline>', "{/timeline}" => '</joe-timeline>'));
        $content = strtr($content, array("{timeline-item}" => '<joe-timeline-item>', "{/timeline-item}" => '</joe-timeline-item>'));
    }
    echo $content;
}
