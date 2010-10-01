<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php echo $this->Html->charset(); ?>
  <title>
    <?php echo Configure::read('Header'); ?>
  </title>
  <?php
    echo $this->Html->meta('icon');
    echo $this->Html->css('default');
    echo $this->Html->css('fancybox/jquery.fancybox-1.3.1');
    echo $scripts_for_layout;
  ?>
</head>
<body>
  <div id="container">

    <div id="header">
      <h1><?php echo Configure::read('Header'); ?></h1>
    </div>

    <div id="content">
      <?php echo $this->Session->flash(); ?>

      <?php echo $content_for_layout; ?>

    </div>
    <div id="footer">
      
      Made with 
      <a href="<?php echo Configure::read('Markab.homepage'); ?>">Markab <?php echo Configure::read('Markab.version'); ?></a>,
      by <a href="http://florianherlings.de">Florian Herlings</a>.

    </div>
  </div>

  <script type="text/javascript" src="<?php echo FULL_BASE_URL. Router::url('/', false).'js/jquery-1.4.2.min.js'; ?>" ></script>
  <script type="text/javascript" src="<?php echo FULL_BASE_URL. Router::url('/', false).'js/default.js'; ?>" ></script>
  <script type="text/javascript" src="<?php echo FULL_BASE_URL. Router::url('/', false); ?>css/fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
  <script type="text/javascript" src="<?php echo FULL_BASE_URL. Router::url('/', false); ?>css/fancybox/jquery.fancybox-1.3.1.js"></script>
  <?php if (Configure::read('Masonry') === true): ?>
    <script type="text/javascript" src="<?php echo FULL_BASE_URL. Router::url('/', false).'js/jquery.masonry.min.js'; ?>" ></script>
    <script type="text/javascript">
      $(window).load(function() {
        $('#images').masonry();
      });
    </script>
  <?php endif; ?>
</body>
</html>