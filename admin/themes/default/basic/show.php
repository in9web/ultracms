<?php 
use Ultra\Request;
use Stringy\StaticStringy as S;

get_header_admin(); ?>

<h1 class="page-header"><?php t(@$module_name); ?></h1>

<table class="table table-hover table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        if (!in_array('created_at', $columns))
            $columns[] = 'created_at';

        if (!in_array('updated_at', $columns))
            $columns[] = 'updated_at';
    ?>
    
    <?php foreach ($columns_show as $col_key => $col): ?>
        <tr>
            <td><?php t((string)S::humanize($col)) ?></td>
            <td><?php echo $item->$col ?></td>
        </tr>
    <?php endforeach; ?>

    </tbody>

</table>

<?php get_footer_admin(); ?>