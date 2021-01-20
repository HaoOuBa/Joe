<?php


function _getVersion()
{
    return "1.0.0";
};

timerStart();
function timerStart()
{
    global $timeStart;
    $mTime     = explode(' ', microtime());
    $timeStart = $mTime[1] + $mTime[0];
    return true;
}
function timerStop($precision = 3)
{
    global $timeStart, $timeEnd;
    $mTime     = explode(' ', microtime());
    $timeEnd   = $mTime[1] + $mTime[0];
    $timeTotal = number_format($timeEnd - $timeStart, $precision);
    echo $timeTotal < 1 ? $timeTotal * 1000 . "ms" : $timeTotal . "s";
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
                ->where('status = ?', 'publish')
                ->where('type = ?', 'post')
                ->where('password IS NULL')
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
}
