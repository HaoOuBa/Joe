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
				url: window.Joe.THEME_URL + 'assets/json/joe.live.json',
				dataType: 'json',
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
			window.scrollTo({ top: 0, behavior: 'smooth' });
			queryData.isLoading = true;
			$('.joe_live__list').html('');
			$.ajax({
				url: Joe.BASE_API,
				type: 'POST',
				dataType: 'json',
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
                                    <img width="100%" height="100%" class="screenshot lazyload" src="${Joe.LAZY_LOAD}" data-src="${_.screenshot}" alt="${_.introduction}" />
                                </div>
                                <div class="description">
                                    <div class="avatar">
                                        <svg class="icon" viewBox="0 0 76 31" xmlns="http://www.w3.org/2000/svg"><path d="M57.7 11.4C56.3 10 55 8.5 53.6 7c-.2-.3-.5-.5-.8-.8l-.5-.5C48.6 2.2 43.5 0 38 0S27.4 2.2 23.6 5.7l-.5.5-.8.8c-1.4 1.5-2.7 3-4.1 4.4-5 5.1-11.7 6.1-18.3 6.3V31H76V17.6c-6.6-.2-13.3-1.1-18.3-6.2z"/></svg>
                                        <img width="25" height="25" class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="${_.avatar180}" alt="${_.nick}"/>
                                    </div>
                                    <div class="nick">${_.nick}</div>
                                    <p class="introduction">${_.introduction}</p>
                                    <div class="meta">
                                        <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="13" height="13"><path d="M859.91 609.925v45.6c-.68 2.22-1.51 4.435-1.964 6.705-4.66 24.1-7.285 48.83-14.316 72.22-20.85 69.02-59.92 126.54-114.694 173.5-42.245 36.25-89.786 62.366-144.135 75.22-17.87 4.236-36.194 6.73-54.32 10.036h-45.575c-2.22-.685-4.49-1.72-6.754-1.87-48.126-2.996-93.726-15.525-136.5-37.385-80.866-41.186-139.196-102.515-165.836-190.74-5.675-18.855-8.04-38.62-11.975-57.976v-43.51c1.715-10.69 3.2-21.474 5.22-32.16 8.62-46.685 29.366-88.025 56.84-126.19 25.915-35.92 53.44-70.704 78.016-107.535 26.569-39.95 39.424-84.294 31.89-132.915-1.485-9.605-2.875-19.21-4.336-28.764.98-.251 1.965-.45 2.95-.731 59.31 62.16 68.966 138.465 60.495 220.92 2.17-2.32 3.986-3.935 5.37-5.8 50.34-68.084 71.965-143.3 55.555-227.546-10.43-53.59-32.994-101.766-70.324-141.816C369.306 61.846 349.695 47.656 331.62 32h18.655c1.536.63 2.976 1.715 4.535 1.865 32.82 2.82 63.65 12.955 93.02 27.2C515 93.581 569.45 141.65 615 200.285c66.95 86.28 110.485 181.995 119.106 292.2 3.305 42.07-.986 82.956-12.2 123.29-4.236 15.275-10.21 30.045-15.68 45.95 21.725-9.251 38.24-23.39 50.995-41.716 38.04-54.775 48.675-115.855 40.055-183.38 2.8 3.25 4.236 4.535 5.215 6.145 22.914 36.2 40.055 74.814 49.005 116.784 3.554 16.612 5.619 33.607 8.414 50.367m-358.345-80.31c-.855.606-1.79 1.236-2.67 1.841-1.185 16.64-2.07 33.3-3.68 49.935-2.37 25.385-8.445 49.86-20.32 72.625-14.52 27.88-38.79 45.22-65.69 59.01-29.01 14.97-47.285 36.35-49.656 70.101-2.469 34.71 7.966 63.87 35.945 85.2 26.216 19.961 56.841 26.471 89.306 25.386 51.83-1.69 90.445-26.321 105.925-78.196 11.116-37.23 9.3-74.714 1.865-112.194-10.16-51.375-28.765-99.265-60.6-141.235-8.945-11.728-20.24-21.684-30.425-32.473" fill="#fc6528"/></svg>
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
                        <svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="12" height="12"><path d="M822.272 146.944l-396.8 396.8c-19.456 19.456-51.2 19.456-70.656 0-18.944-19.456-18.944-51.2 0-70.656l396.8-396.8c19.456-19.456 51.2-19.456 70.656 0 18.944 19.456 18.944 45.056 0 70.656z"/><path d="M745.472 940.544l-396.8-396.8c-19.456-19.456-19.456-51.2 0-70.656 19.456-19.456 51.2-19.456 70.656 0l403.456 390.144c19.456 25.6 19.456 51.2 0 76.8-26.112 19.968-51.712 19.968-77.312.512zm-564.224-63.488c0-3.584 0-7.68.512-11.264h-.512v-714.24h.512c-.512-3.584-.512-7.168-.512-11.264 0-43.008 21.504-78.336 48.128-78.336s48.128 34.816 48.128 78.336c0 3.584 0 7.68-.512 11.264h.512v714.24h-.512c.512 3.584.512 7.168.512 11.264 0 43.008-21.504 78.336-48.128 78.336s-48.128-35.328-48.128-78.336z"/></svg>
            		</li>
            		<li class="joe_live__pagination-item" data-page="${queryData.page - 1}">${queryData.page - 1}</li>
            	`;
			}
			htmlStr += `<li class="joe_live__pagination-item active">${queryData.page}</li>`;
			if (queryData.page != queryData.totalPage) {
				htmlStr += `
            		<li class="joe_live__pagination-item" data-page="${queryData.page + 1}">${queryData.page + 1}</li>
            		<li class="joe_live__pagination-item" data-page="${queryData.page + 1}">
                        <svg class="next" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="12" height="12"><path d="M822.272 146.944l-396.8 396.8c-19.456 19.456-51.2 19.456-70.656 0-18.944-19.456-18.944-51.2 0-70.656l396.8-396.8c19.456-19.456 51.2-19.456 70.656 0 18.944 19.456 18.944 45.056 0 70.656z"/><path d="M745.472 940.544l-396.8-396.8c-19.456-19.456-19.456-51.2 0-70.656 19.456-19.456 51.2-19.456 70.656 0l403.456 390.144c19.456 25.6 19.456 51.2 0 76.8-26.112 19.968-51.712 19.968-77.312.512zm-564.224-63.488c0-3.584 0-7.68.512-11.264h-.512v-714.24h.512c-.512-3.584-.512-7.168-.512-11.264 0-43.008 21.504-78.336 48.128-78.336s48.128 34.816 48.128 78.336c0 3.584 0 7.68-.512 11.264h.512v714.24h-.512c.512 3.584.512 7.168.512 11.264 0 43.008-21.504 78.336-48.128 78.336s-48.128-35.328-48.128-78.336z"/></svg>
            		</li>
            	`;
			}
			if (queryData.page < queryData.totalPage) htmlStr += `<li class="joe_live__pagination-item" data-page="${queryData.totalPage}">末页</li>`;
			$('.joe_live__pagination').html(htmlStr);
		}
		$('.joe_live__pagination').on('click', '.joe_live__pagination-item', function () {
			const page = $(this).attr('data-page');
			if (!page || queryData.isLoading) return;
			queryData.page = Number(page);
			renderLiveList();
		});
		function parseNum(num = 0) {
			if (num >= 10000) return Math.round(num / 1000) / 10 + '万';
			return num;
		}
	}
});
