$(function () {
    $("head").append(
        `<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, shrink-to-fit=no, viewport-fit=cover">`
    );

    window.JoeEditor = CodeMirror.fromTextArea(
        document.querySelector("textarea#text"),
        {
            theme: "joe",
            mode: "gfm",
            /* Tab大小 */
            indentUnit: 4,
            /* 显示行号 */
            lineNumbers: true,
            /* 超出宽度自动换行 */
            lineWrapping: true,
            /* 当前行背景高亮 */
            styleActiveLine: true,
            /* 匹配括号 */
            matchBrackets: true,
            /* 自动闭合括号 */
            autoCloseBrackets: true,
            /* 自动闭合标签 */
            autoCloseTags: true,
            /* 折行 */
            foldGutter: true,
            gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
            /* 匹配标签 */
            matchTags: { bothTags: true },
            /* 按键 */
            extraKeys: {
                /* 换行时自动联想输入的类型 */
                Enter: "newlineAndIndentContinueMarkdownList",
                /* 匹配标签 */
                "Ctrl-J": "toMatchingTag",
            },
            /* 双击鼠标选中后，可以拖拽被选择的文本 */
            selectionPointer: true,
        }
    );

    /* 设置高度 */
    JoeEditor.setSize("100%", "550");

    /* 实时预览 */
    JoeEditor.on("change", function () {
        // console.log(JoeEditor.getValue());
    });

    /* 节流，防止傻逼疯狂ctrl + v上传 */
    let _flag = false;
    /* 实现粘贴上传图片 */
    JoeEditor.on("paste", function (editor, event) {
        let clipboardData =
            event.clipboardData ||
            window.clipboardData ||
            event.originalEvent.clipboardData;
        if (!clipboardData || !clipboardData.items) return;
        let items = clipboardData.items;
        let file = null;
        if (items.length === 0) return;
        for (let i = 0; i < items.length; i++) {
            if (items[i].kind === "file" && items[i].type.match(/^image/)) {
                event.preventDefault(), (file = items[i].getAsFile());
            }
        }
        if (!file) return;
        /* 节流，防止傻逼疯狂ctrl + v上传 */
        if (_flag) return;
        _flag = true;
        let uploadUrl = JoeUploadURL;
        let cid = $('input[name="cid"]').val();
        cid && (uploadUrl = uploadUrl + "&cid=" + cid);
        let random = Date.now().toString(36);
        let fileName = random + ".png";
        let formData = new FormData();
        formData.append("name", fileName);
        formData.append("file", file, fileName);
        $.ajax({
            url: uploadUrl,
            method: "post",
            data: formData,
            contentType: false,
            processData: false,
            xhr: () => {
                let xhr = $.ajaxSettings.xhr();
                if (!xhr.upload) return;
                $(".CodeMirror-progress").show();
                xhr.upload.addEventListener(
                    "progress",
                    (e) => {
                        let percent = (e.loaded / e.total) * 100;
                        $(".CodeMirror-progress").css("right", -percent + "%");
                    },
                    false
                );
                return xhr;
            },
            success(res) {
                const text = `![${res[1].title}](${res[0]})`;
                let timer = setTimeout(function () {
                    $(".CodeMirror-progress").hide();
                    $(".CodeMirror-progress").css("right", "100%");
                    /* 节流，防止傻逼疯狂ctrl + v上传 */
                    _flag = false;
                    const cursor = JoeEditor.getCursor();
                    if (cursor.ch === 0) JoeEditor.replaceSelection(text);
                    else JoeEditor.replaceSelection("\n\n" + text);
                    JoeEditor.focus();
                    clearTimeout(timer);
                }, 1000);
            },
            error() {
                let timer = setTimeout(function () {
                    $(".CodeMirror-progress").hide();
                    $(".CodeMirror-progress").css("right", "100%");
                    /* 节流，防止傻逼疯狂ctrl + v上传 */
                    _flag = false;
                    clearTimeout(timer);
                }, 1000);
            },
        });
    });

    Typecho.insertFileToEditor = function (file, url, isImage) {
        const htmlStr = isImage
            ? "![" + file + "](" + url + ")"
            : "[" + file + "](" + url + ")";
        const cursor = JoeEditor.getCursor();
        const n = cursor.ch === 0 ? "" : "\n";
        JoeEditor.replaceSelection(n + htmlStr);
        JoeEditor.focus();
    };
});
