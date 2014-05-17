<?php if (!defined("BASEPATH")) exit('No direct script access allowed.');

define("LOCK_CHANNEL_ENTRY_NAME", "Lock Channel Entry");
define("LOCK_CHANNEL_ENTRY_VERSION", "0.1");
define("LOCK_CHANNEL_ENTRY_DESCRIPTION", "Lock entry if the entry or template is currently being edited by another user.");
define("LOCK_CHANNEL_ENTRY_SETTINGS_EXIST", "n");
define("LOCK_CHANNEL_ENTRY_DOCS_URL", "");
define("LOCK_CHANNEL_ENTRY_SALT", "245kj3h45kl32&$*&^*#^%QQ&^%W323#@^42l46;3lj");

class lock_channel_entry_settings
{
    static function _generate_ping_hash($object_id, $session_id)
    {
        return md5(sprintf("object_id=%d&session_id=%s&salt=%s", $object_id, $session_id, LOCK_ENTRY_SALT));
    }
}
