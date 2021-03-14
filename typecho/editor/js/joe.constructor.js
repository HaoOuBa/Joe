class JoeInstance {
    constructor() {
        this.init();
    }

    init() {
        $(".CodeMirror-wrap").before('<ul class="CodeMirror-means"></ul>');
        $(".CodeMirror-wrap").append('<div class="CodeMirror-progress"></div>');
        $("body").append(`
            <div class="CodeMirror-dialog">
                <div class="CodeMirror-dialog__wrapper">
                    <div class="CodeMirror-dialog__wrapper-header"></div>
                    <div class="CodeMirror-dialog__wrapper-bodyer"></div>
                    <div class="CodeMirror-dialog__wrapper-footer">
                        <button class="CodeMirror-dialog__wrapper-footer--cancle">取消</button>
                        <button class="CodeMirror-dialog__wrapper-footer--confirm">确定</button>
                    </div>
                </div>
            </div>
        `);
        $(".CodeMirror-dialog__wrapper-footer--cancle").on("click", () => {
            this.options.cancel();
            $(".CodeMirror-dialog").removeClass("active");
            $("body").css("overflow", "");
        });
        $(".CodeMirror-dialog__wrapper-footer--confirm").on("click", () => {
            this.options.confirm();
            $(".CodeMirror-dialog").removeClass("active");
            $("body").css("overflow", "");
        });
    }

    /* 打开弹窗 */
    __OpenTheDialog(options = {}) {
        const _options = {
            title: "提示",
            innerHtml: "内容",
            cancel: () => {},
            confirm: () => {},
        };
        this.options = Object.assign(_options, options);
        $(".CodeMirror-dialog__wrapper-header").html(this.options.title);
        $(".CodeMirror-dialog__wrapper-bodyer").html(this.options.innerHtml);
        $(".CodeMirror-dialog").addClass("active");
        $("body").css("overflow", "hidden");
    }

    /* 初始化插入标题功能 - 已测试 √ */
    initTitleText(tool) {
        const item = $(`
                <li class="CodeMirror-means-item" title="${tool.title}">
                    ${tool.icon}
                    <div class="CodeMirror-means__dropdown">
                        <div class="CodeMirror-means__dropdown-item" data-text="# "> H1 </div>
                        <div class="CodeMirror-means__dropdown-item" data-text="## "> H2 </div>
                        <div class="CodeMirror-means__dropdown-item" data-text="### "> H3 </div>
                        <div class="CodeMirror-means__dropdown-item" data-text="#### "> H4 </div>
                        <div class="CodeMirror-means__dropdown-item" data-text="##### "> H5 </div>
                        <div class="CodeMirror-means__dropdown-item" data-text="###### "> H6 </div>
                    </div>
                </li>
            `);
        item.on("click", function (e) {
            e.stopPropagation();
            $(this).toggleClass("active");
        });
        item.on("click", ".CodeMirror-means__dropdown-item", function (e) {
            e.stopPropagation();
            const text = $(this).attr("data-text");
            const cursor = JoeEditor.getCursor();
            if (cursor.ch === 0) JoeEditor.replaceSelection(text);
            else JoeEditor.replaceSelection("\n\n" + text);
            item.removeClass("active");
            JoeEditor.focus();
        });
        $(document).on("click", () => item.removeClass("active"));
        $(".CodeMirror-means").append(item);
    }

    /* 全屏/取消全屏 - 已测试 √ */
    handleFullscreen(tool) {
        const toolsHeight = $(".CodeMirror-means").height();
        const item = $(
            `<li class="CodeMirror-means-item" title="${tool.title}">${tool.icon}</li>`
        );
        item.on("click", function () {
            const bool = JoeEditor.getOption("fullScreen");
            if (bool) {
                JoeEditor.setOption("fullScreen", false);
                $(".CodeMirror-wrap").css("top", "");
                $(".CodeMirror-means").removeClass("fullscreen");
                $(item).removeClass("active");
            } else {
                JoeEditor.setOption("fullScreen", true);
                $(".CodeMirror-wrap").css("top", toolsHeight);
                $(".CodeMirror-means").addClass("fullscreen");
                $(item).addClass("active");
            }
        });
        $(".CodeMirror-means").append(item);
    }

    /* 加粗 - 已测试 √ */
    insertBoldText() {
        const cursor = JoeEditor.getCursor();
        const selection = JoeEditor.getSelection();
        JoeEditor.replaceSelection("**" + selection + "**");
        if (selection === "") JoeEditor.setCursor(cursor.line, cursor.ch + 2);
        JoeEditor.focus();
    }

    /* 倾斜 - 已测试 √ */
    insertItalicText() {
        const cursor = JoeEditor.getCursor();
        const selection = JoeEditor.getSelection();
        JoeEditor.replaceSelection("*" + selection + "*");
        if (selection === "") JoeEditor.setCursor(cursor.line, cursor.ch + 1);
        JoeEditor.focus();
    }

    /* 删除线 - 已测试 √ */
    insertDeleteText() {
        const cursor = JoeEditor.getCursor();
        const selection = JoeEditor.getSelection();
        JoeEditor.replaceSelection("~~" + selection + "~~");
        if (selection === "") JoeEditor.setCursor(cursor.line, cursor.ch + 2);
        JoeEditor.focus();
    }

    /* 引用 - 已测试 √ */
    insertQuoteText() {
        const cursor = JoeEditor.getCursor();
        const selection = JoeEditor.getSelection();
        if (cursor.ch === 0) {
            JoeEditor.replaceSelection("> " + selection);
        } else {
            JoeEditor.setCursor(cursor.line, 0);
            JoeEditor.replaceSelection("> " + selection);
            JoeEditor.setCursor(cursor.line, cursor.ch + 2);
        }
        JoeEditor.focus();
    }

    /* 空格 - 已测试 √ */
    insertSpaceText() {
        JoeEditor.replaceSelection("　");
        JoeEditor.focus();
    }

    /* 行内代码 - 已测试 √ */
    insertCodeInlineText() {
        const cursor = JoeEditor.getCursor();
        const selection = JoeEditor.getSelection();
        JoeEditor.replaceSelection("`" + selection + "`");
        if (selection === "") JoeEditor.setCursor(cursor.line, cursor.ch + 1);
        JoeEditor.focus();
    }

    /* 横线 - 已测试 √ */
    insertHrText() {
        const cursor = JoeEditor.getCursor();
        if (cursor.ch === 0) JoeEditor.replaceSelection("\n------------\n\n");
        else JoeEditor.replaceSelection("\n\n------------\n\n");
        JoeEditor.focus();
    }

    /* 无序列表 - 已测试 √ */
    insertUnorderedListText() {
        const cursor = JoeEditor.getCursor();
        const selection = JoeEditor.getSelection();
        if (cursor.ch === 0) {
            if (selection === "") {
                JoeEditor.replaceSelection("- ");
            } else {
                const selectionText = selection.split("\n");
                for (let i = 0, len = selectionText.length; i < len; i++) {
                    selectionText[i] =
                        selectionText[i] === "" ? "" : "- " + selectionText[i];
                }
                JoeEditor.replaceSelection(selectionText.join("\n"));
            }
        } else {
            if (selection === "") {
                JoeEditor.replaceSelection("\n- ");
            } else {
                const selectionText = selection.split("\n");
                for (let i = 0, len = selectionText.length; i < len; i++) {
                    selectionText[i] =
                        selectionText[i] === "" ? "" : "- " + selectionText[i];
                }
                JoeEditor.replaceSelection("\n" + selectionText.join("\n"));
            }
        }
        JoeEditor.focus();
    }

    /* 有序列表 - 已测试 √ */
    insertOrderedListText() {
        const cursor = JoeEditor.getCursor();
        const selection = JoeEditor.getSelection();
        if (cursor.ch === 0) {
            if (selection === "") {
                JoeEditor.replaceSelection("1. ");
            } else {
                const selectionText = selection.split("\n");
                for (let i = 0, len = selectionText.length; i < len; i++) {
                    selectionText[i] =
                        selectionText[i] === ""
                            ? ""
                            : i + 1 + ". " + selectionText[i];
                }
                JoeEditor.replaceSelection(selectionText.join("\n"));
            }
        } else {
            if (selection === "") {
                JoeEditor.replaceSelection("\n\n1. ");
            } else {
                const selectionText = selection.split("\n");
                for (let i = 0, len = selectionText.length; i < len; i++) {
                    selectionText[i] =
                        selectionText[i] === ""
                            ? ""
                            : i + 1 + ". " + selectionText[i];
                }
                JoeEditor.replaceSelection("\n" + selectionText.join("\n"));
            }
        }
        JoeEditor.focus();
    }

    /* 插入时间 - 已测试 √ */
    insertTimeText() {
        const time = new Date();
        const _Year = time.getFullYear();
        const _Month = String(time.getMonth() + 1).padStart(2, 0);
        const _Date = String(time.getDate()).padStart(2, 0);
        const _Hours = String(time.getHours()).padStart(2, 0);
        const _Minutes = String(time.getMinutes()).padStart(2, 0);
        const _Seconds = String(time.getSeconds()).padStart(2, 0);
        const _Day = [
            "星期日",
            "星期一",
            "星期二",
            "星期三",
            "星期四",
            "星期五",
            "星期六",
        ][time.getDay()];
        const _time = `${_Year}-${_Month}-${_Date} ${_Hours}:${_Minutes}:${_Seconds} ${_Day}`;
        const cursor = JoeEditor.getCursor();
        if (cursor.ch === 0) JoeEditor.replaceSelection(_time);
        else JoeEditor.replaceSelection("\n" + _time);
        JoeEditor.focus();
    }

    /* 插入URL链接 - 已测试 √ */
    insertLinkText() {
        this.__OpenTheDialog({
            title: "插入链接",
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
            confirm() {
                const title = $(".CodeMirror-dialog input[name='title']").val();
                const url = $(".CodeMirror-dialog input[name='url']").val();
                JoeEditor.replaceSelection(
                    `[${title || "默认标题"}](${url || "默认地址"})`
                );
                JoeEditor.focus();
            },
        });
    }

    /* 插入图片 - 已测试 √ */
    insertImageText() {
        this.__OpenTheDialog({
            title: "插入图片",
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
            confirm() {
                const title = $(".CodeMirror-dialog input[name='title']").val();
                const url = $(".CodeMirror-dialog input[name='url']").val();
                JoeEditor.replaceSelection(
                    `![${title || "默认图片"}](${url || "默认地址"})`
                );
                JoeEditor.focus();
            },
        });
    }

    /* 插入表格 - 已测试 √ */
    insertTableText() {
        this.__OpenTheDialog({
            title: "插入表格",
            innerHtml: `
                <div class="fitem">
                    <label>表格行</label>
                    <input style="width: 50px; flex: none; margin-right: 10px;" value="3" autocomplete="off" name="row"/>
                    <label>表格列</label>
                    <input style="width: 50px; flex: none;" value="3" autocomplete="off" name="column"/>
                </div>
            `,
            confirm() {
                let row = $(".CodeMirror-dialog input[name='row']").val();
                let column = $(".CodeMirror-dialog input[name='column']").val();
                if (isNaN(row)) row = 3;
                if (isNaN(column)) column = 3;
                let rowStr = "";
                let rangeStr = "";
                let columnlStr = "";
                for (let i = 0; i < column; i++) {
                    rowStr += "| 表头 ";
                    rangeStr += "| :--: ";
                }
                for (let i = 0; i < row; i++) {
                    for (let j = 0; j < column; j++) columnlStr += "| 表格 ";
                    columnlStr += "|\n";
                }
                const htmlStr = `${rowStr}|\n${rangeStr}|\n${columnlStr}\n`;
                const cursor = JoeEditor.getCursor();
                if (cursor.ch === 0) JoeEditor.replaceSelection(htmlStr);
                else JoeEditor.replaceSelection("\n\n" + htmlStr);
                JoeEditor.focus();
            },
        });
    }

    /* 插入代码块 - 已测试 √ */
    insertCodeBlockText() {
        this.__OpenTheDialog({
            title: "插入代码块",
            innerHtml: `
                <div class="fitem">
                    <label>语言类型</label>
                    <input autocomplete="off" name="type" placeholder="请输入语言类型（英文）"/>
                </div>
            `,
            confirm() {
                const type = $(".CodeMirror-dialog input[name='type']").val();
                const cursor = JoeEditor.getCursor();
                const htmlStr = `\`\`\`${
                    type || "html"
                }\ncode here...\n\`\`\`\n\n`;
                if (cursor.ch === 0) JoeEditor.replaceSelection(htmlStr);
                else JoeEditor.replaceSelection("\n\n" + htmlStr);
                JoeEditor.focus();
            },
        });
    }

    /* 关于 */
    handleAbout() {
        this.__OpenTheDialog({
            title: "关于",
            innerHtml: `
                <ul>
                    <li>文件读取教程（将文件推拽至编辑器即可）</li>
                    <li>图片粘贴上传教程（不支持本地文件复制粘贴，支持网络图片复制、截图等）</li>
                    <li>本编辑器仅为Joe主题使用，未经允许不得移植至其他主题！</li>
                </ul>
            `,
        });
    }
}
window.JoeInstance = JoeInstance;
