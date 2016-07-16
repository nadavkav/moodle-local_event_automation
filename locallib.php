<?php

function local_event_automation_database_observer ($event) {
    global $DB;
    $admin_user = get_admin();
    $to_testuser = \core_user::get_user(123, '*', MUST_EXIST); 
    $to_user_noga = \core_user::get_user(1234, '*', MUST_EXIST); 
    $to_user_liron = \core_user::get_user(12345, '*', MUST_EXIST); 
    $to_user_orel = \core_user::get_user(123456, '*', MUST_EXIST); 
    $to_user_shuli = \core_user::get_user(321, '*', MUST_EXIST); 
    $to_user_hanna = \core_user::get_user(332, '*', MUST_EXIST); 
    $to_user_moodle = \core_user::get_user(333, '*', MUST_EXIST); 

    if ($event->contextinstanceid == 19170) { 
        $data_field_id = 409;  
        $sql = "SELECT dc.content
                FROM mdl_data_content AS dc
                JOIN mdl_data_fields AS df ON df.id = dc.fieldid
                JOIN mdl_data AS d ON d.id = df.dataid
                WHERE d.id = ? AND dc.recordid = ? and df.id = " . $data_field_id;
        $workflow_status = $DB->get_record_sql($sql, array($event->other['dataid'], $event->objectid));

        $subject = 'טופס בקשת פתיחת השתלמות - סטטוס השתנה = ' . $workflow_status->content;
        $message = '';

        switch ($workflow_status->content) {

            case 'נוצרה בקשה לפתיחת השתלמות':
                $to_user = $to_user_noga;
                if ($workflow_status->content == '') $workflow_status->content = 'נוצרה בקשה לפתיחת השתלמות';
                $message = "<div style='direction:rtl;text-align:right;'>";
                $message .= "שלום {$to_user->firstname}<br>";
                $message .= "עודכן טופס בקשה ליצירה של קורס חדש.<br>";
                $message .= "סטטוס הטופס הנוכחי הוא:  \"" . $workflow_status->content . "\"<br>";
                $message .= "יש לרשום את ההשתלמות באתר משרד החינוך ולעדכן בטופס בקשת ההשתלמות את קוד ההשתלמות ולשנות את הסטטוס ל\"עודכן קוד ההשתלמות\" <br>";
                $message .= "יש להקליק על הקישור הבא, לצפיה בטופס הרישום";
                $message .= " <a href='http://pegasus1.weizmann.ac.il/moodle2/mod/data/view.php?d=" .
                    $event->other['dataid'] . "&rid=" . $event->objectid . "&mode=single'>טופס הרישום</a><br>";
                $message .= "</div>";
                break;
            case 'עודכן קוד השתלמות':
                $to_user = $to_user_liron;
                $message = "<div style='direction:rtl;text-align:right;'>";
                $message .= "שלום {$to_user->firstname}<br>";
                $message .= "עודכן טופס בקשה ליצירה של קורס חדש.<br>";
                $message .= "סטטוס הטופס הנוכחי הוא: " . $workflow_status->content . "<br>";
                $message .= "יש לעדכן את קוד הקורס ולשנות את הסטטוס ל\"עודכן קוד הקורס\"<br>";
                $message .= "יש להקליק על הקישור הבא, לצפיה בטופס הרישום";
                $message .= " <a href='http://pegasus1.weizmann.ac.il/moodle2/mod/data/view.php?d=" .
                    $event->other['dataid'] . "&rid=" . $event->objectid . "&mode=single'>טופס הרישום</a><br>";
                $message .= "</div>";
                break;
            case 'עודכן קוד הקורס':
                $to_user = $to_user_moodle;
                $message = "<div style='direction:rtl;text-align:right;'>";
                $message .= "שלום {$to_user->firstname}<br>";
                $message .= "עודכן טופס בקשה ליצירה של קורס חדש.<br>";
                $message .= "סטטוס הטופס הנוכחי הוא: " . $workflow_status->content . "<br>";
                $message .= "יש לפתוח קורס במוודל ולעדכן סטוס ל \"נפתח קורס במוודל\"<br>";
                $message .= "יש להקליק על הקישור הבא, לצפיה בטופס הרישום";
                $message .= " <a href='http://pegasus1.weizmann.ac.il/moodle2/mod/data/view.php?d=" .
                    $event->other['dataid'] . "&rid=" . $event->objectid . "&mode=single'>טופס הרישום</a><br>";
                $message .= "</div>";
                break;
            case 'נפתח קורס במוודל':
                $to_user = $to_user_liron;
                $message = "<div style='direction:rtl;text-align:right;'>";
                $message .= "שלום {$to_user->firstname}<br>";
                $message .= "עודכן טופס בקשה ליצירה של קורס חדש.<br>";
                $message .= "סטטוס הטופס הנוכחי הוא: " . $workflow_status->content . "<br>";
                $message .= "יש לפתוח טופס הרשמה ולעדכן את הקישור בבקשה ולשנות סטטוס ל\"עודכן קישור לטופס\"<br>";
                $message .= "יש להקליק על הקישור הבא, לצפיה בטופס הרישום";
                $message .= " <a href='http://pegasus1.weizmann.ac.il/moodle2/mod/data/view.php?d=" .
                    $event->other['dataid'] . "&rid=" . $event->objectid . "&mode=single'>טופס הרישום</a><br>";
                $message .= "</div>";
                break;
            case 'עודכן קישור לטופס':
                $to_user = $to_user_noga;
                $message = "<div style='direction:rtl;text-align:right;'>";
                $message .= "שלום {$to_user->firstname}<br>";
                $message .= "עודכן טופס בקשה ליצירה של קורס חדש.<br>";
                $message .= "סטטוס הטופס הנוכחי הוא: " . $workflow_status->content . "<br>";
                $message .= "הסתיים תהליך פתיחת הקורס נא לשלוח דואל לרכז ההשתלמות ועדכני סטטוס ל\"הושלם\" " . "<br>";
                $message .= "יש להקליק על הקישור הבא, לצפיה בטופס הרישום";
                $message .= " <a href='http://pegasus1.weizmann.ac.il/moodle2/mod/data/view.php?d=" .
                    $event->other['dataid'] . "&rid=" . $event->objectid . "&mode=single'>טופס הרישום</a><br>";
                $message .= "</div>";
                break;
        }
        $success = email_to_user( $to_user, $admin_user, $subject, $message, $message);
        
        // Trigger an event for updating this record.
        $context = context_module::instance($event->objectid);
        $event = \local_event_automation\event\record_emailed::create(array(
            'objectid' => $event->objectid,
            'context' => $context,
            'courseid' => $event->courseid,
            'other' => array(
                'dataid' => $event->other['dataid'],
                'touserid' => $to_user->id,
                'message' => $message
            )
        ));
        $event->trigger();
        
    }
}