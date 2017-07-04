<?php
/**
* Template variable objects for the getDynaDescriptions package
* @author Bob Ray <https://bobsguides.com>
* @copyright Bob Ray <https://bobsguides.com>
* 6/9/11
*
* @package mycomponents
* @subpackage build
*/

/* Common 'type' options:
 * textfield (text line)
 * textbox
 * richtext
 * textarea
 * textareamini
 * email
 * html
 * image
 * date
 * option (radio buttons)
 * listbox
 * listbox-multiple
 * number
 * checkbox
 * tag
 * hidden
 */

/* Example template variables */

$templateVariables = array();

$templateVariables[1]= $modx->newObject('modTemplateVar');
$templateVariables[1]->fromArray(array(
    'id' => 1,
    'type' => 'textfield',
    'name' => 'dynaDescription',
    'caption' => 'dynaDescription',
    'description' => 'Description for Meta tag',
    'display' => 'default',
    'elements' => '',  /* input option values */
    'locked' => 0,
    'rank' => 0,
    'display_params' => '',
    'default_text' => '',
    'properties' => array(),
),'',true,true);

return $templateVariables;
