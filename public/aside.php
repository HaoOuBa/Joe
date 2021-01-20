<?php if ($this->options->JAside && $this->fields->aside !== "off") :  ?>
    <aside class="joe_aside">
        <?php if (in_array('author', $this->options->JAside)) : ?>
            <section class="joe_aside__item author">
                <img class="image" src="" alt="<?php $this->author->screenName(); ?>" />
            </section>
        <?php endif; ?>
    </aside>
<?php endif; ?>