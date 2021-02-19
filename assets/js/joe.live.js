document.addEventListener('DOMContentLoaded', () => {
    const p = new URLSearchParams(window.location.search);
    if (!p.get('profileRoom')) initLiveList();
    function initLiveList() {
        let queryData = {
            page: 1,
            gameId: '',
            index: 0,
            isLoading: false,
            totalPage: 0
        };
        $('.joe_live__type-title .icon').on('click', function () {
            if (queryData.isLoading) return;
            if (queryData.index === 3) queryData.index = 0;
            queryData.index++;
            renderLiveType();
        });
        $('.joe_live__type-list').on('click', '.item', function () {
            if (queryData.isLoading) return;
            $(this).addClass('active').siblings().removeClass('active');
            queryData.page = 1;
            queryData.gameId = $(this).attr('data-gameId');
            renderLiveList();
        });
        renderLiveType();
        function renderLiveType() {
            $.ajax({
                url: 'https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/json/joe.live.json',
                success(res) {
                    const item = res[queryData.index];
                    $('.joe_live__type-title .text').html(item.name);
                    let htmlStr = '<li class="item animated swing" data-gameId="">全部</li>';
                    item.list.forEach(_ => (htmlStr += `<li class="item animated swing" data-gameId="${_.gameId}">${_.name}</li>`));
                    $('.joe_live__type-list').html(htmlStr);
                    $('.joe_live__type-list .item').first().click();
                }
            });
        }
        function renderLiveList() {
            queryData.isLoading = true;
            $('.joe_live__list').html('');
            $.ajax({
                url: Joe.BASE_API,
                type: 'POST',
                data: {
                    routeType: 'huya_list',
                    page: queryData.page,
                    gameId: queryData.gameId
                },
                success(res) {
                    if (res.code !== 1) return;
                    let htmlStr = '';
                    res.data.datas.forEach(_ => {
                        htmlStr += `
                            <a target="_blank" rel="noopener noreferrer nofollow" class="joe_live__list-item animated bounceIn" href="${window.location.href + '?profileRoom=' + _.profileRoom + '&title=' + _.nick}">
                                <div class="thumb">
                                    <i class="recommendTagName" style="display: ${_.recommendTagName ? '' : 'none'}">${_.recommendTagName}</i>
                                    <img class="screenshot lazyload" src="${Joe.LAZY_LOAD}" data-src="${_.screenshot}" onerror="javascript: this.src = '${Joe.LAZY_LOAD}';" alt="${_.introduction}" />
                                </div>
                                <div class="description">
                                    <div class="avatar">
                                        <svg class="icon" viewBox="0 0 76 31" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M57.7,11.4c-1.4-1.4-2.7-2.9-4.1-4.4c-0.2-0.3-0.5-0.5-0.8-0.8c-0.2-0.2-0.3-0.3-0.5-0.5l0,0C48.6,2.2,43.5,0,38,0S27.4,2.2,23.6,5.7l0,0c-0.2,0.2-0.3,0.3-0.5,0.5c-0.3,0.3-0.5,0.5-0.8,0.8c-1.4,1.5-2.7,3-4.1,4.4c-5,5.1-11.7,6.1-18.3,6.3V31h9.4h8.9h39.4h4.9H76V17.6C69.4,17.4,62.7,16.5,57.7,11.4z"></path>
                                        </svg>
                                        <img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="${_.avatar180}" onerror="javascript: this.src = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';" alt="${_.nick}"/>
                                    </div>
                                    <div class="nick">${_.nick}</div>
                                    <p class="introduction">${_.introduction}</p>
                                    <div class="meta">
                                        <svg class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="13" height="13">
                                            <path d="M859.9104 609.92512l0 45.6c-0.67968 2.21952-1.5104 4.4352-1.9648 6.70464-4.66048 24.09984-7.28448 48.82944-14.31552 72.22016-20.84992 69.02016-59.92064 126.53952-114.6944 173.50016-42.24512 36.2496-89.7856 62.36544-144.1344 75.22048-17.87008 4.23552-36.19456 6.73024-54.32064 10.0352l-45.5744 0c-2.21952-0.6848-4.49024-1.72032-6.75456-1.87008-48.12544-2.9952-93.72544-15.52512-136.50048-37.38496-80.86528-41.18528-139.19488-102.5152-165.83552-190.74048-5.67424-18.8544-8.03968-38.62016-11.9744-57.97504l0-43.50976c1.7152-10.69056 3.2-21.47456 5.21984-32.16 8.61952-46.68544 29.36576-88.0256 56.83968-126.19008 25.91488-35.92064 53.44-70.70464 78.016-107.53536 26.56896-39.95008 39.424-84.2944 31.88992-132.9152-1.4848-9.60512-2.87488-19.20896-4.33536-28.76416 0.98048-0.25088 1.9648-0.45056 2.9504-0.73088 59.31008 62.16064 68.96512 138.46528 60.49408 220.92032 2.17088-2.31936 3.98592-3.93472 5.37088-5.79968 50.33984-68.08448 71.96416-143.29984 55.55456-227.54688-10.42944-53.58976-32.99456-101.76512-70.32448-141.81504C369.3056 61.84576 349.69472 47.65568 331.61984 32l18.65472 0c1.536 0.62976 2.976 1.7152 4.53504 1.86496 32.82048 2.81984 63.65056 12.95488 93.02016 27.2 67.17056 32.51584 121.62048 80.58496 167.17056 139.22048 66.9504 86.27968 110.48448 181.99424 119.10528 292.19968 3.30496 42.06976-0.9856 82.95552-12.19968 123.2896-4.23552 15.27552-10.21056 30.04544-15.68 45.94944 21.72544-9.25056 38.24-23.38944 50.9952-41.7152 38.04032-54.77504 48.67456-115.85536 40.05504-183.38048 2.80064 3.24992 4.23552 4.53504 5.21472 6.14528 22.91456 36.19968 40.05504 74.81472 49.0048 116.78464C855.05024 576.17024 857.11488 593.1648 859.9104 609.92512M501.56544 529.61536c-0.85504 0.60544-1.79072 1.2352-2.67008 1.84064-1.18528 16.64-2.06976 33.30048-3.68 49.93536-2.37056 25.38496-8.44544 49.85984-20.32 72.62464-14.52032 27.87968-38.7904 45.21984-65.69088 59.01056-29.00992 14.9696-47.28448 36.34944-49.65504 70.10048-2.46912 34.70976 7.96544 63.86944 35.94496 85.20064 26.21568 19.96032 56.84096 26.4704 89.3056 25.38496 51.82976-1.6896 90.4448-26.32064 105.92512-78.1952 11.11552-37.23008 9.30048-74.71488 1.86496-112.19456-10.16064-51.37536-28.76544-99.26528-60.60032-141.2352C523.04512 550.36032 511.7504 540.40448 501.56544 529.61536" fill="#fc6528"></path>
                                        </svg>
                                        <span class="total">${parseNum(_.totalCount)}</span>
                                        <span class="name">${_.gameFullName}</span>
                                    </div>
                                </div>
                            </a>
                        `;
                    });
                    $('.joe_live__list').html(htmlStr);
                    queryData.totalPage = res.data.totalPage;
                    initPagination();
                },
                complete: () => (queryData.isLoading = false)
            });
        }
        function initPagination() {
            let htmlStr = '';
            if (queryData.page != 1) {
                htmlStr += `
            		<li class="joe_live__pagination-item" data-page="1">首页</li>
            		<li class="joe_live__pagination-item" data-page="${queryData.page - 1}">
            			<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="12" height="12">
            				<path d="M822.272 146.944l-396.8 396.8c-19.456 19.456-51.2 19.456-70.656 0-18.944-19.456-18.944-51.2 0-70.656l396.8-396.8c19.456-19.456 51.2-19.456 70.656 0 18.944 19.456 18.944 45.056 0 70.656z" fill="" p-id="9417"></path><path d="M745.472 940.544l-396.8-396.8c-19.456-19.456-19.456-51.2 0-70.656 19.456-19.456 51.2-19.456 70.656 0l403.456 390.144c19.456 25.6 19.456 51.2 0 76.8-26.112 19.968-51.712 19.968-77.312 0.512zM181.248 877.056c0-3.584 0-7.68 0.512-11.264h-0.512V151.552h0.512c-0.512-3.584-0.512-7.168-0.512-11.264 0-43.008 21.504-78.336 48.128-78.336s48.128 34.816 48.128 78.336c0 3.584 0 7.68-0.512 11.264h0.512V865.792h-0.512c0.512 3.584 0.512 7.168 0.512 11.264 0 43.008-21.504 78.336-48.128 78.336s-48.128-35.328-48.128-78.336z"></path>
            			</svg>
            		</li>
            		<li class="joe_live__pagination-item" data-page="${queryData.page - 1}">${queryData.page - 1}</li>
            	`;
            }
            htmlStr += `<li class="joe_live__pagination-item active">${queryData.page}</li>`;
            if (queryData.page != queryData.totalPage) {
                htmlStr += `
            		<li class="joe_live__pagination-item" data-page="${queryData.page + 1}">${queryData.page + 1}</li>
            		<li class="joe_live__pagination-item" data-page="${queryData.page + 1}">
            			<svg class="next" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="12" height="12">
            				<path d="M822.272 146.944l-396.8 396.8c-19.456 19.456-51.2 19.456-70.656 0-18.944-19.456-18.944-51.2 0-70.656l396.8-396.8c19.456-19.456 51.2-19.456 70.656 0 18.944 19.456 18.944 45.056 0 70.656z" fill="" p-id="9417"></path><path d="M745.472 940.544l-396.8-396.8c-19.456-19.456-19.456-51.2 0-70.656 19.456-19.456 51.2-19.456 70.656 0l403.456 390.144c19.456 25.6 19.456 51.2 0 76.8-26.112 19.968-51.712 19.968-77.312 0.512zM181.248 877.056c0-3.584 0-7.68 0.512-11.264h-0.512V151.552h0.512c-0.512-3.584-0.512-7.168-0.512-11.264 0-43.008 21.504-78.336 48.128-78.336s48.128 34.816 48.128 78.336c0 3.584 0 7.68-0.512 11.264h0.512V865.792h-0.512c0.512 3.584 0.512 7.168 0.512 11.264 0 43.008-21.504 78.336-48.128 78.336s-48.128-35.328-48.128-78.336z"></path>
            			</svg>
            		</li>
            	`;
            }
            if (queryData.page < queryData.totalPage) htmlStr += `<li class="joe_live__pagination-item" data-page="${queryData.totalPage}">末页</li>`;
            $('.joe_live__pagination').html(htmlStr);
        }
        $('.joe_live__pagination').on('click', '.joe_live__pagination-item', function () {
            const page = $(this).attr('data-page');
            if (!page || queryData.isLoading) return;
            window.scrollTo({ top: 0, behavior: 'smooth' });
            queryData.page = Number(page);
            renderLiveList();
        });
        function parseNum(num = 0) {
            if (num >= 10000) return Math.round(num / 1000) / 10 + '万';
            return num;
        }
    }
});
