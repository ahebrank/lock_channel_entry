<?php if (!defined("BASEPATH")) exit('No direct script access allowed.');
require_once(dirname(__FILE__) . "/settings.php");

/**
 * Module File for Lock Channel Entry
 *
 * This file must be in your /system/third_party/lock_channel_entry directory of your ExpressionEngine installation
 *
 * @package             Lock_channel_entry
 * @author              Denver Sessink (dsessink@gmail.com)
 * @copyright           Copyright (c) 2012 Denver Sessink
 *
 * forked from Lock-Entry (https://github.com/denvers/Lock-Entry) by Andy Hebrank, May 2014
 * 
 */
class Lock_channel_entry
{
    /**
     * @var string
     */
    public $name = LOCK_CHANNEL_ENTRY_NAME;

    /**
     * @var string
     */
    public $version = LOCK_CHANNEL_ENTRY_VERSION;

    /**
     * @var string
     */
    public $description = LOCK_CHANNEL_ENTRY_DESCRIPTION;

    /**
     * @var string
     */
    public $settings_exist = LOCK_CHANNEL_ENTRY_SETTINGS_EXIST;

    /**
     * @var string
     */
    public $docs_url = LOCK_CHANNEL_ENTRY_DOCS_URL;

    /**
     * @var CI_Controller
     */
    private $EE;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->EE =& get_instance();
    }

    /**
     * Update the last_activity
     */
    public function ping()
    {
        if (!$this->EE->input->get('hash')) {
            die('ERROR.0');
        }

        // Accept object ID
        if (!$this->EE->input->get('object_id')) {
            die('ERROR.10');
        }

        if (!$this->EE->input->get('session_id')) {
            die('ERROR.20');
        }

        // accept entry or template mode
        if ( !$this->EE->input->get('mode') == "entry" ) {
            die('ERROR.30');
        }

        // - Ping (keep alive, activity update) (AJAX)
        $mode = "entry";

        $object_id = $this->EE->input->get('object_id');
        $session_id = $this->EE->input->get('session_id');

        // validate entry_id|template_id and member_id
        if (lock_channel_entry_settings::_generate_ping_hash($object_id, $session_id) != $this->EE->input->get('hash')) {
            die('ERROR.40');
        }

        $data = array('last_activity' => date("Y-m-d H:i:s"));
        $sql = $this->EE->db->update_string(
            'lock_channel_entry_entries',
            $data,
            sprintf(
                "`%s` = %d AND `session_id` = %d",
                "entry_id",
                $object_id,
                $session_id
            )
        );
        $this->EE->db->query($sql);

        die('OK');
    }
}

/* End of file mod.lock_channel_entry.php */
