console.time('Global.js执行时长');

document.addEventListener('DOMContentLoaded', () => {
    /* 昼夜模式 */
    {
        if (localStorage.getItem('data-night')) {
            $('html').attr('data-night', 'night');
            $('.joe_action_item.mode .icon-1').addClass('active');
            $('.joe_action_item.mode .icon-2').removeClass('active');
        } else {
            $('html').removeAttr('data-night');
            $('.joe_action_item.mode .icon-1').removeClass('active');
            $('.joe_action_item.mode .icon-2').addClass('active');
        }
        $('.joe_action_item.mode').on('click', () => {
            if (localStorage.getItem('data-night')) {
                $('.joe_action_item.mode .icon-1').removeClass('active');
                $('.joe_action_item.mode .icon-2').addClass('active');
                $('html').removeAttr('data-night');
                localStorage.removeItem('data-night');
            } else {
                $('.joe_action_item.mode .icon-1').addClass('active');
                $('.joe_action_item.mode .icon-2').removeClass('active');
                $('html').attr('data-night', 'night');
                localStorage.setItem('data-night', 'night');
            }
        });
    }

    /* 动态背景 */
    {
        if (!Joe.IS_MOBILE && Joe.DYNAMIC_BACKGROUND !== 'off' && Joe.DYNAMIC_BACKGROUND && !Joe.WALLPAPER_BACKGROUND_PC) {
            $.getScript(`https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/backdrop/${Joe.DYNAMIC_BACKGROUND}`);
        }
    }

    /* 激活全局下拉框功能 */
    {
        $('.joe_dropdown').each(function (index, item) {
            const menu = $(this).find('.joe_dropdown__menu');
            const trigger = $(item).attr('trigger') || 'click';
            const placement = $(item).attr('placement') || $(this).height() || 0;
            menu.css('top', placement);
            if (trigger === 'hover') {
                $(this).hover(
                    () => $(this).addClass('active'),
                    () => $(this).removeClass('active')
                );
            } else {
                $(this).on('click', function (e) {
                    $(this).toggleClass('active');
                    $(document).one('click', () => $(this).removeClass('active'));
                    e.stopPropagation();
                });
                menu.on('click', e => e.stopPropagation());
            }
        });
    }

    /* 激活全局返回顶部功能 */
    {
        const handleScroll = () => ((document.documentElement.scrollTop || document.body.scrollTop) > 300 ? $('.joe_action_item.scroll').addClass('active') : $('.joe_action_item.scroll').removeClass('active'));
        handleScroll();
        $(window).on('scroll', () => handleScroll());
        $('.joe_action_item.scroll').on('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    }

    /* 激活侧边栏人生倒计时功能 */
    {
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
						</div>`;
            });
            $('.joe_aside__item.timelife .joe_aside__item-contain').html(htmlStr);
        }
    }

    /* 激活侧边栏天气功能 */
    {
        if ($('.joe_aside__item.weather').length !== 0) {
            const key = $('.joe_aside__item.weather').attr('data-key');
            const style = $('.joe_aside__item.weather').attr('data-style');
            const aqiColor = { 1: 'FFFFFF', 2: '4A4A4A', 3: 'FFFFFF' };
            window.WIDGET = { CONFIG: { layout: 2, width: '220', height: '270', background: style, dataColor: aqiColor[style], language: 'zh', key: key } };
        }
    }

    /* 激活侧边栏排行榜功能 */
    {
        if ($('.joe_aside__item.ranking').length !== 0) {
            $.ajax({
                url: Joe.BASE_API,
                type: 'POST',
                data: { routeType: 'aside_ranking' },
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
    }

    /* 设置侧边栏最后一个元素的高度 */
    {
        $('.joe_aside__item:last-child').css('top', $('.joe_header').height() + 15);
    }

    /* 激活Live2d人物 */
    {
        if (Joe.LIVE2D !== 'off' && Joe.LIVE2D) {
            $.getScript('https://cdn.jsdelivr.net/npm/live2d-widget@3.1.4/lib/L2Dwidget.min.js', () => {
                L2Dwidget.init({
                    model: { jsonPath: Joe.LIVE2D, scale: 1 },
                    mobile: { show: false },
                    display: { position: 'right', width: 160, height: 200, hOffset: 70, vOffset: 0 }
                });
            });
        }
    }
    /* 懒加载 */
    new LazyLoad('.lazyload');

    console.timeEnd('Global.js执行时长');
});
