document.addEventListener('DOMContentLoaded', () => {
	class JoeMtitle extends HTMLElement {
		constructor() {
			super();
			this.innerHTML = `
				<span class="joe_detail__article-mtitle">
					<span class="text">
						${this.getAttribute('title') || '默认标题'}
					</span>
				</span>`;
		}
	}
	window.customElements.define('joe-mtitle', JoeMtitle);
	class JoeDplayer extends HTMLElement {
		constructor() {
			super();
			this.options = {
				src: this.getAttribute('src'),
				player: this.getAttribute('player')
			};
			this.render();
		}
		render() {
			if (this.options.src) this.innerHTML = `<iframe allowfullscreen="true" class="joe_detail__article-player" src="${this.options.player + this.options.src}"></iframe>`;
			else this.innerHTML = '播放地址未填写！';
		}
	}
	window.customElements.define('joe-dplayer', JoeDplayer);
	class JoeBilibili extends HTMLElement {
		constructor() {
			super();
			this.bvid = this.getAttribute('bvid');
			this.render();
		}
		render() {
			if (this.bvid) this.innerHTML = `<iframe allowfullscreen="true" class="joe_detail__article-player" src="//player.bilibili.com/player.html?bvid=${this.bvid}"></iframe>`;
			else this.innerHTML = 'Bvid未填写！';
		}
	}
	window.customElements.define('joe-bilibili', JoeBilibili);
	class JoeMusic extends HTMLElement {
		constructor() {
			super();
			this.options = {
				id: this.getAttribute('id'),
				width: this.getAttribute('width') || '100%',
				autoplay: this.getAttribute('autoplay') ? 1 : 0
			};
			this.render();
		}
		render() {
			if (this.options.id) this.innerHTML = `<iframe style="display: block; margin: 0 auto; border: 0;" width="${this.options.width}" height="86px" src="//music.163.com/outchain/player?type=2&id=${this.options.id}&auto=${this.options.autoplay}&height=66"></iframe>`;
			else this.innerHTML = '网易云歌曲ID未填写！';
		}
	}
	window.customElements.define('joe-music', JoeMusic);
	class JoeMlist extends HTMLElement {
		constructor() {
			super();
			this.options = {
				id: this.getAttribute('id'),
				width: this.getAttribute('width') || '100%',
				autoplay: this.getAttribute('autoplay') ? 1 : 0
			};
			this.render();
		}
		get template() {
			return `<iframe style="display: block; margin: 0 auto; border: 0;" width="${this.options.width}" height="450px" src="//music.163.com/outchain/player?type=0&id=${this.options.id}&auto=${this.options.autoplay}&height=430"></iframe>`;
		}
		render() {
			if (this.options.id) this.innerHTML = this.template;
			else this.innerHTML = '网易云歌单ID未填写！';
		}
	}
	window.customElements.define('joe-mlist', JoeMlist);
	class JoeAbtn extends HTMLElement {
		constructor() {
			super();
			this.options = {
				icon: this.getAttribute('icon') || '',
				color: this.getAttribute('color') || '#ff6800',
				href: this.getAttribute('href') || '#',
				radius: this.getAttribute('radius') || '17.5px',
				content: this.getAttribute('content') || '多彩按钮'
			};
			this.innerHTML = `
				<a class="joe_detail__article-abtn" style="background: ${this.options.color}; border-radius: ${this.options.radius}" href="${this.options.href}" target="_blank" rel="noopener noreferrer nofollow">
					<span class="icon"><i class="${this.options.icon} fa"></i></span><span class="content">${this.options.content}</span>
				</a>
			`;
		}
	}
	window.customElements.define('joe-abtn', JoeAbtn);
	class JoeAnote extends HTMLElement {
		constructor() {
			super();
			this.options = {
				icon: this.getAttribute('icon') || 'fa-download',
				href: this.getAttribute('href') || '#',
				type: /^secondary$|^success$|^warning$|^error$|^info$/.test(this.getAttribute('type')) ? this.getAttribute('type') : 'secondary',
				content: this.getAttribute('content') || '标签按钮'
			};
			this.innerHTML = `
				<a class="joe_detail__article-anote ${this.options.type}" href="${this.options.href}" target="_blank" rel="noopener noreferrer nofollow">
					<span class="icon"><i class="fa ${this.options.icon}"></i></span><span class="content">${this.options.content}</span>
				</a>
			`;
		}
	}
	window.customElements.define('joe-anote', JoeAnote);
	class JoeDotted extends HTMLElement {
		constructor() {
			super();
			this.startColor = this.getAttribute('startColor') || '#ff6c6c';
			this.endColor = this.getAttribute('endColor') || '#1989fa';
			this.innerHTML = `
				<span class="joe_detail__article-dotted" style="background-image: repeating-linear-gradient(-45deg, ${this.startColor} 0, ${this.startColor} 20%, transparent 0, transparent 25%, ${this.endColor} 0, ${this.endColor} 45%, transparent 0, transparent 50%)"></span>
			`;
		}
	}
	window.customElements.define('joe-dotted', JoeDotted);
	class JoeHide extends HTMLElement {
		constructor() {
			super();
			this.render();
		}
		render() {
			this.innerHTML = '<span class="joe_detail__article-hide">此处内容作者设置了 <i>回复</i> 可见</span>';
			this.$button = this.querySelector('i');
			const $comment = document.querySelector('.joe_comment');
			const $header = document.querySelector('.joe_header');
			if (!$comment || !$header) return;
			this.$button.addEventListener('click', () => {
				const top = $comment.offsetTop - $header.offsetHeight - 15;
				window.scrollTo({ top, behavior: 'smooth' });
			});
		}
	}
	window.customElements.define('joe-hide', JoeHide);
	class JoeCardDefault extends HTMLElement {
		constructor() {
			super();
			const _temp = this.querySelector('._temp');
			this.options = {
				width: this.getAttribute('width') || '100%',
				label: this.getAttribute('label') || '卡片标题',
				content: _temp.innerHTML.trim().replace(/^(<br>)|(<br>)$/g, '') || '卡片内容'
			};
			const htmlStr = `
				<span class="joe_detail__article-card_default" style="width: ${this.options.width}">
					<span class="title">${this.options.label}</span>
					<span class="content">${this.options.content}</span>
				</span>
			`;
			if (this.querySelector('._content')) {
				this.querySelector('._content').innerHTML = htmlStr;
			} else {
				const div = document.createElement('div');
				div.className = '_content';
				div.innerHTML = htmlStr;
				this.appendChild(div);
			}
		}
	}
	window.customElements.define('joe-card-default', JoeCardDefault);
	class JoeMessage extends HTMLElement {
		constructor() {
			super();
			this.options = {
				type: /^success$|^info$|^warning$|^error$/.test(this.getAttribute('type')) ? this.getAttribute('type') : 'info',
				content: this.getAttribute('content') || '消息内容'
			};
			this.innerHTML = `
				<span class="joe_detail__article-message ${this.options.type}">
					<span class="icon"></span>
					<span class="content">${this.options.content}</span>
				</span>
			`;
		}
	}
	window.customElements.define('joe-message', JoeMessage);
	class JoeProgress extends HTMLElement {
		constructor() {
			super();
			this.options = {
				percentage: /^\d{1,3}%$/.test(this.getAttribute('percentage')) ? this.getAttribute('percentage') : '50%',
				color: this.getAttribute('color') || '#ff6c6c'
			};
			this.innerHTML = `
				<span class="joe_detail__article-progress">
					<span class="strip">
						<span class="percent" style="width: ${this.options.percentage}; background: ${this.options.color};"></span>
					</span>
					<span class="percentage">${this.options.percentage}</span>
				</span>
			`;
		}
	}
	window.customElements.define('joe-progress', JoeProgress);
	class JoeCallout extends HTMLElement {
		constructor() {
			super();
			const _temp = this.querySelector('._temp');
			this.options = {
				color: this.getAttribute('color') || '#f0ad4e',
				content: _temp.innerHTML.trim().replace(/^(<br>)|(<br>)$/g, '') || '标注内容'
			};
			const htmlStr = `
				<span class="joe_detail__article-callout" style="border-left-color: ${this.options.color};">
					${this.options.content}
				</span>
			`;
			if (this.querySelector('._content')) {
				this.querySelector('._content').innerHTML = htmlStr;
			} else {
				const div = document.createElement('div');
				div.className = '_content';
				div.innerHTML = htmlStr;
				this.appendChild(div);
			}
		}
	}
	window.customElements.define('joe-callout', JoeCallout);

	const article = document.querySelector('.joe_detail__article');
	if (article) article.innerHTML = article.innerHTML.replace(/<p><\/p>/g, '');

	/* 
	------------------------以下未测试------------------------------------------
	*/
	/* 点击复制 */
	class JoeCopy extends HTMLElement {
		constructor() {
			super();
			this.options = {
				text: this.getAttribute('text') || '默认文本',
				content: this.innerHTML.trim().replace(/^(<br>)|(<br>)$/g, '') || '点击复制'
			};
			this.render();
		}
		get template() {
			return `<span class="joe_detail__article-copy">${this.options.content}</span>`;
		}
		render() {
			this.innerHTML = this.template;
			this.event();
		}
		event() {
			this.$copy = this.querySelector('.joe_detail__article-copy');
			new ClipboardJS(this.$copy, { text: () => this.options.text }).on('success', () => Qmsg.success('复制成功！'));
		}
	}
	window.customElements.define('joe-copy', JoeCopy);
});
