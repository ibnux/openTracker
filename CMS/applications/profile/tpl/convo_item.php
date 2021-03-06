<?php

/**
 * Copyright 2012, openTracker. (http://opentracker.nu)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @link          http://opentracker.nu openTracker Project
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author Wuild
 * @package openTracker
 */

if(!defined("INCLUDED"))
    die("Access denied");

$db = new DB("messages");
$db->setSort("message_added DESC");
$db->setColPrefix("message_");
$db->select("message_id = '" . $this->item . "'");
$db->nextRecord();

$user = new Acl($db->sender);
?>
<div class="item">
    <div class="avatar">
        <?php echo "<img src='" . $user->avatar() . "' style='max-width:70px'>"; ?>
    </div>
    <div class="sender">
        <b><a href="<?php echo page("profile", "view", strtolower($user->name)) ?>"><?php echo ($db->sender != 0) ? $user->name : "System" ?></a></b> <br />
        <?php echo htmlformat($db->content, true); ?>
    </div>
    <div class="date">
        <?php echo get_date($db->added) ?>
    </div>
</div>
