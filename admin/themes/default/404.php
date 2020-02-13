<?php 
use Ultra\Assets;

// load default assets
Assets::addAssetVendor('jquery-1.11.3');
Assets::addAssetVendor('bootstrap-3.3.6');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo ULTRANAME; ?></title>
<?php
    echo get_assets_css();
    echo get_assets_js();
?>
</head>
<body>
    <div class="container text-center">
        <h1><?php echo ULTRANAME; ?></h1>
        <h3 class="alert alert-info">Ops! Page not found!</h3>
    </div>
</body>
</html>