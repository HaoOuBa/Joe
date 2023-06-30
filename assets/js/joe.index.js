document.addEventListener('DOMContentLoaded', () => {
	/* 激活轮播图功能 */
	{
		if ($('.joe_index__banner .swiper-container').length !== 0) {
			let direction = 'horizontal';
			if (!Joe.IS_MOBILE && $('.joe_index__banner-recommend .item').length === 2) direction = 'vertical';
			new Swiper('.swiper-container', {
				keyboard: false,
				direction,
				loop: true,
				autoplay: true,
				mousewheel: true,
				pagination: { el: '.swiper-pagination' },
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev'
				}
			});
		}
	}

	/* 初始化首页列表功能 */
	{
		const getListMode = _ => {
			if (_.mode === 'default') {
				return `
                    <li class="joe_list__item wow default">
                        <div class="line"></div>
                        <a href="${_.permalink}" class="thumbnail" title="${_.title}" target="_blank" rel="noopener noreferrer">
                            <img width="100%" height="100%" class="lazyload" src="${_.lazyload}" data-src="${_.image[0]}" alt="${_.title}" />
                            <time datetime="${_.time}">${_.time}</time>
                            <svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="20" height="20"><path d="M903.93 107.306H115.787c-51.213 0-93.204 42.505-93.204 93.72V825.29c0 51.724 41.99 93.717 93.717 93.717h788.144c51.72 0 93.717-41.993 93.717-93.717V201.025c-.512-51.214-43.017-93.719-94.23-93.719zm-788.144 64.527h788.657c16.385 0 29.704 13.316 29.704 29.704v390.229L760.54 402.285c-12.805-13.828-30.217-21.508-48.14-19.971-17.924 1.02-34.821 10.754-46.602 26.114l-172.582 239.16-87.06-85.52c-12.29-11.783-27.654-17.924-44.039-17.924-16.39.508-31.755 7.676-43.53 20.48L86.595 821.705V202.05c-1.025-17.416 12.804-30.73 29.191-30.217zm788.145 683.674H141.906l222.255-245.82 87.06 86.037c12.8 12.807 30.212 18.95 47.115 17.417 17.41-1.538 33.797-11.266 45.063-26.118l172.584-238.647 216.111 236.088 2.051-1.54V825.8c.509 16.39-13.315 29.706-30.214 29.706zm0 0"/><path d="M318.072 509.827c79.89 0 144.417-65.037 144.417-144.416 0-79.378-64.527-144.925-144.417-144.925-79.891 0-144.416 64.527-144.416 144.412 0 79.892 64.525 144.93 144.416 144.93zm0-225.327c44.553 0 80.912 36.362 80.912 80.91 0 44.557-35.847 81.43-80.912 81.43-45.068 0-80.916-36.36-80.916-80.915 0-44.556 36.872-81.425 80.916-81.425zm0 0"/></svg>
                        </a>
                        <div class="information">
                            <a href="${_.permalink}" class="title" title="${_.title}" target="_blank" rel="noopener noreferrer">
                                <span class="badge" style="display: ${_.type === 'sticky' ? 'inline-block' : 'none'}">置顶</span>${_.title}
                            </a>
                            <a class="abstract" href="${_.permalink}" title="文章摘要" target="_blank" rel="noopener noreferrer">${_.abstract}</a>
                            <div class="meta">
                                <ul class="items">
                                    <li>${_.created}</li>
                                    <li>${_.views} 阅读</li>
                                    <li>${_.commentsNum} 评论</li>
                                    <li>${_.agree} 点赞</li>
                                </ul>
                                <div class="last" style="display: ${_.category.length ? 'flex' : 'none'}">
                                    <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="15" height="15"><path d="M512.2 564.743a76.818 76.818 0 0 1-30.973-6.508L108.224 393.877c-26.105-11.508-42.56-35.755-42.927-63.272-.384-27.44 15.356-52.053 41.042-64.232l373.004-176.74c20.591-9.737 45.16-9.755 65.75.017L917.68 266.39c25.668 12.188 41.39 36.792 41.024 64.231-.384 27.5-16.821 51.73-42.908 63.237l-372.57 164.377a77.18 77.18 0 0 1-31.025 6.508zM139.843 329.592l370.213 163.241c1.291.56 3.018.567 4.345-.009l369.758-163.128-369.706-175.464v-.01c-1.326-.628-3.158-.636-4.502 0l-370.108 175.37zm748.015 1.858h.175-.175zM512.376 941.674c-10.348 0-20.8-2.32-30.537-6.997L121.05 778.624c-18.113-7.834-26.454-28.87-18.62-46.983 7.835-18.112 28.862-26.488 46.993-18.61l362.08 156.629 345.26-156.366c17.939-8.166 39.14-.253 47.324 17.746 8.166 17.964.227 39.157-17.729 47.324l-344.51 156.61c-9.196 4.449-19.281 6.7-29.471 6.7z" fill="#444"/><path d="M871.563 515.449L511.81 671.775 152.358 515.787v73.578a34.248 34.248 0 0 0 20.76 31.48l301.518 129.19c11.806 5.703 24.499 8.546 37.175 8.546s25.367-2.843 37.174-8.546L850.82 620.534a34.248 34.248 0 0 0 20.744-31.474V515.45z" fill="#ff6a18"/></svg>
                                    <a class="link" target="_blank" rel="noopener noreferrer" href="${_.category.length && _.category[0].permalink}">${_.category.length && _.category[0].name}</a>
                                </div>
                            </div>
                        </div>
                    </li>
                `;
			} else if (_.mode === 'single') {
				return `
                    <li class="joe_list__item wow single">
                        <div class="line"></div>
                        <div class="information">
                            <a href="${_.permalink}" class="title" title="${_.title}" target="_blank" rel="noopener noreferrer">
                                <span class="badge" style="display: ${_.type === 'sticky' ? 'inline-block' : 'none'}">置顶</span>${_.title}
                            </a>
                            <div class="meta">
                                <ul class="items">
                                    <li>${_.created}</li>
                                    <li>${_.views} 阅读</li>
                                    <li>${_.commentsNum} 评论</li>
                                    <li>${_.agree} 点赞</li>
                                </ul>
                                <div class="last" style="display: ${_.category.length ? 'flex' : 'none'}">
                                    <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="15" height="15"><path d="M512.2 564.743a76.818 76.818 0 0 1-30.973-6.508L108.224 393.877c-26.105-11.508-42.56-35.755-42.927-63.272-.384-27.44 15.356-52.053 41.042-64.232l373.004-176.74c20.591-9.737 45.16-9.755 65.75.017L917.68 266.39c25.668 12.188 41.39 36.792 41.024 64.231-.384 27.5-16.821 51.73-42.908 63.237l-372.57 164.377a77.18 77.18 0 0 1-31.025 6.508zM139.843 329.592l370.213 163.241c1.291.56 3.018.567 4.345-.009l369.758-163.128-369.706-175.464v-.01c-1.326-.628-3.158-.636-4.502 0l-370.108 175.37zm748.015 1.858h.175-.175zM512.376 941.674c-10.348 0-20.8-2.32-30.537-6.997L121.05 778.624c-18.113-7.834-26.454-28.87-18.62-46.983 7.835-18.112 28.862-26.488 46.993-18.61l362.08 156.629 345.26-156.366c17.939-8.166 39.14-.253 47.324 17.746 8.166 17.964.227 39.157-17.729 47.324l-344.51 156.61c-9.196 4.449-19.281 6.7-29.471 6.7z" fill="#444"/><path d="M871.563 515.449L511.81 671.775 152.358 515.787v73.578a34.248 34.248 0 0 0 20.76 31.48l301.518 129.19c11.806 5.703 24.499 8.546 37.175 8.546s25.367-2.843 37.174-8.546L850.82 620.534a34.248 34.248 0 0 0 20.744-31.474V515.45z" fill="#ff6a18"/></svg>
                                    <a class="link" target="_blank" rel="noopener noreferrer" href="${_.category.length && _.category[0].permalink}">${_.category.length && _.category[0].name}</a>
                                </div>
                            </div>
                        </div>
                        <a href="${_.permalink}" class="thumbnail" title="${_.title}" target="_blank" rel="noopener noreferrer">
                            <img width="100%" height="100%" class="lazyload" src="${_.lazyload}" data-src="${_.image[0]}" alt="${_.title}" />
                            <time datetime="${_.time}">${_.time}</time>
                            <svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="20" height="20"><path d="M903.93 107.306H115.787c-51.213 0-93.204 42.505-93.204 93.72V825.29c0 51.724 41.99 93.717 93.717 93.717h788.144c51.72 0 93.717-41.993 93.717-93.717V201.025c-.512-51.214-43.017-93.719-94.23-93.719zm-788.144 64.527h788.657c16.385 0 29.704 13.316 29.704 29.704v390.229L760.54 402.285c-12.805-13.828-30.217-21.508-48.14-19.971-17.924 1.02-34.821 10.754-46.602 26.114l-172.582 239.16-87.06-85.52c-12.29-11.783-27.654-17.924-44.039-17.924-16.39.508-31.755 7.676-43.53 20.48L86.595 821.705V202.05c-1.025-17.416 12.804-30.73 29.191-30.217zm788.145 683.674H141.906l222.255-245.82 87.06 86.037c12.8 12.807 30.212 18.95 47.115 17.417 17.41-1.538 33.797-11.266 45.063-26.118l172.584-238.647 216.111 236.088 2.051-1.54V825.8c.509 16.39-13.315 29.706-30.214 29.706zm0 0"/><path d="M318.072 509.827c79.89 0 144.417-65.037 144.417-144.416 0-79.378-64.527-144.925-144.417-144.925-79.891 0-144.416 64.527-144.416 144.412 0 79.892 64.525 144.93 144.416 144.93zm0-225.327c44.553 0 80.912 36.362 80.912 80.91 0 44.557-35.847 81.43-80.912 81.43-45.068 0-80.916-36.36-80.916-80.915 0-44.556 36.872-81.425 80.916-81.425zm0 0"/></svg>
                        </a>
                        <div class="information" style="margin-bottom: 0;">
                            <a class="abstract" href="${_.permalink}" title="文章摘要" target="_blank" rel="noopener noreferrer">${_.abstract}</a>
                        </div>
                    </li>
                `;
			} else if (_.mode === 'multiple') {
				return `
                    <li class="joe_list__item wow multiple">
                        <div class="line"></div>
                        <div class="information">
                            <a href="${_.permalink}" class="title" title="${_.title}" target="_blank" rel="noopener noreferrer">
                                <span class="badge" style="display: ${_.type === 'sticky' ? 'inline-block' : 'none'}">置顶</span>${_.title}
                            </a>
                            <a class="abstract" href="${_.permalink}" title="文章摘要" target="_blank" rel="noopener noreferrer">${_.abstract}</a>
                        </div>
                        <a href="${_.permalink}" class="thumbnail" title="${_.title}" target="_blank" rel="noopener noreferrer">
                            ${_.image
								.map((item, index) => {
									if (index < 3) {
										return `<img width="100%" height="100%" class="lazyload" src="${_.lazyload}" data-src="${item}" alt="${_.title}" />`;
									}
								})
								.join('')}
                        </a>
                        <div class="meta">
                            <ul class="items">
                                <li>${_.created}</li>
                                <li>${_.views} 阅读</li>
                                <li>${_.commentsNum} 评论</li>
                                <li>${_.agree} 点赞</li>
                            </ul>
                            <div class="last" style="display: ${_.category.length ? 'flex' : 'none'}">
                                <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="15" height="15"><path d="M512.2 564.743a76.818 76.818 0 0 1-30.973-6.508L108.224 393.877c-26.105-11.508-42.56-35.755-42.927-63.272-.384-27.44 15.356-52.053 41.042-64.232l373.004-176.74c20.591-9.737 45.16-9.755 65.75.017L917.68 266.39c25.668 12.188 41.39 36.792 41.024 64.231-.384 27.5-16.821 51.73-42.908 63.237l-372.57 164.377a77.18 77.18 0 0 1-31.025 6.508zM139.843 329.592l370.213 163.241c1.291.56 3.018.567 4.345-.009l369.758-163.128-369.706-175.464v-.01c-1.326-.628-3.158-.636-4.502 0l-370.108 175.37zm748.015 1.858h.175-.175zM512.376 941.674c-10.348 0-20.8-2.32-30.537-6.997L121.05 778.624c-18.113-7.834-26.454-28.87-18.62-46.983 7.835-18.112 28.862-26.488 46.993-18.61l362.08 156.629 345.26-156.366c17.939-8.166 39.14-.253 47.324 17.746 8.166 17.964.227 39.157-17.729 47.324l-344.51 156.61c-9.196 4.449-19.281 6.7-29.471 6.7z" fill="#444"/><path d="M871.563 515.449L511.81 671.775 152.358 515.787v73.578a34.248 34.248 0 0 0 20.76 31.48l301.518 129.19c11.806 5.703 24.499 8.546 37.175 8.546s25.367-2.843 37.174-8.546L850.82 620.534a34.248 34.248 0 0 0 20.744-31.474V515.45z" fill="#ff6a18"/></svg>
                                <a class="link" target="_blank" rel="noopener noreferrer" href="${_.category.length && _.category[0].permalink}">${_.category.length && _.category[0].name}</a>
                            </div>
                        </div>
                    </li>
                `;
			} else {
				return `
                    <li class="joe_list__item wow none">
                        <div class="line"></div>
                        <div class="information">
                            <a href="${_.permalink}" class="title" title="${_.title}" target="_blank" rel="noopener noreferrer">
                                <span class="badge" style="display: ${_.type === 'sticky' ? 'inline-block' : 'none'}">置顶</span>${_.title}
                            </a>
                            <a class="abstract" href="${_.permalink}" title="文章摘要" target="_blank" rel="noopener noreferrer">${_.abstract}</a>
                            <div class="meta">
                                <ul class="items">
                                    <li>${_.created}</li>
                                    <li>${_.views} 阅读</li>
                                    <li>${_.commentsNum} 评论</li>
                                    <li>${_.agree} 点赞</li>
                                </ul>
                                <div class="last" style="display: ${_.category.length ? 'flex' : 'none'}">
                                    <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="15" height="15"><path d="M512.2 564.743a76.818 76.818 0 0 1-30.973-6.508L108.224 393.877c-26.105-11.508-42.56-35.755-42.927-63.272-.384-27.44 15.356-52.053 41.042-64.232l373.004-176.74c20.591-9.737 45.16-9.755 65.75.017L917.68 266.39c25.668 12.188 41.39 36.792 41.024 64.231-.384 27.5-16.821 51.73-42.908 63.237l-372.57 164.377a77.18 77.18 0 0 1-31.025 6.508zM139.843 329.592l370.213 163.241c1.291.56 3.018.567 4.345-.009l369.758-163.128-369.706-175.464v-.01c-1.326-.628-3.158-.636-4.502 0l-370.108 175.37zm748.015 1.858h.175-.175zM512.376 941.674c-10.348 0-20.8-2.32-30.537-6.997L121.05 778.624c-18.113-7.834-26.454-28.87-18.62-46.983 7.835-18.112 28.862-26.488 46.993-18.61l362.08 156.629 345.26-156.366c17.939-8.166 39.14-.253 47.324 17.746 8.166 17.964.227 39.157-17.729 47.324l-344.51 156.61c-9.196 4.449-19.281 6.7-29.471 6.7z" fill="#444"/><path d="M871.563 515.449L511.81 671.775 152.358 515.787v73.578a34.248 34.248 0 0 0 20.76 31.48l301.518 129.19c11.806 5.703 24.499 8.546 37.175 8.546s25.367-2.843 37.174-8.546L850.82 620.534a34.248 34.248 0 0 0 20.744-31.474V515.45z" fill="#ff6a18"/></svg>
                                    <a class="link" target="_blank" rel="noopener noreferrer" href="${_.category.length && _.category[0].permalink}">${_.category.length && _.category[0].name}</a>
                                </div>
                            </div>
                        </div>
                    </li>
                `;
			}
		};
		let queryData = { page: 1, pageSize: window.Joe.PAGE_SIZE, type: 'created' };
		const initDom = () => {
			$('.joe_index__list .joe_list').html('');
			$('.joe_load').show();
			let activeItem = $('.joe_index__title-title .item[data-type="' + queryData.type + '"]');
			let activeLine = $('.joe_index__title-title .line');
			activeItem.addClass('active').siblings().removeClass('active');
			activeLine.css({ left: activeItem.position().left, width: activeItem.width() });
		};
		const pushDom = () => {
			return new Promise((reslove, reject) => {
				$('.joe_load').attr('loading', true);
				$('.joe_load').html('loading...');
				$('.joe_index__list .joe_list__loading').show();
				$.ajax({
					url: Joe.BASE_API,
					type: 'POST',
					dataType: 'json',
					data: { routeType: 'publish_list', page: queryData.page, pageSize: queryData.pageSize, type: queryData.type },
					success(res) {
						if (res.data.length === 0) {
							$('.joe_load').removeAttr('loading');
							$('.joe_load').html('查看更多');
							$('.joe_load').hide();
							$('.joe_index__list .joe_list__loading').hide();
							return Qmsg.warning('没有更多内容了');
						}
						res.data.forEach(_ => $('.joe_index__list .joe_list').append(getListMode(_)));
						$('.joe_load').removeAttr('loading');
						$('.joe_load').html('查看更多');
						$('.joe_index__list .joe_list__loading').hide();
						reslove(res.data.length > 0 ? res.data.length - 1 : 0);
					}
				});
			});
		};
		initDom();
		pushDom();
		$('.joe_index__title-title .item').on('click', async function () {
			if ($(this).attr('data-type') === queryData.type) return;
			queryData = { page: 1, pageSize: window.Joe.PAGE_SIZE, type: $(this).attr('data-type') };
			initDom();
			pushDom();
		});
		$('.joe_load').on('click', async function () {
			if ($(this).attr('loading')) return;
			queryData.page++;
			let length = await pushDom();
			length = $('.joe_index__list .joe_list .joe_list__item').length - length;
			const queryElement = `.joe_index__list .joe_list .joe_list__item:nth-child(${length})`;
			const offset = $(queryElement).offset().top - $('.joe_header').height();
			window.scrollTo({ top: offset - 15, behavior: 'smooth' });
		});
	}

	/* 激活列表特效 */
	{
		const wow = $('.joe_index__list').attr('data-wow');
		if (wow !== 'off' && wow) new WOW({ boxClass: 'wow', animateClass: `animated ${wow}`, offset: 0, mobile: true, live: true, scrollContainer: null }).init();
	}
});
