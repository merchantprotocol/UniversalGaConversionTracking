<?php
/**
 * GAConversionTrack
 *
 * @category    Interactiv4
 * @package     Interactiv4_GAConversionTrack
 * @copyright   Copyright (c) 2012 Interactiv4 SL. (http://www.interactiv4.com)
 */
$this->startSetup();

try {
$this->addAttribute('order', 'i4gaconversiontrack_tracked', array('type' => 'int'));
} catch(Exception $e){}
$this->endSetup();
