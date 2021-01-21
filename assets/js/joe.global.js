window.Joe = function () {
    let IsMobile = false;
    if (/windows phone|iphone|android/gi.test(window.navigator.userAgent)) {
        IsMobile = true;
    } else {
        IsMobile = false;
    }

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
    /* Timelife */
    if ($('.joe_aside__item.timelife').length !== 0) {
        let timelife = [
            { title: '今日已经过去', endTitle: '小时', num: 0, percent: '0%' },
            { title: '这周已经过去', endTitle: '天', num: 0, percent: '0%' },
            { title: '本月已经过去', endTitle: '天', num: 0, percent: '0%' },
            { title: '今年已经过去', endTitle: '个月', num: 0, percent: '0%' }
        ];
        {
            let nowDate = +new Date();
            let todayStartDate = new Date(new Date().toLocaleDateString()).getTime();
            let todayPassHours = (nowDate - todayStartDate) / 1000 / 60 / 60;
            let todayPassHoursPercent = (todayPassHours / 24) * 100;
            timelife[0].num = parseInt(todayPassHours);
            timelife[0].percent = parseInt(todayPassHoursPercent) + '%';
        }
        {
            let weeks = { 0: 7, 1: 1, 2: 2, 3: 3, 4: 4, 5: 5, 6: 6 };
            let weekDay = weeks[new Date().getDay()];
            let weekDayPassPercent = (weekDay / 7) * 100;
            timelife[1].num = parseInt(weekDay);
            timelife[1].percent = parseInt(weekDayPassPercent) + '%';
        }
        {
            let year = new Date().getFullYear();
            let date = new Date().getDate();
            let month = new Date().getMonth() + 1;
            let monthAll = new Date(year, month, 0).getDate();
            let monthPassPercent = (date / monthAll) * 100;
            timelife[2].num = date;
            timelife[2].percent = parseInt(monthPassPercent) + '%';
        }
        {
            let month = new Date().getMonth() + 1;
            let yearPass = (month / 12) * 100;
            timelife[3].num = month;
            timelife[3].percent = parseInt(yearPass) + '%';
        }
        let htmlStr = '';
        timelife.forEach((item, index) => {
            htmlStr += `
                <div class="item">
                    <div class="title">
                        ${item.title}
                        <span class="text">${item.num}</span>
                        ${item.endTitle}
                    </div>
                    <div class="progress">
                        <div class="progress-bar">
                            <div class="progress-bar-inner progress-bar-inner-${index}" style="width: ${item.percent}"></div>
                        </div>
                        <div class="progress-percentage">${item.percent}</div>
                    </div>
                </div>
            `;
        });
        $('.joe_aside__item.timelife .joe_aside__item-contain').html(htmlStr);
    }

    /* Weather */
    if ($('.joe_aside__item.weather').length !== 0) {
        const key = $('.joe_aside__item.weather').attr('data-key');
        const style = $('.joe_aside__item.weather').attr('data-style');
        const aqiColor = { 1: 'FFFFFF', 2: '4A4A4A', 3: 'FFFFFF' };
        window.WIDGET = { CONFIG: { layout: 2, width: '220', height: '270', background: style, dataColor: aqiColor[style], language: 'zh', key: key } };
    }

    /* Ranking */
    if ($('.joe_aside__item.ranking').length !== 0) {
        $.ajax({
            url: '/index.php/action/ranking',
            success(res) {
                $('.joe_aside__item.ranking .joe_aside__item-title .text').html(res.title);
                let htmlStr = '';
                if (res.code === 1) {
                    res.data.forEach((item, index) => {
                        htmlStr += `
                            <li class="item">
                                <span class="sort">${index + 1}</span>
                                <a class="link" href="${item.url}" title="${item.title}" target="_blank" rel="noopener noreferrer nofollow">${item.title}</a>
                            </li>
                        `;
                    });
                } else {
                    htmlStr += `<li class="error">数据抓取异常！</li>`;
                }
                $('.joe_aside__item.ranking .joe_aside__item-contain').html(htmlStr);
            }
        });
    }

    /* Index Swiper */
    if ($('.joe_index__banner .swiper-container').length > 0) {
        let direction = 'horizontal';
        if (!IsMobile && $('.joe_index__banner-recommend .item').length === 2) direction = 'vertical';
        new Swiper('.swiper-container', { direction, loop: true, autoplay: true, mousewheel: true, pagination: { el: '.swiper-pagination' } });
    }

    new LazyLoad('.lazyload');
};

document.addEventListener('DOMContentLoaded', () => Joe());
