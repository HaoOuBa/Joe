window.Joe = function () {
    const BASE_API = '/index.php/joe/api';

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
            url: BASE_API,
            type: 'POST',
            data: {
                routeType: 'ranking'
            },
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

    /* Index Title */
    if ($('.joe_index__list').length > 0) {
        let queryData = { page: 1, pageSize: 10, type: 'created' };
        const initDom = () => {
            $('.joe_index__list').html('');
            const activeItem = $(`.joe_index__title-title .item[data-type="${queryData.type}"]`);
            const activeLine = $('.joe_index__title-title .line');
            activeItem.addClass('active').siblings().removeClass('active');
            activeLine.css({ left: activeItem.position().left, width: activeItem.width() });
        };
        const pushDom = () => {
            $.ajax({
                url: BASE_API,
                type: 'POST',
                data: {
                    routeType: 'list',
                    page: queryData.page,
                    pageSize: queryData.pageSize,
                    type: queryData.type
                },
                success(res) {
                    res.data.forEach(_ => {
                        $('.joe_index__list').append(`
                            <li class="joe_list__list">
                                <div class="line"></div>
                                <a href="${_.permalink}" class="thumbnail" title="${_.title}">
                                    <img alt="" />
                                    <time datetime="${_.time}">${_.time}</time>
                                    <svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                                        <path d="M903.93077753 107.30625876H115.78633587C64.57261118 107.30625876 22.58166006 149.81138495 22.58166006 201.02510964v624.26547214c0 51.7240923 41.99095114 93.71694641 93.71694641 93.7169464h788.14444164c51.7202834 0 93.71694641-41.99285557 93.71694642-93.7169464v-624.26547214c-0.51227057-51.21372469-43.01739676-93.71885088-94.229217-93.71885088zM115.78633587 171.8333054h788.65671224c16.385041 0 29.70407483 13.31522639 29.70407484 29.70407482v390.22828696l-173.60830179-189.48107072c-12.80486025-13.82749697-30.21634542-21.50774542-48.14010264-19.97093513-17.92375723 1.02073227-34.82106734 10.75387344-46.60138495 26.11437327l-172.58185762 239.1598896-87.06123767-85.52061846c-12.28878076-11.78222353-27.65308802-17.92375723-44.03812902-17.92375577-16.3907529 0.50846167-31.75506163 7.67644101-43.52966736 20.48129978L86.59453164 821.70468765V202.04965083c-1.02454117-17.41529409 12.80486025-30.73052046 29.19180423-30.21634543zM903.93077753 855.50692718H141.90642105l222.25496164-245.81940722 87.0593347 86.03669649c12.80105134 12.80676323 30.21253651 18.95020139 47.11555999 17.4172 17.40958218-1.53871621 33.79652618-11.26614404 45.06267018-26.11818071l172.58376063-238.64762047 216.11152349 236.08817198 2.05098681-1.54062067v142.87778132c0.50846167 16.3907529-13.31522639 29.70597929-30.21444096 29.70597928z m0 0" p-id="1916"></path>
                                        <path d="M318.07226687 509.82713538c79.88945091 0 144.41649754-65.03741277 144.41649754-144.41649753 0-79.37718032-64.52704663-144.92495923-144.41649754-144.92495922-79.89135536 0-144.41649754 64.52704663-144.41649756 144.41268862 0 79.89135536 64.52514218 144.92876814 144.41649756 144.92876813z m0-225.3266807c44.55230407 0 80.91208763 36.36168802 80.91208762 80.91018317 0 44.55611297-35.84751297 81.43007159-80.91208762 81.43007012-45.06838356 0-80.91589654-36.35978356-80.91589508-80.91589507 0-44.55611297 36.87205415-81.42435823 80.91589508-81.42435822z m0 0" p-id="1917"></path>
                                    </svg>
                                </a>
                            </li>
                        `);
                    });
                }
            });
        };
        initDom();
        pushDom();
        $('.joe_index__title-title .item').on('click', function () {
            queryData = { page: 1, pageSize: 10, type: $(this).attr('data-type') };
            initDom();
            pushDom();
        });
    }

    new LazyLoad('.lazyload');
};

document.addEventListener('DOMContentLoaded', () => Joe());
