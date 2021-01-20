<?php if ($this->options->JAside && $this->fields->aside !== "off") :  ?>
    <aside class="joe_aside">
        <?php if (in_array('author', $this->options->JAside)) : ?>
            <section class="joe_aside__item author">
                <img class="image" src="<?php $this->options->JAside_Author_Image() ?>" alt="<?php $this->author->screenName(); ?>" />
                <div class="user">
                    <img class="avatar" src="<?php _getAvatarByMail($this->author->mail) ?>" alt="<?php $this->author->screenName(); ?>" />
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
                <h3 class="joe_aside__item-title">
                    <svg class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                        <path d="M864.801 895.471h-33.56v-96.859c0-126.081-73.017-235.093-179.062-287.102 106.046-52.01 179.062-161.022 179.062-287.102v-96.859h33.56c17.301 0 31.325-14.327 31.325-32 0-17.673-14.024-32-31.325-32H159.018c-17.3 0-31.325 14.327-31.325 32 0 17.673 14.025 32 31.325 32h33.02v96.859c0 126.08 73.016 235.092 179.061 287.102-106.046 52.009-179.062 161.02-179.062 287.101v96.859h-33.02c-17.3 0-31.325 14.326-31.325 32s14.025 32 31.325 32H864.8c17.301 0 31.325-14.326 31.325-32s-14.023-31.999-31.324-31.999zM256.05 222.427v-94.878h513.046v94.878c0 141.674-114.85 256.522-256.523 256.522-141.674 0-256.523-114.848-256.523-256.522z m513.046 673.044H256.05v-94.879c0-141.674 114.849-256.521 256.523-256.521 141.673 0 256.523 114.848 256.523 256.521v94.879z" p-id="29837"></path>
                        <path d="M544.141 384c0-17.69-14.341-32.031-32.031-32.031-71.694 0-127.854-56.161-127.854-127.855 0-17.69-14.341-32.032-32.031-32.032s-32.032 14.341-32.032 32.032c0 107.617 84.3 191.918 191.917 191.918 17.69 0 32.031-14.342 32.031-32.032z" p-id="29838"></path>
                    </svg>
                    <span class="text">人生倒计时</span>
                    <span class="line"></span>
                </h3>
                <div class="joe_aside__item-contain"></div>
            </section>
        <?php endif; ?>
    </aside>
<?php endif; ?>