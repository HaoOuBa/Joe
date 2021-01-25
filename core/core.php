<?php

/* 页面加载计时 */
_startCountTime();

/* 主题开发API */
require_once('route.php');

/* 主题初始化 */
function themeInit($self)
{

    /* 主题开放API 路由规则 */
    $path_info = $self->request->getPathinfo();
    if ($path_info === "/joe/api") {
        switch ($self->request->routeType) {
            case 'aside_ranking':
                _getRanking($self);
                break;
            case 'publish_list':
                _getPost($self);
                break;
            case 'baidu_record':
                _getRecord($self);
                break;
            case 'handle_views':
                _handleViews($self);
                break;
            case 'handle_agree':
                _handleAgree($self);
                break;
        };
    }
}

/* 主题版本号 */
function _getVersion()
{
    return "1.0.0";
};

function _isMobile()
{
    if (isset($_SERVER['HTTP_X_WAP_PROFILE']))
        return true;
    if (isset($_SERVER['HTTP_VIA'])) {
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile');
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            return true;
    }
    if (isset($_SERVER['HTTP_ACCEPT'])) {
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}

/* 获取加密的文章标题 */
function _getEncryptionTitle($item, $type = true)
{
    $title = "";
    if ($item->hidden) {
        $db = Typecho_Db::get();
        $title = $db->fetchRow($db->select('title')->from('table.contents')->where('cid = ?', $item->cid))['title'];
    } else {
        $title = $item->title;
    }
    if ($type) echo $title;
    else return $title;
}

/* 过滤文章内容 */
function _parseContent($post)
{
    /* 优先判断文章内是否有回复可见的内容 */
    $content = $post->content;
    if (preg_match('/\[hide\].*\[\/hide\]/', $content)) {
        $db = Typecho_Db::get();
        $hasComment = $db->fetchAll($db->select()->from('table.comments')->where('cid = ?', $post->cid)->where('mail = ?', $post->remember('mail', true))->limit(1));
        if ($hasComment) {
            $content = preg_replace('/\[hide\](.*?)\[\/hide\]/sm', '$1', $content);
        } else {
            $content = preg_replace('/\[hide\](.*?)\[\/hide\]/sm', '<span class="joe_detail__article-hide block">此处内容 <i data-scroll="comment">回复</i> 可见</span>', $content);
        }
    }
    echo $content;
}

function _startCountTime()
{
    global $timeStart;
    $mTime     = explode(' ', microtime());
    $timeStart = $mTime[1] + $mTime[0];
    return true;
}

function _endCountTime($precision = 3)
{
    global $timeStart, $timeEnd;
    $mTime     = explode(' ', microtime());
    $timeEnd   = $mTime[1] + $mTime[0];
    $timeTotal = number_format($timeEnd - $timeStart, $precision);
    echo $timeTotal < 1 ? $timeTotal * 1000 . 'ms' : $timeTotal . 's';
}

function _getAvatarByMail($mail)
{
    $gravatarsUrl = 'https://gravatar.helingqi.com/wavatar/';
    $mailLower = strtolower($mail);
    $md5MailLower = md5($mailLower);
    $qqMail = str_replace('@qq.com', '', $mailLower);
    if (strstr($mailLower, "qq.com") && is_numeric($qqMail) && strlen($qqMail) < 11 && strlen($qqMail) > 4) {
        echo 'https://thirdqq.qlogo.cn/g?b=qq&nk=' . $qqMail . '&s=100';
    } else {
        echo $gravatarsUrl . $md5MailLower . '?d=mm';
    }
};

function _getAsideAuthorMotto()
{
    $JMottoRandom = explode("\r\n", Helper::options()->JAside_Author_Motto);
    echo $JMottoRandom[array_rand($JMottoRandom, 1)];
}

function _getAbstract($item, $type = true)
{
    $abstract = "";
    if ($item->password) {
        $abstract = "本篇文章为加密文章，请前往内页查看详情";
    } else {
        if ($item->fields->abstract) {
            $abstract = $item->fields->abstract;
        } else {
            $abstract = strip_tags($item->excerpt);
        }
    }
    if ($type) {
        echo $abstract;
    } else {
        return $abstract;
    }
}

function _getThumbnail($item, $type = true)
{
    $randomThumb = 'https://cdn.jsdelivr.net/npm/typecho_joe_theme@4.3.5/assets/img/random/' . rand(1, 25) . '.webp';
    $custom_thumbnail = Helper::options()->JThumbnail;
    if ($custom_thumbnail) {
        $custom_thumbnail_arr = explode("\r\n", $custom_thumbnail);
        $randomThumb = $custom_thumbnail_arr[array_rand($custom_thumbnail_arr, 1)] . "?key=" . mt_rand(0, 1000000);
    }
    $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
    $patternMD = '/\!\[.*?\]\((http(s)?:\/\/.*?(jpg|jpeg|gif|png|webp))/i';
    $patternMDfoot = '/\[.*?\]:\s*(http(s)?:\/\/.*?(jpg|jpeg|gif|png|webp))/i';
    if ($item->fields->thumb) {
        $randomThumb = $item->fields->thumb;
    } elseif (preg_match_all($pattern, $item->content, $thumbUrl)) {
        $randomThumb = $thumbUrl[1][0];
    } elseif (preg_match_all($patternMD, $item->content, $thumbUrl)) {
        $randomThumb = $thumbUrl[1][0];
    } elseif (preg_match_all($patternMDfoot, $item->content, $thumbUrl)) {
        $randomThumb = $thumbUrl[1][0];
    }
    if ($type) echo $randomThumb;
    else return $randomThumb;
}

function _getViews($item, $type = true)
{
    $db = Typecho_Db::get();
    $result = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $item->cid))['views'];
    if ($type) echo number_format($result);
    else return number_format($result);
}

