function _instanceof(left, right) {
    if (right != null && typeof Symbol !== 'undefined' && right[Symbol.hasInstance]) {
        return !!right[Symbol.hasInstance](left);
    } else {
        return left instanceof right;
    }
}

function _classCallCheck(instance, Constructor) {
    if (!_instanceof(instance, Constructor)) {
        throw new TypeError('Cannot call a class as a function');
    }
}

function _defineProperties(target, props) {
    for (var i = 0; i < props.length; i++) {
        var descriptor = props[i];
        descriptor.enumerable = descriptor.enumerable || false;
        descriptor.configurable = true;
        if ('value' in descriptor) descriptor.writable = true;
        Object.defineProperty(target, descriptor.key, descriptor);
    }
}

function _createClass(Constructor, protoProps, staticProps) {
    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
    if (staticProps) _defineProperties(Constructor, staticProps);
    return Constructor;
}

var JoeOwO = /*#__PURE__*/ (function () {
    'use strict';

    function JoeOwO(options) {
        var _this = this;

        _classCallCheck(this, JoeOwO);

        var defaultOption = {
            contain: '.joe_owo__contain',
            target: '.joe_owo__target',
            seat: 'OωO',
            api: 'https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/json/joe.owo.json'
        };
        this.options = Object.assign(defaultOption, options);
        $.ajax({
            url: this.options.api,
            type: 'get',
            dataType: 'json',
            success: function success(res) {
                return _this.initHtml(res);
            }
        });
    }
    /* 初始化 */

    _createClass(JoeOwO, [
        {
            key: 'initHtml',
            value: function initHtml(res) {
                var barStr = '';
                var scrollStr = '';

                for (var key in res) {
                    barStr += '<div class="item" data-index="'.concat(res[key].index, '">').concat(key, '</div>');
                    scrollStr += '\n                <ul class="scroll" data-index="'.concat(res[key].index, '">\n                    ').concat(
                        res[key].container
                            .map(function (_) {
                                return '<li class="item" data-text="'.concat(_.data, '">').concat(_.icon, '</li>');
                            })
                            .join(''),
                        ' \n                </ul>\n            '
                    );
                }

                $(this.options.contain).html('\n            <div class="seat">'.concat(this.options.seat, '</div>\n            <div class="box">\n                ').concat(scrollStr, '\n                <div class="bar">').concat(barStr, '</div>\n            </div>\n        '));
                this.initEvent();
            }
        },
        {
            key: 'initEvent',
            value: function initEvent() {
                /* 容器 */
                var contain = this.options.contain;
                var height = $(contain).height();
                /* 点击页面关闭 */

                $(document).on('click', function () {
                    $(contain + ' .box').removeClass('show');
                });
                /* 点击占位符，显示表情弹窗 */

                var seat = contain + ' .seat';
                $(seat).on('click', function (e) {
                    e.stopPropagation();
                    $(this).siblings('.box').css('top', height).toggleClass('show');
                });
                /* 点击tab栏，切换表情类型 */

                var barItem = contain + ' .box .bar .item';
                $(barItem).on('click', function (e) {
                    e.stopPropagation();
                    $(this).addClass('active').siblings().removeClass('active');
                    var scrollIndx = contain + ' .box .scroll[data-index="' + $(this).attr('data-index') + '"]';
                    $(scrollIndx).show().siblings('.scroll').hide();
                });
                /* 点击表情，向文本框插入内容 */

                var items = contain + ' .scroll .item';
                var textarea = $(this.options.target)[0];
                $(items).on('click', function () {
                    var text = $(this).attr('data-text');
                    var cursorPos = textarea.selectionEnd;
                    var areaValue = textarea.value;
                    textarea.value = areaValue.slice(0, cursorPos) + text + areaValue.slice(cursorPos);
                    textarea.focus();
                });
                /* 默认激活第一个 */

                $(barItem).first().click();
            }
        }
    ]);

    return JoeOwO;
})();

if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = JoeOwO;
} else {
    window.JoeOwO = JoeOwO;
}
