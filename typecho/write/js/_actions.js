import { undo, redo } from '@codemirror/history';
export default class JoeAction {
	constructor() {
		$('body').append(`
            <div class="cm-modal">
                <div class="cm-modal__wrapper">
                    <div class="cm-modal__wrapper-header">
                        <div class="cm-modal__wrapper-header--text"></div>
                        <div class="cm-modal__wrapper-header--close">×</div>
                    </div>
                    <div class="cm-modal__wrapper-bodyer"></div>
                    <div class="cm-modal__wrapper-footer">
                        <button class="cm-modal__wrapper-footer--cancle">取消</button>
                        <button class="cm-modal__wrapper-footer--confirm">确定</button>
                    </div>
                </div>
            </div>
        `);
		$('.cm-modal__wrapper-footer--cancle, .cm-modal__wrapper-header--close').on('click', () => $('.cm-modal').removeClass('active'));
		$('.cm-modal__wrapper-footer--confirm').on('click', () => {
			this.options.confirm();
			$('.cm-modal').removeClass('active');
		});
	}
	_openModal(options = {}) {
		const _options = {
			title: '提示',
			innerHtml: '内容',
			hasFooter: true,
			confirm: () => {},
			handler: () => {}
		};
		this.options = Object.assign(_options, options);
		$('.cm-modal__wrapper-header--text').html(this.options.title);
		$('.cm-modal__wrapper-bodyer').html(this.options.innerHtml);
		this.options.hasFooter ? $('.cm-modal__wrapper-footer').show() : $('.cm-modal__wrapper-footer').hide();
		$('.cm-modal').addClass('active');
		this.options.handler();
	}
	_getLineCh(cm) {
		const head = cm.state.selection.main.head;
		const line = cm.state.doc.lineAt(head);
		return head - line.from;
	}
	_replaceSelection(cm, str) {
		cm.dispatch(cm.state.replaceSelection(str));
	}
	_setCursor(cm, pos) {
		cm.dispatch({ selection: { anchor: pos } });
	}
	_getSelection(cm) {
		return cm.state.sliceDoc(cm.state.selection.main.from, cm.state.selection.main.to);
	}
	_insetAmboText(cm, str) {
		const cursor = cm.state.selection.main.head;
		const selection = this._getSelection(cm);
		this._replaceSelection(cm, ` ${str + selection + str} `);
		if (selection === '') this._setCursor(cm, cursor + str.length + 1);
		cm.focus();
	}
	_createTableLists(cm, url, activeTab = '', modalTitle) {
		$.ajax({
			url,
			dataType: 'json',
			success: res => {
				let tabbarStr = '';
				let listsStr = '';
				for (let key in res) {
					const arr = res[key].split(' ');
					tabbarStr += `<div class="tabbar-item ${key === activeTab ? 'active' : ''}" data-show="${key}">${key}</div>`;
					listsStr += `<div class="lists ${key === activeTab ? 'active' : ''}" data-show="${key}">${arr.map(item => `<div class="lists-item" data-text="${item}">${item}</div>`).join(' ')}</div>`;
				}
				this._openModal({
					title: modalTitle,
					hasFooter: false,
					innerHtml: `<div class="tabbar">${tabbarStr}</div>${listsStr}`,
					handler: () => {
						$('.cm-modal__wrapper-bodyer .tabbar-item').on('click', function () {
							const activeTab = $(this);
							const show = activeTab.attr('data-show');
							const tabbar = $('.cm-modal__wrapper-bodyer .tabbar');
							activeTab.addClass('active').siblings().removeClass('active');
							tabbar.stop().animate({
								scrollLeft: activeTab[0].offsetLeft - tabbar[0].offsetWidth / 2 + activeTab[0].offsetWidth / 2 - 15
							});
							$('.cm-modal__wrapper-bodyer .lists').removeClass('active');
							$(".cm-modal__wrapper-bodyer .lists[data-show='" + show + "']").addClass('active');
						});
						const _this = this;
						$('.cm-modal__wrapper-bodyer .lists-item').on('click', function () {
							const text = $(this).attr('data-text');
							_this._replaceSelection(cm, ` ${text} `);
							$('.cm-modal').removeClass('active');
							cm.focus();
						});
					}
				});
			}
		});
	}
	handleFullScreen(el) {
		el.toggleClass('active');
		$('body').toggleClass('fullscreen');
		$('.cm-container').toggleClass('fullscreen');
		$('.cm-preview').width(0);
	}
	handlePublish() {
		$('#btn-submit').click();
	}
	handleUndo(cm) {
		undo(cm);
		cm.focus();
	}
	handleRedo(cm) {
		redo(cm);
		cm.focus();
	}
	handleIndent(cm) {
		this._replaceSelection(cm, '　');
		cm.focus();
	}
	handleTime(cm) {
		const time = new Date();
		const _Year = time.getFullYear();
		const _Month = String(time.getMonth() + 1).padStart(2, 0);
		const _Date = String(time.getDate()).padStart(2, 0);
		const _Hours = String(time.getHours()).padStart(2, 0);
		const _Minutes = String(time.getMinutes()).padStart(2, 0);
		const _Seconds = String(time.getSeconds()).padStart(2, 0);
		const _Day = ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'][time.getDay()];
		const _time = `${this._getLineCh(cm) ? '\n' : ''}${_Year}-${_Month}-${_Date} ${_Hours}:${_Minutes}:${_Seconds} ${_Day}\n`;
		this._replaceSelection(cm, _time);
		cm.focus();
	}
	handleHr(cm) {
		const str = `${this._getLineCh(cm) ? '\n' : ''}\n------------\n\n`;
		this._replaceSelection(cm, str);
		cm.focus();
	}
	handleClean(cm) {
		cm.dispatch({ changes: { from: 0, to: cm.state.doc.length, insert: '' } });
		cm.focus();
	}
	handleOrdered(cm) {
		const selection = this._getSelection(cm);
		if (selection === '') {
			const str = (this._getLineCh(cm) ? '\n\n' : '') + '1. ';
			this._replaceSelection(cm, str);
		} else {
			const selectionText = selection.split('\n');
			for (let i = 0, len = selectionText.length; i < len; i++) {
				selectionText[i] = selectionText[i] === '' ? '' : i + 1 + '. ' + selectionText[i];
			}
			const str = (this._getLineCh(cm) ? '\n' : '') + selectionText.join('\n');
			this._replaceSelection(cm, str);
		}
		cm.focus();
	}
	handleUnordered(cm) {
		const selection = this._getSelection(cm);
		if (selection === '') {
			const str = (this._getLineCh(cm) ? '\n' : '') + '- ';
			this._replaceSelection(cm, str);
		} else {
			const selectionText = selection.split('\n');
			for (let i = 0, len = selectionText.length; i < len; i++) {
				selectionText[i] = selectionText[i] === '' ? '' : '- ' + selectionText[i];
			}
			const str = (this._getLineCh(cm) ? '\n' : '') + selectionText.join('\n');
			this._replaceSelection(cm, str);
		}
		cm.focus();
	}
	handleQuote(cm) {
		const selection = this._getSelection(cm);
		if (selection === '') {
			this._replaceSelection(cm, `${this._getLineCh(cm) ? '\n' : ''}> `);
		} else {
			const selectionText = selection.split('\n');
			for (let i = 0, len = selectionText.length; i < len; i++) {
				selectionText[i] = selectionText[i] === '' ? '' : '> ' + selectionText[i];
			}
			const str = (this._getLineCh(cm) ? '\n' : '') + selectionText.join('\n');
			this._replaceSelection(cm, str);
		}
		cm.focus();
	}
	handleDownload(cm) {
		const title = $('#title').val() || '新文章';
		const aTag = document.createElement('a');
		let blob = new Blob([cm.state.doc.toString()]);
		aTag.download = title + '.md';
		aTag.href = URL.createObjectURL(blob);
		aTag.click();
		URL.revokeObjectURL(blob);
	}
	handleTitle(cm, tool) {
		const item = $(`
			<div class="cm-tools-item" title="${tool.title}">
				${tool.innerHTML}
				<div class="cm-tools__dropdown">
					<div class="cm-tools__dropdown-item" data-text="# "> H1 </div>
					<div class="cm-tools__dropdown-item" data-text="## "> H2 </div>
					<div class="cm-tools__dropdown-item" data-text="### "> H3 </div>
					<div class="cm-tools__dropdown-item" data-text="#### "> H4 </div>
					<div class="cm-tools__dropdown-item" data-text="##### "> H5 </div>
					<div class="cm-tools__dropdown-item" data-text="###### "> H6 </div>
				</div>
			</div>
		`);
		item.on('click', function (e) {
			e.stopPropagation();
			$(this).toggleClass('active');
		});
		const _this = this;
		item.on('click', '.cm-tools__dropdown-item', function (e) {
			e.stopPropagation();
			const text = $(this).attr('data-text');
			if (_this._getLineCh(cm)) _this._replaceSelection(cm, '\n\n' + text);
			else _this._replaceSelection(cm, text);
			item.removeClass('active');
			cm.focus();
		});
		$(document).on('click', () => item.removeClass('active'));
		$('.cm-tools').append(item);
	}
	handleLink(cm) {
		this._openModal({
			title: '插入链接',
			innerHtml: `
                <div class="fitem">
                    <label>链接标题</label>
                    <input autocomplete="off" name="title" placeholder="请输入链接标题"/>
                </div>
                <div class="fitem">
                    <label>链接地址</label>
                    <input autocomplete="off" name="url" placeholder="请输入链接地址"/>
                </div>
            `,
			confirm: () => {
				const title = $(".cm-modal input[name='title']").val() || 'Test';
				const url = $(".cm-modal input[name='url']").val() || 'http://';
				this._replaceSelection(cm, ` [${title}](${url}) `);
				cm.focus();
			}
		});
	}
	handleImage(cm) {
		this._openModal({
			title: '插入图片',
			innerHtml: `
                <div class="fitem">
                    <label>图片名称</label>
                    <input autocomplete="off" name="title" placeholder="请输入图片名称"/>
                </div>
                <div class="fitem">
                    <label>图片地址</label>
                    <input autocomplete="off" name="url" placeholder="请输入图片地址"/>
                </div>
            `,
			confirm: () => {
				const title = $(".cm-modal input[name='title']").val() || 'Test';
				const url = $(".cm-modal input[name='url']").val() || 'http://';
				this._replaceSelection(cm, ` ![${title}](${url}) `);
				cm.focus();
			}
		});
	}
	handleTable(cm) {
		this._openModal({
			title: '插入表格',
			innerHtml: `
                <div class="fitem">
                    <label>表格行</label>
                    <input style="width: 50px; flex: none; margin-right: 10px;" value="3" autocomplete="off" name="row"/>
                    <label>表格列</label>
                    <input style="width: 50px; flex: none;" value="3" autocomplete="off" name="column"/>
                </div>
            `,
			confirm: () => {
				let row = $(".cm-modal input[name='row']").val();
				let column = $(".cm-modal input[name='column']").val();
				if (isNaN(row)) row = 3;
				if (isNaN(column)) column = 3;
				let rowStr = '';
				let rangeStr = '';
				let columnlStr = '';
				for (let i = 0; i < column; i++) {
					rowStr += '| 表头 ';
					rangeStr += '| :--: ';
				}
				for (let i = 0; i < row; i++) {
					for (let j = 0; j < column; j++) columnlStr += '| 表格 ';
					columnlStr += '|\n';
				}
				const htmlStr = `${rowStr}|\n${rangeStr}|\n${columnlStr}\n`;
				if (this._getLineCh(cm)) this._replaceSelection(cm, '\n\n' + htmlStr);
				else this._replaceSelection(cm, htmlStr);
				cm.focus();
			}
		});
	}
	handleCodeBlock(cm) {
		this._openModal({
			title: '插入代码块',
			innerHtml: `
                <div class="fitem">
                    <label>语言类型</label>
                    <select name="type">
                        <option value="">- 请选择语言类型 -</option>
                        <option value="html">HTML</option>
                        <option value="php">PHP</option>
                        <option value="javascript">JavaScript</option>
                        <option value="typescript">TypeScript</option>
                        <option value="css">Css</option>
                        <option value="css-extras">Css-Extras</option>
                        <option value="sass">Sass</option>
                        <option value="scss">Scss</option>
                        <option value="less">Less</option>
                        <option value="go">GO</option>
                        <option value="java">Java</option>
                        <option value="json">Json</option>
                        <option value="bash">Bash</option>
                        <option value="git">Git</option>
                        <option value="markup">Markup</option>
                        <option value="clike">Clike</option>
                        <option value="batch">Batch</option>
                        <option value="c">C</option>
                        <option value="csharp">Csharp</option>
                        <option value="cpp">Cpp</option>
                        <option value="diff">Diff</option>
                        <option value="docker">Docker</option>
                        <option value="latex">Latex</option>
                        <option value="markdown">Markdown</option>
                        <option value="markup-templating">Markup-Templating</option>
                        <option value="mongodb">Mongodb</option>
                        <option value="nginx">Nginx</option>
                        <option value="objectivec">Objectivec</option>
                        <option value="powershell">PowerShell</option>
                        <option value="python">Python</option>
                        <option value="jsx">Jsx</option>
                        <option value="ruby">Ruby</option>
                        <option value="sql">SQL</option>
                        <option value="stylus">Stylus</option>
                        <option value="swift">Swift</option>
                        <option value="velocity">Velocity</option>
                    </select>
                </div>
            `,
			confirm: () => {
				const type = $(".cm-modal select[name='type']").val() || 'html';
				const htmlStr = `\`\`\`${type}\ncode here...\n\`\`\``;
				if (this._getLineCh(cm)) this._replaceSelection(cm, '\n\n' + htmlStr);
				else this._replaceSelection(cm, htmlStr);
				cm.focus();
			}
		});
	}
	handleAbout() {
		this._openModal({
			title: '关于',
			hasFooter: false,
			innerHtml: `
                <ul>
                    <li>短代码功能正在开发中...</li>
                    <li>仅支持网络图片粘贴上传（截图等）</li>
                    <li>本编辑器仅供Joe主题使用，未经允许不得移植至其他主题！</li>
                </ul>
            `
		});
	}
	handleTask(cm, type) {
		const str = type ? '{x}' : '{ }';
		this._replaceSelection(cm, ` ${str} `);
		cm.focus();
	}
	handleNetease(cm, type) {
		this._openModal({
			title: type ? '网易云歌单' : '网抑云单首',
			innerHtml: `
				<div class="fitem">
					<label>歌${type ? '单' : '曲'}　ID</label>
					<input autocomplete="off" name="id" placeholder="请输入歌${type ? '单' : '曲'}ID"/>
				</div>
				<div class="fitem">
					<label>显示宽度</label>
					<input autocomplete="off" value="100%" name="width" placeholder="请输入宽度（百分比/像素）"/>
				</div>
				<div class="fitem">
					<label>自动播放</label>
					<select name="autoplay">
						<option value="1" selected>是</option>
						<option value="0">否</option>
					</select>
				</div>
            `,
			confirm: () => {
				const id = $(".cm-modal input[name='id']").val();
				const width = $(".cm-modal input[name='width']").val() || '100%';
				const autoplay = $(".cm-modal select[name='autoplay']").val();
				const str = `{${type ? 'music-list' : 'music'} id="${id}" width="${width}" ${autoplay === '1' ? 'autoplay="autoplay"' : ''}/}\n`;
				if (this._getLineCh(cm)) this._replaceSelection(cm, '\n' + str);
				else this._replaceSelection(cm, str);
				cm.focus();
			}
		});
	}
}
