<?php

class recentTracksComponent extends sfComponent
{
  public function execute($request)
  {
    $lastfm               = new wpLastFm();
    $lastfm_recent_tracks = $lastfm->get('user.getRecentTracks');
    $tracks               = $lastfm_recent_tracks->recenttracks->track;

    // If the count parameter is set for the component we use that otherwise we get all the tracks (10 by default)
    $count = $this->count ? $this->count : count($tracks);

    // If the image_size parameter is set for the component we use that otherwise we use SMALL as the default
    $image_size = $this->image_size ? $this->image_size : 'SMALL';

    for($i = 0; $i < $count; $i++) {
      $track = $tracks[$i];
      $track_arr[$i]['artist']     = (string)$track->artist;
      $track_arr[$i]['name']       = (string)$track->name;
      $track_arr[$i]['date']       = (string)$track->date;

      // Get the right image based on the image size
      switch($image_size) {
        case 'SMALL':
          $image = str_replace('/34/', '/34s/', (string)$track->image[0]);
          break;
        case 'MEDIUM':
          $image = str_replace('/64/', '/64s/', (string)$track->image[1]);
          break;
        case 'LARGE':
          $image = str_replace('/126/', '/126s/', (string)$track->image[2]);
          break;
      }
        
      // If the track doesn't have a picture we set a default picture
      if (empty($image)) {
        $image = sfConfig::get('app_wp_lastfm_web_dir') . '/images/default_artist_' . strtolower($image_size) . '.png';
      }

      $track_arr[$i]['image'] = $image;
    }
    $this->lfm_recent_tracks = $track_arr;

    // Create a lowercase string of the image size for use with our css class
    $this->image_size = strtolower($image_size);
  }
}
