console.time('Archive.js执行时长');
document.addEventListener('DOMContentLoaded', () => {
    /* 激活列表特效 */
    {
        const wow = $('.joe_archive__list').attr('data-wow');
        if (wow !== 'off' && wow) new WOW({ boxClass: 'wow', animateClass: `animated ${wow}`, offset: 0, mobile: true, live: true, scrollContainer: null }).init();
    }
    console.timeEnd('Archive.js执行时长');
});
