document.addEventListener('DOMContentLoaded', () => {
	/* 初始化昼夜模式 */
	{
		if (localStorage.getItem('data-night')) {
			$('.joe_action_item.mode .icon-1').addClass('active')
			$('.joe_action_item.mode .icon-2').removeClass('active')
		} else {
			$('html').removeAttr('data-night')
			$('.joe_action_item.mode .icon-1').removeClass('active')
			$('.joe_action_item.mode .icon-2').addClass('active')
		}
		$('.joe_action_item.mode').on('click', () => {
			if (localStorage.getItem('data-night')) {
				$('.joe_action_item.mode .icon-1').removeClass('active')
				$('.joe_action_item.mode .icon-2').addClass('active')
				$('html').removeAttr('data-night')
				localStorage.removeItem('data-night')
			} else {
				$('.joe_action_item.mode .icon-1').addClass('active')
				$('.joe_action_item.mode .icon-2').removeClass('active')
				$('html').attr('data-night', 'night')
				localStorage.setItem('data-night', 'night')
			}
		})
	}

	/* 动态背景 */
	{
		if (!Joe.IS_MOBILE && Joe.DYNAMIC_BACKGROUND !== 'off' && Joe.DYNAMIC_BACKGROUND && !Joe.WALLPAPER_BACKGROUND_PC) {
			$.getScript(`https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/backdrop/${Joe.DYNAMIC_BACKGROUND}`)
		}
	}

	/* 搜索框弹窗 */
	{
		$('.joe_header__above-search .input').on('click', e => {
			e.stopPropagation()
			$('.joe_header__above-search .result').addClass('active')
		})
		$(document).on('click', function () {
			$('.joe_header__above-search .result').removeClass('active')
		})
		$(document).on('scroll', function () {
			$('.joe_header__above-search .result').removeClass('active')
		})
	}

	/* 激活全局下拉框功能 */
	{
		$('.joe_dropdown').each(function (index, item) {
			const menu = $(this).find('.joe_dropdown__menu')
			const trigger = $(item).attr('trigger') || 'click'
			const placement = $(item).attr('placement') || $(this).height() || 0
			menu.css('top', placement)
			if (trigger === 'hover') {
				$(this).hover(
					() => $(this).addClass('active'),
					() => $(this).removeClass('active')
				)
			} else {
				$(this).on('click', function (e) {
					$(this).toggleClass('active')
					$(document).one('click', () => $(this).removeClass('active'))
					e.stopPropagation()
				})
				menu.on('click', e => e.stopPropagation())
			}
		})
	}

	/* 激活全局返回顶部功能 */
	{
		const handleScroll = () => ((document.documentElement.scrollTop || document.body.scrollTop) > 300 ? $('.joe_action_item.scroll').addClass('active') : $('.joe_action_item.scroll').removeClass('active'))
		handleScroll()
		$(window).on('scroll', () => handleScroll())
		$('.joe_action_item.scroll').on('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }))
	}

	/* 激活侧边栏人生倒计时功能 */
	{
		if ($('.joe_aside__item.timelife').length !== 0) {
			let timelife = [
				{ title: '今日已经过去', endTitle: '小时', num: 0, percent: '0%' },
				{ title: '这周已经过去', endTitle: '天', num: 0, percent: '0%' },
				{ title: '本月已经过去', endTitle: '天', num: 0, percent: '0%' },
				{ title: '今年已经过去', endTitle: '个月', num: 0, percent: '0%' }
			]
			{
				let nowDate = +new Date()
				let todayStartDate = new Date(new Date().toLocaleDateString()).getTime()
				let todayPassHours = (nowDate - todayStartDate) / 1000 / 60 / 60
				let todayPassHoursPercent = (todayPassHours / 24) * 100
				timelife[0].num = parseInt(todayPassHours)
				timelife[0].percent = parseInt(todayPassHoursPercent) + '%'
			}
			{
				let weeks = { 0: 7, 1: 1, 2: 2, 3: 3, 4: 4, 5: 5, 6: 6 }
				let weekDay = weeks[new Date().getDay()]
				let weekDayPassPercent = (weekDay / 7) * 100
				timelife[1].num = parseInt(weekDay)
				timelife[1].percent = parseInt(weekDayPassPercent) + '%'
			}
			{
				let year = new Date().getFullYear()
				let date = new Date().getDate()
				let month = new Date().getMonth() + 1
				let monthAll = new Date(year, month, 0).getDate()
				let monthPassPercent = (date / monthAll) * 100
				timelife[2].num = date
				timelife[2].percent = parseInt(monthPassPercent) + '%'
			}
			{
				let month = new Date().getMonth() + 1
				let yearPass = (month / 12) * 100
				timelife[3].num = month
				timelife[3].percent = parseInt(yearPass) + '%'
			}
			let htmlStr = ''
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
						</div>`
			})
			$('.joe_aside__item.timelife .joe_aside__item-contain').html(htmlStr)
		}
	}

	/* 激活侧边栏天气功能 */
	{
		if ($('.joe_aside__item.weather').length !== 0) {
			const key = $('.joe_aside__item.weather').attr('data-key')
			const style = $('.joe_aside__item.weather').attr('data-style')
			const aqiColor = { 1: 'FFFFFF', 2: '4A4A4A', 3: 'FFFFFF' }
			window.WIDGET = { CONFIG: { layout: 2, width: '220', height: '270', background: style, dataColor: aqiColor[style], language: 'zh', key: key } }
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
					$('.joe_aside__item.ranking .joe_aside__item-title .text').html(res.title)
					let htmlStr = ''
					if (res.code === 1) {
						res.data.forEach((item, index) => {
							htmlStr += `
									<li class="item">
										<span class="sort">${index + 1}</span>
										<a class="link" href="${item.url}" title="${item.title}" target="_blank" rel="noopener noreferrer nofollow">${item.title}</a>
									</li>
								`
						})
					} else {
						htmlStr += `<li class="error">数据抓取异常！</li>`
					}
					$('.joe_aside__item.ranking .joe_aside__item-contain').html(htmlStr)
				}
			})
		}
	}

	/* 设置侧边栏最后一个元素的高度 */
	{
		$('.joe_aside__item:last-child').css('top', $('.joe_header').height() + 15)
	}

	/* 激活Live2d人物 */
	{
		if (Joe.LIVE2D !== 'off' && Joe.LIVE2D) {
			$.getScript('https://cdn.jsdelivr.net/npm/live2d-widget@3.1.4/lib/L2Dwidget.min.js', () => {
				L2Dwidget.init({
					model: { jsonPath: Joe.LIVE2D, scale: 1 },
					mobile: { show: false },
					display: { position: 'right', width: 160, height: 200, hOffset: 70, vOffset: 0 }
				})
			})
		}
	}

	/* 计算页面滚动多少 */
	{
		const calcProgress = () => {
			let scrollTop = $(window).scrollTop()
			let documentHeight = $(document).height()
			let windowHeight = $(window).height()
			let progress = parseInt((scrollTop / (documentHeight - windowHeight)) * 100)
			if (progress <= 0) progress = 0
			if (progress >= 100) progress = 100
			$('.joe_header__below-progress').css('width', progress + '%')
		}
		calcProgress()
		$(window).on('scroll', () => calcProgress())
	}

	/* 判断页面上是否有侧边栏 */
	{
		const getAside = () => {
			if ($('.joe_aside').length === 0) {
				$('body').addClass('noaside')
			} else {
				$('body').removeClass('noaside')
			}
		}
		getAside()
		$(window).on('resize', () => getAside())
	}

	/* 评论框点击切换画图模式和文本模式 */
	{
		$('.joe_comment__respond-type .item').on('click', function () {
			$(this).addClass('active').siblings().removeClass('active')
			if ($(this).attr('data-type') === 'draw') {
				$('.joe_comment__respond-form .body .draw').show().siblings().hide()
				$('#joe_comment_draw').prop('width', $('.joe_comment__respond-form .body').width())
				/* 设置表单格式为画图模式 */
				$('.joe_comment__respond-form').attr('data-type', 'draw')
			} else {
				$('.joe_comment__respond-form .body .text').show().siblings().hide()
				/* 设置表单格式为文字模式 */
				$('.joe_comment__respond-form').attr('data-type', 'text')
			}
		})
	}

	/* 激活画图功能 */
	{
		if ($('#joe_comment_draw').length !== 0) {
			/* 激活画板 */
			window.sketchpad = new Sketchpad({ element: '#joe_comment_draw', height: 300, penSize: 5, color: '303133' })
			/* 撤销上一步 */
			$('.joe_comment__respond-form .body .draw .icon-undo').on('click', () => window.sketchpad.undo())
			/* 动画预览 */
			$('.joe_comment__respond-form .body .draw .icon-animate').on('click', () => window.sketchpad.animate(10))
			/* 更改画板的线宽 */
			$('.joe_comment__respond-form .body .draw .line li').on('click', function () {
				window.sketchpad.penSize = $(this).attr('data-line')
				$(this).addClass('active').siblings().removeClass('active')
			})
			/* 更改画板的颜色 */
			$('.joe_comment__respond-form .body .draw .color li').on('click', function () {
				window.sketchpad.color = $(this).attr('data-color')
				$(this).addClass('active').siblings().removeClass('active')
			})
		}
	}

	/* 重写评论功能 */
	{
		const respond = $('.joe_comment__respond')
		/* 重写回复功能 */
		$('.joe_comment__reply').on('click', function () {
			/* 父级ID */
			const coid = $(this).attr('data-coid')
			/* 当前的项 */
			const item = $('#' + $(this).attr('data-id'))
			/* 添加自定义属性表示父级ID */
			respond.find('.joe_comment__respond-form').attr('data-coid', coid)
			item.append(respond)
			$(".joe_comment__respond-type .item[data-type='text']").click()
			$('.joe_comment__cancle').show()
			window.scrollTo({
				top: item.offset().top - $('.joe_header').height() - 15,
				behavior: 'smooth'
			})
		})
		/* 重写取消回复功能 */
		$('.joe_comment__cancle').on('click', function () {
			/* 移除自定义属性父级ID */
			respond.find('.joe_comment__respond-form').removeAttr('data-coid')
			$('.joe_comment__cancle').hide()
			$('.joe_comment__title').after(respond)
			$(".joe_comment__respond-type .item[data-type='text']").click()
			window.scrollTo({
				top: $('.joe_comment').offset().top - $('.joe_header').height() - 15,
				behavior: 'smooth'
			})
		})
	}

	/* 激活评论提交 */
	{
		let isSubmit = false
		$('.joe_comment__respond-form').on('submit', function (e) {
			e.preventDefault()
			const url = $('.joe_comment__respond-form').attr('action')
			const type = $('.joe_comment__respond-form').attr('data-type')
			const parent = $('.joe_comment__respond-form').attr('data-coid')
			const author = $(".joe_comment__respond-form .head input[name='author']").val()
			const mail = $(".joe_comment__respond-form .head input[name='mail']").val()
			let text = $(".joe_comment__respond-form .body textarea[name='text']").val()
			if (author.trim() === '') return Qmsg.info('请输入昵称！')
			if (!/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/.test(mail)) return Qmsg.info('请输入正确的邮箱！')
			if (type === 'text' && text.trim() === '') return Qmsg.info('请输入评论内容！')
			if (type === 'draw') {
				const txt = $('#joe_comment_draw')[0].toDataURL('image/webp', 0.1)
				text = '{!{' + txt + '}!} '
			}
			if (isSubmit) return
			isSubmit = true
			$.ajax({
				url,
				type: 'POST',
				data: { author, mail, text, parent },
				success(res) {
					let arr = [],
						str = ''
					arr = $(res).contents()
					Array.from(arr).forEach(_ => {
						if (_.parentNode.className === 'container') str = _
					})
					if (!/Joe/.test(res)) return Qmsg.warning(str.textContent.trim() || '')
					window.location.href = Joe.changeURLArg(location.href, 'scroll', 'joe_comment')
				},
				complete: () => (isSubmit = false)
			})
		})
	}

	/* 切换标签显示不同的标题 */
	{
		if (Joe.DOCUMENT_TITLE) {
			const TITLE = document.title
			document.addEventListener('visibilitychange', () => {
				if (document.visibilityState === 'hidden') {
					document.title = Joe.DOCUMENT_TITLE
				} else {
					document.title = TITLE
				}
			})
		}
	}

	/* 小屏幕伸缩侧边栏 */
	{
		$('.joe_header__above-slide').on('click', function () {
			$(this).toggleClass('active')
		})
	}
})
