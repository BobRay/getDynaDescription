<?php

/**
 * Script to interact with user during getdynadescription package install
 *
 * Copyright 2011-2017 Bob Ray <https://bobsguides.com>
 * @author Bob Ray 2011-2020 <https://bobsguides.com>
 * Created 6/9/11
 *
 *  is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 *  is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package mycomponent
 */
/**
 * Description: Script to interact with user during getdynadescription package install
 * @package mycomponent
 * @subpackage build
 */
/* Use these if you would like to do different things depending on what's happening */

/* The return value from this script should be an HTML form (minus the
 * <form> tags and submit button) in a single string.
 *
 * The form will be shown to the user during install
 * after the readme.txt display.
 *
 * This example presents an HTML form to the user with one input field
 * (you can have more).
 *
 * The user's entries in the form's input field(s) will be available
 * in any php resolvers with $modx->getOption('field_name', $options, 'default_value').
 *
 * You can use the value(s) to set system settings, snippet properties,
 * chunk content, etc. One common use is to use a checkbox and ask the
 * user if they would like to install an example resource for your
 * component.
 */

$templates = $modx->getCollection('modTemplate');
$output = '<p>The getDynaDescription snippet will allow you to create description Meta tags by placing a tag in your template(s). The snippet can use the value of the dynaDescription Template variable, the description resource field, or the beginning of the resource content for the Meta tag.</p><br />';
$output .= '<p>If you would like to have the dynaDescription template variable created automatically and attached to any of your templates, check the appropriate boxes below. If you plan to use the resource description field or the resource content, you won\'t need the TV.</p><br />';

$output .= '<fieldset style="padding:15px;margin:0"><legend>&nbsp;&nbsp;Create TV&nbsp;&nbsp;</legend>';
$output .= '<input type="checkbox" name="createTv" value="CreateDescriptionTv">&nbsp;&nbsp;Create dynaDescription template variable<br /><br />';
$output .= '<input type="text" name="tvDefault" value="">&nbsp;&nbsp;Default value for TV (optional - not recommended)<br /><br />';

if (!empty ($templates) ) {
    $output .=  '<br />Select Templates to attach TV to:<br /><br />';
    foreach ($templates as $template) {
        $output .= '<input type="checkbox" name="templates[]" value="' .$template->get('templatename') .  '">&nbsp;&nbsp;' . $template->get('templatename') . '<br />';
    }
    $output .= '</fieldset>';
}  else {
    $output .= 'No Templates<br />';
}

$output .= '<br /><p>If you want a snippet tag inserted in the &lt;head&gt; section of the selected templates (be sure you have checked the templates above) select the desired option below:</p><br />';

$output .= '<fieldset style="padding:15px; margin:0"><legend>&nbsp;&nbsp;Tag Style&nbsp;&nbsp;</legend>';
$output .= '<input type="radio" name="doTag" value="no" checked="checked">&nbsp;&nbsp;No (other options will be ignored)<br />';
$output .= '<input type="radio" name="doTag" value="useTV">&nbsp;&nbsp;[[!getDynaDescription? &amp;descriptionTv=`dynaDescription`]] (use the TV)<br />';
$output .= '<input type="radio" name="doTag" value="useDescription">&nbsp;&nbsp;[[!getDynaDescription? &amp;useResourceDescription=`1`]] (use the resource Description field)<br />';
$output .= '<input type="radio" name="doTag" value="noProperties">&nbsp;&nbsp;[[!getDynaDescription? &amp;descriptionTv=``]] (use resource content)</fieldset><br />';

$output .= '<fieldset style="padding:15px;margin:0"><legend>&nbsp;&nbsp;Options&nbsp;&nbsp;</legend>';
$output .= '<input type="checkbox" name="fullTag" value="fullTag">&nbsp;&nbsp;Create Full Tag (adds &amp;fullTag=`1` to the snippet tag to create the entire Meta tag instead of just the description part)<br /><br />';
$output .= '<input type="text" name="maxWords" size="4" value="25">&nbsp;&nbsp;Max words to use from content</fieldset><br /><br />';

return $output;
