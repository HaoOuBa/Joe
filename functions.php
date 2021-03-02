<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/* Joe核心文件 */
require_once("core/core.php");

function themeConfig($form)
{
    $_db = Typecho_Db::get();
    $_prefix = $_db->getPrefix();
    try {
        if (!array_key_exists('views', $_db->fetchRow($_db->select()->from('table.contents')->page(1, 1)))) {
            $_db->query('ALTER TABLE `' . $_prefix . 'contents` ADD `views` INT DEFAULT 0;');
        }
        if (!array_key_exists('agree', $_db->fetchRow($_db->select()->from('table.contents')->page(1, 1)))) {
            $_db->query('ALTER TABLE `' . $_prefix . 'contents` ADD `agree` INT DEFAULT 0;');
        }
    } catch (Exception $e) {
    }
?>
    <link rel="stylesheet" href="<?php Helper::options()->themeUrl('typecho/config/joe.config.css') ?>">
    <script src="<?php Helper::options()->themeUrl('typecho/config/joe.config.js') ?>"></script>
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

    $JCustomNavs = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JCustomNavs',
        NULL,
        NULL,
        '导航栏自定义链接（非必填）',
        '介绍：用于自定义导航栏链接 <br />
         格式：跳转文字 || 跳转链接（中间使用两个竖杠分隔）<br />
         其他：一行一个，一行代表一个超链接 <br />
         例如：<br />
            百度一下 || https://baidu.com <br />
            腾讯视频 || https://v.qq.com
         '
    );
    $JCustomNavs->setAttribute('class', 'joe_content joe_global');
    $form->addInput($JCustomNavs);

    $JList_Animate = new Typecho_Widget_Helper_Form_Element_Select(
        'JList_Animate',
        array(
            'off' => '关闭（默认）',
            'bounce' => 'bounce',
            'flash' => 'flash',
            'pulse' => 'pulse',
            'rubberBand' => 'rubberBand',
            'headShake' => 'headShake',
            'swing' => 'swing',
            'tada' => 'tada',
            'wobble' => 'wobble',
            'jello' => 'jello',
            'heartBeat' => 'heartBeat',
            'bounceIn' => 'bounceIn',
            'bounceInDown' => 'bounceInDown',
            'bounceInLeft' => 'bounceInLeft',
            'bounceInRight' => 'bounceInRight',
            'bounceInUp' => 'bounceInUp',
            'bounceOut' => 'bounceOut',
            'bounceOutDown' => 'bounceOutDown',
            'bounceOutLeft' => 'bounceOutLeft',
            'bounceOutRight' => 'bounceOutRight',
            'bounceOutUp' => 'bounceOutUp',
            'fadeIn' => 'fadeIn',
            'fadeInDown' => 'fadeInDown',
            'fadeInDownBig' => 'fadeInDownBig',
            'fadeInLeft' => 'fadeInLeft',
            'fadeInLeftBig' => 'fadeInLeftBig',
            'fadeInRight' => 'fadeInRight',
            'fadeInRightBig' => 'fadeInRightBig',
            'fadeInUp' => 'fadeInUp',
            'fadeInUpBig' => 'fadeInUpBig',
            'fadeOut' => 'fadeOut',
            'fadeOutDown' => 'fadeOutDown',
            'fadeOutDownBig' => 'fadeOutDownBig',
            'fadeOutLeft' => 'fadeOutLeft',
            'fadeOutLeftBig' => 'fadeOutLeftBig',
            'fadeOutRight' => 'fadeOutRight',
            'fadeOutRightBig' => 'fadeOutRightBig',
            'fadeOutUp' => 'fadeOutUp',
            'fadeOutUpBig' => 'fadeOutUpBig',
            'flip' => 'flip',
            'flipInX' => 'flipInX',
            'flipInY' => 'flipInY',
            'flipOutX' => 'flipOutX',
            'flipOutY' => 'flipOutY',
            'rotateIn' => 'rotateIn',
            'rotateInDownLeft' => 'rotateInDownLeft',
            'rotateInDownRight' => 'rotateInDownRight',
            'rotateInUpLeft' => 'rotateInUpLeft',
            'rotateInUpRight' => 'rotateInUpRight',
            'rotateOut' => 'rotateOut',
            'rotateOutDownLeft' => 'rotateOutDownLeft',
            'rotateOutDownRight' => 'rotateOutDownRight',
            'rotateOutUpLeft' => 'rotateOutUpLeft',
            'rotateOutUpRight' => 'rotateOutUpRight',
            'hinge' => 'hinge',
            'jackInTheBox' => 'jackInTheBox',
            'rollIn' => 'rollIn',
            'rollOut' => 'rollOut',
            'zoomIn' => 'zoomIn',
            'zoomInDown' => 'zoomInDown',
            'zoomInLeft' => 'zoomInLeft',
            'zoomInRight' => 'zoomInRight',
            'zoomInUp' => 'zoomInUp',
            'zoomOut' => 'zoomOut',
            'zoomOutDown' => 'zoomOutDown',
            'zoomOutLeft' => 'zoomOutLeft',
            'zoomOutRight' => 'zoomOutRight',
            'zoomOutUp' => 'zoomOutUp',
            'slideInDown' => 'slideInDown',
            'slideInLeft' => 'slideInLeft',
            'slideInRight' => 'slideInRight',
            'slideInUp' => 'slideInUp',
            'slideOutDown' => 'slideOutDown',
            'slideOutLeft' => 'slideOutLeft',
            'slideOutRight' => 'slideOutRight',
            'slideOutUp' => 'slideOutUp',
        ),
        'off',
        '选择一款炫酷的列表动画',
        '介绍：开启后，列表将会显示所选择的炫酷动画'
    );
    $JList_Animate->setAttribute('class', 'joe_content joe_global');
    $form->addInput($JList_Animate->multiMode());

    $JFooter_Left = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JFooter_Left',
        NULL,
        '2019 - 2020 © Reach - <a href="https://as.js.cn" target="_blank" rel="noopener noreferrer">Joe</a>',
        '自定义底部栏左侧内容（非必填）',
        '介绍：用于修改全站底部左侧内容（wap端上方） <br>
         例如：2019 - 2020 © Reach - Joe             '
    );
    $JFooter_Left->setAttribute('class', 'joe_content joe_global');
    $form->addInput($JFooter_Left);

    $JFooter_Right = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JFooter_Right',
        NULL,
        '<a href="https://as.js.cn/feed/" target="_blank" rel="noopener noreferrer">RSS</a>
         <a href="https://as.js.cn/sitemap.xml" target="_blank" rel="noopener noreferrer" style="margin-left: 15px">MAP</a>',
        '自定义底部栏右侧内容（非必填）',
        '介绍：用于修改全站底部右侧内容（wap端下方） <br>
         例如：&lt;a href="/"&gt;首页&lt;/a&gt; &lt;a href="/"&gt;关于&lt;/a&gt;'
    );
    $JFooter_Right->setAttribute('class', 'joe_content joe_global');
    $form->addInput($JFooter_Right);

    $JLive2d = new Typecho_Widget_Helper_Form_Element_Select(
        'JLive2d',
        array(
            'off' => '关闭（默认）',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-shizuku@1.0.5/assets/shizuku.model.json' => 'shizuku',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-izumi@1.0.5/assets/izumi.model.json' => 'izumi',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-haru@1.0.5/01/assets/haru01.model.json' => 'haru01',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-haru@1.0.5/02/assets/haru02.model.json' => 'haru02',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-wanko@1.0.5/assets/wanko.model.json' => 'wanko',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-hijiki@1.0.5/assets/hijiki.model.json' => 'hijiki',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-koharu@1.0.5/assets/koharu.model.json' => 'koharu',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-z16@1.0.5/assets/z16.model.json' => 'z16',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-haruto@1.0.5/assets/haruto.model.json' => 'haruto',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-tororo@1.0.5/assets/tororo.model.json' => 'tororo',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-chitose@1.0.5/assets/chitose.model.json' => 'chitose',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-miku@1.0.5/assets/miku.model.json' => 'miku',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-epsilon2_1@1.0.5/assets/Epsilon2.1.model.json' => 'Epsilon2.1',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-unitychan@1.0.5/assets/unitychan.model.json' => 'unitychan',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-nico@1.0.5/assets/nico.model.json' => 'nico',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-rem@1.0.1/assets/rem.model.json' => 'rem',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-nito@1.0.5/assets/nito.model.json' => 'nito',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-nipsilon@1.0.5/assets/nipsilon.model.json' => 'nipsilon',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-ni-j@1.0.5/assets/ni-j.model.json' => 'ni-j',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-nietzsche@1.0.5/assets/nietzche.model.json' => 'nietzche',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-platelet@1.1.0/assets/platelet.model.json' => 'platelet',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-isuzu@1.0.4/assets/model.json' => 'isuzu',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-jth@1.0.0/assets/model/katou_01/katou_01.model.json' => 'katou_01',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-mikoto@1.0.0/assets/mikoto.model.json' => 'mikoto',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-mashiro-seifuku@1.0.1/assets/seifuku.model.json' => 'seifuku',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-ichigo@1.0.1/assets/ichigo.model.json' => 'ichigo',
            'https://cdn.jsdelivr.net/npm/live2d-widget-model-hk_fos@1.0.0/assets/hk416.model.json' => 'hk416'
        ),
        'off',
        '选择一款喜爱的Live2D动态人物模型（仅在屏幕分辨率大于1760px下显示）',
        '介绍：开启后会在右下角显示一个小人'
    );
    $JLive2d->setAttribute('class', 'joe_content joe_global');
    $form->addInput($JLive2d->multiMode());

    $JDocumentTitle = new Typecho_Widget_Helper_Form_Element_Text(
        'JDocumentTitle',
        NULL,
        NULL,
        '网页被隐藏时显示的标题',
        '介绍：在PC端切换网页标签时，网站标题显示的内容。如果不填写，则默认不开启 <br />
         注意：严禁加单引号或双引号！！！否则会导致网站出错！！'
    );
    $JDocumentTitle->setAttribute('class', 'joe_content joe_global');
    $form->addInput($JDocumentTitle);

    $JCursorEffects = new Typecho_Widget_Helper_Form_Element_Select(
        'JCursorEffects',
        array(
            'off' => '关闭（默认）',
            'cursor1.js' => '效果1',
            'cursor2.js' => '效果2',
            'cursor3.js' => '效果3',
            'cursor4.js' => '效果4'
        ),
        'off',
        '选择页面点击特效',
        '介绍：用于开启炫酷的页面点击特效'
    );
    $JCursorEffects->setAttribute('class', 'joe_content joe_global');
    $form->addInput($JCursorEffects->multiMode());

    $JCustomCSS = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JCustomCSS',
        NULL,
        NULL,
        '自定义CSS（非必填）',
        '介绍：请填写自定义CSS内容，填写时无需填写style标签。<br />
         其他：如果想修改主题色、卡片透明度等，都可以通过这个实现 <br />
         例如：body { --theme: #ff6800; --background: rgba(255,255,255,0.85) }'
    );
    $JCustomCSS->setAttribute('class', 'joe_content joe_global');
    $form->addInput($JCustomCSS);

    $JCustomScript = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JCustomScript',
        NULL,
        NULL,
        '自定义JS（非必填）',
        '介绍：请填写自定义JS内容，例如网站统计等，填写时无需填写script标签。'
    );
    $JCustomScript->setAttribute('class', 'joe_content joe_global');
    $form->addInput($JCustomScript);

    $JCustomHeadEnd = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JCustomHeadEnd',
        NULL,
        NULL,
        '自定义增加&lt;head&gt;&lt;/head&gt;里内容（非必填）',
        '介绍：此处用于在&lt;head&gt;&lt;/head&gt;标签里增加自定义内容 <br />
         例如：可以填写引入第三方css、js等等'
    );
    $JCustomHeadEnd->setAttribute('class', 'joe_content joe_global');
    $form->addInput($JCustomHeadEnd);

    $JCustomBodyEnd = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JCustomBodyEnd',
        NULL,
        NULL,
        '自定义&lt;body&gt;&lt;/body&gt;末尾位置内容（非必填）',
        '介绍：此处用于填写在&lt;body&gt;&lt;/body&gt;标签末尾位置的内容 <br>
         例如：可以填写引入第三方js脚本等等'
    );
    $JCustomBodyEnd->setAttribute('class', 'joe_content joe_global');
    $form->addInput($JCustomBodyEnd);

    $JBirthDay = new Typecho_Widget_Helper_Form_Element_Text(
        'JBirthDay',
        NULL,
        NULL,
        '网站成立日期（非必填）',
        '介绍：用于显示当前站点已经运行了多少时间。<br>
         注意：填写时务必保证填写正确！例如：2021/1/1 00:00:00 <br>
         其他：不填写则不显示，若填写错误，则不会显示计时'
    );
    $JBirthDay->setAttribute('class', 'joe_content joe_global');
    $form->addInput($JBirthDay);

    $JCustomFont = new Typecho_Widget_Helper_Form_Element_Text(
        'JCustomFont',
        NULL,
        NULL,
        '自定义网站字体（非必填）',
        '介绍：用于修改全站字体，填写则使用引入的字体，不填写使用默认字体 <br>
         格式：字体URL链接 <br>
         注意：由于体积文件较大，建议使用cdn链接方式进行引入'
    );
    $JCustomFont->setAttribute('class', 'joe_content joe_global');
    $form->addInput($JCustomFont);


    $JAside_Author_Nick = new Typecho_Widget_Helper_Form_Element_Text(
        'JAside_Author_Nick',
        NULL,
        "Typecho",
        '博主栏博主昵称 - PC/WAP',
        '介绍：用于修改博主栏的博主昵称 <br />
         注意：如果不填写时则显示 *个人设置* 里的昵称'
    );
    $JAside_Author_Nick->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Author_Nick);
    /* --------------------------------------- */
    $JAside_Author_Avatar = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JAside_Author_Avatar',
        NULL,
        NULL,
        '博主栏博主头像 - PC/WAP',
        '介绍：用于修改博主栏的博主头像 <br />
         注意：如果不填写时则显示 *个人设置* 里的头像'
    );
    $JAside_Author_Avatar->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Author_Avatar);
    /* --------------------------------------- */
    $JAside_Author_Image = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JAside_Author_Image',
        NULL,
        "https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/img/aside_author_image.jpg",
        '博主栏背景壁纸 - PC',
        '介绍：用于修改PC端博主栏的背景壁纸 <br/>
         格式：图片地址 或 Base64地址'
    );
    $JAside_Author_Image->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Author_Image);
    /* --------------------------------------- */
    $JAside_Wap_Image = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JAside_Wap_Image',
        NULL,
        "https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/img/wap_aside_image.jpg",
        '博主栏背景壁纸 - WAP',
        '介绍：用于修改WAP端博主栏的背景壁纸 <br/>
         格式：图片地址 或 Base64地址'
    );
    $JAside_Wap_Image->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Wap_Image);
    /* --------------------------------------- */
    $JAside_Author_Link = new Typecho_Widget_Helper_Form_Element_Text(
        'JAside_Author_Link',
        NULL,
        "https://as.js.cn",
        '博主栏昵称跳转地址 - PC/WAP',
        '介绍：用于修改博主栏点击博主昵称后的跳转地址'
    );
    $JAside_Author_Link->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Author_Link);
    /* --------------------------------------- */
    $JAside_Author_Motto = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JAside_Author_Motto',
        NULL,
        "有钱终成眷属，没钱亲眼目睹",
        '博主栏座右铭（一言）- PC/WAP',
        '介绍：用于修改博主栏的座右铭（一言） <br />
         格式：可以填写多行也可以填写一行，填写多行时，每次随机显示其中的某一条，也可以填写API地址 <br />
         其他：API和自定义的座右铭完全可以一起写（换行填写），不会影响 <br />
         注意：API需要开启跨域权限才能调取，否则会调取失败！<br />
         推荐API：https://api.vvhan.com/api/ian'
    );
    $JAside_Author_Motto->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Author_Motto);
    /* --------------------------------------- */
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
        '博主栏下方随机文章条目 - PC',
        '介绍：用于设置博主栏下方的随机文章显示数量 <br />
         注意：由于此项是查询整个表，文章多时，请关闭此项'
    );
    $JAside_Author_Nav->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Author_Nav->multiMode());
    /* --------------------------------------- */
    $JAside_Timelife_Status = new Typecho_Widget_Helper_Form_Element_Select(
        'JAside_Timelife_Status',
        array(
            'off' => '关闭（默认）',
            'on' => '开启'
        ),
        'off',
        '是否开启人生倒计时模块 - PC',
        '介绍：用于控制是否显示人生倒计时模块'
    );
    $JAside_Timelife_Status->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Timelife_Status->multiMode());
    /* --------------------------------------- */
    $JAside_Hot_Num = new Typecho_Widget_Helper_Form_Element_Select(
        'JAside_Hot_Num',
        array(
            'off' => '关闭（默认）',
            '3' => '显示3条',
            '4' => '显示4条',
            '5' => '显示5条',
            '6' => '显示6条',
            '7' => '显示7条',
            '8' => '显示8条',
            '9' => '显示9条',
            '10' => '显示10条',
        ),
        'off',
        '是否开启热门文章栏 - PC',
        '介绍：用于控制是否开启热门文章栏'
    );
    $JAside_Hot_Num->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Hot_Num->multiMode());
    /* --------------------------------------- */
    $JAside_Newreply_Status = new Typecho_Widget_Helper_Form_Element_Select(
        'JAside_Newreply_Status',
        array(
            'off' => '关闭（默认）',
            'on' => '开启'
        ),
        'off',
        '是否开启最新回复栏 - PC',
        '介绍：用于控制是否开启最新回复栏'
    );
    $JAside_Newreply_Status->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Newreply_Status->multiMode());
    /* --------------------------------------- */
    $JAside_Ranking = new Typecho_Widget_Helper_Form_Element_Select(
        'JAside_Ranking',
        array(
            'off' => '关闭（默认）',
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
        'off',
        '是否开启排行榜栏 - PC',
        '介绍：用于控制是否开启排行榜栏'
    );
    $JAside_Ranking->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Ranking->multiMode());
    /* --------------------------------------- */
    $JAside_Weather_Key = new Typecho_Widget_Helper_Form_Element_Text(
        'JAside_Weather_Key',
        NULL,
        NULL,
        '天气栏KEY值 - PC',
        '介绍：用于初始化天气栏 <br/>
         注意：填写时务必填写正确！不填写则不会显示<br />
         其他：免费申请地址：<a href="//cj.weather.com.cn">cj.weather.com.cn</a> '
    );
    $JAside_Weather_Key->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Weather_Key);
    /* --------------------------------------- */
    $JAside_Weather_Style = new Typecho_Widget_Helper_Form_Element_Select(
        'JAside_Weather_Style',
        array(
            '1' => '自动（默认）',
            '2' => '浅色',
            '3' => '深色'
        ),
        '1',
        '选择天气栏的风格 - PC',
        '介绍：选择一款您所喜爱的天气风格 <br />
         注意：需要先填写天气的KEY值才会生效'
    );
    $JAside_Weather_Style->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JAside_Weather_Style->multiMode());
    /* --------------------------------------- */
    $JADContent = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JADContent',
        NULL,
        NULL,
        '侧边栏广告 - PC',
        '介绍：用于设置侧边栏广告 <br />
         格式：广告图片 || 跳转链接 （中间使用两个竖杠分隔）<br />
         例如：https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/thumb/1.jpg || https://as.js.cn <br />
         注意：如果您只想显示图片不想跳转，可填写：广告图片 || javascript:void(0)'
    );
    $JADContent->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JADContent);
    /* --------------------------------------- */
    $JCustomAside = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JCustomAside',
        NULL,
        NULL,
        '自定义侧边栏模块 - PC',
        '介绍：用于自定义侧边栏模块 <br />
         格式：请填写前端代码，不会写请勿填写 <br />
         例如：您可以在此处添加一个搜索框、时间、宠物、恋爱计时等等'
    );
    $JCustomAside->setAttribute('class', 'joe_content joe_aside');
    $form->addInput($JCustomAside);


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

    $JDynamic_Background = new Typecho_Widget_Helper_Form_Element_Select(
        'JDynamic_Background',
        array(
            'off' => '关闭（默认）',
            'backdrop1.js' => '效果1',
            'backdrop2.js' => '效果2',
            'backdrop3.js' => '效果3',
            'backdrop4.js' => '效果4',
            'backdrop5.js' => '效果5',
            'backdrop6.js' => '效果6'
        ),
        'off',
        '是否开启动态背景图（仅限PC）',
        '介绍：用于设置PC端动态背景<br />
         注意：如果您填写了下方PC端静态壁纸，将优先展示下方静态壁纸！如需显示动态壁纸，请将PC端静态壁纸设置成空'
    );
    $JDynamic_Background->setAttribute('class', 'joe_content joe_image');
    $form->addInput($JDynamic_Background->multiMode());

    $JWallpaper_Background_PC = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JWallpaper_Background_PC',
        NULL,
        NULL,
        'PC端网站背景图片（非必填）',
        '介绍：PC端网站的背景图片，不填写时显示默认的灰色。<br />
         格式：图片URL地址 或 随机图片api 例如：https://api.btstu.cn/sjbz/?lx=dongman <br />
         注意：如果需要显示上方动态壁纸，请不要填写此项，此项优先级最高！'
    );
    $JWallpaper_Background_PC->setAttribute('class', 'joe_content joe_image');
    $form->addInput($JWallpaper_Background_PC);

    $JWallpaper_Background_WAP = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JWallpaper_Background_WAP',
        NULL,
        NULL,
        'WAP端网站背景图片（非必填）',
        '介绍：WAP端网站的背景图片，不填写时显示默认的灰色。<br />
         格式：图片URL地址 或 随机图片api 例如：https://api.btstu.cn/sjbz/?lx=m_dongman'
    );
    $JWallpaper_Background_WAP->setAttribute('class', 'joe_content joe_image');
    $form->addInput($JWallpaper_Background_WAP);

    $JShare_QQ_Image = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JShare_QQ_Image',
        NULL,
        "https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/img/link.png",
        'QQ分享链接图片',
        '介绍：用于修改在QQ内分享时卡片链接显示的图片 <br/>
         格式：图片地址'
    );
    $JShare_QQ_Image->setAttribute('class', 'joe_content joe_image');
    $form->addInput($JShare_QQ_Image);

    $JIndex_Carousel = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JIndex_Carousel',
        NULL,
        NULL,
        '首页轮播图',
        '介绍：用于显示首页轮播图，请务必填写正确的格式 <br />
         格式：图片地址 || 跳转链接 || 标题 （中间使用两个竖杠分隔）<br />
         其他：一行一个，一行代表一个轮播图 <br />
         例如：<br />
            https://puui.qpic.cn/media_img/lena/PICykqaoi_580_1680/0 || https://baidu.com || 百度一下 <br />
            https://puui.qpic.cn/tv/0/1223447268_1680580/0 || https://v.qq.com || 腾讯视频
         '
    );
    $JIndex_Carousel->setAttribute('class', 'joe_content joe_index');
    $form->addInput($JIndex_Carousel);

    $JIndex_Recommend = new Typecho_Widget_Helper_Form_Element_Text(
        'JIndex_Recommend',
        NULL,
        NULL,
        '首页推荐文章（非必填，填写时请填写2个，否则不显示！）',
        '介绍：用于显示推荐文章，请务必填写正确的格式 <br/>
         格式：文章的id || 文章的id （中间使用两个竖杠分隔）<br />
         例如：1 || 2 <br />
         注意：如果填写的不是2个，将不会显示'
    );
    $JIndex_Recommend->setAttribute('class', 'joe_content joe_index');
    $form->addInput($JIndex_Recommend);

    $JIndexSticky = new Typecho_Widget_Helper_Form_Element_Text(
        'JIndexSticky',
        NULL,
        NULL,
        '首页置顶文章（非必填）',
        '介绍：请务必填写正确的格式 <br />
         格式：文章的ID || 文章的ID || 文章的ID （中间使用两个竖杠分隔）<br />
         例如：1 || 2 || 3'
    );
    $JIndexSticky->setAttribute('class', 'joe_content joe_index');
    $form->addInput($JIndexSticky);

    $JIndex_Hot = new Typecho_Widget_Helper_Form_Element_Radio(
        'JIndex_Hot',
        array('off' => '关闭（默认）', 'on' => '开启'),
        'off',
        '是否开启首页热门文章',
        '介绍：开启后，网站首页将会显示浏览量最多的4篇热门文章'
    );
    $JIndex_Hot->setAttribute('class', 'joe_content joe_index');
    $form->addInput($JIndex_Hot->multiMode());

    $JIndex_Ad = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JIndex_Ad',
        NULL,
        NULL,
        '首页大屏广告',
        '介绍：请务必填写正确的格式 <br />
         格式：广告图片 || 广告链接 （中间使用两个竖杠分隔，限制一个）<br />
         例如：https://puui.qpic.cn/media_img/lena/PICykqaoi_580_1680/0 || https://baidu.com'
    );
    $JIndex_Ad->setAttribute('class', 'joe_content joe_index');
    $form->addInput($JIndex_Ad);

    $JIndex_Notice = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JIndex_Notice',
        NULL,
        NULL,
        '首页通知文字（非必填）',
        '介绍：请务必填写正确的格式 <br />
         格式：通知文字 || 跳转链接（中间使用两个竖杠分隔，限制一个）<br />
         例如：欢迎加入Joe官方QQ群 || https://baidu.com'
    );
    $JIndex_Notice->setAttribute('class', 'joe_content joe_index');
    $form->addInput($JIndex_Notice);

    $JFriends = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JFriends',
        NULL,
        'Joe的博客 || https://as.js.cn || https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/img/link.png || Eternity is not a distance but a decision',
        '友情链接（非必填）',
        '介绍：用于填写友情链接 <br />
         注意：您需要先增加友联链接页面（新增独立页面-右侧模板选择友联），该项才会生效 <br />
         格式：博客名称 || 博客地址 || 博客头像 || 博客简介 <br />
         其他：一行一个，一行代表一个友联'
    );
    $JFriends->setAttribute('class', 'joe_content joe_other');
    $form->addInput($JFriends);

    $JMaccmsAPI = new Typecho_Widget_Helper_Form_Element_Text(
        'JMaccmsAPI',
        NULL,
        NULL,
        '苹果CMS开放API',
        '介绍：请填写苹果CMS V10开放API，用于视频页面使用<br />
         例如：https://v.ini0.com/api.php/provide/vod/ <br />
         如果您搭建了苹果cms网站，那么用你自己的即可，如果没有，请去网上找API <br />
         '
    );
    $JMaccmsAPI->setAttribute('class', 'joe_content joe_other');
    $form->addInput($JMaccmsAPI);

    $JCustomPlayer = new Typecho_Widget_Helper_Form_Element_Text(
        'JCustomPlayer',
        NULL,
        NULL,
        '自定义视频播放器（非必填）',
        '介绍：用于修改主题自带的默认播放器 <br />
         例如：https://v.ini0.com/player/?url= <br />
         注意：主题自带的播放器只能解析M3U8的视频格式'
    );
    $JCustomPlayer->setAttribute('class', 'joe_content joe_other');
    $form->addInput($JCustomPlayer);

    $JSensitiveWords = new Typecho_Widget_Helper_Form_Element_Textarea(
        'JSensitiveWords',
        NULL,
        '你妈死了 || 傻逼 || 操你妈 || 射你妈一脸',
        '评论敏感词（非必填）',
        '介绍：用于设置评论敏感词汇，如果用户评论包含这些词汇，则将会禁止评论 <br />
         例如：你妈死了 || 你妈炸了 || 我是你爹 || 你妈坟头冒烟 （多个使用 || 分隔开）'
    );
    $JSensitiveWords->setAttribute('class', 'joe_content joe_other');
    $form->addInput($JSensitiveWords);

    $JLimitOneChinese = new Typecho_Widget_Helper_Form_Element_Select(
        'JLimitOneChinese',
        array('off' => '关闭（默认）', 'on' => '开启'),
        'off',
        '是否开启评论至少包含一个中文',
        '介绍：开启后如果评论内容未包含一个中文，则将会禁止评论 <br />
         其他：用于屏蔽国外机器人刷的全英文垃圾广告信息'
    );
    $JLimitOneChinese->setAttribute('class', 'joe_content joe_other');
    $form->addInput($JLimitOneChinese->multiMode());

    $JPasteUpload = new Typecho_Widget_Helper_Form_Element_Select(
        'JPasteUpload',
        array('off' => '关闭（默认）', 'on' => '开启'),
        'off',
        '是否开启编辑器粘贴上传图片功能',
        '介绍：开启后文章编辑器将拥有图片上传功能 <br />
         其他：Typecho开发版已实现粘贴上传，如果您使用的是开发版，请关闭此项'
    );
    $JPasteUpload->setAttribute('class', 'joe_content joe_other');
    $form->addInput($JPasteUpload->multiMode());

    $JBaiduToken = new Typecho_Widget_Helper_Form_Element_Text(
        'JBaiduToken',
        NULL,
        NULL,
        '百度推送Token',
        '介绍：填写此处，前台文章页如果未收录，则会自动将当前链接推送给百度加快收录 <br />
         其他：Token在百度收录平台注册账号获取'
    );
    $JBaiduToken->setAttribute('class', 'joe_content joe_post');
    $form->addInput($JBaiduToken);
} ?>