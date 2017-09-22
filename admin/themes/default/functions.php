<?php
use Ultra\Assets;

// load default assets
Assets::addAssetVendor('jquery-1.11.3');
Assets::addAssetVendor('bootstrap-3.3.6');
Assets::addAssetVendor('font-awesome-4.6.3');

define('CKEDITOR_FILE_BROWSER', admin_url('/files/browser'));
define('CKEDITOR_FILE_UPLOAD', admin_url('/files/upload'));

function include_ckeditor($ckeditor_id)
{
    include(dirname(__FILE__).'/ckeditor.php');
}