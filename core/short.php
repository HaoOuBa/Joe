<?php

function _parseContent($post, $login)
{
    $content = $post->content;
    $content = _parseReply($content);

    if (strpos($content, '{x}') !== false || strpos($content, '{ }') !== false) {
        $content = strtr($content, array(
            "{x}" => '<input type="checkbox" class="joe_detail__article-checkbox" checked disabled></input>',
            "{ }" => '<input type="checkbox" class="joe_detail__article-checkbox" disabled></input>'
        ));
    }
    if (strpos($content, '{music') !== false) {
        $content = preg_replace('/{music-list([^}]*)\/}/SU', '<joe-mlist $1></joe-mlist>', $content);
        $content = preg_replace('/{music([^}]*)\/}/SU', '<joe-music $1></joe-music>', $content);
    }
    if (strpos($content, '{bilibili') !== false) {
        $content = preg_replace('/{bilibili([^}]*)\/}/SU', '<joe-bilibili $1></joe-bilibili>', $content);
    }
    if (strpos($content, '{dplayer') !== false) {
        $player = Helper::options()->JCustomPlayer ? Helper::options()->JCustomPlayer : Helper::options()->themeUrl . '/library/player.php?url=';
        $content = preg_replace('/{dplayer([^}]*)\/}/SU', '<joe-dplayer player="' . $player . '" $1></joe-dplayer>', $content);
    }
    if (strpos($content, '{mtitle') !== false) {
        $content = preg_replace('/{mtitle([^}]*)\/}/SU', '<joe-mtitle $1></joe-mtitle>', $content);
    }
    if (strpos($content, '{abtn') !== false) {
        $content = preg_replace('/{abtn([^}]*)\/}/SU', '<joe-abtn $1></joe-abtn>', $content);
    }
    if (strpos($content, '{anote') !== false) {
        $content = preg_replace('/{anote([^}]*)\/}/SU', '<joe-anote $1></joe-anote>', $content);
    }




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
    /* 过滤复制粘贴功能 */
    if (strpos($content, '{copy') !== false) {
        $content = preg_replace('/{copy(.*)}/SU', '<joe-copy $1>', $content);
        $content = preg_replace('/{\/copy}/SU', '</joe-copy>', $content);
    }
    /* 过滤消息提示 */
    if (strpos($content, '{message') !== false) {
        $content = preg_replace('/{message(.*)}/SU', '<joe-message $1>', $content);
        $content = preg_replace('/{\/message}/SU', '</joe-message>', $content);
    }
    /* 时间线 */
    if (strpos($content, '{timeline') !== false) {
        $content = strtr($content, array("{timeline}" => '<joe-timeline>', "{/timeline}" => '</joe-timeline>'));
        $content = strtr($content, array("{timeline-item}" => '<joe-timeline-item>', "{/timeline-item}" => '</joe-timeline-item>'));
    }
    echo $content;
}
