<?php
/**
 * WatchTowerDB plugin for Craft CMS
 *
 * WatchTowerDB Model
 *
 * --snip--
 * Models are containers for data. Just about every time information is passed between services, controllers, and
 * templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 * --snip--
 *
 * @author    James McFall
 * @copyright Copyright (c) 2016 James McFall
 * @link      http://mcfall.geek.nz
 * @package   WatchTowerDB
 * @since     0.1
 */

namespace Craft;

class WatchTowerDBModel extends BaseModel
{
    /**
     * Defines this model's attributes.
     *
     * @return array
     */
    protected function defineAttributes()
    {
        return array_merge(parent::defineAttributes(), array(
            'someField'     => array(AttributeType::String, 'default' => 'some value'),
        ));
    }

}