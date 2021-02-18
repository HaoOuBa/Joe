<?php if ($this->options->JAside && $this->fields->aside !== "off") :  ?>
    <aside class="joe_aside">
        <?php if (in_array('author', $this->options->JAside)) : ?>
            <section class="joe_aside__item author">
                <img class="image lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php $this->options->JAside_Author_Image() ?>" onerror="javascript: this.src='data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';" alt="<?php $this->author->screenName(); ?>" />
                <div class="user">
                    <img class="avatar lazyload" src="<?php _getAvatarLazyload(); ?>" data-src="<?php _getAvatarByMail($this->author->mail) ?>" onerror="javascript: this.src = '<?php _getAvatarLazyload(); ?>'" alt="<?php $this->author->screenName(); ?>" />
                    <a class="link" href="<?php $this->options->JAside_Author_Link() ?>" target="_blank" rel="noopener noreferrer nofollow"><?php $this->author->screenName(); ?></a>
                    <p class="motto"><?php _getAsideAuthorMotto() ?></p>
                </div>
                <?php Typecho_Widget::widget('Widget_Stat')->to($item); ?>
                <div class="count">
                    <div class="item" title="累计文章数">
                        <span class="num"><?php echo number_format($item->publishedPostsNum); ?></span>
                        <span>文章数</span>
                    </div>
                    <div class="item" title="累计评论数">
                        <span class="num"><?php echo number_format($item->publishedCommentsNum); ?></span>
                        <span>评论量</span>
                    </div>
                </div>
                <?php if ($this->options->JAside_Author_Nav !== "off") : ?>
                    <ul class="list">
                        <?php _getAsideAuthorNav() ?>
                    </ul>
                <?php endif; ?>
            </section>
        <?php endif; ?>
        <?php if (in_array('timelife', $this->options->JAside)) : ?>
            <section class="joe_aside__item timelife">
                <div class="joe_aside__item-title">
                    <svg class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                        <path d="M864.801 895.471h-33.56v-96.859c0-126.081-73.017-235.093-179.062-287.102 106.046-52.01 179.062-161.022 179.062-287.102v-96.859h33.56c17.301 0 31.325-14.327 31.325-32 0-17.673-14.024-32-31.325-32H159.018c-17.3 0-31.325 14.327-31.325 32 0 17.673 14.025 32 31.325 32h33.02v96.859c0 126.08 73.016 235.092 179.061 287.102-106.046 52.009-179.062 161.02-179.062 287.101v96.859h-33.02c-17.3 0-31.325 14.326-31.325 32s14.025 32 31.325 32H864.8c17.301 0 31.325-14.326 31.325-32s-14.023-31.999-31.324-31.999zM256.05 222.427v-94.878h513.046v94.878c0 141.674-114.85 256.522-256.523 256.522-141.674 0-256.523-114.848-256.523-256.522z m513.046 673.044H256.05v-94.879c0-141.674 114.849-256.521 256.523-256.521 141.673 0 256.523 114.848 256.523 256.521v94.879z" p-id="29837"></path>
                        <path d="M544.141 384c0-17.69-14.341-32.031-32.031-32.031-71.694 0-127.854-56.161-127.854-127.855 0-17.69-14.341-32.032-32.031-32.032s-32.032 14.341-32.032 32.032c0 107.617 84.3 191.918 191.917 191.918 17.69 0 32.031-14.342 32.031-32.032z" p-id="29838"></path>
                    </svg>
                    <span class="text">人生倒计时</span>
                    <span class="line"></span>
                </div>
                <div class="joe_aside__item-contain"></div>
            </section>
        <?php endif; ?>
        <?php if (in_array('hot', $this->options->JAside)) : ?>
            <section class="joe_aside__item hot">
                <div class="joe_aside__item-title">
                    <svg class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                        <path d="M512 938.666667A426.666667 426.666667 0 0 1 85.333333 512a421.12 421.12 0 0 1 131.2-306.133333 58.88 58.88 0 0 1 42.666667-16.64c33.28 1.066667 58.026667 28.16 84.266667 56.96 7.893333 8.533333 19.626667 21.333333 28.373333 29.013333a542.933333 542.933333 0 0 0 24.533333-61.866667c18.133333-52.266667 35.413333-101.76 75.306667-121.6C526.72 64 583.253333 129.706667 654.933333 213.333333c16.213333 18.773333 38.613333 44.8 53.546667 59.52 1.706667-4.48 3.2-8.96 4.48-12.373333 8.533333-24.32 18.986667-54.613333 51.2-61.653333a57.813333 57.813333 0 0 1 55.68 20.053333A426.666667 426.666667 0 0 1 512 938.666667zM260.693333 282.453333A336.64 336.64 0 0 0 170.666667 512a341.333333 341.333333 0 1 0 614.826666-203.733333 90.24 90.24 0 0 1-42.666666 50.56 68.266667 68.266667 0 0 1-53.546667 1.706666c-25.6-9.173333-51.626667-38.4-99.2-93.226666a826.666667 826.666667 0 0 0-87.253333-91.733334 507.733333 507.733333 0 0 0-26.24 64c-18.133333 52.266667-35.413333 101.76-75.946667 119.253334-48.853333 21.333333-88.32-21.333333-120.106667-56.96-5.76-4.693333-13.226667-13.013333-19.84-19.413334z" p-id="14764"></path>
                        <path d="M512 810.666667a298.666667 298.666667 0 0 1-298.666667-298.666667 42.666667 42.666667 0 0 1 85.333334 0 213.333333 213.333333 0 0 0 213.333333 213.333333 42.666667 42.666667 0 0 1 0 85.333334z" p-id="14765"></path>
                    </svg>
                    <span class="text">热门文章</span>
                    <span class="line"></span>
                </div>
                <?php $this->widget('Widget_Contents_Hot@Aside', 'pageSize=' . $this->options->JAside_Hot_Num)->to($item); ?>
                <ol class="joe_aside__item-contain">
                    <?php if ($item->have()) : ?>
                        <?php $index = 1; ?>
                        <?php while ($item->next()) : ?>
                            <li class="item">
                                <a class="link" href="<?php $item->permalink(); ?>" title="<?php $item->title(); ?>">
                                    <i class="sort"><?php echo $index; ?></i>
                                    <img class="image lazyload" src="<?php _getLazyload(); ?>" data-src="<?php echo _getThumbnails($item)[0]; ?>" onerror="javascript: this.src='<?php _getLazyload() ?>';" alt="<?php $item->title() ?>" />
                                    <div class="describe">
                                        <h6><?php $item->title(); ?></h6>
                                        <span><?php $item->views(); ?> 阅读 - <?php $item->date('m/d'); ?></span>
                                    </div>
                                </a>
                            </li>
                            <?php $index++; ?>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <li class="empty">这个博主很懒！</li>
                    <?php endif; ?>
                </ol>
            </section>
        <?php endif; ?>
        <?php if (in_array('newreply', $this->options->JAside)) : ?>
            <section class="joe_aside__item newreply">
                <div class="joe_aside__item-title">
                    <svg class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                        <path d="M512 647.238856a204.391218 204.391218 0 0 0 204.391218-204.391218V204.391218a204.391218 204.391218 0 0 0-408.782436 0v238.45642a204.391218 204.391218 0 0 0 204.391218 204.391218zM375.739188 204.391218a136.260812 136.260812 0 0 1 272.521624 0v238.45642a136.260812 136.260812 0 0 1-272.521624 0z" p-id="25083"></path>
                        <path d="M852.652029 476.912841a34.065203 34.065203 0 0 0-68.130406 0 257.532934 257.532934 0 0 1-272.521623 238.45642A257.532934 257.532934 0 0 1 239.478377 476.912841a34.065203 34.065203 0 0 0-34.065203-34.065203 34.065203 34.065203 0 0 0-34.065203 34.065203 321.575516 321.575516 0 0 0 307.26813 303.86161V953.825682H307.608782a34.065203 34.065203 0 0 0-34.065202 34.065203 34.065203 34.065203 0 0 0 34.065202 34.065203h408.782436a34.065203 34.065203 0 0 0 34.065202-34.065203 34.065203 34.065203 0 0 0-34.065202-34.065203H546.065203v-170.326015-4.769128A321.575516 321.575516 0 0 0 852.652029 476.912841z" p-id="25084"></path>
                    </svg>
                    <span class="text">最新回复</span>
                    <span class="line"></span>
                </div>
                <?php $this->widget('Widget_Comments_Recent', 'ignoreAuthor=true&pageSize=5')->to($item); ?>
                <ul class="joe_aside__item-contain">
                    <?php if ($item->have()) : ?>
                        <?php while ($item->next()) : ?>
                            <li class="item">
                                <div class="user">
                                    <img class="avatar lazyload" src="<?php _getAvatarLazyload(); ?>" data-src="<?php _getAvatarByMail($item->mail) ?>" onerror="javascript: this.src = '<?php _getAvatarLazyload(); ?>'" alt="<?php $item->author(false) ?>" />
                                    <div class="info">
                                        <div class="author"><?php $item->author(false) ?></div>
                                        <span class="date"><?php $item->date('Y-m-d'); ?></span>
                                    </div>
                                </div>
                                <div class="reply">
                                    <a class="link" title="<?php _parseAsideReply($item->content, false); ?>" href="<?php _parseAsideLink($item->permalink); ?>">
                                        <?php _parseAsideReply($item->content); ?>
                                    </a>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <li class="empty">人气很差！一条回复没有！</li>
                    <?php endif; ?>
                </ul>
            </section>
        <?php endif; ?>
        <?php if (in_array('ranking', $this->options->JAside)) : ?>
            <section class="joe_aside__item ranking">
                <div class="joe_aside__item-title">
                    <svg class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                        <path d="M939.855405 202.777641H832.417563v-78.366426A124.320931 124.320931 0 0 0 708.367484 0H315.271381a124.411215 124.411215 0 0 0-124.05008 124.411215v78.366426H83.873744A84.144595 84.144595 0 0 0 0 286.922236c0 123.14724 82.248633 199.437136 194.561806 232.481044a321.862105 321.862105 0 0 0 281.414918 273.469935v158.899665H308.680656a36.11356 36.11356 0 0 0 0 72.22712h406.277552a36.11356 36.11356 0 0 0 0-72.22712H547.662141v-158.899665a321.681538 321.681538 0 0 0 281.414918-273.469935c112.313172-33.043908 194.65209-109.333804 194.652089-232.481044a84.144595 84.144595 0 0 0-83.873743-84.144595zM67.442074 286.922236A16.612238 16.612238 0 0 1 83.873744 270.851702h107.347557v175.602186C118.542761 415.305943 67.442074 370.976547 67.442074 286.922236z m444.377358 440.314583a254.14918 254.14918 0 0 1-252.794921-253.968612V124.411215a56.69829 56.69829 0 0 1 56.24687-56.69829h393.096103a56.69829 56.69829 0 0 1 56.608005 56.69829v348.856992a254.14918 254.14918 0 0 1-252.794921 253.968612z m320.598131-280.782931V270.851702h107.437842a16.612238 16.612238 0 0 1 16.341386 16.43167c0 83.693176-51.100688 128.022571-123.779228 159.170516z" p-id="15686"></path>
                        <path d="M696.540293 469.476283a33.675895 33.675895 0 0 0-43.426556 19.772174 153.482631 153.482631 0 0 1-92.540999 90.283901 33.856463 33.856463 0 0 0 11.014636 65.816963 32.953624 32.953624 0 0 0 10.924352-1.805678 218.938459 218.938459 0 0 0 133.710457-130.640804A33.856463 33.856463 0 0 0 696.540293 469.476283zM517.417034 157.906542l-2.437665 2.708517a163.955563 163.955563 0 0 1-33.856463 27.08517 183.998589 183.998589 0 0 1-39.8152 16.341386l-6.410157 1.62511v64.914125l10.743784-3.069653a180.567801 180.567801 0 0 0 55.253747-25.911479v223.272086h64.282137v-306.965262z" p-id="15687"></path>
                    </svg>
                    <span class="text">loading...</span>
                    <span class="line"></span>
                </div>
                <ul class="joe_aside__item-contain">
                    <li class="error">数据获取中...</li>
                </ul>
            </section>
        <?php endif; ?>
        <?php if (in_array('weather', $this->options->JAside) && $this->options->JAside_Weather_Key) : ?>
            <section class="joe_aside__item weather" data-key="<?php $this->options->JAside_Weather_Key() ?>" data-style="<?php $this->options->JAside_Weather_Style() ?>">
                <div class="joe_aside__item-title">
                    <svg class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                        <path d="M773.12 757.76h-79.872c-15.36 0-29.696-15.36-29.696-29.696s15.36-29.696 29.696-29.696h79.872c100.352 0 180.224-79.872 180.224-180.224S873.472 337.92 773.12 337.92c-25.6 0-50.176 5.12-74.752 15.36-10.24 5.12-20.48 5.12-25.6 0-10.24-5.12-15.36-15.36-15.36-20.48-15.36-100.352-100.352-175.104-200.704-175.104C346.112 155.648 256 245.76 250.88 356.352c0 15.36-10.24 29.696-29.696 29.696-79.872 5.12-145.408 74.752-145.408 160.768 0 90.112 70.656 160.768 160.768 160.768h75.776c15.36 0 29.696 15.36 29.696 29.696s-15.36 30.72-30.72 30.72h-79.872C110.592 757.76 10.24 662.528 10.24 541.696c0-105.472 75.776-195.584 175.104-216.064 15.36-130.048 130.048-235.52 266.24-235.52 120.832 0 225.28 79.872 256 195.584 20.48-5.12 45.056-10.24 65.536-10.24C908.288 276.48 1013.76 387.072 1013.76 517.12S903.168 757.76 773.12 757.76z" fill="" p-id="13873"></path>
                        <path d="M437.248 933.888c-10.24 0-15.36-5.12-20.48-10.24-10.24-10.24-10.24-29.696 0-45.056l79.872-79.872h-60.416c-10.24 0-25.6-5.12-29.696-20.48-5.12-10.24 0-24.576 5.12-34.816l130.048-130.048c10.24-10.24 29.696-10.24 45.056 0 10.24 10.24 10.24 29.696 0 45.056L512 742.4h55.296c10.24 0 24.576 5.12 29.696 20.48 5.12 10.24 0 24.576-5.12 34.816L461.824 928.768c-10.24 5.12-20.48 5.12-24.576 5.12z" fill="" p-id="13874"></path>
                    </svg>
                    <span class="text">今日天气</span>
                    <span class="line"></span>
                </div>
                <div class="joe_aside__item-contain">
                    <div id="weather-v2-plugin-standard"></div>
                </div>
            </section>
        <?php endif; ?>
    </aside>
<?php endif; ?>