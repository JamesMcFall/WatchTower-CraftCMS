<?php
/**
 * WatchTowerDB plugin for Craft CMS
 *
 * A CraftCMS logging system derived from my CodeIgniter based WatchTowerDB-CI logging system (https://github.com/JamesMcFall/WatchTowerDB-CI-Logging).
 *
 *
 * @author    James McFall
 * @copyright Copyright (c) 2016 James McFall
 * @link      http://mcfall.geek.nz
 * @package   WatchTowerDB
 * @since     0.1
 */

namespace Craft;

class WatchTowerDBPlugin extends BasePlugin
{
    /**
     * Called after the plugin class is instantiated; do any one-time initialization here such as hooks and events:
     * @return <void>
     */
    public function init()
    {
        #craft()->watchTowerDB->log("integration-error", "Failed to integrate!", true, ["test" => time()]);
    }

    /**
     * Returns the user-facing name.
     *
     * @return mixed
     */
    public function getName()
    {
         return Craft::t('WatchTowerDB');
    }

    /**
     * Plugins can have descriptions of themselves displayed on the Plugins page by adding a getDescription() method
     * on the primary plugin class:
     *
     * @return mixed
     */
    public function getDescription()
    {
        return Craft::t('A CraftCMS logging system derived from my CodeIgniter based WatchTowerDB-CI logging system (https://github.com/JamesMcFall/WatchTowerDB-CI-Logging).');
    }

    /**
     * Plugins can have links to their documentation on the Plugins page by adding a getDocumentationUrl() method on
     * the primary plugin class:
     *
     * @return string
     */
    public function getDocumentationUrl()
    {
        return 'https://github.com/https://github.com/JamesMcFall/WatchTower-CraftCMS/watchtowerdb/blob/master/README.md';
    }

    /**
     * Plugins can now take part in Craft’s update notifications, and display release notes on the Updates page, by
     * providing a JSON feed that describes new releases, and adding a getReleaseFeedUrl() method on the primary
     * plugin class.
     *
     * @return string
     */
    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/https://github.com/JamesMcFall/WatchTower-CraftCMS/watchtowerdb/master/releases.json';
    }

    /**
     * Returns the version number.
     *
     * @return string
     */
    public function getVersion()
    {
        return '0.1';
    }

    /**
     * As of Craft 2.5, Craft no longer takes the whole site down every time a plugin’s version number changes, in
     * case there are any new migrations that need to be run. Instead plugins must explicitly tell Craft that they
     * have new migrations by returning a new (higher) schema version number with a getSchemaVersion() method on
     * their primary plugin class:
     *
     * @return string
     */
    public function getSchemaVersion()
    {
        return '0.1';
    }

    /**
     * Returns the developer’s name.
     *
     * @return string
     */
    public function getDeveloper()
    {
        return 'James McFall';
    }

    /**
     * Returns the developer’s website URL.
     *
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'http://mcfall.geek.nz';
    }

    /**
     * Returns whether the plugin should get its own tab in the CP header.
     *
     * @return bool
     */
    public function hasCpSection()
    {
        return false;
    }

    /**
     * Called right before your plugin’s row gets stored in the plugins database table, and tables have been created
     * for it based on its records.
     */
    public function onBeforeInstall()
    {
    }

    /**
     * Called right after your plugin’s row has been stored in the plugins database table, and tables have been
     * created for it based on its records.
     */
    public function onAfterInstall()
    {
    }

    /**
     * Called right before your plugin’s record-based tables have been deleted, and its row in the plugins table
     * has been deleted.
     */
    public function onBeforeUninstall()
    {
    }

    /**
     * Called right after your plugin’s record-based tables have been deleted, and its row in the plugins table
     * has been deleted.
     */
    public function onAfterUninstall()
    {
    }

    /**
     * Defines the attributes that model your plugin’s available settings.
     *
     * @return array
     */
    protected function defineSettings()
    {
        return array(
            'webmasterEmail' => array(AttributeType::String, 'label' => 'Webmaster Email', 'default' => ''),
        );
    }

    /**
     * Returns the HTML that displays your plugin’s settings.
     *
     * @return mixed
     */
    public function getSettingsHtml()
    {
       return craft()->templates->render('watchtowerdb/WatchTowerDB_Settings', array(
           'settings' => $this->getSettings()
       ));
    }

    /**
     * If you need to do any processing on your settings’ post data before they’re saved to the database, you can
     * do it with the prepSettings() method:
     *
     * @param mixed $settings  The Widget's settings
     *
     * @return mixed
     */
    public function prepSettings($settings)
    {
        // Modify $settings here...

        return $settings;
    }

}