document.addEventListener('DOMContentLoaded', () => {
    let isLoading = false;
    let queryData = { cid: -999, start: -999, count: 48 };
    let total = -999;
    $.ajax({
        url: Joe.BASE_API,
        type: 'POST',
        dataType: 'json',
        data: { routeType: 'wallpaper_type' },
        success(res) {
            if (res.code !== 1) return $('.joe_wallpaper__type-list').html('<li class="error">壁纸抓取失败！请联系作者！</li>');
            if (!res.data.length) return $('.joe_wallpaper__type-list').html(`<li class="error">暂无数据！</li>`);
            let htmlStr = '';
            res.data.forEach(_ => (htmlStr += `<li class="item animated swing" data-cid="${_.id}">${_.name}</li>`));
            $('.joe_wallpaper__type-list').html(htmlStr);
            $('.joe_wallpaper__type-list .item').first().click();
        }
    });
    $('.joe_wallpaper__type-list').on('click', '.item', function () {
        const cid = $(this).attr('data-cid');
        if (isLoading) return;
        $(this).addClass('active').siblings().removeClass('active');
        queryData.cid = cid;
        queryData.start = 0;
        renderDom();
    });
    function renderDom() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
        $('.joe_wallpaper__list').html('');
        isLoading = true;
        $.ajax({
            url: Joe.BASE_API,
            type: 'POST',
            dataType: 'json',
            data: {
                routeType: 'wallpaper_list',
                cid: queryData.cid,
                start: queryData.start,
                count: queryData.count
            },
            success(res) {
                if (res.code !== 1) return (isLoading = false);
                isLoading = false;
                let htmlStr = '';
                res.data.forEach(_ => {
                    htmlStr += `
                        <a class="item animated bounceIn" data-fancybox="gallery" href="${_.url}">
                            <img width="100%" height="100%" class="lazyload" src="${Joe.LAZY_LOAD}" data-src="${_.img_1024_768 || _.url}" alt="壁纸">
                        </a>`;
                });
                $('.joe_wallpaper__list').html(htmlStr);
                total = res.total;
                initPagination();
            }
        });
    }
    function initPagination() {
        let htmlStr = '';
        if (queryData.start / queryData.count !== 0) {
            htmlStr += `
                <li class="joe_wallpaper__pagination-item" data-start="0">首页</li>
                <li class="joe_wallpaper__pagination-item" data-start="${queryData.start - queryData.count}">
                    <svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="12" height="12"><path d="M822.272 146.944l-396.8 396.8c-19.456 19.456-51.2 19.456-70.656 0-18.944-19.456-18.944-51.2 0-70.656l396.8-396.8c19.456-19.456 51.2-19.456 70.656 0 18.944 19.456 18.944 45.056 0 70.656z"/><path d="M745.472 940.544l-396.8-396.8c-19.456-19.456-19.456-51.2 0-70.656 19.456-19.456 51.2-19.456 70.656 0l403.456 390.144c19.456 25.6 19.456 51.2 0 76.8-26.112 19.968-51.712 19.968-77.312.512zm-564.224-63.488c0-3.584 0-7.68.512-11.264h-.512v-714.24h.512c-.512-3.584-.512-7.168-.512-11.264 0-43.008 21.504-78.336 48.128-78.336s48.128 34.816 48.128 78.336c0 3.584 0 7.68-.512 11.264h.512v714.24h-.512c.512 3.584.512 7.168.512 11.264 0 43.008-21.504 78.336-48.128 78.336s-48.128-35.328-48.128-78.336z"/></svg>
                </li>
                <li class="joe_wallpaper__pagination-item" data-start="${queryData.start - queryData.count}">${Math.ceil(queryData.start / queryData.count)}</li>
            `;
        }
        htmlStr += `<li class="joe_wallpaper__pagination-item active">${Math.ceil(queryData.start / queryData.count) + 1}</li>`;
        if (queryData.start != total - queryData.count) {
            htmlStr += `
                <li class="joe_wallpaper__pagination-item" data-start="${queryData.start + queryData.count}">${Math.ceil(queryData.start / queryData.count) + 2}</li>
                <li class="joe_wallpaper__pagination-item" data-start="${queryData.start + queryData.count}">
                    <svg class="next" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="12" height="12"><path d="M822.272 146.944l-396.8 396.8c-19.456 19.456-51.2 19.456-70.656 0-18.944-19.456-18.944-51.2 0-70.656l396.8-396.8c19.456-19.456 51.2-19.456 70.656 0 18.944 19.456 18.944 45.056 0 70.656z"/><path d="M745.472 940.544l-396.8-396.8c-19.456-19.456-19.456-51.2 0-70.656 19.456-19.456 51.2-19.456 70.656 0l403.456 390.144c19.456 25.6 19.456 51.2 0 76.8-26.112 19.968-51.712 19.968-77.312.512zm-564.224-63.488c0-3.584 0-7.68.512-11.264h-.512v-714.24h.512c-.512-3.584-.512-7.168-.512-11.264 0-43.008 21.504-78.336 48.128-78.336s48.128 34.816 48.128 78.336c0 3.584 0 7.68-.512 11.264h.512v714.24h-.512c.512 3.584.512 7.168.512 11.264 0 43.008-21.504 78.336-48.128 78.336s-48.128-35.328-48.128-78.336z"/></svg>
                </li>
            `;
        }
        if (queryData.start < total - queryData.count) htmlStr += `<li class="joe_wallpaper__pagination-item" data-start="${total - queryData.count}">末页</li>`;
        $('.joe_wallpaper__pagination').html(htmlStr);
    }
    $('.joe_wallpaper__pagination').on('click', '.joe_wallpaper__pagination-item', function () {
        const start = $(this).attr('data-start');
        if (!start || isLoading) return;
        queryData.start = Number(start);
        renderDom();
    });
});
