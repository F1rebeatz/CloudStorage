<?php
/**
 * @var \Kernel\View\ViewInterface $view
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $view->title() ?? 'CloudStorage' ?></title>
    <link href="/assets/css/app.css" rel="stylesheet">
    <link href="/assets/css/bootstrap.css" rel="stylesheet">
</head>
<body>
<?php $view->component('header') ?>
<div class="container">
