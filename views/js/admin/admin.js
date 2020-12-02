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

    $('#content-query-form').on('submit', () => {
        event.preventDefault();
        const data = $('#content-query-form').serialize();
       fetch(query_controller,
           {
               method : 'POST',
               headers: {
                   'Accept': 'application/json',
                   'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
               },
               body : data,
           }).then(data => data.json())
             .then(data => $('#query-content').html('data'));
        });
});