<?php

/**
 * “ Eternity is not a distance but a decision - Joe ” <br /> “ 环境要求：PHP 5.4 ~ 7.2 ”
 * @package Typecho Joe Theme
 * @author Joe
 * @link https://ae.js.cn
 */

?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php $this->need('public/include.php'); ?>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/joe.index.css'); ?>">
    <script src="https://cdn.jsdelivr.net/npm/swiper@5.4.5/js/swiper.min.js"></script>
</head>

<body>
    <div id="Joe">
        <?php $this->need('public/header.php'); ?>
        <div class="joe_container">
            <div class="joe_main">
                <div class="joe_index">
                    <?php
                    /* 轮播图 */
                    $carousel = [];
                    $carousel_text = $this->options->JIndex_Carousel;
                    if ($carousel_text) {
                        $carousel_arr = explode("\r\n", $carousel_text);
                        if (count($carousel_arr) > 0) {
                            for ($i = 0; $i < count($carousel_arr); $i++) {
                                $img = explode("||", $carousel_arr[$i])[0];
                                $url = explode("||", $carousel_arr[$i])[1];
                                $title = explode("||", $carousel_arr[$i])[2];
                                $carousel[] = array("img" => trim($img), "url" => trim($url), "title" => trim($title));
                            };
                        }
                    }
                    /* 推荐文章 */
                    $recommend = [];
                    $recommend_text = $this->options->JIndex_Recommend;
                    if ($recommend_text) {
                        $recommend_arr = explode("||", $recommend_text);
                        if (count($recommend_arr) === 2) $recommend = $recommend_arr;
                    }
                    ?>
                    <?php if (sizeof($carousel) > 0 || sizeof($recommend) === 2) : ?>
                        <div class="joe_index__banner">
                            <?php if (sizeof($carousel) > 0) : ?>
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <?php foreach ($carousel as $item) : ?>
                                            <div class="swiper-slide">
                                                <a class="item" href="<?php echo $item['url'] ?>" target="_blank" rel="noopener noreferrer nofollow">
                                                    <img class="thumbnail" src="<?php echo $item['img'] ?>" alt="<?php echo $item['title'] ?>" width="100%" height="100%" />
                                                    <div class="title"><?php echo $item['title'] ?></div>
                                                    <svg class="icon" viewBox="0 0 1026 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                                                        <path d="M784.299475 1007.961156a33.200407 33.200407 0 0 1-27.105646-9.061947l-216.524395-144.349597-108.903751 108.262198c-9.061947 9.061947-36.167593 18.0437-45.229541 9.061947a49.720417 49.720417 0 0 1-27.105646-45.229541v-198.881666A33.200407 33.200407 0 0 1 368.893414 700.656903l343.070875-370.577492a44.748375 44.748375 0 0 1 63.273239 63.27324L441.068212 754.868196v72.174799l63.27324-54.211293a42.583131 42.583131 0 0 1 54.211293-9.061947L757.193829 890.155846l153.652126-749.81596-759.198684 370.497298 171.695826 108.50278c18.0437 9.061947 27.105646 45.22954 9.061946 63.27324-9.061947 18.0437-45.22954 27.105646-63.273239 18.043699L34.082544 547.004777C25.100791 538.023025 16.038844 529.281854 16.038844 510.837184s9.061947-27.105646 27.105647-36.167594l903.788863-451.814237c18.0437-9.061947 36.167593-9.061947 45.229541 0C1010.447177 32.077688 1010.447177 49.960999 1010.447177 68.004699l-180.757773 903.788864c0 18.0437-9.061947 27.105646-27.105646 36.167593z"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            <?php endif; ?>
                            <?php if (sizeof($recommend) === 2) : ?>
                                <div class="joe_index__banner-recommend <?php echo sizeof($carousel) === 0 ? 'noswiper' : '' ?>">
                                    <?php foreach ($recommend as $cid) : ?>
                                        <?php $this->widget('Widget_Archive', 'pageSize=1&type=post', 'cid=' . $cid)->to($item); ?>
                                        <figure class="item">
                                            <a class="thumbnail" href="<?php $item->permalink() ?>" title="<?php $item->title() ?>">
                                                <img class="lazyload" src="<?php _getLazyload(); ?>" data-original="<?php _getThumbnail($item); ?>" alt="<?php $item->title() ?>" width="100%" />
                                            </a>
                                            <figcaption class="information">
                                                <span class="information_type">推荐</span>
                                                <span class="information_title"><?php $item->title() ?></span>
                                            </figcaption>
                                        </figure>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->options->JIndex_Hot === "on") : ?>
                        <?php $this->widget('Widget_Contents_Hot@Index', 'pageSize=4')->to($item); ?>
                        <div class="joe_index__hot">
                            <ul class="joe_index__hot-list">
                                <?php while ($item->next()) : ?>
                                    <li class="item">
                                        <a class="link" href="<?php $item->permalink(); ?>" title="<?php $item->title(); ?>">
                                            <figure class="inner">
                                                <span class="views"><?php _getViews($item); ?></span>
                                                <img class="image lazyload" src="<?php _getLazyload(); ?>" data-original="<?php _getThumbnail($item); ?>" alt="<?php $item->title(); ?>" />
                                                <figcaption class="title"><?php $item->title(); ?></figcaption>
                                            </figure>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="joe_index__title">
                        <ul class="joe_index__title-title">
                            <li class="item" data-type="created">最新文章</li>
                            <li class="item" data-type="commentsNum">评论最多</li>
                            <li class="item" data-type="agree">点赞最多</li>
                            <li class="item" data-type="views">浏览最多</li>
                            <li class="line"></li>
                        </ul>
                    </div>
                    <div class="joe_index__list">
                        <ul class="joe_list"></ul>
                        <ul class="joe_list__loading">
                            <li class="item">
                                <div class="thumbnail"></div>
                                <div class="information">
                                    <div class="title"></div>
                                    <div class="abstract">
                                        <p></p>
                                        <p></p>
                                    </div>
                                </div>
                            </li>
                            <li class="item">
                                <div class="thumbnail"></div>
                                <div class="information">
                                    <div class="title"></div>
                                    <div class="abstract">
                                        <p></p>
                                        <p></p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="joe_load">查看更多</div>
            </div>
            <?php $this->need('public/aside.php'); ?>
        </div>
        <?php $this->need('public/footer.php'); ?>
    </div>
</body>

</html>