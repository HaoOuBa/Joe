const parser = new HyperDown();
export default function createPreviewHtml(str) {
	str = parser.makeHtml(str);

	/* 任务 - 完成 */
	str = str.replace(/{x}/g, '<input type="checkbox" class="task" checked disabled></input>');

	/* 任务 - 未完成 */
	str = str.replace(/{ }/g, '<input type="checkbox" class="task" disabled></input>');

	/* 网易云 - 歌单 */
	str = str.replace(/{music-list([^\/})]*)\/}/g, '<joe-mlist $1></joe-mlist>');
	
	$('.cm-preview-content').html(str);
	$('.cm-preview-content pre code').each((i, el) => Prism.highlightElement(el));
}