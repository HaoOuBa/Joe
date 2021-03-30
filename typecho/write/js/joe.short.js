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
			return `<object style="display: block;margin: 0 auto;" width="${this.options.width}" height="450px" data="//music.163.com/outchain/player?type=0&id=${this.options.id}&auto=${this.options.autoplay}&height=430"></object>`;
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
			return `<object style="display: block;margin: 0 auto;" width="${this.options.width}" height="86px" data="//music.163.com/outchain/player?type=2&id=${this.options.id}&auto=${this.options.autoplay}&height=66"></object>`;
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
			return `<object style="display: block;margin: 0 auto;" width="100%" height="180px" data="//player.bilibili.com/player.html?bvid=${this.options.bvid}"></object>`;
		}
		render() {
			if (this.options.bvid) this.innerHTML = this.template;
			else this.innerHTML = 'Bvid未填写！';
		}
	}
	window.customElements.define('joe-bilibili', JoeBilibili);
});
