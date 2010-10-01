
<div id="images">
  <?php for($i=0;$i<count($pictures);$i++): ?>
    <?php $picture = $pictures[$i]; ?>
    <?php if ($picture['file_name']): ?>
      <div class="item <?php echo ($picture['selected']) ? 'selected' : ''; ?>">
        <div class="image">
          <a rel="images_group" title="<?php echo $picture['file_name']; ?>" href="<?php echo $picture['full_path']; ?>">
            <img border="0" src="<?php echo $picture['thumbnail_path']; ?>" width="<?php echo Configure::read('Image.width'); ?>" />
          </a>
        </div>
        <?php echo $picture['file_name']; ?>
        <a href="<?php echo FULL_BASE_URL . Router::url('/', false); ?>select/<?php echo $id; ?>/<?php echo $picture['file_name']; ?>" class="select_button">(h)</a>
      </div>
      <?php if ((Configure::read('Image.pics_per_row')-1) === ($i % Configure::read('Image.pics_per_row'))): ?>
        <br style="float: none; clear: both;" />
      <?php endif; ?>
    <?php endif; ?>
  <?php endfor; ?>
  <br style="float: none; clear: both;" />
</div>