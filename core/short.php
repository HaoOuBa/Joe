<?php

function _parseContent($post, $login)
{
    $content = $post->content;
    $content = _parseReply($content);

    if (strpos($content, '{lamp/}') !== false) {
        $content = strtr($content, array(
            "{lamp/}" => '<span class="joe_lamp"></span>',
        ));
    }
    if (strpos($content, '{x}') !== false || strpos($content, '{ }') !== false) {
        $content = strtr($content, array(
            "{x}" => '<input type="checkbox" class="joe_checkbox" checked disabled></input>',
            "{ }" => '<input type="checkbox" class="joe_checkbox" disabled></input>'
        ));
    }
    if (strpos($content, '{music') !== false) {
        $content = preg_replace('/{music-list([^}]*)\/}/SU', '<joe-mlist $1></joe-mlist>', $content);
        $content = preg_replace('/{music([^}]*)\/}/SU', '<joe-music $1></joe-music>', $content);
    }
    if (strpos($content, '{mp3') !== false) {
        $content = preg_replace('/{mp3([^}]*)\/}/SU', '<joe-mp3 $1></joe-mp3>', $content);
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
    if (strpos($content, '{cloud') !== false) {
        $content = preg_replace('/{cloud([^}]*)\/}/SU', '<joe-cloud $1></joe-cloud>', $content);
    }
    if (strpos($content, '{anote') !== false) {
        $content = preg_replace('/{anote([^}]*)\/}/SU', '<joe-anote $1></joe-anote>', $content);
    }
    if (strpos($content, '{dotted') !== false) {
        $content = preg_replace('/{dotted([^}]*)\/}/SU', '<joe-dotted $1></joe-dotted>', $content);
    }
    if (strpos($content, '{message') !== false) {
        $content = preg_replace('/{message([^}]*)\/}/SU', '<joe-message $1></joe-message>', $content);
    }
    if (strpos($content, '{progress') !== false) {
        $content = preg_replace('/{progress([^}]*)\/}/SU', '<joe-progress $1></joe-progress>', $content);
    }
    if (strpos($content, '{hide') !== false) {
        $db = Typecho_Db::get();
        $hasComment = $db->fetchAll($db->select()->from('table.comments')->where('cid = ?', $post->cid)->where('mail = ?', $post->remember('mail', true))->limit(1));
        if ($hasComment || $login) {
            $content = strtr($content, array("{hide}" => "", "{/hide}" => ""));
        } else {
            $content = preg_replace('/{hide[^}]*}([\s\S]*?){\/hide}/', '<joe-hide></joe-hide>', $content);
        }
    }
    if (strpos($content, '{card-default') !== false) {
        $content = preg_replace('/{card-default([^}]*)}([\s\S]*?){\/card-default}/', '<section style="margin-bottom: 15px"><joe-card-default $1><span class="_temp" style="display: none">$2</span></joe-card-default></section>', $content);
    }
    if (strpos($content, '{callout') !== false) {
        $content = preg_replace('/{callout([^}]*)}([\s\S]*?){\/callout}/', '<section style="margin-bottom: 15px"><joe-callout $1><span class="_temp" style="display: none">$2</span></joe-callout></section>', $content);
    }
    if (strpos($content, '{alert') !== false) {
        $content = preg_replace('/{alert([^}]*)}([\s\S]*?){\/alert}/', '<section style="margin-bottom: 15px"><joe-alert $1><span class="_temp" style="display: none">$2</span></joe-alert></section>', $content);
    }
    if (strpos($content, '{card-describe') !== false) {
        $content = preg_replace('/{card-describe([^}]*)}([\s\S]*?){\/card-describe}/', '<section style="margin-bottom: 15px"><joe-card-describe $1><span class="_temp" style="display: none">$2</span></joe-card-describe></section>', $content);
    }
    if (strpos($content, '{tabs') !== false) {
        $content = preg_replace('/{tabs}([\s\S]*?){\/tabs}/', '<section style="margin-bottom: 15px"><joe-tabs><span class="_temp" style="display: none">$1</span></joe-tabs></section>', $content);
    }
    if (strpos($content, '{card-list') !== false) {
        $content = preg_replace('/{card-list}([\s\S]*?){\/card-list}/', '<section style="margin-bottom: 15px"><joe-card-list><span class="_temp" style="display: none">$1</span></joe-card-list></section>', $content);
    }
    if (strpos($content, '{timeline') !== false) {
        $content = preg_replace('/{timeline}([\s\S]*?){\/timeline}/', '<section style="margin-bottom: 15px"><joe-timeline><span class="_temp" style="display: none">$1</span></joe-timeline></section>', $content);
    }
    if (strpos($content, '{collapse') !== false) {
        $content = preg_replace('/{collapse}([\s\S]*?){\/collapse}/', '<section style="margin-bottom: 15px"><joe-collapse><span class="_temp" style="display: none">$1</span></joe-collapse></section>', $content);
    }
    if (strpos($content, '{gird') !== false) {
        $content = preg_replace('/{gird([^}]*)}([\s\S]*?){\/gird}/', '<section style="margin-bottom: 15px"><joe-gird $1><span class="_temp" style="display: none">$2</span></joe-gird></section>', $content);
    }
    if (strpos($content, '{copy') !== false) {
        $content = preg_replace('/{copy([^}]*)\/}/SU', '<joe-copy $1></joe-copy>', $content);
    }

    echo $content;
}
