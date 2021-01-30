/* 视频页面需要用到JS */
console.time('Video.js执行时长')

document.addEventListener('DOMContentLoaded', () => {
	const p = new URLSearchParams(window.location.search)
	const vod_id = p.get('vod_id')
	if (vod_id) {
		initVideoDetail()
	} else {
		initVideoList()
	}

	/* 初始化列表页 */
	function initVideoList() {
		/* 当前的分类id */
		let queryData = { pg: -999, t: -999 }
		/* 总页数 */
		let total = -999
		/* 是否正在加载列表 */
		let isLoading = false
		/* 获取视频分类 */
		$.ajax({
			url: Joe.BASE_API,
			type: 'POST',
			data: { routeType: 'maccms_list' },
			success(res) {
				if (res.code !== 1) return $('.joe_video__type-list').html(`<li class="error">${res.data}</li>`)
				if (!res.data.class.length) return $('.joe_video__type-list').html(`<li class="error">暂无数据！</li>`)
				let htmlStr = '<li class="item" data-t="">全部</li>'
				res.data.class.forEach(_ => (htmlStr += `<li class="item" data-t="${_.type_id}">${_.type_name}</li>`))
				$('.joe_video__type-list').html(htmlStr)
				$('.joe_video__type-list .item').first().click()
			}
		})
		/* 点击切换分类 */
		$('.joe_video__type-list').on('click', '.item', function () {
			const t = $(this).attr('data-t')
			if (t === queryData.t || isLoading) return
			window.scrollTo({ top: 0, behavior: 'smooth' })
			$(this).addClass('active').siblings().removeClass('active')
			queryData.pg = 0
			queryData.t = t
			renderDom()
		})
		/* 渲染视频列表 */
		function renderDom() {
			$('.joe_video__list-item').css('display', '').html('')
			isLoading = true
			$.ajax({
				url: Joe.BASE_API,
				type: 'POST',
				data: { routeType: 'maccms_list', t: queryData.t, pg: queryData.pg, ac: 'videolist' },
				success(res) {
					if (res.code !== 1) return $('.joe_video__list-item').css('display', 'block').html('<p class="error">数据加载失败！请检查！</p>')
					if (!res.data.list.length) {
						$('.joe_video__list-item').css('display', 'block').html('<p class="error">当前分类暂无数据！</p>')
					} else {
						let htmlStr = ''
						res.data.list.forEach(_ => {
							htmlStr += `
								<a class="item animated bounceIn" href="${window.location.href + '?vod_id=' + _.vod_id}" target="_blank" rel="noopener noreferrer nofollow">
									<i class="year" style="display: ${_.vod_year && _.vod_year != 0 ? 'block' : 'none'}">${_.vod_year}</i>
									<div class="thumb">
										<img onerror="javascript: this.src = '${Joe.LAZY_LOAD}'" class="pic video_lazyload" src="${Joe.LAZY_LOAD}" data-original="${_.vod_pic}" alt="${_.vod_name}">
									</div>    
									<p class="title">${_.vod_name}</p>
								</a>`
						})
						$('.joe_video__list-item').html(htmlStr)
						new LazyLoad('.video_lazyload')
					}
					total = res.data.pagecount
					initPagination()
				},
				complete: () => (isLoading = false)
			})
		}
		/* 初始化分页 */
		function initPagination() {
			let htmlStr = ''
			if (queryData.pg !== 0) {
				htmlStr += `
					<li class="joe_video__pagination-item" data-pg="0">首页</li>
					<li class="joe_video__pagination-item" data-pg="${queryData.pg - 1}">
						<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="12" height="12">
							<path d="M822.272 146.944l-396.8 396.8c-19.456 19.456-51.2 19.456-70.656 0-18.944-19.456-18.944-51.2 0-70.656l396.8-396.8c19.456-19.456 51.2-19.456 70.656 0 18.944 19.456 18.944 45.056 0 70.656z" fill="" p-id="9417"></path><path d="M745.472 940.544l-396.8-396.8c-19.456-19.456-19.456-51.2 0-70.656 19.456-19.456 51.2-19.456 70.656 0l403.456 390.144c19.456 25.6 19.456 51.2 0 76.8-26.112 19.968-51.712 19.968-77.312 0.512zM181.248 877.056c0-3.584 0-7.68 0.512-11.264h-0.512V151.552h0.512c-0.512-3.584-0.512-7.168-0.512-11.264 0-43.008 21.504-78.336 48.128-78.336s48.128 34.816 48.128 78.336c0 3.584 0 7.68-0.512 11.264h0.512V865.792h-0.512c0.512 3.584 0.512 7.168 0.512 11.264 0 43.008-21.504 78.336-48.128 78.336s-48.128-35.328-48.128-78.336z"></path>
						</svg>
					</li>
					<li class="joe_video__pagination-item" data-pg="${queryData.pg - 1}">${queryData.pg}</li>
				`
			}
			htmlStr += `<li class="joe_video__pagination-item active">${queryData.pg + 1}</li>`
			if (queryData.pg != total) {
				htmlStr += `
					<li class="joe_video__pagination-item" data-pg="${queryData.pg + 1}">${queryData.pg + 2}</li>
					<li class="joe_video__pagination-item" data-pg="${queryData.pg + 1}">
						<svg class="next" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="12" height="12">
							<path d="M822.272 146.944l-396.8 396.8c-19.456 19.456-51.2 19.456-70.656 0-18.944-19.456-18.944-51.2 0-70.656l396.8-396.8c19.456-19.456 51.2-19.456 70.656 0 18.944 19.456 18.944 45.056 0 70.656z" fill="" p-id="9417"></path><path d="M745.472 940.544l-396.8-396.8c-19.456-19.456-19.456-51.2 0-70.656 19.456-19.456 51.2-19.456 70.656 0l403.456 390.144c19.456 25.6 19.456 51.2 0 76.8-26.112 19.968-51.712 19.968-77.312 0.512zM181.248 877.056c0-3.584 0-7.68 0.512-11.264h-0.512V151.552h0.512c-0.512-3.584-0.512-7.168-0.512-11.264 0-43.008 21.504-78.336 48.128-78.336s48.128 34.816 48.128 78.336c0 3.584 0 7.68-0.512 11.264h0.512V865.792h-0.512c0.512 3.584 0.512 7.168 0.512 11.264 0 43.008-21.504 78.336-48.128 78.336s-48.128-35.328-48.128-78.336z"></path>
						</svg>
					</li>
				`
			}
			if (queryData.pg < total) htmlStr += `<li class="joe_video__pagination-item" data-pg="${total}">末页</li>`
			$('.joe_video__pagination').html(htmlStr)
		}
		/* 切换分页 */
		$('.joe_video__pagination').on('click', '.joe_video__pagination-item', function () {
			const pg = $(this).attr('data-pg')
			if (!pg || isLoading) return
			window.scrollTo({ top: 0, behavior: 'smooth' })
			queryData.pg = Number(pg)
			renderDom()
		})
	}

	/* 初始化播放页 */
	function initVideoDetail() {
		$.ajax({
			url: Joe.BASE_API,
			type: 'POST',
			data: {
				routeType: 'maccms_list',
				ac: 'detail',
				ids: vod_id
			},
			success(res) {
				if (res.code !== 1) return $('.joe_video__detail-info').html(`<p class="error">${res.data}</p>`)
				if (!res.data.list.length) return $('.joe_video__detail-info').html(`<p class="error">数据抓取异常！请检查！</p>`)
				const item = res.data.list[0]
				$('.joe_video__detail-info').html(`
					<div class="thumbnail">
						<img class="pic video_lazyload" onerror="javascript: this.src = '${Joe.LAZY_LOAD}'" src="${Joe.LAZY_LOAD}" data-original="${item.vod_pic}" alt="${item.vod_name}">
						<i class="year" style="display: ${item.vod_year && item.vod_year != 0 ? 'block' : 'none'}">${item.vod_year}</i>
					</div>
					<dl class="description">
						<dt>${item.vod_name + (item.vod_remarks ? ' - ' + item.vod_remarks : '')}</dt>
						<dd><span class="muted">类型：</span><p class="text">${item.vod_class || '未知'}</p></dd>
						<dd><span class="muted">主演：</span><p class="text">${item.vod_actor || '未知'}</p></dd>
						<dd><span class="muted">导演：</span><p class="text">${item.vod_director || '未知'}</p></dd>
						<dd><span class="muted">简介：</span><p class="text">${item.vod_content ? item.vod_content : item.vod_blurb}</p></dd>
					</dl>
				`)
				new LazyLoad('.video_lazyload')
			}
		})
	}

	console.timeEnd('Video.js执行时长')
})
