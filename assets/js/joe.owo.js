class JoeOwO {
    constructor(options) {
        const defaultOption = {
            contain: '.joe_owo__contain',
            target: '.joe_owo__target',
            seat: 'OωO',
            api: '/usr/themes/Joe/assets/json/joe.owo.json'
        };
        this.options = Object.assign(defaultOption, options);
        $.ajax({
            url: this.options.api,
            type: 'get',
            dataType: 'json',
            success: res => this.initHtml(res)
        });
    }
    /* 初始化 */
    initHtml(res) {
        let barStr = '';
        let scrollStr = '';
        for (let key in res) {
            barStr += `<div class="item" data-index="${res[key].index}">${key}</div>`;
            scrollStr += `
                <ul class="scroll" data-index="${res[key].index}">
                    ${res[key].container.map(_ => `<li class="item" data-text="${_.data}">${_.icon}</li>`).join('')} 
                </ul>
            `;
        }
        $(this.options.contain).html(`
            <div class="seat">${this.options.seat}</div>
            <div class="box">
                ${scrollStr}
                <div class="bar">${barStr}</div>
            </div>
        `);

        this.initEvent();
    }
    initEvent() {
        /* 容器 */
        const contain = this.options.contain;

        /* 点击页面关闭 */
        $(document).on('click', function () {
            const box = contain + ' .box';
            $(box).stop().slideUp('fast');
        });

        /* 点击占位符，显示表情弹窗 */
        const seat = contain + ' .seat';
        $(seat).on('click', function (e) {
            e.stopPropagation();
            $(this).siblings('.box').stop().slideToggle('fast');
        });

        /* 点击tab栏，切换表情类型 */
        const barItem = contain + ' .box .bar .item';
        $(barItem).on('click', function (e) {
            e.stopPropagation();
            $(this).addClass('active').siblings().removeClass('active');
            const scrollIndx = contain + ' .box .scroll[data-index="' + $(this).attr('data-index') + '"]';
            $(scrollIndx).show().siblings('.scroll').hide();
        });

        /* 点击表情，向文本框插入内容 */
        const items = contain + ' .scroll .item';
        const textarea = $(this.options.target)[0];
        $(items).on('click', function () {
            const text = $(this).attr('data-text');
            const cursorPos = textarea.selectionEnd;
            const areaValue = textarea.value;
            textarea.value = areaValue.slice(0, cursorPos) + text + areaValue.slice(cursorPos);
            textarea.focus();
        });

        /* 默认激活第一个 */
        $(barItem).first().click();
    }
}
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = JoeOwO;
} else {
    window.JoeOwO = JoeOwO;
}
