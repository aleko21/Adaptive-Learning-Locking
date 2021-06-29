/**
 * JavaScript for form editing language conditions.
 *
 * @module moodle-availability_ad-form
 */
M.availability_ad = M.availability_ad || {};

/**
 * @class M.availability_ad.form
 * @extends M.core_availability.plugin
 */
M.availability_ad.form = Y.Object(M.core_availability.plugin);

/**
 * Languages available for selection.
 *
 * @property languages
 * @type Array
 */
M.availability_ad.form.languages = null;

/**
 * Initialises this plugin.
 *
 * @method initInner
 * @param {Array} languages Array of objects containing languageid => name
 */
M.availability_ad.form.initInner = function(languages) {
    this.languages = languages;
};

M.availability_ad.form.getNode = function(json) {
    // Create HTML structure.
   var strings = M.str.availability_ad;
	
	var html = '<label>' + strings.title + ' <span class="availability-ad">' +
            '<select name="id">' + 
			'<option value="choose">' + M.str.moodle.choosedots + '</option>' + 
			'<option value="adaptive">' + 'Adaptive Restriction' + '</option>' + 
			'</select></span></label>';
    var node = Y.Node.create('<span>' + html + '</span>');

    // Set initial values (leave default 'choose' if creating afresh).
    if (json.creating === undefined) {
        if (json.id !== undefined && node.one('select[name=id] > option[value=' + json.id + ']')) {
            node.one('select[name=id]').set('value', json.id);
        } else if (json.id === undefined) {
            node.one('select[name=id]').set('value', 'choose');
        }
    }

    // Add event handlers (first time only).
    if (!M.availability_ad.form.addedEvents) {
        M.availability_ad.form.addedEvents = true;
        var root = Y.one('#fitem_id_availabilityconditionsjson');
        root.delegate('change', function() {
            // Just update the form fields.
            M.core_availability.form.update();
        }, '.availability_ad select');
    }
	
    return node;
};

M.availability_ad.form.fillValue = function(value, node) {
    var selected = node.one('select[name=id]').get('value');
    if (selected === 'choose') {
        value.id = '';
    } else {
        value.id = selected;
    }
};

M.availability_ad.form.fillErrors = function(errors, node) {
    var value = {};
    this.fillValue(value, node);

    // Check language item id.
    if (value.id === '') {
        errors.push('availability_ad:missing');
    }

};
