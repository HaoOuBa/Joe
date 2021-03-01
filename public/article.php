<?php if (sizeof($this->categories) > 0 || $this->user->uid == $this->authorId) : ?>
    <div class="joe_detail__category">
        <?php if (sizeof($this->categories) > 0) : ?>
            <?php foreach (array_slice($this->categories, 0, 5) as $key => $item) : ?>
                <a href="<?php echo $item['permalink']; ?>" class="item item-<?php echo $key ?>" title="<?php echo $item['name']; ?>"><?php echo $item['name']; ?></a>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if ($this->user->uid == $this->authorId) : ?>
            <?php if ($this->is('post')) : ?>
                <a class="edit" target="_blank" rel="noopener noreferrer" href="<?php $this->options->adminUrl(); ?>write-post.php?cid=<?php echo $this->cid; ?>">编辑文章</a>
            <?php else : ?>
                <a class="edit" target="_blank" rel="noopener noreferrer" href="<?php $this->options->adminUrl(); ?>write-page.php?cid=<?php echo $this->cid; ?>">编辑页面</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>

<h1 class="joe_detail__title"><?php $this->title() ?></h1>
<div class="joe_detail__count">
    <div class="joe_detail__count-information">
        <img width="35" height="35" class="avatar lazyload" src="<?php _getAvatarLazyload(); ?>" data-src="<?php _getAvatarByMail($this->author->mail) ?>" onerror="javascript: this.src = '<?php _getAvatarLazyload(); ?>'" alt="<?php $this->author(); ?>" />
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
    <?php if (!$this->hidden && $this->fields->video) : ?>
        <div class="joe_detail__article-video">
            <div class="play">
                <div class="title">播放预览</div>
                <div class="box">
                    <iframe allowfullscreen="true" data-player="<?php echo $this->options->JCustomPlayer ? $this->options->JCustomPlayer : '/usr/themes/Joe/library/player.php?url=' ?>"></iframe>
                </div>
            </div>
            <div class="episodes">
                <div class="title">剧集列表</div>
                <?php $video_arr = explode("\r\n", $this->fields->video); ?>
                <div class="box">
                    <?php foreach ($video_arr as $item) : ?>
                        <div class="item" data-src="<?php echo explode("$", $item)[1] ?>"><?php echo explode("$", $item)[0] ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif ?>

    <?php if ($this->is('post')) : ?>
        <?php if ($this->hidden) : ?>
            <form class="joe_detail__article-protected" action="<?php echo Typecho_Widget::widget('Widget_Security')->getTokenUrl($this->permalink); ?>">
                <div class="contain">
                    <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="20" height="20"><path d="M812.631 664.064H373.54a79.027 79.027 0 0 0-78.956 79.099v196.966h518.047a79.027 79.027 0 0 0 78.95-79.099V743.183a79.027 79.027 0 0 0-78.95-79.119z" fill="#F4CA1C"/><path d="M812.974 382.976h-32.369V313.37a272.256 272.256 0 1 0-544.512 0v69.606h-25.062A113.915 113.915 0 0 0 97.28 496.773v367.33A113.915 113.915 0 0 0 211.031 977.92h601.943A113.91 113.91 0 0 0 926.72 864.102V496.773a113.91 113.91 0 0 0-113.746-113.797zM305.715 313.37a202.634 202.634 0 1 1 405.269 0v69.606H305.715V313.37zm551.373 550.732a44.186 44.186 0 0 1-44.124 44.155H211.03a44.196 44.196 0 0 1-44.119-44.155V496.773a44.196 44.196 0 0 1 44.119-44.165h601.943a44.186 44.186 0 0 1 44.124 44.16v367.334zM525.373 554.138a62.7 62.7 0 0 0-34.816 114.82v103.46a34.816 34.816 0 1 0 69.632 0v-103.46a62.7 62.7 0 0 0-34.805-114.82z" fill="#595BB3"/></svg>
                    <input class="password" type="password" placeholder="请输入访问密码...">
                    <button class="submit" type="submit">确定</button>
                </div>
            </form>
        <?php else : ?>
            <?php _parseContent($this, $this->user->hasLogin()) ?>
        <?php endif; ?>
    <?php else : ?>
        <?php _parseContent($this, $this->user->hasLogin()) ?>
    <?php endif; ?>
</div>