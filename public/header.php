<header class="joe_header">
    <div class="joe_header__above">
        <div class="joe_container">
            <a title="<?php $this->options->title(); ?>" class="joe_header__above-logo" href="<?php $this->options->siteUrl(); ?>">
                <img class="lazyload" src="" data-original="<?php $this->options->JLogo() ?>" alt="<?php $this->options->title(); ?>" />
            </a>
            <nav class="joe_header__above-nav">
                <a class="item <?php echo $this->is('index') ? 'active' : '' ?>" href="<?php $this->options->siteUrl(); ?>" title="首页">首页</a>
                <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                <?php if (count($pages->stack) <= $this->options->JNavMaxNum) : ?>
                    <?php foreach ($pages->stack as $item) : ?>
                        <a class="item <?php echo $this->is('page', $item['slug']) ? 'active' : '' ?>" href="<?php echo $item['permalink'] ?>" title="<?php echo $item['title'] ?>"><?php echo $item['title'] ?></a>
                    <?php endforeach; ?>
                <?php else : ?>
                    <?php foreach (array_slice($pages->stack, 0, $this->options->JNavMaxNum) as $item) : ?>
                        <a class="item <?php echo $this->is('page', $item['slug']) ? 'active' : '' ?>" href="<?php echo $item['permalink'] ?>" title="<?php echo $item['title'] ?>"><?php echo $item['title'] ?></a>
                    <?php endforeach; ?>
                    <div class="joe_dropdown" trigger="click" placement="60px">
                        <div class="joe_dropdown__link">
                            <a href="#" rel="nofollow">更多</a>
                            <svg class="joe_dropdown__link-icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="14" height="14">
                                <path d="M561.873 725.165c-11.262 11.262-26.545 21.72-41.025 18.502-14.479 2.413-28.154-8.849-39.415-18.502L133.129 375.252c-17.697-17.696-17.697-46.655 0-64.352s46.655-17.696 64.351 0l324.173 333.021 324.977-333.02c17.696-17.697 46.655-17.697 64.351 0s17.697 46.655 0 64.351L561.873 725.165z" p-id="3535" fill="var(--main)"></path>
                            </svg>
                        </div>
                        <nav class="joe_dropdown__menu">
                            <?php foreach (array_slice($pages->stack, $this->options->JNavMaxNum) as $item) : ?>
                                <a class="<?php echo $this->is('page', $item['slug']) ? 'active' : '' ?>" href="<?php echo $item['permalink'] ?>" title="<?php echo $item['title'] ?>"><?php echo $item['title'] ?></a>
                            <?php endforeach; ?>
                        </nav>
                    </div>
                <?php endif; ?>
            </nav>
            <form class="joe_header__above-search" method="post" action="<?php $this->options->siteUrl(); ?>">
                <input maxlength="16" autocomplete="off" placeholder="请输入关键字..." name="s" class="input" type="text" />
                <button type="submit" class="submit">Search</button>
                <span class="icon"></span>
            </form>
        </div>
    </div>
    <div class="joe_header__below">
        <div class="joe_container">
            <nav class="joe_header__below-class">
                <?php $this->widget('Widget_Metas_Category_List')->to($item); ?>
                <?php while ($item->next()) : ?>
                    <?php if ($item->levels === 0) : ?>
                        <?php $children = $item->getAllChildren($item->mid); ?>
                        <?php if (empty($children)) : ?>
                            <a class="item <?php echo $this->is('category', $item->slug) ? 'active' : '' ?>" href="<?php $item->permalink(); ?>" title="<?php $item->name(); ?>"><?php $item->name(); ?></a>
                        <?php else : ?>
                            <div class="joe_dropdown" trigger="hover">
                                <div class="joe_dropdown__link">
                                    <a class="item <?php echo $this->is('category', $item->slug) ? 'active' : '' ?>" href="<?php $item->permalink(); ?>" title="<?php $item->name(); ?>"><?php $item->name(); ?></a>
                                    <svg class="joe_dropdown__link-icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="13" height="13">
                                        <path d="M561.873 725.165c-11.262 11.262-26.545 21.72-41.025 18.502-14.479 2.413-28.154-8.849-39.415-18.502L133.129 375.252c-17.697-17.696-17.697-46.655 0-64.352s46.655-17.696 64.351 0l324.173 333.021 324.977-333.02c17.696-17.697 46.655-17.697 64.351 0s17.697 46.655 0 64.351L561.873 725.165z" p-id="3535" fill="var(--minor)"></path>
                                    </svg>
                                </div>
                                <nav class="joe_dropdown__menu">
                                    <?php foreach ($children as $mid) : ?>
                                        <?php $child = $item->getCategory($mid); ?>
                                        <a class="<?php echo $this->is('category', $child['slug']) ? 'active' : '' ?>" href="<?php echo $child['permalink'] ?>" title="<?php echo $child['name']; ?>"><?php echo $child['name']; ?></a>
                                    <?php endforeach; ?>
                                </nav>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            </nav>
        </div>
    </div>
</header>