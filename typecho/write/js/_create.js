const parser = new HyperDown();
export default function createPreviewHtml(str) {
	str = parser.makeHtml(str);

    str = str.replace(/{x}/g, '<input type="checkbox" class="task" checked disabled></input>')
    str = str.replace(/{ }/g, '<input type="checkbox" class="task" disabled></input>')

	$('.cm-preview-content').html(str);
	$('.cm-preview-content pre code').each((i, el) => Prism.highlightElement(el));
}
