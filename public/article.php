<div class="joe_detail">
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
                    <span class="text"><?php _getViews($this); ?> 阅读</span>
                    <span class="line">/</span>
                    <span class="text" id="Joe_Baidu_Record">正在检测是否收录...</span>
                </div>
            </div>
        </div>
        <time class="joe_detail__count-created" datetime="<?php $this->date('m/d'); ?>"><?php $this->date('m/d'); ?></time>
    </div>
    <div class="joe_detail__article">
        <!-- 如果是文章页面，选择输出 -->
        <?php if ($this->is('post')) : ?>
            <!-- 设置了密码，则显示密码 -->
            <?php if ($this->hidden) : ?>
                
                <!-- 未设置密码，正常输出 -->
            <?php else : ?>
                <?php _parseContent($this) ?>
            <?php endif; ?>
            <!-- 如果是独立页面，直接输出内容 -->
        <?php else : ?>
            <?php _parseContent($this) ?>
        <?php endif; ?>
    </div>
</div>