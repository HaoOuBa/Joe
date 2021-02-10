<?php

/**
 * “ Eternity is not a distance but a decision - Joe ” <br /> “ 环境要求：PHP 5.4 ~ 7.2 ”
 * @package Joe
 * @author Joe
 * @link https://as.js.cn
 */

?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php $this->need('public/include.php'); ?>
    <!-- 首页所使用到的CSS以及JS -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/joe.index.css'); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@5.4.5/css/swiper.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@5.4.5/js/swiper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/wowjs@1.1.3/dist/wow.min.js"></script>
    <script src="<?php $this->options->themeUrl('assets/js/joe.index.js'); ?>"></script>
</head>

<body>
    <div id="Joe">
        <?php $this->need('public/header.php'); ?>
        <div class="joe_container">
            <div class="joe_main">
                <div class="joe_index">
                    <?php
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
                                                    <img class="thumbnail lazyload" src="<?php _getLazyload() ?>" data-src="<?php echo $item['img'] ?>" onerror="javascript: this.src='<?php _getLazyload() ?>';" alt="<?php echo $item['title'] ?>" width="100%" height="100%" />
                                                    <div class="title"><?php echo $item['title'] ?></div>
                                                    <svg class="icon" viewBox="0 0 1026 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                                                        <path d="M784.299475 1007.961156a33.200407 33.200407 0 0 1-27.105646-9.061947l-216.524395-144.349597-108.903751 108.262198c-9.061947 9.061947-36.167593 18.0437-45.229541 9.061947a49.720417 49.720417 0 0 1-27.105646-45.229541v-198.881666A33.200407 33.200407 0 0 1 368.893414 700.656903l343.070875-370.577492a44.748375 44.748375 0 0 1 63.273239 63.27324L441.068212 754.868196v72.174799l63.27324-54.211293a42.583131 42.583131 0 0 1 54.211293-9.061947L757.193829 890.155846l153.652126-749.81596-759.198684 370.497298 171.695826 108.50278c18.0437 9.061947 27.105646 45.22954 9.061946 63.27324-9.061947 18.0437-45.22954 27.105646-63.273239 18.043699L34.082544 547.004777C25.100791 538.023025 16.038844 529.281854 16.038844 510.837184s9.061947-27.105646 27.105647-36.167594l903.788863-451.814237c18.0437-9.061947 36.167593-9.061947 45.229541 0C1010.447177 32.077688 1010.447177 49.960999 1010.447177 68.004699l-180.757773 903.788864c0 18.0437-9.061947 27.105646-27.105646 36.167593z"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="swiper-pagination"></div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                            <?php endif; ?>
                            <?php if (sizeof($recommend) === 2) : ?>
                                <div class="joe_index__banner-recommend <?php echo sizeof($carousel) === 0 ? 'noswiper' : '' ?>">
                                    <?php foreach ($recommend as $cid) : ?>
                                        <?php $this->widget('Widget_Archive@' . $cid, 'pageSize=1&type=post', 'cid=' . $cid)->to($item); ?>
                                        <figure class="item">
                                            <a class="thumbnail" href="<?php $item->permalink() ?>" title="<?php $item->title() ?>">
                                                <img class="lazyload" src="<?php _getLazyload(); ?>" data-src="<?php _getThumbnail($item); ?>" onerror="javascript: this.src='<?php _getLazyload() ?>';" alt="<?php $item->title() ?>" width="100%" />
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
                                                <img class="image lazyload" src="<?php _getLazyload(); ?>" data-src="<?php _getThumbnail($item); ?>" onerror="javascript: this.src='<?php _getLazyload() ?>';" alt="<?php $item->title(); ?>" />
                                                <figcaption class="title"><?php $item->title(); ?></figcaption>
                                            </figure>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php
                    $index_ad_text = $this->options->JIndex_Ad;
                    $index_ad = null;
                    if ($index_ad_text) {
                        $index_ad_arr = explode("||", $index_ad_text);
                        if (count($index_ad_arr) === 2) $index_ad = array("image" => trim($index_ad_arr[0]), "url" => trim($index_ad_arr[1]));
                    }
                    ?>
                    <?php if ($index_ad) : ?>
                        <div class="joe_index__ad">
                            <a class="joe_index__ad-link" href="<?php echo $index_ad['url'] ?>" target="_blank" rel="noopener noreferrer nofollow">
                                <img class="image lazyload" src="<?php _getLazyload() ?>" data-src="<?php echo $index_ad['image'] ?>" onerror="javascript: this.src='<?php _getLazyload() ?>';" alt="<?php echo $index_ad['url'] ?>" width="100%" />
                                <span class="icon">广告</span>
                            </a>
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
                        <?php
                        $index_notice_text = $this->options->JIndex_Notice;
                        $index_notice = null;
                        if ($index_notice_text) {
                            $index_notice_arr = explode("||", $index_notice_text);
                            if (count($index_notice_arr) === 2) $index_notice = array("text" => trim($index_notice_arr[0]), "url" => trim($index_notice_arr[1]));
                        }
                        ?>
                        <?php if ($index_notice) : ?>
                            <div class="joe_index__title-notice">
                                <svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                                    <path d="M656.26112 347.20768a188.65152 188.65152 0 1 0 0 324.04992V347.20768z" fill="#F4CA1C"></path>
                                    <path d="M668.34944 118.88128a73.34912 73.34912 0 0 0-71.168-4.06016L287.17056 263.5008a4.608 4.608 0 0 1-2.01216 0.4608H130.048A73.728 73.728 0 0 0 56.32 337.59744v349.63968a73.728 73.728 0 0 0 73.728 73.63584h156.55424a4.67968 4.67968 0 0 1 1.94048 0.43008l309.59104 143.19616a73.7024 73.7024 0 0 0 104.66816-66.82112V181.20704a73.216 73.216 0 0 0-34.45248-62.32576zM125.40416 687.23712V337.59744a4.608 4.608 0 0 1 4.608-4.608h122.0352v358.88128H130.048a4.608 4.608 0 0 1-4.64384-4.6336z m508.31872 150.44096a4.608 4.608 0 0 1-6.56384 4.19328l-306.02752-141.55264V323.77344l305.9712-146.72384a4.608 4.608 0 0 1 6.62016 4.15744v656.47104z m304.5376-358.95808h-150.25152a34.5088 34.5088 0 1 0 0 69.0176h150.25152a34.5088 34.5088 0 1 0 0-69.0176z m-128.25088-117.76a34.44736 34.44736 0 0 0 24.41728-10.10176L940.672 244.736a34.52416 34.52416 0 0 0-48.83968-48.80896L785.5872 302.08a34.5088 34.5088 0 0 0 24.4224 58.88z m24.41728 314.60864a34.52416 34.52416 0 1 0-48.83968 48.81408l106.24512 106.1376a34.52416 34.52416 0 0 0 48.83968-48.80896z" fill="#595BB3"></path>
                                </svg>
                                <a href="<?php echo $index_notice['url'] ?>" target="_blank" rel="noopener noreferrer nofollow"><?php echo $index_notice['text'] ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="joe_index__list" data-wow="<?php $this->options->JList_Animate() ?>">
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