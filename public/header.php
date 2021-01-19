<header class="joe_header">

    <!-- Header Above -->
    <div class="joe_header__above">
        <div class="joe_container">
            <a class="joe_header__above-logo" href="<?php $this->options->siteUrl(); ?>">
                <img src="<?php $this->options->JLogo() ?>" alt="<?php $this->options->title(); ?>" />
            </a>
            <nav class="joe_header__above-nav">
                <a class="item <?php echo $this->is('index') ? 'active' : '' ?>" href="<?php $this->options->siteUrl(); ?>">首页</a>

                <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>

                <!-- 判断是否超出设置的个数，未超出全部直接显示 -->
                <?php if (count($pages->stack) <= $this->options->JNavMaxNum) : ?>
                    <?php foreach ($pages->stack as $item) : ?>
                        <a class="item" href="">首页</a>
                    <?php endforeach; ?>
                <?php else : ?>

                <?php endif; ?>
            </nav>
            <form class="joe_header__above-search" method="post" action="<?php $this->options->siteUrl(); ?>">
                <input maxlength="16" autocomplete="off" placeholder="请输入关键字..." name="s" class="input" type="text" />
                <button type="submit" class="submit">Search</button>
                <span class="icon"></span>
            </form>
        </div>
    </div>


</header>