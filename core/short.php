<?php

function _parseShortCode($content)
{
    /* 过滤网易云音乐歌单 */
    if (preg_match('/\[music-list\s{0,}id="\d{0,}"\s{0,}\/\]/', $content)) {
        $content = preg_replace(
            '/\[music-list\s{0,}id="(\d{0,})"\s{0,}\/]/',
            '<iframe width="330" height="450" src="//music.163.com/outchain/player?type=0&id=$1&auto=0&height=430"></iframe>',
            $content
        );
    }
    /* 过滤网易云音乐单首歌 */
    if (preg_match('/\[music\s{0,}id="\d{0,}"\s{0,}\/\]/', $content)) {
        $content = preg_replace(
            '/\[music\s{0,}id="(\d{0,})"\s{0,}\/\]/',
            '<iframe width="330" height="86" src="//music.163.com/outchain/player?type=2&id=$1&auto=0&height=66"></iframe>',
            $content
        );
    }
    /* 过滤bilibili播放器 */
    if (preg_match('/\[bilibili\s{0,}bvid="\w{0,}"\s{0,}\/\]/', $content)) {
        $content = preg_replace(
            '/\[bilibili\s{0,}bvid="(\w{0,})"\s{0,}\/\]/',
            '<iframe class="joe_detail__article-player block" allowfullscreen="true" src="//player.bilibili.com/player.html?bvid=$1"></iframe>',
            $content
        );
    }
    /* 过滤dplayer播放器 */
    if (preg_match('/\[dplayer\s{0,}src=".{0,}"\s{0,}\/\]/', $content)) {
        $player = Helper::options()->JCustomPlayer ? Helper::options()->JCustomPlayer : '/usr/themes/Joe/library/player.php?url=';
        $content = preg_replace(
            '/\[dplayer\s{0,}src="(.{0,})"\s{0,}\/\]/',
            '<iframe class="joe_detail__article-player block" allowfullscreen="true" src="' . $player . '$1"></iframe>',
            $content
        );
    }
    return $content;
}
