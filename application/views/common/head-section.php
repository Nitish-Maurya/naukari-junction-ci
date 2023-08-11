<!DOCTYPE html>
<html>
<head>
<?php
$res=$this->Common_model->select('jp_setting','2','id');
$favi_img=$res->fevi;
$favi_img1='';
if($favi_img)
{
	if(file_exists('./'.$res->fevi))
		$favi_img1=base_url().$res->fevi;
	else
		
		$favi_img1=base_url('assets/images/Logo.png');
}
else
	$favi_img1=base_url('assets/images/Logo.png');
$loder_file1=$res->main_loder;
$loder_file2='';
if($loder_file1)
{
	$loder_file2=base_url().$loder_file1;
}
else
{
	$loder_file2=base_url('assets/images/loader01.gif');
}
?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta name="description"  content="<?= $res->description; ?>"/>
	<meta name="keywords" content="<?= $res->keyword; ?>">
	<meta name="author"  content="<?= $res->author; ?>"/>
	<meta name="MobileOptimized" content="320">
	<title><?= $res->title; ?></title>
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/jquery.toast.css'); ?>">
	<link rel="icon" type="image/ico" href="<?= $favi_img1; ?>" />
	<link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
	<script src="<?= base_url('assets/js/lib/jquery-3.1.1.min.js'); ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap-datepicker.min.css'); ?>">
	<link href="<?= base_url('assets/css/style.min.css'); ?>" rel="stylesheet">
	<?php echo $res->google_analytics;
	echo $res->google_adds_s;
	?>
</head>
<body <?php if(!empty($this->email)) { echo "class='jp_login'"; } ?> onload="read_cookie();">
<div class="jp_loading_wrapper">
    <div class="jp_loading_inner">
        <img src="<?php echo  $loder_file2; ?>" alt="" />
    </div>
</div>