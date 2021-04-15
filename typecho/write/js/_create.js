const parser = new HyperDown();
const player = window.JoeConfig.playerAPI;
export default function createPreviewHtml(str) {
	str = str.replace(/　/g, '&emsp;');

	/* 生成HTML元素 */
	str = parser.makeHtml(str);

	str = str.replace(/{x}/g, '<input type="checkbox" class="joe_detail__article-checkbox" checked disabled></input>');
	str = str.replace(/{ }/g, '<input type="checkbox" class="joe_detail__article-checkbox" disabled></input>');
	str = str.replace(/\:\:\(\s*(呵呵|哈哈|吐舌|太开心|笑眼|花心|小乖|乖|捂嘴笑|滑稽|你懂的|不高兴|怒|汗|黑线|泪|真棒|喷|惊哭|阴险|鄙视|酷|啊|狂汗|what|疑问|酸爽|呀咩爹|委屈|惊讶|睡觉|笑尿|挖鼻|吐|犀利|小红脸|懒得理|勉强|爱心|心碎|玫瑰|礼物|彩虹|太阳|星星月亮|钱币|茶杯|蛋糕|大拇指|胜利|haha|OK|沙发|手纸|香蕉|便便|药丸|红领巾|蜡烛|音乐|灯泡|开心|钱|咦|呼|冷|生气|弱|吐血|狗头)\s*\)/g, function ($0, $1) {
		$1 = encodeURI($1).replace(/%/g, '');
		return `<img class="owo" src="${window.JoeConfig.themeURL}assets/owo/paopao/${$1}_2x.png" />`;
	});
	str = str.replace(/\:\@\(\s*(高兴|小怒|脸红|内伤|装大款|赞一个|害羞|汗|吐血倒地|深思|不高兴|无语|亲亲|口水|尴尬|中指|想一想|哭泣|便便|献花|皱眉|傻笑|狂汗|吐|喷水|看不见|鼓掌|阴暗|长草|献黄瓜|邪恶|期待|得意|吐舌|喷血|无所谓|观察|暗地观察|肿包|中枪|大囧|呲牙|抠鼻|不说话|咽气|欢呼|锁眉|蜡烛|坐等|击掌|惊喜|喜极而泣|抽烟|不出所料|愤怒|无奈|黑线|投降|看热闹|扇耳光|小眼睛|中刀)\s*\)/g, function ($0, $1) {
		$1 = encodeURI($1).replace(/%/g, '');
		return `<img class="owo" src="${window.JoeConfig.themeURL}assets/owo/aru/${$1}_2x.png" />`;
	});
	
	/* 网易云 - 歌单 */
	str = str.replace(/{music-list([^}]*)\/}/g, '<joe-mlist $1></joe-mlist>');

	/* 网易云 - 歌曲 */
	str = str.replace(/{music([^}]*)\/}/g, '<joe-music $1></joe-music>');

	/* BiliBili */
	str = str.replace(/{bilibili([^}]*)\/}/g, '<joe-bilibili $1></joe-bilibili>');

	/* dplayer */
	str = str.replace(/{dplayer([^}]*)\/}/g, '<joe-dplayer player="' + player + '" $1></joe-dplayer>');

	/* mtitle */
	str = str.replace(/{mtitle([^}]*)\/}/g, '<joe-mtitle $1></joe-mtitle>');

	$('.cm-preview-content').html(str);
	$('.cm-preview-content pre code').each((i, el) => Prism.highlightElement(el));
}
