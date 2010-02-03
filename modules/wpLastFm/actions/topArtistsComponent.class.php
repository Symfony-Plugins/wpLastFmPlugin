<?php

class topArtistsComponent extends sfComponent
{
  public function execute($request)
  {
    $lastfm         = new wpLastFm();
    $lastfm_artists = $lastfm->get('user.getTopArtists');
    $artists        = $lastfm_artists->topartists->artist;

    // If the count parameter is set for the component we use that otherwise we count all the artists
    $count = $this->count ? $this->count : count($artists);
    // If the rows parameter is set for the component we use that otherwise we use the default
    $rows  = $this->rows ? $this->rows : 3;
    // If the image_size parameter is set for the component we use that otherwise we use MEDIUM as the default
    $image_size = $this->image_size ? $this->image_size : 'MEDIUM';
 
    // Calculate the number of artists per row
    $count_per_row = ceil($count / $rows);

    $x = 1;
    for($i=0; $i<$count; $i++) {
      if ($i % $count_per_row == 0) {
        $row = 'row_'.$x;
        $x++;
      }
      $artist = $artists[$i];
      $artists_arr[$row][$i]['name']      = (string)$artist->name;
      $artists_arr[$row][$i]['playcount'] = (string)$artist->playcount;

      // Get the right image based on the image size
      switch($image_size) {
        case 'SMALL':
          $image = str_replace('/34/', '/34s/', (string)$artist->image[0]);
          $image_width = 34;
          break;
        case 'MEDIUM':
          $image = str_replace('/64/', '/64s/', (string)$artist->image[1]);
          $image_width = 64;
          break;
        case 'LARGE':
          $image = str_replace('/126/', '/126s/', (string)$artist->image[2]);
          $image_width = 126;
          break;
      }

      // If the track doesn't have a picture we set a default picture
      if (empty($image)) {
        $image = sfConfig::get('app_wp_lastfm_web_dir') . '/images/default_artist_' . strtolower($image_size) . '.png';
      }

      $artists_arr[$row][$i]['image'] = $image;
    }
    $this->lfm_artists = $artists_arr;

    // Create a lowercase string of the image size for use with our css class
    $this->image_size = strtolower($image_size);
    
    // Calculate the row width
    $this->row_width = ($image_width + 2 + 2) * $count_per_row . 'px';
  }
}
