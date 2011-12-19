<?php
/**
 * GenerateUniqueAlias generateuniquealias plugin
 *
 * Copyright 2011 Benjamin Vauchel <contact@omycode.fr>
 *
 * @author Benjamin Vauchel <contact@omycode.fr>
 * @version Version 1.0.0-beta1
 * 12/15/11
 *
 * GenerateUniqueAlias is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * GenerateUniqueAlias is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * GenerateUniqueAlias; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package generateuniquealias
 */

/**
 * MODx GenerateUniqueAlias generateuniquealias plugin
 *
 * Description: Generate unique alias for resources (but preserves custom alias).
 * Example : "this-is-my-page-title-55" (where 55 is the resource's ID)
 * WARNING : This plugin is triggered after MODx generate his own resource's alias. So to avoid duplicate alias conflicts be sure to use this plugin from the start for all resources.
 *
 * Events: OnResourceDuplicate, OnDocFormSave
 *
 * @package generateuniquealias
 *
 */

$eventName = $modx->event->name;
switch($eventName) 
{
  case 'OnResourceDuplicate':
  
    if($newResource->get('alias'))
    {
      $alias = $newResource->get('alias');
    }
    else
    {
      $alias = $newResource->cleanAlias($newResource->get('pagetitle'));
    }
    $alias .= '-'.$newResource->get('id');
    $newResource->set('alias', $alias);
    $newResource->save();
  
  break;
  
  case 'OnDocFormSave':
    // If no custom alias, generation of unique alias from pagetitle
    if(empty($_REQUEST['alias'])) 
    {
      $alias = $resource->cleanAlias($resource->get('pagetitle')).'-'.$resource->get('id');
      $resource->set('alias', $alias);
      $resource->save();
    }
  break;
}