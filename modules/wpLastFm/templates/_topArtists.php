<div class='lfm' style='width:<?php echo $row_width?>'>
  <?php foreach($lfm_artists AS $row) : ?>
    <div class='lfm-artist-row-<?php echo $image_size?>'>
      <?php foreach($row AS $artist) : ?>
        <div class='lfm-artist-<?php echo $image_size?>'>
          <?php echo image_tag($artist['image'], array('title'=>$artist['name'] . ', ' . $artist['playcount'] . ' times played'))?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
</div>
