/** The local changelog dialog preserves the current editor draft. */
(() => {
	'use strict';
	let opener;
	document.querySelectorAll('[data-pfc-document]').forEach(button => {
		button.addEventListener('click', event => {
			const dialog = document.getElementById('pfc-document-' + button.dataset.pfcDocument);
			if (!dialog || typeof dialog.showModal !== 'function') return;
			event.preventDefault();
			opener = button;
			dialog.showModal();
			const content = dialog.querySelector('.pfc-document-content');
			if (content) content.scrollTop = 0;
		});
	});
	document.querySelectorAll('.pfc-document-dialog').forEach(dialog => {
		dialog.querySelector('[data-pfc-close]').addEventListener('click', () => dialog.close());
		dialog.addEventListener('click', event => {
			const bounds = dialog.getBoundingClientRect();
			if (event.target === dialog && (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom)) dialog.close();
		});
		dialog.addEventListener('close', () => opener?.focus());
	});
})();
