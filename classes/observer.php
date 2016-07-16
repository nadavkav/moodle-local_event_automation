<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Event observers.
 *
 * @package    local_event_automation
 * @copyright  2016 onwards - Weizmann institute
 * @author     Nadav Kavalerchik <nadavkav@weizmann.ac.il>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_event_automation;
defined('MOODLE_INTERNAL') || die();

class observer {

    public static function record_updated(\mod_data\event\record_updated $event) {

        global $DB;
        $admin_user = get_admin();
        $to_testuser = $DB->get_record('user', array('id' => 7)); 
        $to_user_noga = \core_user::get_user(12345, '*', MUST_EXIST); 
        $to_user_liron = \core_user::get_user(123456, '*', MUST_EXIST); 
        $to_user_orel = \core_user::get_user(12345567, '*', MUST_EXIST); 
        $to_user_shuli = \core_user::get_user(123, '*', MUST_EXIST); 
        $to_user_moodle = \core_user::get_user(321, '*', MUST_EXIST); 

        if ($event->contextinstanceid == 19170) { 
            $data_field_id = 409; 
            $sql = "SELECT dc.content
                FROM mdl_data_content AS dc
                JOIN mdl_data_fields AS df ON df.id = dc.fieldid
                JOIN mdl_data AS d ON d.id = df.dataid
                WHERE d.id = ? AND dc.recordid = ? and df.id = " . $data_field_id;
            $workflow_status = $DB->get_record_sql($sql, array($event->other['dataid'], $event->objectid));

            $subject = 'טופס בקשת קורס - סטטוס השתנה = ' . $workflow_status->content;
            $message = '';

            switch ($workflow_status->content) {
                case 'נוצרה בקשה לפתיחת השתלמות':
                    $to_user = $to_user_noga;
                    $message = "שלום {$to_user->firstname}<br>";
                    $message .= "עודכן טופס בקשה ליצירה של קורס חדש.";
                    $message .= "סטטוס הטופס הנוכחי הוא: " . $workflow_status->content;
                    $message .= "יש לבצע בו עדכון XXX";
                    $message .= "יש להקליק על הקישור הבא, לצפיה בטופס הרישום";
                    $message .= "<a href='http://pegasus1.weizmann.ac.il/moodle2/mod/data/view.php?d=" .
                        $event->other['dataid'] . "&mode=single'>טופס הרישום</a>";
                    break;
                case 'עודכן קוד השתלמות':
                    $to_user = $to_user_noga;
                    $message = "שלום {$to_user->firstname}<br>";
                    $message .= "עודכן טופס בקשה ליצירה של קורס חדש.";
                    $message .= "סטטוס הטופס הנוכחי הוא: " . $workflow_status->content;
                    $message .= "יש לבצע בו עדכון XXX";
                    $message .= "יש להקליק על הקישור הבא, לצפיה בטופס הרישום";
                    $message .= "<a href='http://pegasus1.weizmann.ac.il/moodle2/mod/data/view.php?d=" .
                        $event->other['dataid'] . "&mode=single'>טופס הרישום</a>";
                    break;
                case 'עודכן קוד הקורס':
                    $to_user = $to_user_liron;
                    $message = "שלום {$to_user->firstname}<br>";
                    $message .= "עודכן טופס בקשה ליצירה של קורס חדש.";
                    $message .= "סטטוס הטופס הנוכחי הוא: " . $workflow_status->content;
                    $message .= "יש לבצע בו עדכון XXX";
                    $message .= "יש להקליק על הקישור הבא, לצפיה בטופס הרישום";
                    $message .= "<a href='http://pegasus1.weizmann.ac.il/moodle2/mod/data/view.php?d=" .
                        $event->other['dataid'] . "&mode=single'>טופס הרישום</a>";
                    break;
                case 'נפתח קורס במוודל':
                    $to_user = $to_user_orel;
                    $message = "שלום {$to_user->firstname}<br>";
                    $message .= "עודכן טופס בקשה ליצירה של קורס חדש.";
                    $message .= "סטטוס הטופס הנוכחי הוא: " . $workflow_status->content;
                    $message .= "יש לבצע בו עדכון XXX";
                    $message .= "יש להקליק על הקישור הבא, לצפיה בטופס הרישום";
                    $message .= "<a href='http://pegasus1.weizmann.ac.il/moodle2/mod/data/view.php?d=" .
                        $event->other['dataid'] . "&mode=single'>טופס הרישום</a>";
                    break;
                case 'עודכן קישור לטופס':
                    $to_user = $to_user_moodle;
                    $message = "שלום {$to_user->firstname}<br>";
                    $message .= "עודכן טופס בקשה ליצירה של קורס חדש.";
                    $message .= "סטטוס הטופס הנוכחי הוא: " . $workflow_status->content;
                    $message .= "יש לבצע בו עדכון XXX";
                    $message .= "יש להקליק על הקישור הבא, לצפיה בטופס הרישום";
                    $message .= "<a href='http://pegasus1.weizmann.ac.il/moodle2/mod/data/view.php?d=" .
                        $event->other['dataid'] . "&mode=single'>טופס הרישום</a>";
                    break;
            }
            //$message = $workflow_status->content;
            //$to_user = $to_user_hanna;
            //$success = email_to_user($admin_user, $to_user, $subject, $message, $message);

            //print_object($success);die;
            //return "The user with id '$this->userid' updated the data record with id '$this->objectid' in the data activity " .
            // "with course module id '$this->contextinstanceid'.";

            // 'view.php?d=' . $this->other['dataid'] . '&amp;rid=' . $this->objectid,
        }
    }

}