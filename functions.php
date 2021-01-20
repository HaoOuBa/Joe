<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
require_once("core/core.php");
function themeConfig($form)
{
    $_db = Typecho_Db::get();
    $_prefix = $_db->getPrefix();
    try {
        if (!array_key_exists('view', $_db->fetchRow($_db->select()->from('table.contents')->page(1, 1)))) {
            $_db->query('ALTER TABLE `' . $_prefix . 'contents` ADD `view` INT DEFAULT 0;');
        }
        if (!array_key_exists('agree', $_db->fetchRow($_db->select()->from('table.contents')->page(1, 1)))) {
            $_db->query('ALTER TABLE `' . $_prefix . 'contents` ADD `agree` INT DEFAULT 0;');
        }
    } catch (Exception $e) {
    }
?>
    <link rel="stylesheet" href="<?php Helper::options()->themeUrl('assets/css/joe.config.css') ?>">
    <script src="<?php Helper::options()->themeUrl('assets/js/joe.config.js') ?>"></script>
    <div class="joe_config">
        <div>
            <div class="joe_config__aside">
                <div class="logo">Joe <?php echo _getVersion() ?></div>
                <ul class="tabs">
                    <li class="item" data-current="joe_notice">最新公告</li>
                    <li class="item" data-current="joe_global">全局设置</li>
                    <li class="item" data-current="joe_image">图片设置</li>
                    <li class="item" data-current="joe_post">文章设置</li>
                    <li class="item" data-current="joe_aside">侧栏设置</li>
                    <li class="item" data-current="joe_index">首页设置</li>
                    <li class="item" data-current="joe_other">其他设置</li>
                </ul>
                <?php require_once('core/backup.php'); ?>
            </div>
        </div>
        <div class="joe_config__notice">请求数据中...</div>
    <?php
    $JFavicon = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JFavicon',
        NULL,
        'https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/favicon.ico',
        '网站 Favicon 设置',
        '介绍：用于设置网站 Favicon，一个好的 Favicon 可以给用户一种很专业的观感 <br />
         格式：图片 URL地址 或 Base64 地址 <br />
         其他：免费转换 Favicon 网站 <a target="_blank" href="//tool.lu/favicon">tool.lu/favicon</a>'
    );
    $JFavicon->setAttribute('class', 'joe_content joe_image');
    $form->addInput($JFavicon);

    $JLogo = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JLogo',
        NULL,
        'https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/img/logo.png',
        '网站 Logo 设置',
        '介绍：用于设置网站 Logo，一个好的 Logo 能为网站带来有效的流量 <br />
         格式：图片 URL地址 或 Base64 地址 <br />
         其他：免费制作 logo 网站 <a target="_blank" href="//www.uugai.com">www.uugai.com</a>'
    );
    $JLogo->setAttribute('class', 'joe_content joe_image');
    $form->addInput($JLogo);

    $JNavMaxNum = new Typecho_Widget_Helper_Form_Element_Select(
        'JNavMaxNum',
        array(
            '3' => '3个（默认）',
            '4' => '4个',
            '5' => '5个',
            '6' => '6个',
            '7' => '7个',
        ),
        '3',
        '选择导航栏最大显示的个数',
        '介绍：用于设置最大多少个后，以更多下拉框显示'
    );
    $JNavMaxNum->setAttribute('class', 'joe_content joe_global');
    $form->addInput($JNavMaxNum->multiMode());

    $JAside = new Typecho_Widget_Helper_Form_Element_Checkbox(
        'JAside',
        array(
            'author' => '作者栏',
            'timelife' => '计时栏',
            'weather' => '天气栏（需先在下方填写KEY值）',
            'hot' => '热门文章栏',
            'ranking' => '排行榜栏',
        ),
        null,
        '选择首页需要显示的侧边栏栏目',
        '介绍：用于控制首页侧边栏的栏目显示规则 <br>
         注意：如果全部未选，则表示不开启侧边栏'
    );
    $JAside->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside->multiMode());

    $JAside_Author_Image = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JAside_Author_Image',
        NULL,
        "https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/img/aside_author_image.jpg",
        '作者栏 —— 背景',
        '介绍：用于修改作者栏的背景图片 <br/>
         格式：图片地址 <br />
         注意：不填写时，则显示默认背景'
    );
    $JAside_Author_Image->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Author_Image);

    $JAside_Author_Link = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JAside_Author_Link',
        NULL,
        "https://ae.js.cn",
        '作者栏 —— 跳转链接',
        '介绍：用于修改作者栏的跳转链接'
    );
    $JAside_Author_Link->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Author_Link);

    $JAside_Author_Motto = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JAside_Author_Motto',
        NULL,
        "有钱终成眷属，没钱亲眼目睹",
        '作者栏 —— 座右铭',
        '介绍：用于显示在侧边栏作者信息的座右铭。<br />
         格式：可以填写多行也可以填写一行，填写多行时，每次随机显示其中的某一条'
    );
    $JAside_Author_Motto->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Author_Motto);

    $JAside_Author_Nav = new Typecho_Widget_Helper_Form_Element_Select(
        'JAside_Author_Nav',
        array(
            'off' => '关闭（默认）',
            '3' => '开启，并显示3条最新文章',
            '4' => '开启，并显示4条最新文章',
            '5' => '开启，并显示5条最新文章',
            '6' => '开启，并显示6条最新文章',
            '7' => '开启，并显示7条最新文章',
            '8' => '开启，并显示8条最新文章',
            '9' => '开启，并显示9条最新文章',
            '10' => '开启，并显示10条最新文章'
        ),
        'off',
        '作者栏 —— 随机文章数目',
        '介绍：用于控制作者栏的随机文章条数'
    );
    $JAside_Author_Nav->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Author_Nav->multiMode());

    $JAside_Weather_Key = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JAside_Weather_Key',
        NULL,
        NULL,
        '天气栏 —— 天气KEY值',
        '介绍：用于初始化天气栏 <br/>
         注意：填写时请填写正确的KEY值！<br />
         其他：免费申请地址：<a href="//cj.weather.com.cn">cj.weather.com.cn</a>'
    );
    $JAside_Weather_Key->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Weather_Key);

    $JAside_Weather_Style = new Typecho_Widget_Helper_Form_Element_Select(
        'JAside_Weather_Style',
        array(
            '1' => '自动（默认）',
            '2' => '浅色',
            '3' => '深色'
        ),
        '1',
        '天气栏 —— 天气风格样式',
        '介绍：选择一款您所喜爱的天气风格 <br />
         注意：需要先填写天气的KEY值'
    );
    $JAside_Weather_Style->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Weather_Style->multiMode());

    $JAside_Hot_Num = new Typecho_Widget_Helper_Form_Element_Select(
        'JAside_Hot_Num',
        array(
            '3' => '显示3条（默认）',
            '4' => '显示4条',
            '5' => '显示5条',
            '6' => '显示6条',
            '7' => '显示7条',
            '8' => '显示8条',
            '9' => '显示9条',
            '10' => '显示10条',
        ),
        '3',
        '热门文章栏 —— 文章数',
        '介绍：用于控制热门文章栏目的数量'
    );
    $JAside_Hot_Num->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Hot_Num->multiMode());

    $JAside_Ranking = new Typecho_Widget_Helper_Form_Element_Select(
        'JAside_Ranking',
        array(
            '知乎全站排行榜$zhihu_total' => '知乎全站排行榜',
            '知乎科学排行榜$zhihu_science' => '知乎科学排行榜',
            '知乎数码排行榜$zhihu_digital' => '知乎数码排行榜',
            '知乎体育排行榜$zhihu_sport' => '知乎体育排行榜',
            '知乎时尚排行榜$zhihu_fashion' => '知乎时尚排行榜',
            '微博热搜榜$weibo' => '微博热搜榜',
            '微博新闻榜$weibo_news' => '微博新闻榜',
            '360实时热点$so_hotnews' => '360实时热点',
            '百度实时热点$baidu_ssrd' => '百度实时热点',
            '百度今日热点$baidu_today' => '百度今日热点',
            '百度七日热点$baidu_week' => '百度七日热点',
            '百度体育热点$baidu_sport' => '百度体育热点',
            '百度娱乐热点$baidu_yule' => '百度娱乐热点',
            '百度民生热点$baidu_minsheng' => '百度民生热点',
            '历史今天$lssdjt' => '历史今天',
            '网易24H新闻点击榜$t_en_dianji' => '网易24H新闻点击榜',
            '网易今日跟贴榜$t_en_today' => '网易今日跟贴榜',
            '网易1小时前点击榜$t_en_hour' => '网易1小时前点击榜',
            '网易娱乐跟贴榜$t_en_yule' => '网易娱乐跟贴榜',
            'CNBA点击榜$cnbeta_hot' => 'CNBA点击榜',
            'CNBA评论榜$cnbeta_comment' => 'CNBA评论榜',
            '虎嗅热文榜$huxiu' => '虎嗅热文榜',
            'IT之家24H最热榜$ithome_day' => 'IT之家24H最热榜',
            'IT之家一周最热榜$ithome_week' => 'IT之家一周最热榜',
            'IT之家月度热文榜$ithome_month' => 'IT之家月度热文榜',
            '36KR人气榜$kr_renqi' => '36KR人气榜',
            '36KR收藏榜$kr_shoucang' => '36KR收藏榜',
            '36KR综合榜$kr_zonghe' => '36KR综合榜',
            '少数派热文榜$sspai' => '少数派热文榜',
            '豆瓣新片榜$douban_day' => '豆瓣新片榜',
            '豆瓣口碑榜$douban_week' => '豆瓣口碑榜',
            '豆瓣北美榜$douban_na' => '豆瓣北美榜',
            '豆瓣京东畅销榜$douban_jd' => '豆瓣京东畅销榜',
            '豆瓣当当畅销榜$douban_dd' => '豆瓣当当畅销榜',
            '观察者24H最热榜$guancha_day' => '观察者24H最热榜',
            '观察者3天最热榜$guancha_three' => '观察者3天最热榜',
            '观察者一周最热榜$guancha_week' => '观察者一周最热榜',
            '晋江文学月排行榜$jjwxc_month' => '晋江文学月排行榜',
            '晋江文学季度榜$jjwxc_quater' => '晋江文学季度榜',
            '晋江文学总分榜$jjwxc_rank' => '晋江文学总分榜',
            '澎湃热门新闻榜$ppnews_day' => '澎湃热门新闻榜',
            '澎湃3天最热新闻榜$ppnews_three' => '澎湃3天最热新闻榜',
            '澎湃一周最热新闻榜$ppnews_week' => '澎湃一周最热新闻榜',
            '起点24小时畅销榜$qidian_day' => '起点24小时畅销榜',
            '起点周阅读指数榜$qidian_week' => '起点周阅读指数榜',
            '起点风云榜$qidian_fy' => '起点风云榜',
            '爱范儿热文排行榜$ifanr' => '爱范儿热文排行榜',
            'ACFun日榜$acfun_day' => 'ACFun日榜',
            'ACFun三日榜$acfun_three_days' => 'ACFun三日榜',
            'ACFun三日榜$acfun_three_days' => 'ACFun三日榜',
            'ACFun七日榜$acfun_week' => 'ACFun七日榜',
            'ACFun七日榜$acfun_week' => 'ACFun七日榜',
            '腾讯视频热门榜$qq_v' => '腾讯视频热门榜',
            'bilibili排行榜$bsite' => 'bilibili排行榜',
            'V2EX热门榜$vsite' => 'V2EX热门榜',
            '52破解热门榜$t_pj_hot' => '52破解热门榜',
            '52破解人气榜$t_pj_renqi' => '52破解人气榜',
            '52破解精品榜$t_pj_soft' => '52破解精品榜',
            '抖音视频榜$t_dy_hot' => '抖音视频榜',
            '抖音正能量榜$t_dy_right' => '抖音正能量榜',
            '抖音搜索榜$t_dy_s' => '抖音搜索榜',
            '汽车之家热门榜$t_auto_art' => '汽车之家热门榜',
            '汽车之家3日最热榜$t_auto_video' => '汽车之家3日最热榜',
            '今日头条周热榜$t_tt_week' => '今日头条周热榜',
            '看看新闻热点榜$kankan' => '看看新闻热点榜',
            '新京报今日热门榜$xingjing' => '新京报今日热门榜',
            '新京报本周热门榜$xingjing_week' => '新京报本周热门榜',
            '新京报本月热门榜$xingjing_month' => '新京报本月热门榜',
            'Zaker新闻榜$zaker' => 'Zaker新闻榜',
            '雪球话题榜$xueqiu' => '雪球话题榜',
            '天涯论坛热帖榜$tianya_retie' => '天涯论坛热帖榜',
            '钛媒体热文榜$tmtpost' => '钛媒体热文榜',
            'techweb排行榜$techweb' => 'techweb排行榜',
            '爱卡汽车热点榜$xcar_ssrd' => '爱卡汽车热点榜',
            '爱卡汽车人气榜$xcar_rq' => '爱卡汽车人气榜',
            '爱卡汽车关注榜$xcar_gz' => '爱卡汽车关注榜',
            '太平洋汽车热文榜$pcauto_art' => '太平洋汽车热文榜',
            '太平洋汽车热贴榜$pcauto_tie' => '太平洋汽车热贴榜',
            '新浪点击榜$sina_dj' => '新浪点击榜',
            '新浪评论榜$sina_pl' => '新浪评论榜',
            '新浪视频榜$sina_vd' => '新浪视频榜',
            '新浪图片榜$sina_pic' => '新浪图片榜'
        ),
        '知乎全站排行榜$zhihu_total',
        '选择排行榜类型',
        '介绍：用于控制侧边栏排行榜所显示的类型'
    );
    $JAside_Ranking->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Ranking->multiMode());

    $JThumbnail = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JThumbnail',
        NULL,
        NULL,
        '自定义缩略图',
        '介绍：用于修改主题默认缩略图 <br/>
         格式：图片地址，一行一个 <br />
         注意：不填写时，则使用主题内置的默认缩略图
         '
    );
    $JThumbnail->setAttribute('class', 'joe_content joe_image');
    $form->addInput($JThumbnail);

    $JLazyload = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JLazyload',
        NULL,
        "https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/img/lazyload.jpg",
        '自定义懒加载图',
        '介绍：用于修改主题默认懒加载图 <br/>
         格式：图片地址'
    );
    $JLazyload->setAttribute('class', 'joe_content joe_image');
    $form->addInput($JLazyload);
} ?>