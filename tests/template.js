/* Exercise manual insertion without mutating an actual project. */
const fs = require('fs');
const vm = require('vm');
const assert = require('assert');
const source = fs.readFileSync(require('path').join(__dirname, '../assets/template.js'), 'utf8');
for (const block of [true, false]) {
    for (const content of ['', 'Existing unsaved work']) {
        let click;
        let inserted = false;
        const field = {value: content, dispatchEvent() {}};
        const status = {};
        const context = {
            window: null,
            document: {addEventListener(type, callback) {click = callback;}, getElementById(id) {return id === 'content' ? field : status;}},
            Event: function () {},
            pfcTemplate: {block, content: 'TEMPLATE', success: 'ok', occupied: 'kept'},
            wp: {data: {select() {return {getEditedPostContent() {return content;}};}, dispatch() {return {insertBlocks() {inserted = true;}};}}, blocks: {parse(value) {return value;}}}
        };
        context.window = context;
        vm.runInNewContext(source, context);
        click({target: {id: 'pfc-insert-template'}});
        assert.strictEqual(status.textContent, content ? 'kept' : 'ok');
        if (block) assert.strictEqual(inserted, !content);
        else assert.strictEqual(field.value, content || 'TEMPLATE');
        console.log('PASS:', block ? 'block editor' : 'classic editor', content ? 'preserves unsaved content' : 'inserts into empty draft');
    }
}
