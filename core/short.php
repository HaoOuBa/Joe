<?php

function _parseContent($post, $login)
{
    /* 优先判断文章内是否有回复可见的内容 */
    $content = $post->content;
    if (preg_match('/\{hide\}.{0,}\{\/hide\}/sSU', $content)) {
        $db = Typecho_Db::get();
        $hasComment = $db->fetchAll($db->select()->from('table.comments')->where('cid = ?', $post->cid)->where('mail = ?', $post->remember('mail', true))->limit(1));
        if ($hasComment || $login) {
            $content = preg_replace('/\{hide\}(.{0,})\{\/hide\}/sSU', '$1', $content);
        } else {
            $content = preg_replace('/\{hide\}(.{0,})\{\/hide\}/sSU', '<span class="joe_detail__article-hide block">此处内容作者设置了 <i>回复</i> 可见</span>', $content);
        }
    }
    /* 过滤网易云音乐歌单 */
    if (preg_match('/\{music-list\s{0,}id="\d{0,}"\s{0,}\/\}/SU', $content)) {
        $content = preg_replace(
            '/\{music-list\s{0,}id="(\d{0,})"\s{0,}\/\}/SU',
            '<iframe class="lazyload" data-src="//music.163.com/outchain/player?type=0&id=$1&auto=0&height=430" width="330" height="450"></iframe>',
            $content
        );
    }
    /* 过滤网易云音乐单首歌 */
    if (preg_match('/\{music\s{0,}id="\d{0,}"\s{0,}\/\}/SU', $content)) {
        $content = preg_replace(
            '/\{music\s{0,}id="(\d{0,})"\s{0,}\/\}/SU',
            '<iframe class="lazyload" data-src="//music.163.com/outchain/player?type=2&id=$1&auto=0&height=66" width="330" height="86"></iframe>',
            $content
        );
    }
    /* 过滤dplayer播放器 */
    if (preg_match('/\{dplayer\s{0,}src=".{0,}"\s{0,}\/\}/sSU', $content)) {
        $player = Helper::options()->JCustomPlayer ? Helper::options()->JCustomPlayer : '/usr/themes/Joe/library/player.php?url=';
        $content = preg_replace(
            '/\{dplayer\s{0,}src="(.{0,})"\s{0,}\/\}/sSU',
            '<iframe class="joe_detail__article-player block lazyload" allowfullscreen="true" data-src="' . $player . '$1"></iframe>',
            $content
        );
    }
    /* 过滤bilibili播放器 */
    if (preg_match('/\{bilibili\s{0,}bvid="\w{0,}"\s{0,}\/\}/sSU', $content)) {
        $content = preg_replace(
            '/\{bilibili\s{0,}bvid="(\w{0,})"\s{0,}\/\}/sSU',
            '<iframe class="joe_detail__article-player block lazyload" allowfullscreen="true" data-src="//player.bilibili.com/player.html?bvid=$1"></iframe>',
            $content
        );
    }
    /* 过滤完成任务勾选 */
    if (preg_match('/\{x\}/SU', $content)) {
        $content = preg_replace(
            '/\{x\}/SU',
            '<input type="checkbox" class="joe_detail__article-checkbox" checked disabled></input>',
            $content
        );
    }
    /* 过滤未完成任务勾选 */
    if (preg_match('/\{\s{1}\}/SU', $content)) {
        $content = preg_replace(
            '/\{\s{1}\}/SU',
            '<input type="checkbox" class="joe_detail__article-checkbox" disabled></input>',
            $content
        );
    }
    /* 过滤默认卡片 */
    if (preg_match('/\{card-default\s{0,}width=".{0,}"\s{0,}label=".{0,}"\s{0,}\}.{0,}\{\/card-default\}/sSU', $content)) {
        $content = preg_replace(
            '/\{card-default\s{0,}width="(.{0,})"\s{0,}label="(.{0,})"\s{0,}\}(.{0,})\{\/card-default\}/sSU',
            '<span class="joe_detail__article-card block" style="width: $1">
                <span class="title block">$2</span>
                <span class="content block">$3</span>
             </span>',
            $content
        );
    }
    /* 过滤消息提示 */
    if (preg_match('/\{message\s{0,}type="success|info|warning|error"\s{0,}\}.{0,}\{\/message\}/sSU', $content)) {
        $content = preg_replace(
            '/\{message\s{0,}type="(success|info|warning|error)"\s{0,}\}(.{0,})\{\/message\}/sSU',
            '<span class="joe_detail__article-message block $1">
                <span class="icon"></span>
                <span class="content">$2</span>
             </span>',
            $content
        );
    }
    /* 过滤居中标题 */
    if (preg_match('/\{mtitle\}.{0,}\{\/mtitle\}/sSU', $content)) {
        $content = preg_replace(
            '/\{mtitle\}(.{0,})\{\/mtitle\}/sSU',
            '<span class="joe_detail__article-mtitle">
                <span class="text">$1</span>
             </span>',
            $content
        );
    }
    /* 过滤note button */
    if (preg_match('/\{anote\s{0,}icon=".{0,}"\s{0,}href=".{0,}"\s{0,}type="secondary|success|warning|error|info"\s{0,}}.{0,}\{\/anote\}/sSU', $content)) {
        $content = preg_replace(
            '/\{anote\s{0,}icon="(.{0,})"\s{0,}href="(.{0,})"\s{0,}type="(secondary|success|warning|error|info)"\s{0,}}(.{0,})\{\/anote\}/sSU',
            '<a class="joe_detail__article-anote $3" href="$2" target="_blank" rel="noopener noreferrer nofollow">
                <span class="icon"><i class="fa $1"></i></span><span class="content">$4</span>
             </a>',
            $content
        );
    }
    /* 过滤note button */
    if (preg_match('/\{abtn\s{0,}icon=".{0,}"\s{0,}color=".{0,}"\s{0,}href=".{0,}"\s{0,}radius=".{0,}"\s{0,}\}.{0,}\{\/abtn\}/sSU', $content)) {
        $content = preg_replace(
            '/\{abtn\s{0,}icon="(.{0,})"\s{0,}color="(.{0,})"\s{0,}href="(.{0,})"\s{0,}radius="(.{0,})"\s{0,}\}(.{0,})\{\/abtn\}/sSU',
            '<a class="joe_detail__article-abtn" style="background: $2; border-radius: $4" href="$3" target="_blank" rel="noopener noreferrer nofollow">
                <span class="icon"><i class="$1 fa"></i></span><span class="content">$5</span>
             </a>',
            $content
        );
    }
    /* 过滤复制粘贴功能 */
    if (preg_match('/\{copy\s{0,}text=".{0,}"\s{0,}\}.{0,}\{\/copy\}/sSU', $content)) {
        $content = preg_replace(
            '/\{copy\s{0,}text="(.{0,})"\s{0,}\}(.{0,})\{\/copy\}/sSU',
            '<span data-clipboard-text="$1" class="joe_detail__article-copy">$2</span>',
            $content
        );
    }
    echo $content;
}
