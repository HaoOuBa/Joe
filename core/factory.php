<?php


/* 加强后台编辑器功能 */
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('Editor', 'edit');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('Editor', 'edit');

class Editor
{
    public static function edit()
    {
        echo "<link rel='stylesheet' href='" . Helper::options()->themeUrl . '/typecho/editor/joe.editor.css?update=20210202' . "'>\n";
        echo "<script src='" . Helper::options()->themeUrl . '/typecho/editor/joe.extend.js?update=20210202' . "'></script>\n";
        echo "<script src='" . Helper::options()->themeUrl . '/typecho/editor/joe.editor.js?update=20210202' . "'></script>\n";
        if (Helper::options()->JPasteUpload === "on") { ?>
            <script>
                $("#text").on("paste", event => {
                    let clipboardData = event.clipboardData || window.clipboardData || event.originalEvent.clipboardData;
                    if (!clipboardData || !clipboardData.items) return;
                    let items = clipboardData.items;
                    let file = null;
                    if (items.length === 0) return;
                    for (let i = 0; i < items.length; i++) {
                        if (items[i].kind === 'file' && items[i].type.match(/^image/)) {
                            event.preventDefault(), file = items[i].getAsFile()
                        }
                    }
                    if (!file) return;
                    let uploadUrl = '<?php Helper::security()->index('/action/upload'); ?>';
                    let cid = $('input[name="cid"]').val()
                    cid && (uploadUrl = uploadUrl + '&cid=' + cid);
                    let random = Date.now().toString(36);
                    let fileName = random + '.png'
                    let uploadText = '[图片上传中...(' + random + ')]';
                    $('#text').insertContent(uploadText)
                    let formData = new FormData();
                    formData.append('name', fileName);
                    formData.append('file', file, fileName);
                    $.ajax({
                        method: 'post',
                        url: uploadUrl,
                        data: formData,
                        contentType: false,
                        processData: false,
                        success(res) {
                            $("#text").val($("#text").val().replace(uploadText, '![' + res[1].title + '](' + res[0] + ')'))
                        },
                        error() {
                            $("#text").val($("#text").val().replace(uploadText, '[图片上传失败！(' + random + ')]'))
                        }
                    });
                })
            </script>
<?php
        }
    }
}


/* 加强评论拦截功能 */
Typecho_Plugin::factory('Widget_Feedback')->comment = array('Intercept', 'message');
class Intercept
{
    public static function message($comment)
    {
        /* 判断评论内容是否包含敏感词 */
        if (Helper::options()->JSensitiveWords) {
            if (_checkSensitiveWords(Helper::options()->JSensitiveWords, $comment['text'])) {
                throw new Typecho_Widget_Exception("评论内容包含敏感词汇！", 403);
            }
        }
        /* 判断评论是否至少包含一个中文 */
        if (Helper::options()->JLimitOneChinese === "on") {
            if (!preg_match("/\{!\{.{0,}/", $comment['text']) && preg_match("/[\x{4e00}-\x{9fa5}]/u", $comment['text']) == 0) {
                throw new Typecho_Widget_Exception("评论至少包含一个中文！", 403);
            }
        }
        return $comment;
    }
}
