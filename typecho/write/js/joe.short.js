document.addEventListener('DOMContentLoaded', () => {
	/* 网易云音乐 - 歌单 */
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
			return `
            <style>iframe {display: block;margin: 0 auto;border: none;}</style>
            <iframe src="//music.163.com/outchain/player?type=0&id=${this.options.id}&auto=${this.options.autoplay}&height=430" width="${this.options.width}" height="450px"></iframe>
        `;
		}
		render() {
			this.innerHTML = '';
			this._shadowRoot = this.attachShadow({ mode: 'closed' });
			if (this.options.id) this._shadowRoot.innerHTML = this.template;
			else this._shadowRoot.innerHTML = '网易云歌单ID未填写！';
		}
	}
	window.customElements.define('joe-mlist', JoeMlist);
});
