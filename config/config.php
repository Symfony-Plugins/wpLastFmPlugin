<?php
// If the plugin module is enabled in the setting we add the assets
if (in_array('wpLastFm', sfConfig::get('sf_enabled_modules', array())))
{
  $this->dispatcher->connect('context.load_factories', array('wpLastFmConfig', 'listenToContextLoadFactoriesEvent'));
}
