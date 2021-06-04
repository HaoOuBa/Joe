import { HighlightStyle, tags } from '@codemirror/highlight';

export default () => {
	return HighlightStyle.define([
		/* -----------------以下为代码高亮部分-------------------- */
		/* 应该是括号类的样式 */
		{
			tag: tags.punctuation,
			color: '#808080'
		},
		/* 应该是标签名的样式 */
		{
			tag: tags.name,
			color: '#d19a66'
		},
		/* 应该是属性名的样式 */
		{
			tag: tags.propertyName,
			color: '#96c0d8'
		},
		/* 应该是属性值的样式 */
		{
			tag: tags.string,
			color: '#98c379'
		},
		/* 应该是关键词的样式 */
		{
			tag: tags.keyword,
			color: '#c678dd'
		},
		/* 应该是特殊符号的样式 */
		{
			tag: tags.operator,
			color: '#96c0d8'
		},
		/* 应该是变量名的样式 */
		{
			tag: tags.variableName,
			color: '#e06c75'
		},
		/* 应该是数字的样式 */
		{
			tag: tags.number,
			color: '#d19a66'
		},
		/* 注释的样式 */
		{
			tag: tags.comment,
			color: '#5C6370'
		},
		/* 未知 */
		{
			tag: tags.processingInstruction,
			color: '#abb2bf'
		},
		/* 未知 */
		{
			tag: tags.labelName,
			color: '#abb2bf'
		},
		/* 未知 */
		{
			tag: tags.definition(tags.propertyName),
			color: '#e06c75'
		},
		/* 未知 */
		{
			tag: tags.definition(tags.variableName),
			color: '#e5c07b'
		},
		/* 未知 */
		{
			tag: tags.local(tags.variableName),
			color: '#d19a66'
		},
		/* 未知 */
		{
			tag: tags.atom,
			color: '#d19a66'
		},
		/* 未知 */
		{
			tag: tags.meta,
			color: '#abb2bf'
		},

		/* -----------------以下为Markdown高亮部分-------------------- */

		/* 加粗 **Text** */
		{
			tag: tags.strong,
			color: '#61afef',
			fontWeight: '500'
		},
		/* 倾斜文字 *Text* */
		{
			tag: tags.emphasis,
			color: '#b294bb',
			fontStyle: 'italic',
			fontFamily: 'Helvetica Neue, Helvetica, PingFang SC, Hiragino Sans GB, Microsoft YaHei, 微软雅黑, Arial, sans-serif'
		},
		/* 删除线 ~~Text~~ */
		{
			tag: tags.strikethrough,
			color: '#ed6a43',
			textDecoration: 'line-through'
		},
		/* 链接 [Test] */
		{
			tag: tags.link,
			color: '#e26666'
		},
		/* 地址 (http://) */
		{
			tag: tags.url,
			color: '#5fa76f'
		},
		/* 标题样式 # */
		{
			tag: tags.heading1,
			color: '#e06c75',
			fontSize: '18px',
			fontWeight: '700'
		},
		{
			tag: tags.heading2,
			color: '#e06c75',
			fontSize: '18px',
			fontWeight: '700'
		},
		{
			tag: tags.heading3,
			color: '#e06c75',
			fontSize: '18px',
			fontWeight: '700'
		},
		{
			tag: tags.heading4,
			color: '#e06c75',
			fontSize: '18px',
			fontWeight: '700'
		},
		{
			tag: tags.heading5,
			color: '#e06c75',
			fontSize: '18px',
			fontWeight: '700'
		},
		{
			tag: tags.heading6,
			color: '#e06c75',
			fontSize: '18px',
			fontWeight: '700'
		},
	]);
};