function _getAgree($item, $type = true)
{
    $db = Typecho_Db::get();
    $result = $db->fetchRow($db->select('agree')->from('table.contents')->where('cid = ?', $item->cid))['agree'];
    if ($type) echo number_format($result);
    else return number_format($result);
}

function _parseAsideLink($link)
{
    echo str_replace("#", "?scroll=", $link);
}


function _parseAsideReply($text, $type = true)
{
    if ($type) echo _parseReply(preg_replace('~{!{.*~', '# 图片回复', strip_tags($text)));
    else echo preg_replace('~{!{.*~', '# 图片回复', strip_tags($text));
}

function _parseReply($text)
{
    $text = preg_replace_callback(
        '/\:\:\(\s*(呵呵|哈哈|吐舌|太开心|笑眼|花心|小乖|乖|捂嘴笑|滑稽|你懂的|不高兴|怒|汗|黑线|泪|真棒|喷|惊哭|阴险|鄙视|酷|啊|狂汗|what|疑问|酸爽|呀咩爹|委屈|惊讶|睡觉|笑尿|挖鼻|吐|犀利|小红脸|懒得理|勉强|爱心|心碎|玫瑰|礼物|彩虹|太阳|星星月亮|钱币|茶杯|蛋糕|大拇指|胜利|haha|OK|沙发|手纸|香蕉|便便|药丸|红领巾|蜡烛|音乐|灯泡|开心|钱|咦|呼|冷|生气|弱|吐血)\s*\)/is',
        function ($match) {
            return '<img class="owo_image" alt="表情" src="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/owo/paopao/' . str_replace('%', '', urlencode($match[1])) . '_2x.png" />';
        },
        $text
    );
    $text = preg_replace_callback(
        '/\:\@\(\s*(高兴|小怒|脸红|内伤|装大款|赞一个|害羞|汗|吐血倒地|深思|不高兴|无语|亲亲|口水|尴尬|中指|想一想|哭泣|便便|献花|皱眉|傻笑|狂汗|吐|喷水|看不见|鼓掌|阴暗|长草|献黄瓜|邪恶|期待|得意|吐舌|喷血|无所谓|观察|暗地观察|肿包|中枪|大囧|呲牙|抠鼻|不说话|咽气|欢呼|锁眉|蜡烛|坐等|击掌|惊喜|喜极而泣|抽烟|不出所料|愤怒|无奈|黑线|投降|看热闹|扇耳光|小眼睛|中刀)\s*\)/is',
        function ($match) {
            return '<img class="owo_image" alt="表情" src="https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/owo/paopao/' . str_replace('%', '', urlencode($match[1])) . '_2x.png">';
        },
        $text
    );
    return $text;
}


function _getLazyload($type = true)
{
    if ($type) echo Helper::options()->JLazyload;
    else return Helper::options()->JLazyload;
}

function _getAvatarLazyload($type = true)
{
    if ($type) echo "https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/img/lazyload_avatar.png";
    else return "https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/img/lazyload_avatar.png";
}

