<?php

function _getVersion()
{
    return "1.0.0";
};

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
