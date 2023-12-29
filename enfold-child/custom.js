jQuery(document).ready(function($) {
    function checkButtonState($button) {
        var buttonId = $button.data('row-index');
        var isButtonAdded = localStorage.getItem(buttonId);
        if (isButtonAdded === 'true') {
            $button.prop('disabled', true).text('Added').addClass('added-button');
        } else {
            $button.show(); 
        }
    }
    $('.gvlogic').each(function(index) {
        $(this).data('row-index', index);
        checkButtonState($(this));
    });
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
                $button.prop('disabled', true).text('Added').addClass('added-button');
                localStorage.setItem(rowIndex, 'true');
            }
        });
    });
});
