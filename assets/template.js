/* Insert only into the current empty draft; preserve all unsaved content. */
(function () {
    'use strict';
    document.addEventListener('click', function (event) {
        if (event.target.id !== 'pfc-insert-template' || !window.pfcTemplate) return;
        const config = window.pfcTemplate;
        const status = document.getElementById('pfc-template-status');
        let inserted = false;
        if (config.block && window.wp && wp.data && wp.blocks) {
            const editor = wp.data.select('core/editor');
            if (editor && !editor.getEditedPostContent().trim()) {
                wp.data.dispatch('core/block-editor').insertBlocks(wp.blocks.parse(config.content));
                inserted = true;
            }
        } else {
            const field = document.getElementById('content');
            const visual = window.tinymce && tinymce.get('content');
            const current = visual && !visual.isHidden() ? visual.getContent() : field && field.value;
            if (typeof current === 'string' && !current.trim()) {
                if (visual && !visual.isHidden()) { visual.setContent(config.content); visual.save(); }
                else { field.value = config.content; field.dispatchEvent(new Event('input', {bubbles: true})); field.dispatchEvent(new Event('change', {bubbles: true})); }
                inserted = true;
            }
        }
        if (status) status.textContent = inserted ? config.success : config.occupied;
    });
}());
