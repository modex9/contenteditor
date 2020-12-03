{foreach $query_results as $table => $rows}
    <div class="col-lg-12">
        <strong>{$table} | </strong><p>{l s='Number of matching records: '}{$rows|count}</p>
    </div>
    {if count($rows) > 0}
        <table class="table table-dark">
            <thead>
                {foreach $rows.0 as $col_name => $col_value}
                    <th>{$col_name}</th>
                {/foreach}
            </thead>
            <tbody>
                {foreach $rows as $row}
                    <tr>
                        {foreach $row as $col_name => $col_value}
                            <td>{$col_value}</td>
                        {/foreach}
                    </tr>
                {/foreach}
            </tbody>

        </table>
    {/if}
{/foreach}