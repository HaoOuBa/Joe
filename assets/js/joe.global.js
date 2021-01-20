window.Joe = function () {
    /* Dropdown */
    {
        $('.joe_dropdown').each(function (index, item) {
            const menu = $(this).find('.joe_dropdown__menu');
            /* 弹出方式 */
            const trigger = $(item).attr('trigger') || 'click';
            /* 弹出高度 */
            const placement = $(item).attr('placement') || $(this).height() || 0;
            /* 设置弹出高度 */
            menu.css('top', placement);
            /* 如果是hover，则绑定hover事件 */
            if (trigger === 'hover') {
                $(this).hover(
                    () => $(this).addClass('active'),
                    () => $(this).removeClass('active')
                );
            } else {
                /* 否则绑定点击事件 */
                $(this).on('click', function (e) {
                    $(this).toggleClass('active');
                    $(document).one('click', () => $(this).removeClass('active'));
                    e.stopPropagation();
                });
                menu.on('click', e => e.stopPropagation());
            }
        });
    }
};

document.addEventListener('DOMContentLoaded', () => Joe());
