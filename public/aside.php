<aside class="joe_aside">
    <section class="joe_aside__item author">
        <img width="100%" height="120" class="image lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php $this->options->JAside_Author_Image() ?>" onerror="javascript: this.src='data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';" alt="博主栏壁纸" />
        <div class="user">
            <img width="75" height="75" class="avatar lazyload" src="<?php _getAvatarLazyload(); ?>" data-src="<?php $this->options->JAside_Author_Avatar ? $this->options->JAside_Author_Avatar() : _getAvatarByMail($this->author->mail) ?>" onerror="javascript: this.src = '<?php _getAvatarLazyload(); ?>'" alt="博主头像" />
            <a class="link" href="<?php $this->options->JAside_Author_Link() ?>" target="_blank" rel="noopener noreferrer nofollow"><?php $this->options->JAside_Author_Nick ? $this->options->JAside_Author_Nick() : $this->author->screenName(); ?></a>
            <p class="motto joe_motto"></p>
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
            <ul class="list"><?php _getAsideAuthorNav() ?></ul>
        <?php endif; ?>
    </section>
    <?php if ($this->options->JAside_Timelife_Status === 'on') : ?>
        <section class="joe_aside__item timelife">
            <div class="joe_aside__item-title">
                <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                    <path d="M864.801 895.471h-33.56v-96.859c0-126.081-73.017-235.093-179.062-287.102 106.046-52.01 179.062-161.022 179.062-287.102v-96.859h33.56c17.301 0 31.325-14.327 31.325-32 0-17.673-14.024-32-31.325-32H159.018c-17.3 0-31.325 14.327-31.325 32 0 17.673 14.025 32 31.325 32h33.02v96.859c0 126.08 73.016 235.092 179.061 287.102-106.046 52.009-179.062 161.02-179.062 287.101v96.859h-33.02c-17.3 0-31.325 14.326-31.325 32s14.025 32 31.325 32H864.8c17.301 0 31.325-14.326 31.325-32s-14.023-31.999-31.324-31.999zM256.05 222.427v-94.878h513.046v94.878c0 141.674-114.85 256.522-256.523 256.522-141.674 0-256.523-114.848-256.523-256.522zm513.046 673.044H256.05v-94.879c0-141.674 114.849-256.521 256.523-256.521 141.673 0 256.523 114.848 256.523 256.521v94.879z" />
                    <path d="M544.141 384c0-17.69-14.341-32.031-32.031-32.031-71.694 0-127.854-56.161-127.854-127.855 0-17.69-14.341-32.032-32.031-32.032s-32.032 14.341-32.032 32.032c0 107.617 84.3 191.918 191.917 191.918 17.69 0 32.031-14.342 32.031-32.032z" />
                </svg>
                <span class="text">人生倒计时</span>
                <span class="line"></span>
            </div>
            <div class="joe_aside__item-contain"></div>
        </section>
    <?php endif; ?>
    <?php if ($this->options->JCustomAside) : ?>
        <section class="joe_aside__item"><?php $this->options->JCustomAside() ?></section>
    <?php endif; ?>
    <?php if ($this->options->JAside_Hot_Num && $this->options->JAside_Hot_Num !== 'off') : ?>
        <section class="joe_aside__item hot">
            <div class="joe_aside__item-title">
                <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                    <path d="M512 938.667A426.667 426.667 0 0 1 85.333 512a421.12 421.12 0 0 1 131.2-306.133 58.88 58.88 0 0 1 42.667-16.64c33.28 1.066 58.027 28.16 84.267 56.96 7.893 8.533 19.626 21.333 28.373 29.013a542.933 542.933 0 0 0 24.533-61.867c18.134-52.266 35.414-101.76 75.307-121.6 55.04-27.733 111.573 37.974 183.253 121.6 16.214 18.774 38.614 44.8 53.547 59.52 1.707-4.48 3.2-8.96 4.48-12.373 8.533-24.32 18.987-54.613 51.2-61.653a57.813 57.813 0 0 1 55.68 20.053A426.667 426.667 0 0 1 512 938.667zM260.693 282.453A336.64 336.64 0 0 0 170.667 512a341.333 341.333 0 1 0 614.826-203.733 90.24 90.24 0 0 1-42.666 50.56 68.267 68.267 0 0 1-53.547 1.706c-25.6-9.173-51.627-38.4-99.2-93.226a826.667 826.667 0 0 0-87.253-91.734 507.733 507.733 0 0 0-26.24 64c-18.134 52.267-35.414 101.76-75.947 119.254-48.853 21.333-88.32-21.334-120.107-56.96-5.76-4.694-13.226-13.014-19.84-19.414z" />
                    <path d="M512 810.667A298.667 298.667 0 0 1 213.333 512a42.667 42.667 0 0 1 85.334 0A213.333 213.333 0 0 0 512 725.333a42.667 42.667 0 0 1 0 85.334z" />
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
                                <img width="100%" height="130" class="image lazyload" src="<?php _getLazyload(); ?>" data-src="<?php echo _getThumbnails($item)[0]; ?>" onerror="javascript: this.src='<?php _getLazyload() ?>';" alt="<?php $item->title() ?>" />
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
    <?php if ($this->options->JAside_Newreply_Status === 'on') : ?>
        <section class="joe_aside__item newreply">
            <div class="joe_aside__item-title">
                <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                    <path d="M512 647.239a204.391 204.391 0 0 0 204.391-204.391V204.39a204.391 204.391 0 0 0-408.782 0v238.457A204.391 204.391 0 0 0 512 647.238zM375.74 204.39a136.26 136.26 0 0 1 272.52 0v238.457a136.26 136.26 0 0 1-272.52 0z" />
                    <path d="M852.652 476.913a34.065 34.065 0 0 0-68.13 0A257.533 257.533 0 0 1 512 715.369a257.533 257.533 0 0 1-272.522-238.456 34.065 34.065 0 0 0-34.065-34.065 34.065 34.065 0 0 0-34.065 34.065 321.576 321.576 0 0 0 307.268 303.861v173.052H307.61a34.065 34.065 0 0 0-34.065 34.065 34.065 34.065 0 0 0 34.065 34.065H716.39a34.065 34.065 0 0 0 34.065-34.065 34.065 34.065 0 0 0-34.065-34.065H546.065V778.73a321.576 321.576 0 0 0 306.587-301.817z" />
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
                                <img width="40" height="40" class="avatar lazyload" src="<?php _getAvatarLazyload(); ?>" data-src="<?php _getAvatarByMail($item->mail) ?>" onerror="javascript: this.src = '<?php _getAvatarLazyload(); ?>'" alt="<?php $item->author(false) ?>" />
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
    <?php if ($this->options->JAside_Ranking && $this->options->JAside_Ranking !== 'off') : ?>
        <section class="joe_aside__item ranking">
            <div class="joe_aside__item-title">
                <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                    <path d="M939.855 202.778H832.418V124.41A124.32 124.32 0 0 0 708.368 0H315.27a124.411 124.411 0 0 0-124.05 124.411v78.367H83.874A84.145 84.145 0 0 0 0 286.922C0 410.07 82.249 486.36 194.562 519.403a321.862 321.862 0 0 0 281.415 273.47v158.9H308.68a36.114 36.114 0 0 0 0 72.227h406.277a36.114 36.114 0 0 0 0-72.227H547.662v-158.9a321.682 321.682 0 0 0 281.415-273.47C941.39 486.36 1023.73 410.07 1023.73 286.923a84.145 84.145 0 0 0-83.874-84.145zM67.442 286.922a16.612 16.612 0 0 1 16.432-16.07H191.22v175.602c-72.678-31.148-123.779-75.477-123.779-159.532zM511.82 727.237a254.15 254.15 0 0 1-252.794-253.969V124.411a56.698 56.698 0 0 1 56.246-56.698h393.096a56.698 56.698 0 0 1 56.608 56.698v348.857a254.15 254.15 0 0 1-252.794 253.969zm320.599-280.783V270.852h107.437a16.612 16.612 0 0 1 16.342 16.431c0 83.694-51.1 128.023-123.78 159.17z" />
                    <path d="M696.54 469.476a33.676 33.676 0 0 0-43.426 19.772 153.483 153.483 0 0 1-92.541 90.284 33.856 33.856 0 0 0 11.014 65.817 32.954 32.954 0 0 0 10.925-1.805 218.938 218.938 0 0 0 133.71-130.641 33.856 33.856 0 0 0-19.682-43.427zm-179.123-311.57l-2.438 2.71a163.956 163.956 0 0 1-33.856 27.084 183.999 183.999 0 0 1-39.815 16.342l-6.41 1.625v64.914l10.743-3.07a180.568 180.568 0 0 0 55.254-25.911v223.272h64.282V157.907z" />
                </svg>
                <span class="text">loading...</span>
                <span class="line"></span>
            </div>
            <ul class="joe_aside__item-contain">
                <li class="error">数据获取中...</li>
            </ul>
        </section>
    <?php endif; ?>
    <?php if ($this->options->JAside_Weather_Key) : ?>
        <section class="joe_aside__item weather" data-key="<?php $this->options->JAside_Weather_Key() ?>" data-style="<?php $this->options->JAside_Weather_Style() ?>">
            <div class="joe_aside__item-title">
                <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                    <path d="M773.12 757.76h-79.872c-15.36 0-29.696-15.36-29.696-29.696s15.36-29.696 29.696-29.696h79.872c100.352 0 180.224-79.872 180.224-180.224S873.472 337.92 773.12 337.92c-25.6 0-50.176 5.12-74.752 15.36-10.24 5.12-20.48 5.12-25.6 0-10.24-5.12-15.36-15.36-15.36-20.48-15.36-100.352-100.352-175.104-200.704-175.104C346.112 155.648 256 245.76 250.88 356.352c0 15.36-10.24 29.696-29.696 29.696-79.872 5.12-145.408 74.752-145.408 160.768 0 90.112 70.656 160.768 160.768 160.768h75.776c15.36 0 29.696 15.36 29.696 29.696S326.656 768 311.296 768h-79.872C110.592 757.76 10.24 662.528 10.24 541.696c0-105.472 75.776-195.584 175.104-216.064 15.36-130.048 130.048-235.52 266.24-235.52 120.832 0 225.28 79.872 256 195.584 20.48-5.12 45.056-10.24 65.536-10.24 135.168 1.024 240.64 111.616 240.64 241.664S903.168 757.76 773.12 757.76z" />
                    <path d="M437.248 933.888c-10.24 0-15.36-5.12-20.48-10.24-10.24-10.24-10.24-29.696 0-45.056l79.872-79.872h-60.416c-10.24 0-25.6-5.12-29.696-20.48-5.12-10.24 0-24.576 5.12-34.816l130.048-130.048c10.24-10.24 29.696-10.24 45.056 0 10.24 10.24 10.24 29.696 0 45.056L512 742.4h55.296c10.24 0 24.576 5.12 29.696 20.48 5.12 10.24 0 24.576-5.12 34.816L461.824 928.768c-10.24 5.12-20.48 5.12-24.576 5.12z" />
                </svg>
                <span class="text">今日天气</span>
                <span class="line"></span>
            </div>
            <div class="joe_aside__item-contain">
                <div id="weather-v2-plugin-standard"></div>
            </div>
        </section>
    <?php endif; ?>
    <?php if ($this->options->JADContent) : ?>
        <a class="joe_aside__item advert" target="_blank" rel="noopener noreferrer nofollow" href="<?php echo explode("||", $this->options->JADContent)[1]; ?>" title="广告">
            <img class="lazyload" width="100%" src="<?php _getLazyload() ?>" data-src="<?php echo explode("||", $this->options->JADContent)[0]; ?>" onerror="javascript: this.src='<?php _getLazyload() ?>';" alt="广告" />
            <span class="icon">广告</span>
        </a>
    <?php endif; ?>
</aside>