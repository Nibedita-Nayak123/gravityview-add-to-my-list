jQuery(document).ready(function($) {
    $('.gvlogic').click(function() {
        var $button = $(this);
        var rowIndex = $button.data('row-index');
        var $tr = $button.closest('tr');
        var section = $tr.find('.gv-field-16-3').text();
        var subSection = $tr.find('.gv-field-16-10').text();
        var requirementsList = $tr.find('.gv-field-16-1').text();
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'process_requirements',
                section: section,
                subSection: subSection,
                requirementsList: requirementsList
            },
            success: function(response) {
                alert('Data added to the list!');
                $button.prop('disabled', true).text('Added To The List').addClass('added-button');
//                 localStorage.setItem(rowIndex, 'true');
            }
        });
    });
    var addToListButtons = $('.gv-table-view tr td .add-to-list-button');
    addToListButtons.each(function() {
        var $button = $(this);
        var $tr = $button.closest('tr');
        var section = $tr.find('.gv-field-16-3').text();
        var subSection = $tr.find('.gv-field-16-10').text();
        var requirementsList = $tr.find('.gv-field-16-1').text();
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'update_button_text',
                section: section,
                subSection: subSection,
                requirementsList: requirementsList
            },
            success: function(response) {
				if( response.data.count >= 1 ) {
					$button.text('Added To The List');
					$button.removeClass('gvlogic');
					$button.prop('disabled', true).addClass('added-button');
				} else {
					$button.addeClass('adddata');
				}
            },
            error: function(error) {
                console.error('AJAX request failed:', error);
            }
        });
    });

});
