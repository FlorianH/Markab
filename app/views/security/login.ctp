
<?php echo $form->create('Login', array( 'url' => '/login/'.$id )); ?>

  <?php echo $form->input('password'); ?>

  <?php echo $form->submit(_('login')); ?>

<?php echo $form->end(); ?>