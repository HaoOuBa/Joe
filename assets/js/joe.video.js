document.addEventListener('DOMContentLoaded', () => {
    const p = new URLSearchParams(window.location.search);
    const vod_id = p.get('vod_id');
    
    if (vod_id) {
        initVideoDetail();
    } else {
        initVideoList();
    }

    function initVideoList() {
        let queryData = { pg: '', t: '', wd: '' };
        let pagecount = '';
        let isLoading = false;
        $.ajax({
            url: Joe.BASE_API,
            type: 'POST',
            dataType: 'json',
            data: { routeType: 'maccms_list' },
            success(res) {
                if (res.code !== 1) return $('.joe_video__type-list').html(`<li class="error">${res.data}</li>`);
                if (!res.data.class.length) return $('.joe_video__type-list').html(`<li class="error">暂无数据！</li>`);
                let htmlStr = '<li class="item" data-t="">全部</li>';
                res.data.class.forEach(_ => (htmlStr += `<li class="item animated swing" data-t="${_.type_id}">${_.type_name}</li>`));
                $('.joe_video__type-list').html(htmlStr);
                $('.joe_video__type-list .item').first().click();
            }
        });
        $('.joe_video__type-list').on('click', '.item', function () {
            const t = $(this).attr('data-t');
            if (isLoading) return;
            $(this).addClass('active').siblings().removeClass('active');
            queryData.pg = 1;
            queryData.t = t;
            queryData.wd = '';
            $('.joe_video__list-search input').val('');
            renderDom();
        });
        function renderDom() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            $('.joe_video__list-item').css('display', '').html('');
            isLoading = true;
            $.ajax({
                url: Joe.BASE_API,
                type: 'POST',
                dataType: 'json',
                data: { routeType: 'maccms_list', ac: 'videolist', t: queryData.t, pg: queryData.pg, wd: queryData.wd },
                success(res) {
                    if (res.code !== 1) return $('.joe_video__list-item').css('display', 'block').html('<p class="error">数据加载失败！请检查！</p>');
                    if (!res.data.list.length) {
                        $('.joe_video__list-item').css('display', 'block').html('<p class="error">暂无数据！</p>');
                    } else {
                        let htmlStr = '';
                        res.data.list.forEach(_ => {
                            htmlStr += `
								<a class="item animated bounceIn" href="${window.location.href + '?vod_id=' + _.vod_id}" target="_blank" rel="noopener noreferrer nofollow">
									<i class="year" style="display: ${_.vod_year && _.vod_year != 0 ? 'block' : 'none'}">${_.vod_year}</i>
									<div class="thumb">
										<img width="100%" height="100%" class="pic lazyload" src="${Joe.LAZY_LOAD}" data-src="${_.vod_pic}" alt="${_.vod_name}">
									</div>    
									<p class="title">${_.vod_name}</p>
								</a>`;
                        });
                        $('.joe_video__list-item').html(htmlStr);
                    }
                    pagecount = res.data.pagecount;
                    initPagination();
                },
                complete: () => (isLoading = false)
            });
        }
        function initPagination() {
            if (pagecount == 0) return $('.joe_video__pagination').hide();
            $('.joe_video__pagination').show();
            let htmlStr = '';
            if (queryData.pg != 1) {
                htmlStr += `
            		<li class="joe_video__pagination-item" data-pg="1">首页</li>
            		<li class="joe_video__pagination-item" data-pg="${queryData.pg - 1}">
                        <svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="12" height="12"><path d="M822.272 146.944l-396.8 396.8c-19.456 19.456-51.2 19.456-70.656 0-18.944-19.456-18.944-51.2 0-70.656l396.8-396.8c19.456-19.456 51.2-19.456 70.656 0 18.944 19.456 18.944 45.056 0 70.656z"/><path d="M745.472 940.544l-396.8-396.8c-19.456-19.456-19.456-51.2 0-70.656 19.456-19.456 51.2-19.456 70.656 0l403.456 390.144c19.456 25.6 19.456 51.2 0 76.8-26.112 19.968-51.712 19.968-77.312.512zm-564.224-63.488c0-3.584 0-7.68.512-11.264h-.512v-714.24h.512c-.512-3.584-.512-7.168-.512-11.264 0-43.008 21.504-78.336 48.128-78.336s48.128 34.816 48.128 78.336c0 3.584 0 7.68-.512 11.264h.512v714.24h-.512c.512 3.584.512 7.168.512 11.264 0 43.008-21.504 78.336-48.128 78.336s-48.128-35.328-48.128-78.336z"/></svg>
            		</li>
            		<li class="joe_video__pagination-item" data-pg="${queryData.pg - 1}">${queryData.pg - 1}</li>
            	`;
            }
            htmlStr += `<li class="joe_video__pagination-item active">${queryData.pg}</li>`;
            if (queryData.pg != pagecount) {
                htmlStr += `
            		<li class="joe_video__pagination-item" data-pg="${queryData.pg + 1}">${queryData.pg + 1}</li>
            		<li class="joe_video__pagination-item" data-pg="${queryData.pg + 1}">
                        <svg class="next" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="12" height="12"><path d="M822.272 146.944l-396.8 396.8c-19.456 19.456-51.2 19.456-70.656 0-18.944-19.456-18.944-51.2 0-70.656l396.8-396.8c19.456-19.456 51.2-19.456 70.656 0 18.944 19.456 18.944 45.056 0 70.656z"/><path d="M745.472 940.544l-396.8-396.8c-19.456-19.456-19.456-51.2 0-70.656 19.456-19.456 51.2-19.456 70.656 0l403.456 390.144c19.456 25.6 19.456 51.2 0 76.8-26.112 19.968-51.712 19.968-77.312.512zm-564.224-63.488c0-3.584 0-7.68.512-11.264h-.512v-714.24h.512c-.512-3.584-.512-7.168-.512-11.264 0-43.008 21.504-78.336 48.128-78.336s48.128 34.816 48.128 78.336c0 3.584 0 7.68-.512 11.264h.512v714.24h-.512c.512 3.584.512 7.168.512 11.264 0 43.008-21.504 78.336-48.128 78.336s-48.128-35.328-48.128-78.336z"/></svg>
            		</li>
            	`;
            }
            if (queryData.pg < pagecount) htmlStr += `<li class="joe_video__pagination-item" data-pg="${pagecount}">末页</li>`;
            $('.joe_video__pagination').html(htmlStr);
        }
        $('.joe_video__pagination').on('click', '.joe_video__pagination-item', function () {
            const pg = $(this).attr('data-pg');
            if (!pg || isLoading) return;
            queryData.pg = Number(pg);
            renderDom();
        });
        const searchFn = () => {
            const val = $('.joe_video__list-search input').val();
            if (isLoading) return;
            queryData.pg = 1;
            queryData.t = '';
            queryData.wd = val;
            $('.joe_video__type-list .item').first().addClass('active').siblings().removeClass('active');
            renderDom();
        };
        $('.joe_video__list-search .button').on('click', searchFn);
        $('.joe_video__list-search .input').on('keyup', e => e.keyCode === 13 && searchFn());
    }
    function initVideoDetail() {
        const player = $('.joe_video__player-play').attr('data-player');
        $.ajax({
            url: Joe.BASE_API,
            type: 'POST',
            dataType: 'json',
            data: {
                routeType: 'maccms_list',
                ac: 'detail',
                ids: vod_id
            },
            success(res) {
                if (res.code !== 1) return $('.joe_video__detail-info').html(`<p class="error">${res.data}</p>`);
                if (!res.data.list.length) return $('.joe_video__detail-info').html(`<p class="error">数据抓取异常！请检查！</p>`);
                const item = res.data.list[0];
                /* 设置视频详情 */
                $('.joe_video__detail-info').html(`
					<div class="thumbnail">
						<img width="100%" height="100%" class="pic lazyload" src="${Joe.LAZY_LOAD}" data-src="${item.vod_pic}" alt="${item.vod_name}">
						<i class="year" style="display: ${item.vod_year && item.vod_year != 0 ? 'block' : 'none'}">${item.vod_year}</i>
					</div>
					<dl class="description">
						<dt>${item.vod_name + (item.vod_remarks ? ' - ' + item.vod_remarks : '')}</dt>
						<dd><span class="muted">类型：</span><span class="text">${item.vod_class || '未知'}</span></dd>
						<dd><span class="muted">主演：</span><span class="text">${item.vod_actor || '未知'}</span></dd>
						<dd><span class="muted">导演：</span><span class="text">${item.vod_director || '未知'}</span></dd>
						<dd><span class="muted">简介：</span><span class="text">${getContent(item)}</span></dd>
					</dl>
				`);
                /* 设置视频播放标题 */
                $('.joe_video__player .joe_video__contain-title').html('正在播放：' + item.vod_name);
                /* 设置播放链接 */
                let parseList = str => {
                    let htmlStr = '';
                    let arr = str.split('#');
                    arr.forEach(_ => (htmlStr += `<li data-src="${_.split('$')[1] || ''}" class="item">${_.split('$')[0] || ''}</li>`));
                    return htmlStr;
                };
                let playFromArr = item.vod_play_from.split('$$$');
                let playUrlArr = item.vod_play_url.split('$$$');
                let maps = new Map();
                playFromArr.forEach((element, index) => maps.set(element, playUrlArr[index] || []));
                let htmlStr = '';
                let index = 0;
                for (let [key, value] of maps) {
                    index++;
                    htmlStr += `
						<div class="joe_video__source joe_video__contain">
							<div class="joe_video__contain-title">播放线路 ${index}</div>
							<ul class="joe_video__source-list">${parseList(value)}</ul>
						</div>
					`;
                }
                $('.joe_video__player').after(htmlStr);
                $('.joe_video__source').first().find('.joe_video__source-list .item').first().click();
            }
        });
        $(document).on('click', '.joe_video__source-list .item', function () {
            $('.joe_video__source-list .item').removeClass('active');
            $(this).addClass('active');
            const url = $(this).attr('data-src') || $(this).html();
            $('.joe_video__player-play').attr({ src: player + url });
            const offset = $('.joe_video__player').offset().top - $('.joe_header').height() - 15;
            window.scrollTo({ top: offset, behavior: 'smooth' });
        });
    }
    function getContent(item) {
        if (item.vod_content) {
            return item.vod_content.replace(/<[^>]+>/g, '');
        } else if (item.vod_blurb) {
            return item.vod_blurb.replace(/<[^>]+>/g, '');
        } else {
            return '暂无简介';
        }
    }
});
