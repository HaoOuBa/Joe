document.addEventListener('DOMContentLoaded', () => {
	/* 转换字节 */
	const bytesToSize = bytes => {
		const k = 1024,
			sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
			i = Math.floor(Math.log(bytes) / Math.log(k));
		return (bytes / Math.pow(k, i)).toPrecision(3) + ' ' + sizes[i];
	};

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
				{
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
							bottom: '0',
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
							type: 'value'
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
								formatter: params => `${params.data.value} %`
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
});
