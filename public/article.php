<h1 class="joe_detail__title"><?php _getEncryptionTitle($this) ?></h1>
<div class="joe_detail__count">
    <div class="joe_detail__count-information">
        <img class="avatar lazyload" src="<?php _getAvatarLazyload(); ?>" onerror="javascript: this.src = '<?php _getAvatarLazyload(); ?>'" data-original="<?php _getAvatarByMail($this->author->mail) ?>" alt="<?php $this->author(); ?>" />
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