<nav aria-label="...">
<?php 
    $prev_disabled = ''; 
    $next_disabled = ''; 
    $prev_url = admin_url('/'.$module.'/index/page/'.($page-1));
    $next_url = admin_url('/'.$module.'/index/page/'.($page+1));
    if ($page == 1){
        $prev_disabled = 'disabled'; 
        $prev_url = '#';
    }
    if ($page >= ($total_items/$items_per_page)){
        $next_disabled = 'disabled'; 
        $next_url = '#';
    }
?>
    <ul class="pager">
        <li class="previous <?php echo $prev_disabled; ?>"><a href="<?php echo $prev_url; ?>"><span aria-hidden="true">&larr;</span> <?php t('Previous') ?></a></li>
        <li class="next <?php echo $next_disabled; ?>"><a href="<?php echo $next_url; ?>"><?php t('Next') ?> <span aria-hidden="true">&rarr;</span></a></li>
    </ul>
</nav>