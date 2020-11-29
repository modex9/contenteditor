$(document).on('ready', () => {

    //Mass check/uncheck of table columns.
    $("[id^='main-table-check-']").on('click', () => {
        const target = event.target;
        const targetID = target.id;
        const index = targetID.split('-').pop();
        if(!isNaN(index))
        {
            if(event.target.checked)
            {
                $(`#table-fields-${index} input[type='checkbox']`).each( (i, el) => {
                        $(el).attr('checked', '');
                    }
                );
            }
            else
            {
                $(`#table-fields-${index} input[type='checkbox']`).each( (i, el) => {
                        $(el).removeAttr('checked');
                    }
                );
            }
        }
    });
});