function _getAsideAuthorNav()
{
    if (Helper::options()->JAside_Author_Nav !== "off") {
        $db = Typecho_Db::get();
        $adapterName = $db->getAdapterName();
        if ($adapterName == 'pgsql' || $adapterName == 'Pdo_Pgsql' || $adapterName == 'Pdo_SQLite' || $adapterName == 'SQLite') {
            $order_by = 'RANDOM()';
        } else {
            $order_by = 'RAND()';
        }
        $result = $db->fetchAll(
            $db->select()
                ->from('table.contents')
                ->where('table.contents.status = ?', 'publish')
                ->where('table.contents.type = ?', 'post')
                ->where("table.contents.password IS NULL OR table.contents.password = ''")
                ->limit(Helper::options()->JAside_Author_Nav)
                ->order($order_by)
        );
        foreach ($result as $item) {
            $obj = Typecho_Widget::widget('Widget_Abstract_Contents');
            $item = $obj->push($item);
            $title = htmlspecialchars($item['title']);
            $permalink = $item['permalink'];
            echo "
                    <li class='item'>
                        <a class='link' href='{$permalink}' title='{$title}'>{$title}</a>
                        <svg class='icon' viewBox='0 0 1024 1024' version='1.1' xmlns='http://www.w3.org/2000/svg' width='16' height='16'>
							<path d='M448.12 320.331a30.118 30.118 0 0 1-42.616-42.586L552.568 130.68a213.685 213.685 0 0 1 302.2 0l38.552 38.551a213.685 213.685 0 0 1 0 302.2L746.255 618.497a30.118 30.118 0 0 1-42.586-42.616l147.034-147.035a153.45 153.45 0 0 0 0-217.028l-38.55-38.55a153.45 153.45 0 0 0-216.998 0L448.12 320.33zM575.88 703.67a30.118 30.118 0 0 1 42.616 42.586L471.432 893.32a213.685 213.685 0 0 1-302.2 0l-38.552-38.551a213.685 213.685 0 0 1 0-302.2l147.065-147.065a30.118 30.118 0 0 1 42.586 42.616L173.297 595.125a153.45 153.45 0 0 0 0 217.027l38.55 38.551a153.45 153.45 0 0 0 216.998 0L575.88 703.64z m-234.256-63.88L639.79 341.624a30.118 30.118 0 0 1 42.587 42.587L384.21 682.376a30.118 30.118 0 0 1-42.587-42.587z' p-id='7351'></path>
						</svg>
                    </li>
                ";
        }
    }
}

function themeFields($layout)
{
    $aside = new Typecho_Widget_Helper_Form_Element_Radio(
        'aside',
        array(
            'on' => '开启',
            'off' => '关闭'
        ),
        'on',
        '是否开启当前页面的侧边栏',
        '介绍：用于单独设置当前页侧边栏的开启状态 <br /> 
         注意：只有在外观设置侧边栏开启状态下生效'
    );
    $layout->addItem($aside);

    $thumb = new Typecho_Widget_Helper_Form_Element_Textarea(
        'thumb',
        NULL,
        NULL,
        '自定义文章缩略图',
        '填写时：将会显示填写的文章缩略图 <br>
         不填写时：<br>
            1、若文章有图片则取文章内图片 <br>
            2、若文章无图片，并且外观设置里未填写·自定义缩略图·选项，则取模板自带图片 <br>
            3、若文章无图片，并且外观设置里填写了·自定义缩略图·选项，则取自定义缩略图图片'
    );
    $layout->addItem($thumb);

    $abstract = new Typecho_Widget_Helper_Form_Element_Textarea(
        'abstract',
        NULL,
        NULL,
        '自定义文章摘要',
        '填写时：将会显示填写的摘要 <br>
         不填写时：默认取文章里的内容'
    );
    $layout->addItem($abstract);
}

class Widget_Contents_Hot extends Widget_Abstract_Contents
{
    public function execute()
    {
        $this->parameter->setDefault(array('pageSize' => 10));
        $this->db->fetchAll(
            $this->select()->from('table.contents')
                ->where("table.contents.password IS NULL OR table.contents.password = ''")
                ->where('table.contents.status = ?', 'publish')
                ->where('table.contents.created <= ?', time())
                ->where('table.contents.type = ?', 'post')
                ->limit($this->parameter->pageSize)
                ->order('table.contents.views', Typecho_Db::SORT_DESC),
            array($this, 'push')
        );
    }
}

class Widget_Contents_Sort extends Widget_Abstract_Contents
{
    public function execute()
    {
        $this->parameter->setDefault(array('page' => 1, 'pageSize' => 10, 'type' => 'created'));
        $offset = $this->parameter->pageSize * ($this->parameter->page - 1);
        $this->db->fetchAll(
            $this->select()
                ->from('table.contents')
                ->where('table.contents.type = ?', 'post')
                ->where('table.contents.status = ?', 'publish')
                ->limit($this->parameter->pageSize)
                ->offset($offset)
                ->order($this->parameter->type, Typecho_Db::SORT_DESC),
            array($this, 'push')
        );
    }
}
