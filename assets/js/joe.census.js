document.addEventListener('DOMContentLoaded', () => {
	{
		/* 转换字节 */
		const bytesToSize = bytes => {
			if (!bytes) return '0 B';
			const k = 1000,
				sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
				i = Math.floor(Math.log(bytes) / Math.log(k));
			return (bytes / Math.pow(k, i)).toPrecision(3) + ' ' + sizes[i];
		};
		/* 转换内存 */
		const megaknotsToSize = (limit) => {
			if (limit < 1024) return parseInt(limit) + ' MB'
			return parseInt(limit / 1024) + ' GB'
		}
		const categories = [];
		const upSeries = [];
		const downSeries = [];
		const flowDom = document.querySelector('#flow');
		const workDom = document.querySelector('#work');
		const flowChart = flowDom && echarts.init(flowDom);
		const workChart = workDom && echarts.init(workDom);
		if (flowDom && workDom) initChart();
		function initChart() {
			$.ajax({
				url: Joe.BASE_API,
				type: 'POST',
				dataType: 'json',
				data: {
					routeType: 'server_status'
				},
				success(res) {
					if (!res.status) Qmsg.warning('服务器接口异常！');
					{
						$('.joe_census__server-item .count .core').html(`${res.cpu[1]} 核`);
						$('.joe_census__server-item .count .ram').html(`${megaknotsToSize(res.memory.memTotal)}`);
						$('.joe_census__server-item .count .up').html(`总发送：${bytesToSize(res.upTotal)}`);
						$('.joe_census__server-item .count .down').html(`总接收：${bytesToSize(res.downTotal)}`);
						const stamp = new Date();
						const hours = String(stamp.getHours()).padStart(2, 0);
						const minutes = String(stamp.getMinutes()).padStart(2, 0);
						const seconds = String(stamp.getSeconds()).padStart(2, 0);
						const time = `${hours}:${minutes}:${seconds}`;
						categories.push(time);
						upSeries.push(res.up);
						downSeries.push(res.down);
						if (categories.length > 5) categories.shift();
						if (upSeries.length > 5) upSeries.shift();
						if (downSeries.length > 5) downSeries.shift();
						flowChart.setOption({
							title: {
								subtext: '单位 KB/s'
							},
							grid: {
								left: '3%',
								right: '4%',
								bottom: '3%',
								containLabel: true
							},
							tooltip: {
								trigger: 'axis',
								axisPointer: {
									type: 'cross',
									label: {
										backgroundColor: '#6a7985'
									}
								}
							},
							xAxis: {
								axisTick: {
									show: false
								},
								type: 'category',
								boundaryGap: false,
								data: categories
							},
							yAxis: {
								type: 'value'
							},
							series: [
								{
									type: 'line',
									name: '上行',
									smooth: true,
									showSymbol: false,
									itemStyle: {
										normal: {
											color: '#f39494',
											areaStyle: {
												color: '#f39494'
											},
											lineStyle: {
												width: 2,
												color: '#f39494'
											}
										}
									},
									stack: '总量',
									data: upSeries
								},
								{
									type: 'line',
									name: '下行',
									smooth: true,
									showSymbol: false,
									itemStyle: {
										normal: {
											color: '#9dd3e8',
											areaStyle: {
												color: '#9dd3e8'
											},
											lineStyle: {
												width: 2,
												color: '#9dd3e8'
											}
										}
									},
									stack: '总量',
									data: downSeries
								}
							]
						});
					}
					{
						/* CPU占用 */
						const cpuUse = res.cpu[0];
						/* 内存占用 */
						const memoryRealUse = Math.round((res.memory.memRealUsed / res.memory.memTotal) * 1000) / 10;
						/* 内存缓冲 */
						const memoryCacheUse = Math.round((res.memory.memCached / res.memory.memTotal) * 1000) / 10;
						/* 系统缓冲 */
						const memoryBufferUse = Math.round((res.memory.memBuffers / res.memory.memTotal) * 1000) / 10;
						/* 系统负载 */
						const systemLoad = Math.round((res.load.one / res.load.max) * 100) > 100 ? 100 : Math.round((res.load.one / res.load.max) * 100);
						workChart.setOption({
							title: {
								subtext: '单位 百分比'
							},
							tooltip: {
								trigger: 'axis',
								axisPointer: {
									type: 'shadow'
								}
							},
							grid: {
								left: '3%',
								right: '3%',
								bottom: '3%',
								containLabel: true
							},
							xAxis: {
								type: 'category',
								axisTick: {
									show: false
								},
								data: ['CPU占用', '内存占用', '系统缓冲', '内存缓冲', '系统负载']
							},
							yAxis: {
								type: 'value',
								max: 100
							},
							series: {
								data: [
									{
										name: 'CPU占用',
										value: cpuUse,
										itemStyle: {
											color: '#b3c25a'
										}
									},
									{
										name: '内存占用',
										value: memoryRealUse,
										itemStyle: {
											color: '#67b580'
										}
									},
									{
										name: '系统缓冲',
										value: memoryBufferUse,
										itemStyle: {
											color: '#86ba71'
										}
									},
									{
										name: '内存缓冲',
										value: memoryCacheUse,
										itemStyle: {
											color: '#feb041'
										}
									},
									{
										name: '系统负载',
										value: systemLoad,
										itemStyle: {
											color: '#fd7e55'
										}
									}
								],
								type: 'bar',
								showBackground: true,
								label: {
									show: true,
									color: '#ffffff',
									formatter: params => `${params.data.value}%`
								},
								backgroundStyle: {
									color: 'rgba(180, 180, 180, 0.2)'
								}
							}
						});
					}
					setTimeout(initChart, 2000);
				}
			});
		}
	}

	/* 初始化统计 */
	{
		const categoryDom = document.querySelector('#category');
		const categoryChart = echarts.init(categoryDom);
		const seriesData = [];
		$('.joe_census__basic-item.category ul li').each((index, item) => {
			seriesData.push({
				name: item.getAttribute('data-name'),
				value: item.getAttribute('data-value')
			});
		});
		categoryChart.setOption({
			tooltip: {
				trigger: 'item'
			},
			series: [
				{
					type: 'pie',
					roseType: 'area',
					itemStyle: {
						borderRadius: 8
					},
					data: seriesData
				}
			]
		});
	}

	/* 初始化评论统计 */
	{
		const latelyDom = document.querySelector('#lately');
		const latelyChart = echarts.init(latelyDom);
		$.ajax({
			url: Joe.BASE_API,
			type: 'POST',
			dataType: 'json',
			data: {
				routeType: 'comment_lately'
			},
			success(res) {
				latelyChart.setOption({
					title: {
						subtext: '单位 数量'
					},
					tooltip: {
						trigger: 'axis',
						axisPointer: {
							type: 'cross',
							label: {
								backgroundColor: '#6a7985'
							}
						}
					},
					grid: {
						left: '3%',
						right: '3%',
						bottom: '3%',
						containLabel: true
					},
					xAxis: {
						type: 'category',
						axisTick: {
							show: false
						},
						data: res.categories
					},
					yAxis: {
						type: 'value'
					},
					series: {
						name: '数量',
						itemStyle: {
							normal: {
								color: '#91cc75',
								lineStyle: {
									width: 2,
									color: '#91cc75'
								}
							}
						},
						data: res.series,
						type: 'line',
						smooth: true
					}
				});
			}
		});
	}

	/* 初始化归档 */
	{
		let page = 0;
		initFiling();
		function initFiling() {
			if ($('.joe_census__filing .button').html() === 'loading...') return;
			$.ajax({
				url: Joe.BASE_API,
				type: 'POST',
				dataType: 'json',
				data: {
					routeType: 'article_filing',
					page: ++page
				},
				success(res) {
					if (!res.length) {
						$('.joe_census__filing .item.load').remove();
						return Qmsg.warning('没有更多内容了');
					}
					let htmlStr = '';
					res.forEach(item => {
						htmlStr += `
							<div class="item">
								<div class="tail"></div>
								<div class="head"></div>
								<div class="wrapper">
									<div class="panel">${item.date}<svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg"><path d="M21.6 772.8c28.8 28.8 74.4 28.8 103.2 0L512 385.6l387.2 387.2c28.8 28.8 74.4 28.8 103.2 0 28.8-28.8 28.8-74.4 0-103.2L615.2 282.4l-77.6-77.6c-14.4-14.4-37.6-14.4-51.2 0l-77.6 77.6L21.6 669.6c-28.8 28.8-28.8 75.2 0 103.2z" /></svg></div>
									<ol class="panel-body">
										${item.list.map(_ => `<li><a rel="noopener noreferrer" target="_blank" href="${_.permalink}">${_.title}</a></li>`).join('')}
									</ol>
								</div>
							</div>
						`;
					});
					$('#filing').append(htmlStr);
					$('.joe_census__filing .button').html('加载更多');
				}
			});
		}
		$('.joe_census__filing .content').on('click', '.panel', function () {
			const panelBox = $(this).parents('.content');
			panelBox.find('.panel').not($(this)).removeClass('in');
			panelBox.find('.panel-body').not($(this).siblings('.panel-body')).stop().hide('fast');
			$(this).toggleClass('in').siblings('.panel-body').stop().toggle('fast');
		});
		$('.joe_census__filing .button').on('click', function () {
			initFiling();
			$(this).html('loading...');
		});
	}
});
