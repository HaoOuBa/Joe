<?php

require_once("phpmailer.php");
require_once("smtp.php");

/* 加强评论拦截功能 */
Typecho_Plugin::factory('Widget_Feedback')->comment = array('Intercept', 'message');
class Intercept
{
    public static function message($comment)
    {
        /* 用户输入内容画图模式 */
        if (preg_match('/\{!\{(.*)\}!\}/', $comment['text'], $matches)) {
            /* 如果判断是否有双引号，如果有双引号，则禁止评论 */
            if (strpos($matches[1], '"') !== false || _checkXSS($matches[1])) {
                $comment['status'] = 'waiting';
            }
            /* 普通评论 */
        } else {
            /* 判断用户输入是否大于字符 */
            if (Helper::options()->JTextLimit && strlen($comment['text']) > Helper::options()->JTextLimit) {
                $comment['status'] = 'waiting';
            } else {
                /* 判断评论内容是否包含敏感词 */
                if (Helper::options()->JSensitiveWords) {
                    if (_checkSensitiveWords(Helper::options()->JSensitiveWords, $comment['text'])) {
                        $comment['status'] = 'waiting';
                    }
                }
                /* 判断评论是否至少包含一个中文 */
                if (Helper::options()->JLimitOneChinese === "on") {
                    if (preg_match("/[\x{4e00}-\x{9fa5}]/u", $comment['text']) == 0) {
                        $comment['status'] = 'waiting';
                    }
                }
            }
        }
        Typecho_Cookie::delete('__typecho_remember_text');
        return $comment;
    }
}

/* 邮件通知 */
if (
    Helper::options()->JCommentMail === 'on' &&
    Helper::options()->JCommentMailHost &&
    Helper::options()->JCommentMailPort &&
    Helper::options()->JCommentMailFromName &&
    Helper::options()->JCommentMailAccount &&
    Helper::options()->JCommentMailPassword &&
    Helper::options()->JCommentSMTPSecure
) {
    Typecho_Plugin::factory('Widget_Feedback')->finishComment = array('Email', 'send');
}

