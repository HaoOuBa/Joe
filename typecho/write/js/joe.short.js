document.addEventListener('DOMContentLoaded', () => {
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
			return `<iframe allowfullscreen="true" style="display: block; margin: 0 auto; border: 0;" width="${this.options.width}" height="450px" src="//music.163.com/outchain/player?type=0&id=${this.options.id}&auto=${this.options.autoplay}&height=430"></iframe>`;
		}
		render() {
			if (this.options.id) this.innerHTML = this.template;
			else this.innerHTML = '网易云歌单ID未填写！';
		}
	}
	window.customElements.define('joe-mlist', JoeMlist);

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
		get template() {
			return `<iframe allowfullscreen="true" style="display: block; margin: 0 auto; border: 0;" width="${this.options.width}" height="86px" src="//music.163.com/outchain/player?type=2&id=${this.options.id}&auto=${this.options.autoplay}&height=66"></iframe>`;
		}
		render() {
			if (this.options.id) this.innerHTML = this.template;
			else this.innerHTML = '网易云歌曲ID未填写！';
		}
	}
	window.customElements.define('joe-music', JoeMusic);

	class JoeBilibili extends HTMLElement {
		constructor() {
			super();
			this.options = {
				bvid: this.getAttribute('bvid')
			};
			this.render();
		}
		get template() {
			return `<iframe allowfullscreen="true" class="joe_detail__article-player" style="display: block; margin: 0 auto; border: 0;" width="100%" height="180px" src="//player.bilibili.com/player.html?bvid=${this.options.bvid}"></iframe>`;
		}
		render() {
			if (this.options.bvid) this.innerHTML = this.template;
			else this.innerHTML = 'Bvid未填写！';
		}
	}
	window.customElements.define('joe-bilibili', JoeBilibili);

	class JoeDplayer extends HTMLElement {
		constructor() {
			super();
			this.options = {
				src: this.getAttribute('src'),
				player: this.getAttribute('player')
			};
			this.render();
		}
		get template() {
			return `<iframe allowfullscreen="true" class="joe_detail__article-player" style="display: block; margin: 0 auto; border: 0;" width="100%" height="180px" src="${this.options.player + this.options.src}"></iframe>`;
		}
		render() {
			if (this.options.src) this.innerHTML = this.template;
			else this.innerHTML = '播放地址未填写！';
		}
	}
	window.customElements.define('joe-dplayer', JoeDplayer);

	class JoeMtitle extends HTMLElement {
		constructor() {
			super();
			this.options = {
				title: this.getAttribute('title') || '默认标题'
			};
			this.innerHTML = this.template;
		}
		get template() {
			return `<div class="joe_detail__article-mtitle"><span class="text">${this.options.title}</span></div>`;
		}
	}
	window.customElements.define('joe-mtitle', JoeMtitle);
});
