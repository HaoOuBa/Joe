$(function () {
	$('#wmd-editarea textarea').attr('placeholder', '请输入文章内容...（支持图片粘贴上传）')
	$('#wmd-button-bar .wmd-edittab').remove()
    $('#wmd-button-row').html(`
        <li>

        </li>
    `)
})
