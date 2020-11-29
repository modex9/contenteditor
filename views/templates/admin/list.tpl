<div class="container text-center">
    <form action="">
        <div class="row">
            {foreach $tables as $table}
                <div class="col-lg-6 border border-success p-3">
                    <input type="checkbox">
                    <p class="d-inline" >{$table.$table_name_id}</p>
                </div>
            {/foreach}
        </div>
    </form>
</div>