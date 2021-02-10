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
        <img class="avatar lazyload" src="<?php _getAvatarLazyload(); ?>" data-src="<?php _getAvatarByMail($this->author->mail) ?>" onerror="javascript: this.src = '<?php _getAvatarLazyload(); ?>'" alt="<?php $this->author(); ?>" />
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
            <form class="joe_detail__article-protected" action="<?php echo Typecho_Widget::widget('Widget_Security')->getTokenUrl($this->permalink); ?>">
                <div class="contain">
                    <svg class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                        <path d="M812.63104 664.064h-439.0912a79.0272 79.0272 0 0 0-78.95552 79.09888v196.9664h518.04672a79.0272 79.0272 0 0 0 78.9504-79.09888v-117.84704a79.0272 79.0272 0 0 0-78.9504-79.11936z" fill="#F4CA1C" p-id="7008"></path>
                        <path d="M812.97408 382.976h-32.36864V313.3696a272.256 272.256 0 1 0-544.512 0V382.976h-25.0624A113.91488 113.91488 0 0 0 97.28 496.77312v367.32928A113.91488 113.91488 0 0 0 211.03104 977.92h601.94304A113.90976 113.90976 0 0 0 926.72 864.1024V496.77312A113.90976 113.90976 0 0 0 812.97408 382.976zM305.7152 313.3696a202.63424 202.63424 0 1 1 405.26848 0V382.976H305.7152V313.3696zM857.088 864.1024a44.1856 44.1856 0 0 1-44.12416 44.15488H211.03104a44.19584 44.19584 0 0 1-44.11904-44.15488V496.77312a44.19584 44.19584 0 0 1 44.11904-44.16512h601.94304a44.1856 44.1856 0 0 1 44.12416 44.16v367.3344z m-331.71456-309.9648a62.69952 62.69952 0 0 0-34.816 114.82112v103.45984a34.816 34.816 0 1 0 69.632 0v-103.45984a62.69952 62.69952 0 0 0-34.80576-114.82112z" fill="#595BB3" p-id="7009"></path>
                    </svg>
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