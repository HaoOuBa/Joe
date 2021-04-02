<?php $this->related(4)->to($relatedPosts); ?>
<?php if ($relatedPosts->have()) : ?>
    <div class="joe_detail__related">
        <div class="joe_detail__related-title">相关推荐</div>
        <div class="joe_detail__related-content">
            <?php while ($relatedPosts->next()) : ?>
                <a class="item" href="<?php $relatedPosts->permalink(); ?>" title="<?php $relatedPosts->title(); ?>">
                    <img class="lazyload" src="<?php _getLazyload(); ?>" data-src="<?php echo _getThumbnails($relatedPosts)[0]; ?>" alt="<?php $relatedPosts->title(); ?>" />
                    <h6><?php $relatedPosts->title(); ?></h6>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
<?php endif; ?>