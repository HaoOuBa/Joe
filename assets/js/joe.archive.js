/* 搜索页面需要用到的JS */
document.addEventListener('DOMContentLoaded', function () {
    /* 激活列表特效 */
    {
        var wow = $('.joe_archive__list').attr('data-wow');
        if (wow !== 'off' && wow)
            new WOW({
                boxClass: 'wow',
                animateClass: 'animated '.concat(wow),
                offset: 0,
                mobile: true,
                live: true,
                scrollContainer: null
            }).init();
    }
});
