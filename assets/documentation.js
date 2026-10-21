/** Keep native document links usable when a dialog cannot open. */
(() => {
    'use strict';
    if (window.pfcDocumentsReady) return;
    window.pfcDocumentsReady = true;
    const openers = new WeakMap();
    const native = window.HTMLDialogElement && HTMLDialogElement.prototype;
    const close = dialog => {
        if (!native || !native.close) return;
        try { native.close.call(dialog); } catch (error) { return; }
    };
    document.addEventListener('click', event => {
        const trigger = event.target.closest && event.target.closest('[data-pfc-document]');
        if (trigger) {
            const dialog = document.getElementById('pfc-document-' + trigger.dataset.pfcDocument);
            if (!dialog || !native || typeof native.showModal !== 'function') return;
            if (dialog.open) { event.preventDefault(); return; }
            dialog.hidden = false;
            try { native.showModal.call(dialog); } catch (error) { dialog.hidden = true; return; }
            if (!dialog.open) { dialog.hidden = true; return; }
            event.preventDefault();
            openers.set(dialog, trigger);
            const content = dialog.querySelector('.pfc-document-content');
            if (content) content.scrollTop = 0;
            return;
        }
        const button = event.target.closest && event.target.closest('[data-pfc-close]');
        if (button) {
            const dialog = button.closest('.pfc-document-dialog');
            if (dialog && dialog.open) { close(dialog); if (!dialog.open) event.preventDefault(); }
        }
        const dialog = event.target;
        if (dialog.matches && dialog.matches('.pfc-document-dialog[open]')) {
            const rect = dialog.getBoundingClientRect();
            if (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom) close(dialog);
        }
    }, true);
    document.querySelectorAll('.pfc-document-dialog').forEach(dialog => {
        dialog.addEventListener('close', () => {
            dialog.hidden = true;
            const opener = openers.get(dialog);
            if (opener && opener.isConnected) opener.focus();
        });
    });
})();
