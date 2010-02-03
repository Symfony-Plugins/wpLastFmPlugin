<div class='lfm-recent-tracks'>
  <?php foreach($lfm_recent_tracks AS $track) : ?>
    <div class='lfm-recent-track-<?php echo $image_size?>'>
      <div class='lfm-recent-track-image-<?php echo $image_size?>'>
        <?php echo image_tag($track['image'], array('class' => 'lfm-image-' . $image_size))?>
      </div>
      <div class='lfm-recent-track-info-<?php echo $image_size?>'>
        <?php echo $track['artist'] . ' - ' . $track['name']?><br/>
        <?php echo time_ago_in_words(strtotime($track['date'] . ' + ' .  date('Z') . ' seconds')) . ' ago'?>
      </div>
    </div>
  <?php endforeach; ?>
</div>
