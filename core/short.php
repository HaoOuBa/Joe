<?php

function _parseShortCode($content)
{
    /* 过滤网易云音乐歌单 */
    if (preg_match('/\[music-list\s{0,}id="\d{0,}"\s{0,}\/]/', $content)) {
        $content = preg_replace(
            '/\[music-list\s{0,}id="(\d{0,})"\s{0,}\/]/',
            '<iframe width="330" height="450" src="//music.163.com/outchain/player?type=0&id=$1&auto=0&height=430"></iframe>',
            $content
        );
    }
    /* 过滤网易云音乐单首歌 */
    if (preg_match('/\[music\s{0,}id="\d{0,}"\s{0,}\/]/', $content)) {
        $content = preg_replace(
            '/\[music\s{0,}id="(\d{0,})"\s{0,}\/]/',
            '<iframe width="330" height="86" src="//music.163.com/outchain/player?type=2&id=$1&auto=0&height=66"></iframe>',
            $content
        );
    }

    return $content;
}
