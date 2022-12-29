<?php

/**
 * getdynadescription resolver script - runs on install.
 *
 * Copyright 2011-2020 Bob Ray <https://bobsguides.com>
 * @author Bob Ray <https://bobsguides.com>
 * Created 6/9/11
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
 * getdynadescription; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package mycomponent
 */
/**
 * Description: Resolver script for getdynadescription package
 * @package mycomponent
 * @subpackage build
 */

/* Example Resolver script */

/* The $modx object is not available here. In its place we
 * use $object->xpdo
 */

$modx =& $object->xpdo;
$prefix = $modx->getVersionData()['version'] >= 3
    ? 'MODX\Revolution\\'
    : '';

/* set to true to connect property sets to elements */

$success = true;

$modx->log(xPDO::LOG_LEVEL_INFO,'Running PHP Resolver.');
switch($options[xPDOTransport::PACKAGE_ACTION]) {
    /* This code will execute during an install */
    case xPDOTransport::ACTION_INSTALL:
        if ($modx->getOption('createTv', $options, false)) {
            $category = $modx->getObject($prefix . 'modCategory', array('category'=>'getDynaDescription'));
            if (! $category) {
                $modx->log(xPDO::LOG_LEVEL_INFO,'Could not retrieve category object: ' . $category);
            }
            $templateVariables[1]= $modx->newObject($prefix . 'modTemplateVar');
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
                'default_text' => $modx->getOption('tvDefault', $options, ''),
                'properties' => array(),
            ),'',true,true);

            $category->addMany($templateVariables);
            $category->save();

            $templateNames = $modx->getOption('templates', $options, false);
            if (!empty ($templateNames) ) {
                $modx->log(xPDO::LOG_LEVEL_INFO,'Attempting to attach TV to Templates');
                $ok = true;
                $tv = $modx->getObject($prefix . 'modTemplateVar', array('name'=> 'dynaDescription'));
                if ($tv) {
                    $tvId = $tv->get('id');
                } else {
                    $ok = false;
                    $modx->log(xPDO::LOG_LEVEL_INFO,'Could not retrieve TV object: dynaDescription');
                }
                /* add tag to templates here */


                /* Add TV to selected Templates */
                if ($tv) {
                    foreach($templateNames as $templateName) {
                        $template = $modx->getObject($prefix . 'modTemplate', array('templatename'=>$templateName));
                        if ($template) {
                            $templateId = $template->get('id');
                            $tvt = $modx->newObject($prefix . 'modTemplateVarTemplate');

                            $r1 = $tvt->set('templateid', $templateId);
                                $r2 = $tvt->set('tmplvarid', $tvId);
                                if ($r1 && $r2) {
                                    $tvt->save();
                                    $modx->log(xPDO::LOG_LEVEL_INFO,'Attached TV to Template: ' . $templateName);
                                } else {
                                    $ok = false;
                                    $modx->log(xPDO::LOG_LEVEL_INFO,'Could not set TemplateVarTemplate fields');
                                }
                        } else {
                            $ok = false;
                            $modx->log(xPDO::LOG_LEVEL_INFO,'Could not retrieve Template object: ' . $templateName);
                        }
                    }
                }

            }
            if ($ok) {
                $modx->log(xPDO::LOG_LEVEL_INFO,'Connected TV to selected Templates');
            }



        }

        /* See if the user wants tags inserted */
        $tagType = $modx->getOption('doTag', $options, false);
        if ($tagType && $tagType != 'no') {
            $fullTag = $modx->getOption('fullTag', $options, false)? ' &fullTag=`1`' : '';
            $maxWords = $modx->getOption('maxWords', $options, 25);
            $maxWords = $maxWords!= 25 ? ' &maxWords=`'. $maxWords . '`' : '';

            $begin = '[[!getDynaDescription';
            $end = ']]';
            switch ($tagType) {
                case 'useTV':
                    $tag = $begin . '? ' . '&descriptionTv=`dynaDescription`' . $maxWords . $fullTag . $end;
                    break;
                case 'useDescription':
                    $tag = $begin . '? ' . '&useResourceDescription=`1`' . $maxWords . $fullTag . $end;
                    break;
                case 'noProperties':
                    $tag = $begin . '? ' . '&descriptionTv=``' . $maxWords . $fullTag . $end;
                    break;
                default:
                    $tag = $begin . '? ' . '&useResourceDescription=`1`' . $maxWords . $fullTag . $end;
                    break;
            }
            /* have to get these again in case the user did not install the TV */
            $templateNames = $modx->getOption('templates', $options, false);
            if (!empty ($templateNames) ) {

                foreach($templateNames as $templateName) {
                        $template = $modx->getObject($prefix . 'modTemplate', array('templatename'=>$templateName));
                        if ($template) {
                            $templateContent = $template->getContent();
                            if (strstr($templateContent,'getDynaDescription')) {
                                /* tag is already there, replace it */
                                $templateContent = preg_replace("/\[\[\!getDynaDescription.*\]\]/", $tag, $templateContent);
                            } else {
                                /* insert new tag */
                                $templateContent = str_replace('<head>', '<head>' . "\n    " . $tag , $templateContent);
                            }
                            $template->setContent($templateContent);
                            $template->save();

                        }
                }

            }
        }

    /* This code will execute during an upgrade */
    case xPDOTransport::ACTION_UPGRADE:

        /* put any upgrade tasks (if any) here such as removing
           obsolete files, settings, elements, resources, etc.
        */

        $success = true;
        break;

    /* This code will execute during an uninstall */
    case xPDOTransport::ACTION_UNINSTALL:
        $success = true;
        $modx->log(xPDO::LOG_LEVEL_INFO,'Uninstalling . . .');
        $category = $modx->getObject($prefix . 'modCategory', array('category'=>'getDynaDescription'));
        if ($category) {
            if ($category->remove()) {
                $modx->log(xPDO::LOG_LEVEL_INFO,'Removed getDynaDescription category');
            }
        }

        $tv = $modx->getObject($prefix . 'modTemplateVar', array('name'=>'dynaDescription'));
        if ($tv) {
            if ($tv->remove()) {
                $modx->log(xPDO::LOG_LEVEL_INFO,'Removed dynaDescription TV');
            }
        }
        /* Delete tags from templates */
        $templates = $modx->getCollection($prefix . 'modTemplate');
        if ($templates) {
            $modx->log(xPDO::LOG_LEVEL_INFO,'Attempting to remove tags from templates');
            $count = 0;
            foreach($templates as $template) {
                $oldTemplateContent = $template->getContent();
                $newTemplateContent = preg_replace("/\n\s*\[\[\!getDynaDescription.*\]\]/","",$oldTemplateContent);
                if ($oldTemplateContent != $newTemplateContent) {
                    $count++;
                    $template->setContent($newTemplateContent);
                    $template->save();
                    //$modx->log(xPDO::LOG_LEVEL_INFO,'<br />Content: ' . htmlEntities($newTemplateContent) . "<br />");
                }

            }
            if ($count) {
                    $modx->log(xPDO::LOG_LEVEL_INFO,'Removed ' . $count . ' tags from templates');
            }
        }
        break;


}
$modx->log(xPDO::LOG_LEVEL_INFO,'Script resolver actions completed');
return $success;