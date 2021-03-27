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
                    <input autocomplete="off" name="type" placeholder="请输入语言类型（英文）"/>
                </div>
            `,
            confirm: () => {
                const type = $(".cm-modal input[name='type']").val() || 'html';
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
            innerHtml: `
                <ul>
                    <li>短代码功能正在开发中...</li>
                    <li>仅支持网络图片粘贴上传（截图等）</li>
                    <li>本编辑器仅供Joe主题使用，未经允许不得移植至其他主题！</li>
                </ul>
            `
        });
    }
    handleCharacter(cm) {
        const _1 = '★ ✰ ☆ ✩ ✫ ✬ ✭ ✮ ✡'.split(' ');
        const _2 = '─ ━ │ ┃ ┄ ┅ ┆ ┇ ┈ ┉ ┊ ┋ ┍ ┎ ┐ ┑ ┒ └ ┕ ┖ ┘ ┙ ┚ ├ ┝ ┞ ┟ ┡ ┢ ┣ ┤ ┥ ┦ ┧ ┩ ┪ ┫ ┬ ┭ ┮ ┰ ┱ ┲ ┴ ┵ ┶ ┸ ┹ ┺ ┻ ┼ ┽ ┾ ┿ ╀ ╁ ╂ ╃ ╄ ╅ ╆ ╇ ╈ ╉ ╊ ╋ ║ ╒ ╕ ╖ ╘ ╙ ╛ ╜ ╞ ╟ ╠ ╡ ╢ ╣ ╤ ╥ ╦ ╧ ╨ ╪ ╫ ╳ ╔ ╗ ╝ ╚ ╬ ═ ╓ ╩ ┠ ┨ ┯ ┷ ┏ ┓ ┗ ┛ ┳ ⊥ ﹃ ﹄ ┌ ╭ ╮ ╯ ╰'.split(' ');
        const _3 = '№ ① ② ③ ④ ⑤ ⑥ ⑦ ⑧ ⑨ ⑩ ㈠ ㈡ ㈢ ㈣ ㈤ ㈥ ㈦ ㈧ ㈨ ㈩ ⑴ ⑵ ⑶ ⑷ ⑸ ⑹ ⑺ ⑻ ⑼ ⑽ ⑾ ⑿ ⒀ ⒁ ⒂ ⒃ ⒄ ⒅ ⒆ ⒇ ⒈ ⒉ ⒊ ⒋ ⒌ ⒍ ⒎ ⒏ ⒐ ⒑ ⒒ ⒓ ⒔ ⒕ ⒖ ⒗ ⒘ ⒙ ⒚ ⒛ Ⅰ Ⅱ Ⅲ Ⅳ Ⅴ Ⅵ Ⅶ Ⅷ Ⅸ Ⅹ Ⅺ Ⅻ ⅰ ⅱ ⅲ ⅳ ⅴ ⅵ ⅶ ⅷ ⅸ ⅹ ⑪ ⑫ ⑬ ⑭ ⑮ ⑯ ⑰ ⑱ ⑲ ⑳ ⓐ ⓑ ⓒ ⓓ ⓔ ⓕ ⓖ ⓗ ⓘ ⓙ ⓚ ⓛ ⓜ ⓝ ⓞ ⓟ ⓠ ⓡ ⓢ ⓣ ⓤ ⓥ ⓦ ⓧ ⓨ ⓩ'.split(' ');
        const _4 = 'Α Β Γ Δ Ε Ζ Η Θ Ι Κ Λ Μ Ν Ξ Ο Π Ρ Σ Τ Υ Φ Χ Ψ Ω α β γ δ ε ζ ν ξ ο π ρ σ η θ ι κ λ μ τ υ φ χ ψ ω'.split(' ');
        const _5 = 'А Б В Г Д Е Ё Ж З И Й К Л М Н О П Р С Т У Ф Х Ц Ч Ш Щ Ъ Ы Ь Э Ю Я а б в г д е ё ж з и й к л м н о п р с т у ф х ц ч ш щ ъ ы ь э ю я'.split(' ');
        const _6 = 'ぁ あ ぃ い ぅ う ぇ え ぉ お か が き ぎ く ぐ け げ こ ご さ ざ し じ す ず せ ぜ そ ぞ た だ ち ぢ っ つ づ て で と ど な に ぬ ね の は ば ぱ ひ び ぴ ふ ぶ ぷ へ べ ぺ ほ ぼ ぽ ま み む め も ゃ や ゅ ゆ ょ よ ら り る れ ろ ゎ わ ゐ ゑ を ん'.split(' ');
        const _7 = 'ァ ア ィ イ ゥ ウ ェ エ ォ オ カ ガ キ ギ ク グ ケ ゲ コ ゴ サ ザ シ ジ ス ズ セ ゼ ソ ゾ タ ダ チ ヂ ッ ツ ヅ テ デ ト ド ナ ニ ヌ ネ ノ ハ バ パ ヒ ビ ピ フ ブ プ ヘ ベ ペ ホ ボ ポ マ ミ ム メ モ ャ ヤ ュ ユ ョ ヨ ラ リ ル レ ロ ヮ ワ ヰ ヱ ヲ ン ヴ ヵ ヶ'.split(' ');
        const _8 = '夬 丅 乛 丄 丩 乚 夊 亅 亇 厃 丂 零 壹 贰 叁 肆 伍 陆 柒 捌 玖 拾 佰 仟 万 亿 吉 太 拍 艾 分 厘 毫 微 卍 卐 卄 巜 弍 弎 弐 朤 氺 曱 甴 囍 兀 々 〆 の ぁ 〡 〢 〣 〤 〥 〦 〧 〨 〩 ㊊ ㊋ ㊌ ㊍ ㊎ ㊏ ㊛ ㊚ ㊐ ㊑ ㊒ ㊓ ㊔ ㊕ ㊖ ㊗ ㊘ ㊜ ㊝ ㊞ ㊟ ㊠ ㊡ ㊢ ㊣ ㊤ ㊥ ㊦ ㊧ ㊨ ㊩ ㊪ ㊫ ㊬ ㊭ ㊮ ㊯ ㊰'.split(' ');
        const _9 = 'ā á ǎ à ō ó ǒ ò ē é ě è ī í ǐ ì ū ú ǔ ù ǖ ǘ ǚ ǜ ü ㄅ ㄆ ㄇ ㄈ ㄉ ㄊ ㄋ ㄌ ㄍ ㄎ ㄏ ㄐ ㄑ ㄒ ㄓ ㄔ ㄕ ㄖ ㄗ ㄘ ㄙ ㄚ ㄛ ㄜ ㄝ ㄞ ㄟ ㄠ ㄡ ㄢ ㄣ ㄤ ㄥ ㄦ ㄧ ㄨ ㄩ'.split(' ');
        const _10 = '㎎ ㎏ ㎜ ㎝ ㎞ ㎡ ㏄ ㏎ ㏑ ㏒ ㏕ ℡ % ‰ ℃ ℉ ° ′ ″ $ ￡ ￥ ￠ ♂ ♀ ℅'.split(' ');
        const _11 = `. 。 ， 、 ; ： ？ ! ˉ ˇ ¨ ~ 々 ‖ ∶ " ' \` | · … — ～ - 〃 ‘ ’ “ ” 〝 〞 〔 〕 〈 〉 《 》 「 」 『 』 〖 〗 【 】 ( ) [ ] { ｝ ︻ ︼ ﹄ ﹃`.split(' ');
        const _12 = '+ - × ÷ ± / ≌ ∽ ≦ ≧ ≒ ﹤ ﹥ ≈ ≡ ≠ = ≤ ≥ < > ≮ ≯ ∷ ∶ ∫ ∮ ∝ ∞ ∧ ∨ ∑ ∏ ∪ ∩ ∈ ∵ ∴ ⊥ ∥ ∠ ⌒ ⊙ √ ∟ ⊿ ㏒ ㏑ % ‰'.split(' ');
        const _13 = '↑ ↓ ← → ↖ ↗ ↙ ↘ ↔ ↕ ➼ ➽ ➸ ➳ ➺ ➻ ➴ ➵ ➶ ➷ ➹ ▶ ➩ ➪ ➫ ➬ ➭ ➮ ➯ ➱ ➲ ➾ ➔ ➘ ➙ ➚ ➛ ➜ ➝ ➞ ➟ ➠ ➡ ➢ ➣ ➤ ➥ ➦ ➧ ➨ ↚ ↛ ↜ ↝ ↞ ↟ ↠ ↡ ↢ ↣ ↤ ↥ ↦ ↧ ↨ ⇄ ⇅ ⇆ ⇇ ⇈ ⇉ ⇊ ⇋ ⇌ ⇍ ⇎ ⇏ ⇐ ⇑ ⇒ ⇓ ⇔ ⇖ ⇗ ⇘ ⇙ ⇜ ↩ ↪ ↫ ↬ ↭ ↮ ↯ ↰ ↱ ↲ ↳ ↴ ↵ ↶ ↷ ↸ ↹ ↺ ↻ ↼ ↽ ↾ ↿ ⇀ ⇁ ⇂ ⇃ ⇞ ⇟ ⇠ ⇡ ⇢ ⇣ ⇤ ⇥ ⇦ ⇧ ⇨ ⇩ ⇪'.split(' ');

        this._openModal({
            title: '符号大全',
            hasFooter: false,
            innerHtml: `
                <div class="tabbar">
                    <div class="tabbar-item active" data-show="1">星星符号</div>
                    <div class="tabbar-item" data-show="2">绘表符号</div>
                    <div class="tabbar-item" data-show="3">编号&序号</div>
                    <div class="tabbar-item" data-show="4">希腊字母</div>
                    <div class="tabbar-item" data-show="5">俄语字符</div>
                    <div class="tabbar-item" data-show="6">日语字符</div>
                    <div class="tabbar-item" data-show="7">注音码</div>
                    <div class="tabbar-item" data-show="8">中文字符</div>
                    <div class="tabbar-item" data-show="9">汉语拼音</div>
                    <div class="tabbar-item" data-show="10">单位符号</div>
                    <div class="tabbar-item" data-show="11">标点符号</div>
                    <div class="tabbar-item" data-show="12">数学符号</div>
                    <div class="tabbar-item" data-show="13">箭头符号</div>
                </div>
                <div class="lists active" data-show="1">
                    ${_1.map(_ => `<div class="lists-item" data-text="${_}">${_}</div>`).join(' ')}
                </div>
                <div class="lists" data-show="2">
                    ${_2.map(_ => `<div class="lists-item" data-text="${_}">${_}</div>`).join(' ')}
                </div>
                <div class="lists" data-show="3">
                    ${_3.map(_ => `<div class="lists-item" data-text="${_}">${_}</div>`).join(' ')}
                </div>
                <div class="lists" data-show="4">
                    ${_4.map(_ => `<div class="lists-item" data-text="${_}">${_}</div>`).join(' ')}
                </div>
                <div class="lists" data-show="5">
                    ${_5.map(_ => `<div class="lists-item" data-text="${_}">${_}</div>`).join(' ')}
                </div>
                <div class="lists" data-show="6">
                    ${_6.map(_ => `<div class="lists-item" data-text="${_}">${_}</div>`).join(' ')}
                </div>
                <div class="lists" data-show="7">
                    ${_7.map(_ => `<div class="lists-item" data-text="${_}">${_}</div>`).join(' ')}
                </div>
                <div class="lists" data-show="8">
                    ${_8.map(_ => `<div class="lists-item" data-text="${_}">${_}</div>`).join(' ')}
                </div>
                <div class="lists" data-show="9">
                    ${_9.map(_ => `<div class="lists-item" data-text="${_}">${_}</div>`).join(' ')}
                </div>
                <div class="lists" data-show="10">
                    ${_10.map(_ => `<div class="lists-item" data-text="${_}">${_}</div>`).join(' ')}
                </div>
                <div class="lists" data-show="11">
                    ${_11.map(_ => `<div class="lists-item" data-text="${_}">${_}</div>`).join(' ')}
                </div>
                <div class="lists" data-show="12">
                    ${_12.map(_ => `<div class="lists-item" data-text="${_}">${_}</div>`).join(' ')}
                </div>
                <div class="lists" data-show="13">
                    ${_13.map(_ => `<div class="lists-item" data-text="${_}">${_}</div>`).join(' ')}
                </div>
            `,
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
}
