<?php
class wpLastFmConfig
{
  /**
  * After the context has been initiated, we can add the required assets
  * 
  * @param sfEvent $event
  */
  public static function listenToContextLoadFactoriesEvent(sfEvent $event)
  {
    // Add the stylesheet
    $context = $event->getSubject();
    $context->getResponse()->addStylesheet(sfConfig::get('app_wp_lastfm_web_dir').'/css/wp_lastfm.css'/*, 'first'*/);

    // Add the date helper
    sfConfig::set('sf_standard_helpers', array_unique(array_merge(sfConfig::get('sf_standard_helpers', array()), array('Date'))));
  }
}
