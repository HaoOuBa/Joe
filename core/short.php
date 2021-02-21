<?php

function _parseContent($post, $login)
{
    /* 优先判断文章内是否有回复可见的内容 */
    $content = $post->content;

    /* 过滤表情 */
    $content = _parseReply($content);

    /* 过滤默认卡片 */
    if (strpos($content, '{/card-default}') !== false) {
        $content = preg_replace_callback(
            '/\{card-default\s{0,}width="(.{0,})"\s{0,}label="(.{0,})"\s{0,}\}(.{0,})\{\/card-default\}/sSU',
            function ($matches) {
                return '<span class="joe_detail__article-card block" style="width: ' . $matches[1] . '">
                            <span class="title block">' . $matches[2] . '</span>
                            <span class="content block">' . $matches[3] . '</span>
                        </span>
                ';
            },
            $content
        );
    }

    /* 过滤消息提示 */
    if (strpos($content, '{/message}') !== false) {
        $content = preg_replace_callback(
            '/\{message\s{0,}type="(success|info|warning|error)"\s{0,}\}(.{0,})\{\/message\}/sSU',
            function ($matches) {
                return '<span class="joe_detail__article-message block ' . $matches[1] . '">
                            <span class="icon"></span>
                            <span class="content">' . $matches[2] . '</span>
                        </span>
                ';
            },
            $content
        );
    }

    /* 过滤note button */
    if (strpos($content, '{/anote}') !== false) {
        $content = preg_replace_callback(
            '/\{anote\s{0,}icon="(.{0,})"\s{0,}href="(.{0,})"\s{0,}type="(secondary|success|warning|error|info)"\s{0,}}(.{0,})\{\/anote\}/sSU',
            function ($matches) {
                return '<a class="joe_detail__article-anote ' . $matches[3] . '" href="' . $matches[2] . '" target="_blank" rel="noopener noreferrer nofollow">
                            <span class="icon"><i class="fa ' . $matches[1] . '"></i></span><span class="content">' . $matches[4] . '</span>
                        </a>
                ';
            },
            $content
        );
    }

    /* 过滤普通button */
    if (strpos($content, '{/abtn}') !== false) {
        $content = preg_replace_callback(
            '/\{abtn\s{0,}icon="(.{0,})"\s{0,}color="(.{0,})"\s{0,}href="(.{0,})"\s{0,}radius="(.{0,})"\s{0,}\}(.{0,})\{\/abtn\}/sSU',
            function ($matches) {
                return '<a class="joe_detail__article-abtn" style="background: ' . $matches[2] . '; border-radius: ' . $matches[4] . '" href="' . $matches[3] . '" target="_blank" rel="noopener noreferrer nofollow">
                            <span class="icon"><i class="' . $matches[1] . ' fa"></i></span><span class="content">' . $matches[5] . '</span>
                        </a>
                ';
            },
            $content
        );
    }

    /* 过滤回复可见 */
    if (strpos($content, '{/hide}') !== false) {
        $db = Typecho_Db::get();
        $hasComment = $db->fetchAll($db->select()->from('table.comments')->where('cid = ?', $post->cid)->where('mail = ?', $post->remember('mail', true))->limit(1));
        if ($hasComment || $login) {
            $content = strtr($content, array("{hide}" => "", "{/hide}" => ""));
        } else {
            $content = preg_replace_callback(
                '/\{hide\}.{0,}\{\/hide\}/sSU',
                function () {
                    return '<span class="joe_detail__article-hide block">此处内容作者设置了 <i>回复</i> 可见</span>';
                },
                $content
            );
        }
    }

    /* 过滤网易云音乐 */
    if (strpos($content, '{music') !== false) {
        $content = preg_replace_callback(
            '/\{music-list\s{0,}id="(\w{0,})"\s{0,}\/\}/SU',
            function ($matches) {
                return '<iframe class="lazyload" data-src="//music.163.com/outchain/player?type=0&id=' . $matches[1] . '&auto=1&height=430" width="330" height="450"></iframe>';
            },
            $content
        );
        $content = preg_replace_callback(
            '/\{music\s{0,}id="(\w{0,})"\s{0,}\/\}/SU',
            function ($matches) {
                return '<iframe class="lazyload" data-src="//music.163.com/outchain/player?type=2&id=' . $matches[1] . '&auto=1&height=66" width="330" height="86"></iframe>';
            },
            $content
        );
    }

    /* 过滤dplayer播放器 */
    if (strpos($content, '{dplayer') !== false) {
        $content = preg_replace_callback(
            '/\{dplayer\s{0,}src="(.{0,})"\s{0,}\/\}/sSU',
            function ($matches) {
                $player = Helper::options()->JCustomPlayer ? Helper::options()->JCustomPlayer : '/usr/themes/Joe/library/player.php?url=';
                return '<iframe class="joe_detail__article-player block lazyload" allowfullscreen="true" data-src="' . $player . $matches[1] . '"></iframe>';
            },
            $content
        );
    }

    /* 过滤bilibili播放器 */
    if (strpos($content, '{bilibili') !== false) {
        $content = preg_replace_callback(
            '/\{bilibili\s{0,}bvid="(\w{0,})"\s{0,}\/\}/sSU',
            function ($matches) {
                return '<iframe class="joe_detail__article-player block lazyload" allowfullscreen="true" data-src="//player.bilibili.com/player.html?bvid=' . $matches[1] . '"></iframe>';
            },
            $content
        );
    }

    /* 过滤完成任务勾选 */
    if (strpos($content, '{x}') !== false || strpos($content, '{ }') !== false) {
        $content = strtr($content, array(
            "{x}" => '<input type="checkbox" class="joe_detail__article-checkbox" checked disabled></input>',
            "{ }" => '<input type="checkbox" class="joe_detail__article-checkbox" disabled></input>'
        ));
    }

    /* 过滤复制粘贴功能 */
    if (strpos($content, '{/copy}') !== false) {
        $content = preg_replace_callback(
            '/\{copy\s{0,}text="(.{0,})"\s{0,}\}(.{0,})\{\/copy\}/sSU',
            function ($matches) {
                return '<span data-clipboard-text="' . $matches[1] . '" class="joe_detail__article-copy">' . $matches[2] . '</span>';
            },
            $content
        );
    }

    /* 过滤居中标题 */
    if (strpos($content, '{/mtitle}') !== false) {
        $content = strtr($content, array(
            "{mtitle}" => '<span class="joe_detail__article-mtitle"><span class="text">',
            "{/mtitle}" => '</span></span>'
        ));
    }

    echo $content;
}
