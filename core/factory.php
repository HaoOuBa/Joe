<?php
/* 加强评论拦截功能 */
Typecho_Plugin::factory('Widget_Feedback')->comment = array('Intercept', 'message');
class Intercept
{
    public static function message($comment)
    {
        /* 如果用户输入内容画图模式 */
        if (preg_match('/\{!\{(.*)\}!\}/', $comment['text'], $matches)) {
            /* 如果判断是否有双引号，如果有双引号，则禁止评论 */
            if (strpos($matches[1], '"') !== false || _checkXSS($matches[1])) {
                $comment['status'] = 'waiting';
            }
        } else {
            /* 判断评论内容是否包含敏感词 */
            if (Helper::options()->JSensitiveWords) {
                if (_checkSensitiveWords(Helper::options()->JSensitiveWords, $comment['text'])) {
                    $comment['status'] = 'waiting';
                }
            }
            /* 判断评论是否至少包含一个中文 */
            if (Helper::options()->JLimitOneChinese === "on") {
                if (preg_match("/[\x{4e00}-\x{9fa5}]/u", $comment['text']) == 0) {
                    $comment['status'] = 'waiting';
                }
            }
        }
        Typecho_Cookie::delete('__typecho_remember_text');
        return $comment;
    }
}

/* 加强后台编辑器功能 */
if (Helper::options()->JEditor !== 'off') {
    Typecho_Plugin::factory('admin/write-post.php')->richEditor  = array('Editor', 'Edit');
    Typecho_Plugin::factory('admin/write-page.php')->richEditor  = array('Editor', 'Edit');
}

class Editor
{
    public static function Edit()
    { ?>
        <script>
            var JoeUploadURL = '<?php Helper::security()->index('/action/upload'); ?>';
        </script>
<?php
        /* 编辑器核心 */
        echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/lib/codemirror.min.css">';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/lib/codemirror.min.js"></script>';
        /* 编辑器语法高亮 */
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/markdown/markdown.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/javascript/javascript.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/css/css.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/xml/xml.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/gfm/gfm.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/pug/pug.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/sass/sass.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/stylus/stylus.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/clike/clike.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/htmlmixed/htmlmixed.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/vue/vue.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/swift/swift.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/sql/sql.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/shell/shell.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/python/python.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/php/php.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/go/go.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/yaml/yaml.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/yaml-frontmatter/yaml-frontmatter.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/mode/meta.min.js"></script>';
        /* 编辑器附加功能 */
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/addon/edit/continuelist.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/addon/selection/active-line.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/addon/edit/matchbrackets.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/addon/edit/closebrackets.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/addon/selection/selection-pointer.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/addon/display/fullscreen.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/addon/edit/closetag.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/addon/mode/overlay.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/addon/edit/matchtags.min.js"></script>';
        /* 代码折行 */
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/addon/fold/foldcode.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/addon/fold/foldgutter.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/addon/fold/xml-fold.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/addon/fold/markdown-fold.min.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.59.4/addon/fold/brace-fold.min.js"></script>';
        /* 引入本地文件 */
        echo '<link rel="stylesheet" href="/usr/themes/Joe/typecho/editor/css/joe.editor.min.css?v=2021314">';
        echo '<script src="/usr/themes/Joe/typecho/editor/js/joe.editor.min.js?v=2021314"></script>';
        echo '<script src="/usr/themes/Joe/typecho/editor/js/joe.constructor.min.js?v=2021314"></script>';
        echo '<script src="/usr/themes/Joe/typecho/editor/js/joe.instance.min.js?v=2021314"></script>';
    }
}
