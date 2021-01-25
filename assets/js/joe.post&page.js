console.time('Post&Page.js执行时长');

document.addEventListener('DOMContentLoaded', () => {
    /* 获取本篇文章百度收录情况 */
    {
        $.ajax({
            url: Joe.BASE_API,
            type: 'POST',
            data: { routeType: 'baidu_record', site: window.location.href },
            success(res) {
                if (res.data && res.data === '已收录') {
                    $('#Joe_Baidu_Record').css('color', '#67C23A');
                    $('#Joe_Baidu_Record').html('已收录');
                } else {
                    const url = `https://ziyuan.baidu.com/linksubmit/url?sitename=${encodeURI(window.location.href)}`;
                    $('#Joe_Baidu_Record').html(`<a target="_blank" href="${url}" rel="noopener noreferrer nofollow" style="color: #F56C6C">未收录，提交收录</a>`);
                }
            }
        });
    }

    /* 激活代码高亮 */
    {
        Prism.highlightAll();
    }

    /* 激活图片预览功能 */
    {
        $('.joe_detail__article img:not(img.owo_image)').each(function () {
            $(this).wrap($(`<div data-fancybox="Joe" href="${$(this).attr('src')}"></div>`));
        });
    }

    /* 设置文章内的链接为新窗口打开 */
    {
        $('.joe_detail__article a').each(() => $(this).attr({ target: '_blank', rel: 'noopener noreferrer nofollow' }));
    }

    /* 当前页的CID */
    const cid = $('.joe_detail').attr('data-cid');

    /* 激活浏览功能 */
    {
        let viewsArr = localStorage.getItem(Joe.encryption('views')) ? JSON.parse(Joe.decrypt(localStorage.getItem(Joe.encryption('views')))) : [];
        const flag = viewsArr.includes(cid);
        if (!flag) {
            $.ajax({
                url: Joe.BASE_API,
                type: 'POST',
                data: { routeType: 'handle_views', cid },
                success(res) {
                    if (res.code !== 1) return;
                    $('#Joe_Article_Views').html(`${res.data.views} 阅读`);
                    viewsArr.push(cid);
                    const name = Joe.encryption('views');
                    const val = Joe.encryption(JSON.stringify(viewsArr));
                    localStorage.setItem(name, val);
                }
            });
        }
    }

    /* 激活文章点赞功能 */
    {
        let agreeArr = localStorage.getItem(Joe.encryption('agree')) ? JSON.parse(Joe.decrypt(localStorage.getItem(Joe.encryption('agree')))) : [];
        if (agreeArr.includes(cid)) $('.joe_detail__agree .icon-1').addClass('active');
        else $('.joe_detail__agree .icon-2').addClass('active');
        let _loading = false;
        $('.joe_detail__agree .icon').on('click', function () {
            if (_loading) return;
            _loading = true;
            agreeArr = localStorage.getItem(Joe.encryption('agree')) ? JSON.parse(Joe.decrypt(localStorage.getItem(Joe.encryption('agree')))) : [];
            let flag = agreeArr.includes(cid);
            $.ajax({
                url: Joe.BASE_API,
                type: 'POST',
                data: { routeType: 'handle_agree', cid, type: flag ? 'disagree' : 'agree' },
                success(res) {
                    if (res.code !== 1) return;
                    $('.joe_detail__agree .text').html(res.data.agree);
                    if (flag) {
                        const index = agreeArr.findIndex(_ => _ === cid);
                        agreeArr.splice(index, 1);
                        $('.joe_detail__agree .icon-1').removeClass('active');
                        $('.joe_detail__agree .icon-2').addClass('active');
                        $('.joe_detail__agree .icon').removeClass('active');
                    } else {
                        agreeArr.push(cid);
                        $('.joe_detail__agree .icon-2').removeClass('active');
                        $('.joe_detail__agree .icon-1').addClass('active');
                        $('.joe_detail__agree .icon').addClass('active');
                    }
                    const name = Joe.encryption('agree');
                    const val = Joe.encryption(JSON.stringify(agreeArr));
                    localStorage.setItem(name, val);
                },
                complete() {
                    _loading = false;
                }
            });
        });
    }
    console.timeEnd('Post&Page.js执行时长');
});
