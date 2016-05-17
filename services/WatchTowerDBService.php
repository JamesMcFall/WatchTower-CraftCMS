<?php
/**
 * WatchTowerDB plugin for Craft CMS
 *
 * WatchTowerDB Service
 *
 * @author    James McFall
 * @copyright Copyright (c) 2016 James McFall
 * @link      http://mcfall.geek.nz
 * @package   WatchTowerDB
 * @since     0.1
 */

namespace Craft;

class WatchTowerDBService extends BaseApplicationComponent
{

    public function log($streamName, $message, $debugInfo = null, $notify = false) {

        # Get the stream record (WatchTowerDB_StreamRecord).
        $stream = $this->_createStreamIfNotExists($streamName);

        # Create the log entry
        $log = $this->_createLog($stream, $message, $debugInfo);

        # If webmaster notification is requested, send the email and update the log row
        if ($notify) {
            $this->_sendNotificationEmail($log, $stream);
        }

    }



    /**
     * Create a log entry in the supplied stream.
     * 
     * @param <WatchTowerDB_StreamRecord> $stream
     * @param <string> $message (i.e. a specific message)
     * @param <string> $debugInfo (i.e. dumping out an object)
     * @return <WatchTowerDB_LogRecord>
     */
    private function _createLog(WatchTowerDB_StreamRecord $stream, $message, $debugInfo = '') {

        # Create a new log record
        $logRecord = new WatchTowerDB_LogRecord();
        $logRecord->streamId = $stream->id;
        $logRecord->message = $message;

        # If some debug info has been supplied (object/array) dump it onto the output buffer and save as a string.
        if (!is_null($debugInfo)) {
            $logRecord->debugInfo = $this->_dump($debugInfo);
        }
        
        $logRecord->save();

        return $logRecord;
    }

    /**
     * Try to find an existing stream by name. If one doesn't exist, create it.
     *
     * @param <string> $stream
     * @return <Craft\WatchTowerDB_StreamRecord> $streamRecord
     */
    private function _createStreamIfNotExists($streamName) {

        # Can we find an existing stream?
        $streamRecord = new WatchTowerDB_StreamRecord();
        $record = $streamRecord->findByAttributes(["name" => $streamName]);

        # If we didn't find the record, create a new one.
        if (!$record) {
            $streamRecord->name = $streamName;
            $streamRecord->save();  
            $record = $streamRecord;
        }
        
        return $record;
    }

    

    /**
     * Send Notification Email
     * 
     * This method builds a very basic html email to send to the webmaster
     * 
     * @param <WatchTowerDB_LogRecord> $log
     * @param <WatchTowerDB_StreamRecord> $stream
     * @return <boolean> 
     */
    private function _sendNotificationEmail($log, $stream) {

        $webmasterEmails = explode(",", $this->getWebmasterEmail());

        # Build the basic HTML message for the email
        $htmlMessage = "<h3>WatchTower Alert: " . $_SERVER['HTTP_HOST'] . "</h3>";
        $htmlMessage .= "<b>Time:</b> " . $log->dateCreated->format("Y-m-d H:i:s") . "<br /><br />"; # @todo Add settings for date/time format?
        $htmlMessage .= "<b>Message:</b> " . $log->message . "<br /><br />";

        if ($log->debugInfo) {
            $htmlMessage .= "<b>Extra Debugging Info:</b> " . $log->debugInfo . "<br /><br />";
        }
        

        # Send an email to the webmaster
        # @todo make the from address and email details come from settings
        $emailModel = new EmailModel();
        $emailModel->fromEmail = 'no_reply@' . $_SERVER["HTTP_HOST"];
        $emailModel->fromName  = 'WatchTower Craft Logger';
        $emailModel->subject   = "WatchTower Alert: " . $_SERVER["HTTP_HOST"];
        $emailModel->body      = $htmlMessage;
        
        # Craft doesn't support sending to multiple emails... weird.
        foreach ($webmasterEmails as $email) {
            $email = trim($email);

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailModel->toEmail = $email;
                craft()->email->sendEmail($emailModel);        
            }
            
        }

        # Update the log record now that the webmaster has been notified.
        $log->notifiedWebmaster = implode(", ", $webmasterEmails);
        $log->save();

    }


    /**
     * Dump a variable into the output buffer and catch it as a string.
     * 
     * @param <any> $var
     * @return <string> 
     */
    private function _dump($var) {
        ob_start();
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
        return ob_get_clean();
    }

    /**
     * Get webmaster email from settings
     *
     * @return <string> Email address
     */
    private function getWebmasterEmail() {

        $plugin = craft()->plugins->getPlugin('WatchTowerDB');
        $settings = $plugin->getSettings();

        return $settings->webmasterEmail;
    }

}