class Email
{
    public static function send($comment)
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->CharSet = 'UTF-8';
        $mail->SMTPSecure = Helper::options()->JCommentSMTPSecure;
        $mail->Host = Helper::options()->JCommentMailHost;
        $mail->Port = Helper::options()->JCommentMailPort;
        $mail->FromName = Helper::options()->JCommentMailFromName;
        $mail->Username = Helper::options()->JCommentMailAccount;
        $mail->From = Helper::options()->JCommentMailAccount;
        $mail->Password = Helper::options()->JCommentMailPassword;
        $mail->isHTML(true);
        $text = $comment->text;
        $text = preg_replace_callback(
            '/\:\:\(\s*(呵呵|哈哈|吐舌|太开心|笑眼|花心|小乖|乖|捂嘴笑|滑稽|你懂的|不高兴|怒|汗|黑线|泪|真棒|喷|惊哭|阴险|鄙视|酷|啊|狂汗|what|疑问|酸爽|呀咩爹|委屈|惊讶|睡觉|笑尿|挖鼻|吐|犀利|小红脸|懒得理|勉强|爱心|心碎|玫瑰|礼物|彩虹|太阳|星星月亮|钱币|茶杯|蛋糕|大拇指|胜利|haha|OK|沙发|手纸|香蕉|便便|药丸|红领巾|蜡烛|音乐|灯泡|开心|钱|咦|呼|冷|生气|弱|吐血|狗头)\s*\)/is',
            function ($match) {
                return '<img style="max-height: 22px;" src="' . Helper::options()->themeUrl . '/assets/owo/paopao/' . str_replace('%', '', urlencode($match[1])) . '_2x.png"/>';
            },
            $text
        );
        $text = preg_replace_callback(
            '/\:\@\(\s*(高兴|小怒|脸红|内伤|装大款|赞一个|害羞|汗|吐血倒地|深思|不高兴|无语|亲亲|口水|尴尬|中指|想一想|哭泣|便便|献花|皱眉|傻笑|狂汗|吐|喷水|看不见|鼓掌|阴暗|长草|献黄瓜|邪恶|期待|得意|吐舌|喷血|无所谓|观察|暗地观察|肿包|中枪|大囧|呲牙|抠鼻|不说话|咽气|欢呼|锁眉|蜡烛|坐等|击掌|惊喜|喜极而泣|抽烟|不出所料|愤怒|无奈|黑线|投降|看热闹|扇耳光|小眼睛|中刀)\s*\)/is',
            function ($match) {
                return '<img style="max-height: 22px;" src="' . Helper::options()->themeUrl . '/assets/owo/aru/' . str_replace('%', '', urlencode($match[1])) . '_2x.png"/>';
            },
            $text
        );
        $text = preg_replace('/\{!\{([^\"]*)\}!\}/', '<img style="max-width: 100%;vertical-align: middle;" src="$1"/>', $text);
        $html = '
            <style>.Joe{width:550px;margin:0 auto;border-radius:8px;overflow:hidden;font-family:"Helvetica Neue",Helvetica,"PingFang SC","Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;box-shadow:0 2px 12px 0 rgba(0,0,0,0.1);word-break:break-all}.Joe_title{color:#fff;background:linear-gradient(-45deg,rgba(9,69,138,0.2),rgba(68,155,255,0.7),rgba(117,113,251,0.7),rgba(68,155,255,0.7),rgba(9,69,138,0.2));background-size:400% 400%;background-position:50% 100%;padding:15px;font-size:15px;line-height:1.5}</style>
            <div class="Joe"><div class="Joe_title">{title}</div><div style="background: #fff;padding: 20px;font-size: 13px;color: #666;"><div style="margin-bottom: 20px;line-height: 1.5;">{subtitle}</div><div style="padding: 15px;margin-bottom: 20px;line-height: 1.5;background: repeating-linear-gradient(145deg, #f2f6fc, #f2f6fc 15px, #fff 0, #fff 25px);">{content}</div><div style="line-height: 2">请注意：此邮件由系统自动发送，请勿直接回复。<br>若此邮件不是您请求的，请忽略并删除！</div></div></div>
        ';
        /* 如果是博主发的评论 */
        if ($comment->authorId == $comment->ownerId) {
            /* 发表的评论是回复别人 */
            if ($comment->parent != 0) {
                $db = Typecho_Db::get();
                $parentInfo = $db->fetchRow($db->select('mail')->from('table.comments')->where('coid = ?', $comment->parent));
                $parentMail = $parentInfo['mail'];
                /* 被回复的人不是自己时，发送邮件 */
                if ($parentMail != $comment->mail) {
                    $mail->Body = strtr(
                        $html,
                        array(
                            "{title}" => '您在 [' . $comment->title . '] 的评论有了新的回复！',
                            "{subtitle}" => '博主：[ ' . $comment->author . ' ] 在《 <a style="color: #12addb;text-decoration: none;" href="' . substr($comment->permalink, 0, strrpos($comment->permalink, "#")) . '" target="_blank">' . $comment->title . '</a> 》上回复了您:',
                            "{content}" => $text,
                        )
                    );
                    $mail->addAddress($parentMail);
                    $mail->Subject = '您在 [' . $comment->title . '] 的评论有了新的回复！';
                    $mail->send();
                }
            }
            /* 如果是游客发的评论 */
        } else {
            /* 如果是直接发表的评论，不是回复别人，那么发送邮件给博主 */
            if ($comment->parent == 0) {
                $db = Typecho_Db::get();
                $authoInfo = $db->fetchRow($db->select()->from('table.users')->where('uid = ?', $comment->ownerId));
                $authorMail = $authoInfo['mail'];
                if ($authorMail) {
                    $mail->Body = strtr(
                        $html,
                        array(
                            "{title}" => '您的文章 [' . $comment->title . '] 收到一条新的评论！',
                            "{subtitle}" => $comment->author . ' [' . $comment->ip . '] 在您的《 <a style="color: #12addb;text-decoration: none;" href="' . substr($comment->permalink, 0, strrpos($comment->permalink, "#")) . '" target="_blank">' . $comment->title . '</a> 》上发表评论:',
                            "{content}" => $text,
                        )
                    );
                    $mail->addAddress($authorMail);
                    $mail->Subject = '您的文章 [' . $comment->title . '] 收到一条新的评论！';
                    $mail->send();
                }
                /* 如果发表的评论是回复别人 */
            } else {
                $db = Typecho_Db::get();
                $parentInfo = $db->fetchRow($db->select('mail')->from('table.comments')->where('coid = ?', $comment->parent));
                $parentMail = $parentInfo['mail'];
                /* 被回复的人不是自己时，发送邮件 */
                if ($parentMail != $comment->mail) {
                    $mail->Body = strtr(
                        $html,
                        array(
                            "{title}" => '您在 [' . $comment->title . '] 的评论有了新的回复！',
                            "{subtitle}" => $comment->author . ' 在《 <a style="color: #12addb;text-decoration: none;" href="' . substr($comment->permalink, 0, strrpos($comment->permalink, "#")) . '" target="_blank">' . $comment->title . '</a> 》上回复了您:',
                            "{content}" => $text,
                        )
                    );
                    $mail->addAddress($parentMail);
                    $mail->Subject = '您在 [' . $comment->title . '] 的评论有了新的回复！';
                    $mail->send();
                }
            }
        }
    }
}




