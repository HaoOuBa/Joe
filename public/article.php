<div class="joe_detail" data-cid="<?php echo $this->cid ?>">
    <?php if (sizeof($this->categories) > 0 && $this->is('post')) : ?>
        <div class="joe_detail__category">
            <?php foreach (array_slice($this->categories, 0, 5) as $key => $item) : ?>
                <a href="<?php echo $item['permalink']; ?>" class="item item-<?php echo $key ?>" title="<?php echo $item['name']; ?>"><?php echo $item['name']; ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <h1 class="joe_detail__title"><?php $this->title() ?></h1>
    <div class="joe_detail__count">
        <div class="joe_detail__count-information">
            <img class="avatar" src="<?php _getAvatarByMail($this->author->mail) ?>" alt="<?php $this->author(); ?>" />
            <div class="meta">
                <div class="author">
                    <a class="link" href="<?php $this->author->permalink(); ?>" title="<?php $this->author(); ?>"><?php $this->author(); ?></a>
                </div>
                <div class="item">
                    <span class="text"><?php $this->date('Y-m-d'); ?></span>
                    <span class="line">/</span>
                    <span class="text"><?php $this->commentsNum('%d'); ?> 评论</span>
                    <span class="line">/</span>
                    <span class="text" id="Joe_Article_Views"><?php _getViews($this); ?> 阅读</span>
                    <span class="line">/</span>
                    <span class="text" id="Joe_Baidu_Record">正在检测是否收录...</span>
                </div>
            </div>
        </div>
        <time class="joe_detail__count-created" datetime="<?php $this->date('m/d'); ?>"><?php $this->date('m/d'); ?></time>
    </div>
    <div class="joe_detail__article">
        <?php if ($this->is('post')) : ?>
            <?php if ($this->hidden) : ?>
                <div class="joe_detail__article-protected" data-action="<?php echo Typecho_Widget::widget('Widget_Security')->getTokenUrl($this->permalink); ?>">
                    需要密码访问的文章 待完成
                </div>
            <?php else : ?>
                <?php _parseContent($this) ?>
            <?php endif; ?>
        <?php else : ?>
            <?php _parseContent($this) ?>
        <?php endif; ?>
    </div>
    <div class="joe_detail__agree">
        <div class="agree">
            <div class="icon">
                <svg class="icon-1" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5948" width="28" height="28">
                    <path d="M736 128c-65.952 0-128.576 25.024-176.384 70.464-4.576 4.32-28.672 28.736-47.328 47.68L464.96 199.04C417.12 153.216 354.272 128 288 128c-141.152 0-256 114.848-256 256 0 82.432 41.184 144.288 76.48 182.496l316.896 320.128C450.464 911.68 478.304 928 512 928c33.696 0 61.568-16.32 86.752-41.504l316.736-320 2.208-2.464C955.904 516.384 992 471.392 992 384 992 242.848 877.152 128 736 128z" p-id="5949" fill="#ffffff"></path>
                </svg>
                <svg class="icon-2" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5749" width="28" height="28">
                    <path d="M512 928c-28.928 0-57.92-12.672-86.624-41.376L106.272 564C68.064 516.352 32 471.328 32 384c0-141.152 114.848-256 256-256 53.088 0 104 16.096 147.296 46.592 14.432 10.176 17.92 30.144 7.712 44.608-10.176 14.432-30.08 17.92-44.608 7.712C366.016 204.064 327.808 192 288 192c-105.888 0-192 86.112-192 192 0 61.408 20.288 90.112 59.168 138.688l315.584 318.816C486.72 857.472 499.616 863.808 512 864c12.704 0.192 24.928-6.176 41.376-22.624l316.672-319.904C896.064 493.28 928 445.696 928 384c0-105.888-86.112-192-192-192-48.064 0-94.08 17.856-129.536 50.272l-134.08 134.112c-12.512 12.512-32.736 12.512-45.248 0s-12.512-32.736 0-45.248l135.104-135.136C610.56 151.808 671.904 128 736 128c141.152 0 256 114.848 256 256 0 82.368-41.152 144.288-75.68 181.696l-317.568 320.8C569.952 915.328 540.96 928 512 928z" p-id="5750" fill="#ffffff"></path>
                </svg>
            </div>
            <span class="text"><?php _getAgree($this) ?></span>
        </div>
    </div>
</div>