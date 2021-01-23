<div class="joe_detail" data-cid="<?php echo $this->cid ?>">
    <?php if (sizeof($this->categories) > 0 && $this->is('post')) : ?>
        <div class="joe_detail__category">
            <?php foreach (array_slice($this->categories, 0, 5) as $key => $item) : ?>
                <a href="<?php echo $item['permalink']; ?>" class="item item-<?php echo $key ?>" title="<?php echo $item['name']; ?>"><?php echo $item['name']; ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <h1 class="joe_detail__title"><?php _getEncryptionTitle($this) ?></h1>
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
    <div class="joe_detail__copyright">
        <div class="content">
            <div class="item">
                <svg class="icon" width="18" height="18" viewBox="0 0 1024 1024">
                    <path d="M614.72 554.538c-49.086-6.399-100.27-2.1-149.256-2.1-119.465 0-209.04 95.972-206.84 215.437 0 17.095 8.498 31.99 23.493 40.488 14.896 10.697 34.09 14.896 53.285 17.095 61.882 6.398 123.664 6.398 198.342 6.398 40.488 0 93.872-2.1 142.858-4.298 27.692 0 53.284-4.3 78.877-14.896 19.194-8.498 29.89-19.194 31.99-40.488 8.498-104.57-72.478-204.84-172.75-217.636zM680.8 375.39c0-87.474-74.678-162.053-164.251-162.053-89.574 0-162.053 74.679-162.053 162.053-2.1 87.474 74.678 164.252 162.053 164.252 89.673 0 164.252-74.678 164.252-164.252z" fill="#FFFFFF"></path>
                    <path d="M512.35 0C228.733 0 0.5 228.233 0.5 511.85s228.233 511.85 511.85 511.85 511.85-228.233 511.85-511.85S795.967 0 512.35 0z m275.12 772.074c-2.1 21.294-12.797 31.99-31.991 40.488-25.593 10.697-51.185 14.896-78.877 14.896-49.086 2.099-102.37 4.298-142.858 4.298-74.678 0-136.46 0-198.342-6.398-19.195-2.1-38.389-6.398-53.285-17.095-14.895-8.497-23.493-23.493-23.493-40.488-2.1-119.465 87.475-215.437 206.84-215.437 49.085 0 100.27-4.299 149.256 2.1 100.27 12.896 181.247 113.166 172.75 217.636zM354.495 375.39c0-87.474 72.479-162.053 162.053-162.053S680.8 288.016 680.8 375.39c0 89.574-74.679 164.252-164.252 164.252-87.375 0-164.152-76.778-162.053-164.252z" fill="#249FF8"></path>
                </svg>
                <span>版权属于：</span>
                <p class="text"><?php $this->options->title() ?></p>
            </div>
            <div class="item">
                <svg class="icon" width="18" height="18" viewBox="0 0 1024 1024">
                    <path d="M511.854421 0a511.854421 511.854421 0 1 0 512.145579 511.854421A511.854421 511.854421 0 0 0 511.854421 0z" fill="#39B54A"></path>
                    <path d="M576.491328 630.355417l-116.462895 116.462894a129.56497 129.56497 0 0 1-182.555587 0l-2.0381-2.038101a128.982656 128.982656 0 0 1 0-182.26443l81.232868-81.232868a179.644015 179.644015 0 0 0 13.102076 70.460051l-52.69946 52.408302a69.877737 69.877737 0 0 0 0 98.702303l2.038101 2.038101a70.168894 70.168894 0 0 0 98.702303 0l116.462895-116.462894a69.877737 69.877737 0 0 0 0-98.702304l-2.038101-2.0381a69.586579 69.586579 0 0 0-13.975547-10.772818l42.508956-42.508956a128.109184 128.109184 0 0 1 13.102076 11.355132l2.0381 2.0381a129.273813 129.273813 0 0 1 0 182.26443z" fill="#FFFFFF"></path>
                    <path d="M746.235997 460.901905l-81.232869 81.232869a179.352858 179.352858 0 0 0-13.102076-70.460051l52.69946-52.408303a69.877737 69.877737 0 0 0 0-98.702303l-2.038101-2.038101a69.877737 69.877737 0 0 0-98.702303 0l-116.462894 116.462895a69.877737 69.877737 0 0 0 0 98.702303l2.0381 2.038101a68.421951 68.421951 0 0 0 13.975548 10.772817l-42.508957 42.508957a136.552744 136.552744 0 0 1-13.102076-11.355132l-2.0381-2.038101a128.982656 128.982656 0 0 1 0-182.26443l116.462894-116.462894a129.56497 129.56497 0 0 1 182.555587 0l2.038101 2.0381a128.982656 128.982656 0 0 1 0 182.26443z" fill="#FFFFFF"></path>
                </svg>
                <span>本文链接：</span>
                <p class="text">
                    <a class="link" href="<?php $this->permalink() ?>" target="_blank" rel="noopener noreferrer nofollow"><?php $this->permalink() ?></a>
                    （转载时请注明本文出处及文章链接）
                </p>
            </div>
            <div class="item">
                <svg class="icon" width="18" height="18" viewBox="0 0 1024 1024">
                    <path d="M512 512m-512 0a512 512 0 1 0 1024 0 512 512 0 1 0-1024 0Z" fill="#F3B243"></path>
                    <path d="M630.784 323.584m-90.112 0a90.112 90.112 0 1 0 180.224 0 90.112 90.112 0 1 0-180.224 0Z" fill="#FFFFFF"></path>
                    <path d="M630.784 688.128m-90.112 0a90.112 90.112 0 1 0 180.224 0 90.112 90.112 0 1 0-180.224 0Z" fill="#FFFFFF"></path>
                    <path d="M319.488 512m-90.112 0a90.112 90.112 0 1 0 180.224 0 90.112 90.112 0 1 0-180.224 0Z" fill="#FFFFFF"></path>
                    <path d="M341.037056 480.370688l257.343488-175.7184 27.713536 40.59136-257.339392 175.7184z" fill="#FFFFFF"></path>
                    <path d="M349.052928 488.452096l252.854272 182.10816-28.725248 39.886848-252.874752-182.10816z" fill="#FFFFFF"></path>
                </svg>
                <span>作品采用：</span>
                <p class="text">
                    《
                    <a class="link" href="//creativecommons.org/licenses/by-nc-sa/4.0/deed.zh" target="_blank" rel="noopener noreferrer nofollow">署名-非商业性使用-相同方式共享 4.0 国际 (CC BY-NC-SA 4.0)</a>
                    》许可协议授权
                </p>
            </div>
        </div>
    </div>
    <?php $this->related(4)->to($item); ?>
    <?php if ($item->have()) : ?>
        <div class="joe_detail__related">
            <h5 class="joe_detail__related-title">相关推荐</h5>
            <ul class="joe_detail__related-list">
                <?php while ($item->next()) : ?>
                    <li class="item">
                        <a class="link" href="<?php $item->permalink(); ?>" title="<?php $item->title(); ?>">
                            <figure class="inner">
                                <img class="image lazyload" onerror="<?php _getLazyload() ?>" src="<?php _getLazyload(); ?>" data-original="<?php _getThumbnail($item); ?>" alt="<?php $item->title(); ?>" />
                                <figcaption class="title"><?php $item->title(); ?></figcaption>
                            </figure>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    <?php endif; ?>

</div>