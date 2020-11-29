<div class="container text-center">
    <form action="">
        <div class="row">
            {foreach $tables as $table}
                {assign var='table_name' value=$table.$table_name_id}
                {counter assign='id'}
                <div class="col-lg-6 border border-success p-3">
                    <input id="main-table-check-{$id}" type="checkbox">
                    <a class="d-inline" data-toggle="collapse" href="#table-fields-{$id}" role="button">{$table_name}</a>
                    <div id="table-fields-{$id}" class="collapse container col-lg-12">
                        <div class="row">
                            {foreach $table_descriptions.$table_name as $field => $type}
                                <div class="col-lg-6"><input class="float-left" type="checkbox">{$field}</div>
                                <div class="col-lg-6">{$type}</div>
                            {/foreach}
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>
    </form>
</div>