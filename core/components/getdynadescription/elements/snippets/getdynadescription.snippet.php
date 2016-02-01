<?php
/**
 * getdynadescription
 * 
 *
 * getdynadescription is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * getdynadescription is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * getdynadescription; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package getdynadescription
 * @author Unknown; Revolution Author Bob Ray <http://bobsguides.com>
 *
 * @version Version 1.0.0-rc-1
 * 6/9/11
 *
 * Description
 *

/**
  @version Version 1.0.0-rc-1

 /** getDynaDecription properties
 * &package getdynadescription
 *
 *  Required Properties:
 *    none
 *
 *  Optional properties:
 *    @property &resourceId - (int) ID of another resource to get description from; default ''.
 *    @property &descriptionTv - (string) TV to hold a description for each page.
 *    @property &maxWordCount - (int) Maximum number of words to user when grabbing the content field; default value: 25.
 *    @property &fullTag - (int 1/0/) - Set to 1 to create a full meta tag; default: 0
 *    @property &useResourceDescription - (int 1/0/) - Set to 1 to use the resource's description field; default: 0
 */


/* getdynadescription snippet code */

/* Can't see why anyone would want this, but it's in the original snippet - BR */
if ( empty($scriptProperties['resourceId'])) {
    $resource = $modx->getObject('modResource', $scriptProperties['resourceId']);
    if (! $resource) {
        return '';
    }
} else {
    $resource =& $modx->resource;
}

$pid = $resource->get('id');

$mwc = $scriptProperties['maxWordCount'];
$maxWordCount = (!empty($mwc) && is_numeric($mwc)) ? $mwc : 25;

/**
 * Function: getdynadescription()
 * Returns:  A string of text ready to be placed in a meta description tag
 */
if (!function_exists(getDynaDescription)) {
  function getDynaDescription($text='',$excerpt_length=25)
  {
    global $modx;

    /* remove line breaks */
    $text = str_replace("\n",' ',$text);
    $text = str_replace("\r",' ',$text);
    
    /* remove special MODx tags - chunks, snippets, etc.
     * If we don't do this they'll end up expanded in the description.
     */
    $text = preg_replace("/\\[\\[([^\\[\\]]++|(?R))*?\\]\\]/s", '', $text);
    
    /* remove remaining html tags, javascript tags and numeric entities */
    $text = $modx->stripTags($text);

    /* entify special chars (especially quotes, since the description tag attributes are in quotes */
    $text = htmlspecialchars($text, ENT_QUOTES, $modx->getOption('modx_charset', null, 'UTF-8'));
    
    $words = preg_split ("/\s+/", $text,$excerpt_length+1);
    if (count($words) > $excerpt_length) {
      array_pop($words);
      array_push($words, '...');
      $text = implode(' ', $words);
    }
    return trim($text);
  }
}

$output = '';

if ($scriptProperties['useResourceDescription']) {
    /* If &useRessourceDescription is set, use that */
    $output = $modx->resource->get('description');


} else if (!empty($descriptionTv)) {
  /* Try the TV */
    if (!empty ($scriptProperties['descriptionTv'])) {

        $tv = $modx->getObject('modTemplateVar',array('name'=>$scriptProperties['descriptionTv']));
        $output = $tv? $tv->getValue($pid) : '';
    }
}

if (empty($output)) {
  /* still empty, use the content field */

    $content = $modx->resource->get('content');
    $output =  getDynaDescription($content,$maxWordCount);
}

/* Create the full tag if &fullTag is set */
if ($fullTag == true) {
       $output = '<meta name="description" content="' . $output . '">' . "\n";
}

return $output;
