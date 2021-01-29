/* 视频页面需要用到JS */
console.time('Video.js执行时长');

document.addEventListener('DOMContentLoaded', () => {
    /* 当前的分类id */
    let queryData = {
        pg: 0,
        t: -999
    };

    /* 总页数 */
    let total = 0;

    /* 是否正在加载列表 */
    let isLoading = false;

    /* 获取视频分类 */
    $.ajax({
        url: Joe.BASE_API,
        type: 'POST',
        data: {
            routeType: 'maccms_list'
        },
        success(res) {
            if (res.code !== 1) return $('.joe_video__type-list').html(`<li class="error">${res.data}</li>`);
            let htmlStr = '<li class="item" data-t="">全部</li>';
            res.data.class.forEach(_ => (htmlStr += `<li class="item" data-t="${_.type_id}">${_.type_name}</li>`));
            $('.joe_video__type-list').html(htmlStr);
            $('.joe_video__type-list .item').first().click();
        }
    });

    /* 点击切换分类 */
    $('.joe_video__type-list').on('click', '.item', function () {
        const t = $(this).attr('data-t');
        if (t === queryData.t || isLoading) return;
        $(this).addClass('active').siblings().removeClass('active');
        queryData.pg = 0;
        queryData.t = t;
        renderDom();
    });

    /* 渲染视频列表 */
    function renderDom() {
        isLoading = true;
        $('.joe_video__list-item').html('');
        $.ajax({
            url: Joe.BASE_API,
            type: 'POST',
            data: {
                routeType: 'maccms_list',
                t: queryData.t,
                pg: queryData.pg,
                ac: 'videolist'
            },
            success(res) {
                if (res.code !== 1) return;
                let htmlStr = '';
                res.data.list.forEach(_ => {
                    htmlStr += `
                        <a class="item" href="${window.location.href + '?vod_id=' + _.vod_id}" target="_blank" rel="noopener noreferrer nofollow">
                            <i class="year" style="display: ${_.vod_year ? 'block' : 'none'}">${_.vod_year}</i>
                            <div class="thumb">
                                <img onerror="javascript: this.src = '${Joe.LAZY_LOAD}'" class="pic video_lazyload" src="${Joe.LAZY_LOAD}" data-original="${_.vod_pic}" alt="${_.vod_name}">
                            </div>    
                            <p class="title">${_.vod_name}</p>
                        </a>`;
                });
                $('.joe_video__list-item').html(htmlStr);
                new LazyLoad('.video_lazyload');
                isLoading = false;
                total = res.data.pagecount;
                initPagination();
            }
        });
    }

    /* 初始化分页 */
    function initPagination() {
        let htmlStr = '';
        if (queryData.pg !== 0) htmlStr += `<li class="joe_video__pagination-item" data-pg="${queryData.pg - 1}"><svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="12" height="12"><path d="M822.272 146.944l-396.8 396.8c-19.456 19.456-51.2 19.456-70.656 0-18.944-19.456-18.944-51.2 0-70.656l396.8-396.8c19.456-19.456 51.2-19.456 70.656 0 18.944 19.456 18.944 45.056 0 70.656z" fill="" p-id="9417"></path><path d="M745.472 940.544l-396.8-396.8c-19.456-19.456-19.456-51.2 0-70.656 19.456-19.456 51.2-19.456 70.656 0l403.456 390.144c19.456 25.6 19.456 51.2 0 76.8-26.112 19.968-51.712 19.968-77.312 0.512zM181.248 877.056c0-3.584 0-7.68 0.512-11.264h-0.512V151.552h0.512c-0.512-3.584-0.512-7.168-0.512-11.264 0-43.008 21.504-78.336 48.128-78.336s48.128 34.816 48.128 78.336c0 3.584 0 7.68-0.512 11.264h0.512V865.792h-0.512c0.512 3.584 0.512 7.168 0.512 11.264 0 43.008-21.504 78.336-48.128 78.336s-48.128-35.328-48.128-78.336z"></path></svg></li><li class="joe_video__pagination-item" data-pg="${queryData.pg - 1}">${queryData.pg}</li>`;
        htmlStr += `<li class="active joe_video__pagination-item">${queryData.pg + 1}</li>`;
        if (queryData.pg != total) htmlStr += `<li class="joe_video__pagination-item" data-pg="${queryData.pg + 1}">${queryData.pg + 2}</li>`;
        if (queryData.pg < total) htmlStr += `<li class="joe_video__pagination-item" data-pg="${queryData.pg + 1}"><svg class="next" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="12" height="12"><path d="M822.272 146.944l-396.8 396.8c-19.456 19.456-51.2 19.456-70.656 0-18.944-19.456-18.944-51.2 0-70.656l396.8-396.8c19.456-19.456 51.2-19.456 70.656 0 18.944 19.456 18.944 45.056 0 70.656z" fill="" p-id="9417"></path><path d="M745.472 940.544l-396.8-396.8c-19.456-19.456-19.456-51.2 0-70.656 19.456-19.456 51.2-19.456 70.656 0l403.456 390.144c19.456 25.6 19.456 51.2 0 76.8-26.112 19.968-51.712 19.968-77.312 0.512zM181.248 877.056c0-3.584 0-7.68 0.512-11.264h-0.512V151.552h0.512c-0.512-3.584-0.512-7.168-0.512-11.264 0-43.008 21.504-78.336 48.128-78.336s48.128 34.816 48.128 78.336c0 3.584 0 7.68-0.512 11.264h0.512V865.792h-0.512c0.512 3.584 0.512 7.168 0.512 11.264 0 43.008-21.504 78.336-48.128 78.336s-48.128-35.328-48.128-78.336z"></path></svg></li>`;
        $('.joe_video__pagination').html(htmlStr);
    }

    /* 切换分页 */
    $('.joe_video__pagination').on('click', '.joe_video__pagination-item', function () {
        const pg = $(this).attr('data-pg');
        if (!pg || isLoading) return;
        queryData.pg = Number(pg);
        renderDom();
    });

    console.timeEnd('Video.js执行时长');
});
