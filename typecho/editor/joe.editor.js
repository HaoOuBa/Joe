$(function () {
	$('#wmd-editarea textarea').attr('placeholder', '请输入文章内容...（支持图片粘贴上传）')
	$('#wmd-button-bar .wmd-edittab').remove()
	$('#wmd-button-row .wmd-spacer').remove()

	/* 增加自定义功能 */
	const items = [
		{
			title: '回复可见',
			id: 'wmd-hide-button'
		}
	]

	items.forEach(_ => {
		let item = `<li class="wmd-button" id="${_.id}" title="${_.title}">啊</li>`
		$('#wmd-button-row').append(item)
	})
})
