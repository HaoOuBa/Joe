const parser = new HyperDown();
const player = window.JoeConfig.playerAPI;
export default function createPreviewHtml(str) {
	str = parser.makeHtml(str);

	/* 任务 - 完成 */
	str = str.replace(/{x}/g, '<input type="checkbox" class="task" checked disabled></input>');

	/* 任务 - 未完成 */
	str = str.replace(/{ }/g, '<input type="checkbox" class="task" disabled></input>');

	/* 网易云 - 歌单 */
	str = str.replace(/{music-list([^}]*)\/}/g, '<joe-mlist $1></joe-mlist>');

	/* 网易云 - 歌曲 */
	str = str.replace(/{music([^}]*)\/}/g, '<joe-music $1></joe-music>');

	/* BiliBili */
	str = str.replace(/{bilibili([^}]*)\/}/g, '<joe-bilibili $1></joe-bilibili>');

	/* dplayer */
	str = str.replace(/{dplayer([^}]*)\/}/g, '<joe-dplayer player="' + player + '" $1></joe-dplayer>');

	$('.cm-preview-content').html(str);
	$('.cm-preview-content pre code').each((i, el) => Prism.highlightElement(el));
}
