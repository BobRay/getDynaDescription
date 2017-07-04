<?php

/**
 * Default properties for the getdynadescription snippet
 * @author Bob Ray <https://bobsguides.com>
 * @copyright Bob Ray <https://bobsguides.com>
 * 6/9/11
 *
 * @package getdynadescription
 * @subpackage build
 */
/* These are example properties.
 * The description fields should match
 * keys in the lexicon property file
 *
 * Change snippet1, snippet2 to the name of your snippet.
 * Change property1 to the name of the property.
 * */

$properties = array(
    array(
        'name' => 'useResourceDescription',
        'desc' => 'gdd_useresourcedescription_desc',
        'type' => 'combo-boolean',
        'options' => '',

        'value' => '0',
        'lexicon' => 'getdynadescription:properties',
    ),
    array(
        'name' => 'descriptionTv',
        'desc' => 'gdd_descriptiontv_desc',
        'type' => 'text',
        'options' => '',
        'value' => 'dynaDescription',
        'lexicon' => 'getdynadescription:properties',
    ),
    array(
        'name' => 'maxWordCount',
        'desc' => 'gdd_maxwordcount_desc',
        'type' => 'integer',
        'options' => '',
        'value' => '25',
        'lexicon' => 'getdynadescription:properties',
    ),
    array(
        'name' => 'fullTag',
        'desc' => 'gdd_fulltag_desc',
        'type' => 'combo-boolean',
        'options' => '',

        'value' => '0',
        'lexicon' => 'getdynadescription:properties',
    ),
    array(
        'name' => 'resourceId',
        'desc' => 'gdd_resourceid_desc',
        'type' => 'integer',
        'options' => '',
        'value' => '',
        'lexicon' => 'getdynadescription:properties',
    ),
 );

return $properties;