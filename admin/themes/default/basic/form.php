<?php 
use Ultra\Request;
use Stringy\StaticStringy as S;

get_header_admin(); ?>

<h1 class="page-header"><?php t(@$module_name); ?></h1>

<form action="<?php echo admin_url(Request::getCurrentUri()) ?>" class="" method="post" enctype="multipart/form-data">

<?php  
$add_edit = 'add';
if (strpos(Request::getCurrentUri(), $module.'/edit') !== false)
    $add_edit = 'edit';

$columns_form = array();

if ($add_edit=='add')
    $columns_form = $columns_add;
else
    $columns_form = $columns_edit;
?>
    <?php foreach ($columns_form as $col => $opt): ?>

        <?php if ($opt['input_type']=='hidden'): ?>
            
            <input type="<?php echo $opt['input_type'] ?>" class="form-control" id="input_<?php echo $col ?>" name="<?php echo $col ?>" value="<?php echo $item->$col ?>">

        <?php elseif ($opt['input_type']=='textarea'): ?>

            <div class="form-group">
                <label for="input_<?php echo $col ?>"><?php t((string)S::humanize($col)) ?></label>
                <textarea class="form-control" id="input_<?php echo $col ?>" name="<?php echo $col ?>" rows="3"><?php echo $item->$col ?></textarea>
            </div>

        <?php elseif ($opt['input_type']=='file'): ?>

            <div class="form-group">
                <label for="input_<?php echo $col ?>"><?php t((string)S::humanize($col)) ?></label>
                <?php 
                    $ext_ = explode('.', $item->$col);
                    $ext = end($ext_);
                    if (in_array($ext, array('jpg', 'png', 'jpeg', '.gif'))) {
                        printf('<img src="%s" alt="" class="img-responsive" style="max-height:150px;cursor:pointer;" onclick="document.querySelector(\'#%s\').click();">', 
                            $item->$col,
                            'input_'.$col
                        );
                    }
                ?>
                <input type="<?php echo $opt['input_type'] ?>" class="form-control input_bsfile" id="input_<?php echo $col ?>" name="<?php echo $col ?>" placeholder="<?php t((string)S::humanize($col)) ?>" value="<?php echo $item->$col ?>">
            </div>

        <?php else: // default text ?>

            <div class="form-group">
                <label for="input_<?php echo $col ?>"><?php t((string)S::humanize($col)) ?></label>
                <input type="<?php echo $opt['input_type'] ?>" class="form-control" id="input_<?php echo $col ?>" name="<?php echo $col ?>" placeholder="<?php t((string)S::humanize($col)) ?>" value="<?php echo $item->$col ?>">
            </div>

        <?php endif ?>

    <?php endforeach ?>

    <div class="form-group">
        <button type="submit" class="btn btn-default"><?php t('Save') ?></button>
        <button type="reset" class="btn btn-default"><?php t('Reset') ?></button>
    </div>

</form>
<?php get_footer_admin(); ?>