<article class="joe_detail__article">
    <?php if (!$this->hidden && $this->fields->video) : ?>
        <div class="joe_detail__article-video">
            <div class="play">
                <div class="title">播放预览</div>
                <div class="box">
                    <iframe allowfullscreen="true" data-player="<?php $this->options->JCustomPlayer ? $this->options->JCustomPlayer() : Helper::options()->themeUrl('library/player.php?url=') ?>"></iframe>
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
                    <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                        <path d="M812.631 664.064H373.54a79.027 79.027 0 0 0-78.956 79.099v196.966h518.047a79.027 79.027 0 0 0 78.95-79.099V743.183a79.027 79.027 0 0 0-78.95-79.119z" fill="#F4CA1C" />
                        <path d="M812.974 382.976h-32.369V313.37a272.256 272.256 0 1 0-544.512 0v69.606h-25.062A113.915 113.915 0 0 0 97.28 496.773v367.33A113.915 113.915 0 0 0 211.031 977.92h601.943A113.91 113.91 0 0 0 926.72 864.102V496.773a113.91 113.91 0 0 0-113.746-113.797zM305.715 313.37a202.634 202.634 0 1 1 405.269 0v69.606H305.715V313.37zm551.373 550.732a44.186 44.186 0 0 1-44.124 44.155H211.03a44.196 44.196 0 0 1-44.119-44.155V496.773a44.196 44.196 0 0 1 44.119-44.165h601.943a44.186 44.186 0 0 1 44.124 44.16v367.334zM525.373 554.138a62.7 62.7 0 0 0-34.816 114.82v103.46a34.816 34.816 0 1 0 69.632 0v-103.46a62.7 62.7 0 0 0-34.805-114.82z" fill="#595BB3" />
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
</article>