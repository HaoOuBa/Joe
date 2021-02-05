<?php

function _parseShortCode($content)
{
    /* 过滤网易云音乐歌单 */
    if (preg_match('/\[music-list\s{0,}id="\d{0,}"\s{0,}\/\]/SU', $content)) {
        $content = preg_replace(
            '/\[music-list\s{0,}id="(\d{0,})"\s{0,}\/]/SU',
            '<iframe width="330" height="450" src="//music.163.com/outchain/player?type=0&id=$1&auto=0&height=430"></iframe>',
            $content
        );
    }
    /* 过滤网易云音乐单首歌 */
    if (preg_match('/\[music\s{0,}id="\d{0,}"\s{0,}\/\]/SU', $content)) {
        $content = preg_replace(
            '/\[music\s{0,}id="(\d{0,})"\s{0,}\/\]/SU',
            '<iframe width="330" height="86" src="//music.163.com/outchain/player?type=2&id=$1&auto=0&height=66"></iframe>',
            $content
        );
    }
    /* 过滤dplayer播放器 */
    if (preg_match('/\[dplayer\s{0,}src=".{0,}"\s{0,}\/\]/SU', $content)) {
        $player = Helper::options()->JCustomPlayer ? Helper::options()->JCustomPlayer : '/usr/themes/Joe/library/player.php?url=';
        $content = preg_replace(
            '/\[dplayer\s{0,}src="(.{0,})"\s{0,}\/\]/SU',
            '<iframe class="joe_detail__article-player block" allowfullscreen="true" src="' . $player . '$1"></iframe>',
            $content
        );
    }
    /* 过滤bilibili播放器 */
    if (preg_match('/\[bilibili\s{0,}bvid="\w{0,}"\s{0,}\/\]/SU', $content)) {
        $content = preg_replace(
            '/\[bilibili\s{0,}bvid="(\w{0,})"\s{0,}\/\]/SU',
            '<iframe class="joe_detail__article-player block" allowfullscreen="true" src="//player.bilibili.com/player.html?bvid=$1"></iframe>',
            $content
        );
    }
    /* 过滤完成任务勾选 */
    if (preg_match('/\[x\]/SU', $content)) {
        $content = preg_replace(
            '/\[x\]/SU',
            '<input type="checkbox" class="joe_detail__article-checkbox" checked disabled></input>',
            $content
        );
    }
    /* 过滤未完成任务勾选 */
    if (preg_match('/\[\s{1}\]/SU', $content)) {
        $content = preg_replace(
            '/\[\s{1}\]/SU',
            '<input type="checkbox" class="joe_detail__article-checkbox" disabled></input>',
            $content
        );
    }
    /* 过滤默认卡片 */
    if (preg_match('/\[card-default\s{0,}width=".{0,}"\s{0,}label=".{0,}"\].{0,}\[\/card-default\]/sSU', $content)) {
        $content = preg_replace(
            '/\[card-default\s{0,}width="(.{0,})"\s{0,}label="(.{0,})"\](.{0,})\[\/card-default\]/sSU',
            '<span class="joe_detail__article-card block" style="width: $1">
                <span class="title block">$2</span>
                <span class="content block">$3</span>
             </span>',
            $content
        );
    }
    /* 过滤消息提示 */
    if (preg_match('/\[message\s{0,}type="success|info|warning|error"\s{0,}\].{0,}\[\/message\]/sSU', $content)) {
        $content = preg_replace(
            '/\[message\s{0,}type="(success|info|warning|error)"\s{0,}\](.{0,})\[\/message\]/sSU',
            '<span class="joe_detail__article-message block $1">
                <span class="icon"></span>
                <span class="content">$2</span>
             </span>',
            $content
        );
    }

    return $content;
}
