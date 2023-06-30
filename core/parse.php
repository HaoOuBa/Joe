<?php

/* 过滤短代码 */
require_once('short.php');

function _checkXSS($text)
{
    $isXss = false;
    $list = array(
        '/onabort/is',
        '/onblur/is',
        '/onchange/is',
        '/onclick/is',
        '/ondblclick/is',
        '/onerror/is',
        '/onfocus/is',
        '/onkeydown/is',
        '/onkeypress/is',
        '/onkeyup/is',
        '/onload/is',
        '/onmousedown/is',
        '/onmousemove/is',
        '/onmouseout/is',
        '/onmouseover/is',
        '/onmouseup/is',
        '/onreset/is',
        '/onresize/is',
        '/onselect/is',
        '/onsubmit/is',
        '/onunload/is',
        '/eval/is',
        '/ascript:/is',
        '/style=/is',
        '/width=/is',
        '/width:/is',
        '/height=/is',
        '/height:/is',
        '/src=/is',
    );
    if (strip_tags($text)) {
        for ($i = 0; $i < count($list); $i++) {
            if (preg_match($list[$i], $text) > 0) {
                $isXss = true;
                break;
            }
        }
    } else {
        $isXss = true;
    };
    return $isXss;
}

/* 过滤评论回复 */
function _parseCommentReply($text)
{
    if (_checkXSS($text)) {
        echo "该回复疑似异常，已被系统拦截！";
    } else {
        $text = _parseReply($text);
        echo preg_replace('/\{!\{([^\"]*)\}!\}/', '<img class="lazyload draw_image" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="$1" alt="画图"/>', $text);
    }
}

/* 过滤表情 */
function _parseReply($text)
{
    $text = preg_replace_callback(
        '/\:\:\(\s*(呵呵|哈哈|吐舌|太开心|笑眼|花心|小乖|乖|捂嘴笑|滑稽|你懂的|不高兴|怒|汗|黑线|泪|真棒|喷|惊哭|阴险|鄙视|酷|啊|狂汗|what|疑问|酸爽|呀咩爹|委屈|惊讶|睡觉|笑尿|挖鼻|吐|犀利|小红脸|懒得理|勉强|爱心|心碎|玫瑰|礼物|彩虹|太阳|星星月亮|钱币|茶杯|蛋糕|大拇指|胜利|haha|OK|沙发|手纸|香蕉|便便|药丸|红领巾|蜡烛|音乐|灯泡|开心|钱|咦|呼|冷|生气|弱|吐血|狗头)\s*\)/is',
        function ($match) {
            return '<img class="owo_image lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="' . Helper::options()->themeUrl . '/assets/owo/paopao/' . str_replace('%', '', urlencode($match[1])) . '_2x.png" alt="表情"/>';
        },
        $text
    );
    $text = preg_replace_callback(
        '/\:\@\(\s*(高兴|小怒|脸红|内伤|装大款|赞一个|害羞|汗|吐血倒地|深思|不高兴|无语|亲亲|口水|尴尬|中指|想一想|哭泣|便便|献花|皱眉|傻笑|狂汗|吐|喷水|看不见|鼓掌|阴暗|长草|献黄瓜|邪恶|期待|得意|吐舌|喷血|无所谓|观察|暗地观察|肿包|中枪|大囧|呲牙|抠鼻|不说话|咽气|欢呼|锁眉|蜡烛|坐等|击掌|惊喜|喜极而泣|抽烟|不出所料|愤怒|无奈|黑线|投降|看热闹|扇耳光|小眼睛|中刀)\s*\)/is',
        function ($match) {
            return '<img class="owo_image lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="' . Helper::options()->themeUrl . '/assets/owo/aru/' . str_replace('%', '', urlencode($match[1])) . '_2x.png" alt="表情"/>';
        },
        $text
    );
    return $text;
}

/* 格式化留言回复 */
function _parseLeavingReply($text)
{
    if (_checkXSS($text)) {
        echo "该回复疑似异常，已被系统拦截！";
    } else {
        $text = strip_tags($text);
        $text = _parseReply($text);
        echo preg_replace('/\{!\{([^\"]*)\}!\}/', '<img class="draw_image" src="$1" alt="画图"/>', $text);
    }
}

/* 格式化侧边栏回复 */
function _parseAsideReply($text, $type = true)
{
    if (_checkXSS($text)) {
        echo "该回复疑似异常，已被系统拦截！";
    } else {
        $text = strip_tags($text);
        $text = preg_replace('/\{!\{([^\"]*)\}!\}/', '# 图片回复', $text);
        if ($type) echo _parseReply($text);
        else echo $text;
    }
}

/* 过滤侧边栏最新回复的跳转链接 */
function _parseAsideLink($link)
{
    echo str_replace("#", "?scroll=", $link);
}
