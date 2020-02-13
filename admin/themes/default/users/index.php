<?php 
use Stringy\StaticStringy as S;
//use function Stringy\create as s;
get_header_admin(); ?>

<a href="<?php echo admin_url($module.'/add') ?>" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-plus"></i> <?php t('Add') ?></a>

<h1 class="page-header"><?php t(@$module_name); ?></h1>

<?php admin_err_suc_msg() ?>

<?php if ($items): ?>
<table class="table table-hover table-striped table-bordered table-condensed">

    <thead>
        <tr>
        <?php foreach ($columns as $col_key => $col): ?>
            <th><?php t((string)S::humanize($col)); ?></th>
        <?php endforeach ?>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    
        <?php foreach ($items as $item_key => $item): ?>
        <tr>
            <?php foreach ($columns as $col_key => $col): ?>
            <td><?php echo $item->$col; ?></td>
            <?php endforeach ?>
            <td>
                <a href="<?php echo admin_url($module.'/password/'.$item->id); ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-lock"></i></a>
                <a href="<?php echo admin_url($module.'/show/'.$item->id); ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-eye-open"></i></a>
                <a href="<?php echo admin_url($module.'/edit/'.$item->id); ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-edit"></i></a>
                <a href="<?php echo admin_url($module.'/delete/'.$item->id); ?>" class="btn btn-default btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
            </td>
        </tr>
        <?php endforeach ?>

    </tbody>

</table>

<?php get_pager_admin($data) ?>

<?php endif ?>
<?php get_footer_admin(); ?>