/* 加强后台编辑器功能 */
if (Helper::options()->JEditor !== 'off') {
    Typecho_Plugin::factory('admin/write-post.php')->richEditor  = array('Editor', 'Edit');
    Typecho_Plugin::factory('admin/write-page.php')->richEditor  = array('Editor', 'Edit');
}

class Editor
{
    public static function Edit()
    {
?>
        <link rel="stylesheet" href="https://fastly.jsdelivr.net/npm/aplayer@1.10.1/dist/APlayer.min.css">
        <link rel="stylesheet" href="https://fastly.jsdelivr.net/npm/prism-theme-one-light-dark@1.0.4/prism-onedark.min.css">
        <link rel="stylesheet" href="<?php Helper::options()->themeUrl('typecho/write/css/joe.write.min.css') ?>">
        <script>
            window.JoeConfig = {
                uploadAPI: '<?php Helper::security()->index('/action/upload'); ?>',
                emojiAPI: '<?php Helper::options()->themeUrl('typecho/write/json/emoji.json') ?>',
                expressionAPI: '<?php Helper::options()->themeUrl('typecho/write/json/expression.json') ?>',
                characterAPI: '<?php Helper::options()->themeUrl('typecho/write/json/character.json') ?>',
                playerAPI: '<?php Helper::options()->JCustomPlayer ? Helper::options()->JCustomPlayer() : Helper::options()->themeUrl('library/player.php?url=') ?>',
                autoSave: <?php Helper::options()->autoSave(); ?>,
                themeURL: '<?php Helper::options()->themeUrl(); ?>',
                canPreview: false
            }
        </script>
        <script src="https://fastly.jsdelivr.net/npm/aplayer@1.10.1/dist/APlayer.min.js"></script>
        <script src="https://fastly.jsdelivr.net/npm/typecho-joe-next@6.2.4/plugin/prism/prism.min.js"></script>
        <script src="<?php Helper::options()->themeUrl('typecho/write/parse/parse.min.js') ?>"></script>
        <script src="<?php Helper::options()->themeUrl('typecho/write/dist/index.bundle.js') ?>"></script>
        <script src="<?php Helper::options()->themeUrl('assets/js/joe.short.min.js') ?>"></script>
<?php
    }
}
