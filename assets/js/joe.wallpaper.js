/* 壁纸页面需要用到的JS */
console.time('Wallpaper.js执行时长');

document.addEventListener('DOMContentLoaded', () => {
    /* 是否正在请求 */
    let isLoading = false;
    /* 查询字段 */
    let queryData = {
        cid: '',
        start: 0,
        count: 30
    };
    /* 总页数 */
    let total = 0;

    /* 获取壁纸分类 */
    $.ajax({
        url: Joe.BASE_API,
        type: 'POST',
        data: {
            routeType: 'wallpaper_type'
        },
        success(res) {
            if (res.code !== 1) return $('.joe_wallpaper__type-list').html('<li class="error">壁纸抓取失败！请联系作者！</li>');
            let htmlStr = '';
            res.data.forEach(_ => (htmlStr += `<li class="item" data-cid="${_.id}">${_.name}</li>`));
            $('.joe_wallpaper__type-list').html(htmlStr);
            $('.joe_wallpaper__type-list .item').first().click();
        }
    });

    /* 切换类目 */
    $('.joe_wallpaper__type-list').on('click', '.item', function () {
        const cid = $(this).attr('data-cid');
        if (queryData.cid === cid || isLoading) return;
        $(this).addClass('active').siblings().removeClass('active');
        queryData.cid = cid;
        queryData.start = 0;
        getList();
    });

    /* 渲染DOM */
    function getList() {
        isLoading = true;
        $('.joe_wallpaper__list').html('');
        $.ajax({
            url: Joe.BASE_API,
            type: 'POST',
            data: {
                routeType: 'wallpaper_list',
                cid: queryData.cid,
                start: queryData.start,
                count: queryData.count
            },
            success(res) {
                if (res.code !== 1) return;
                let htmlStr = '';
                res.data.forEach(_ => {
                    htmlStr += `
                        <a class="item animated bounceIn" data-fancybox="gallery" href="${_.url}">
                            <img onerror="javascript: this.src = '${Joe.LAZY_LOAD}'" class="wallpaper_lazyload" src="${Joe.LAZY_LOAD}" data-original="${_.img_1024_768}" alt="壁纸">
                        </a>`;
                });
                $('.joe_wallpaper__list').html(htmlStr);
                new LazyLoad('.wallpaper_lazyload');
                total = res.total;
                isLoading = false;
                initPagination();
            }
        });
    }

    /* 初始化分页 */
    function initPagination() {
        let htmlStr = '';
        if (queryData.start / queryData.count !== 0) htmlStr += `<li class="joe_wallpaper__pagination-item" data-start="${queryData.start - queryData.count}"><svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="12" height="12"><path d="M822.272 146.944l-396.8 396.8c-19.456 19.456-51.2 19.456-70.656 0-18.944-19.456-18.944-51.2 0-70.656l396.8-396.8c19.456-19.456 51.2-19.456 70.656 0 18.944 19.456 18.944 45.056 0 70.656z" fill="" p-id="9417"></path><path d="M745.472 940.544l-396.8-396.8c-19.456-19.456-19.456-51.2 0-70.656 19.456-19.456 51.2-19.456 70.656 0l403.456 390.144c19.456 25.6 19.456 51.2 0 76.8-26.112 19.968-51.712 19.968-77.312 0.512zM181.248 877.056c0-3.584 0-7.68 0.512-11.264h-0.512V151.552h0.512c-0.512-3.584-0.512-7.168-0.512-11.264 0-43.008 21.504-78.336 48.128-78.336s48.128 34.816 48.128 78.336c0 3.584 0 7.68-0.512 11.264h0.512V865.792h-0.512c0.512 3.584 0.512 7.168 0.512 11.264 0 43.008-21.504 78.336-48.128 78.336s-48.128-35.328-48.128-78.336z"></path></svg></li><li class="joe_wallpaper__pagination-item" data-start="${queryData.start - queryData.count}">${queryData.start / queryData.count}</li>`;
        htmlStr += `<li class="active joe_wallpaper__pagination-item">${queryData.start / queryData.count + 1}</li>`;
        if (queryData.start != total) htmlStr += `<li class="joe_wallpaper__pagination-item" data-start="${queryData.start + queryData.count}">${queryData.start / queryData.count + 2}</li>`;
        if (queryData.start < total) htmlStr += `<li class="joe_wallpaper__pagination-item" data-start="${queryData.start + queryData.count}"><svg class="next" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="12" height="12"><path d="M822.272 146.944l-396.8 396.8c-19.456 19.456-51.2 19.456-70.656 0-18.944-19.456-18.944-51.2 0-70.656l396.8-396.8c19.456-19.456 51.2-19.456 70.656 0 18.944 19.456 18.944 45.056 0 70.656z" fill="" p-id="9417"></path><path d="M745.472 940.544l-396.8-396.8c-19.456-19.456-19.456-51.2 0-70.656 19.456-19.456 51.2-19.456 70.656 0l403.456 390.144c19.456 25.6 19.456 51.2 0 76.8-26.112 19.968-51.712 19.968-77.312 0.512zM181.248 877.056c0-3.584 0-7.68 0.512-11.264h-0.512V151.552h0.512c-0.512-3.584-0.512-7.168-0.512-11.264 0-43.008 21.504-78.336 48.128-78.336s48.128 34.816 48.128 78.336c0 3.584 0 7.68-0.512 11.264h0.512V865.792h-0.512c0.512 3.584 0.512 7.168 0.512 11.264 0 43.008-21.504 78.336-48.128 78.336s-48.128-35.328-48.128-78.336z"></path></svg></li>`;
        $('.joe_wallpaper__pagination').html(htmlStr);
    }

    /* 切换分页 */
    $('.joe_wallpaper__pagination').on('click', '.joe_wallpaper__pagination-item', function () {
        const start = $(this).attr('data-start');
        if (!start || isLoading) return;
        queryData.start = Number(start);
        getList();
    });

    console.timeEnd('Wallpaper.js执行时长');
});
