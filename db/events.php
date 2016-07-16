<?php

// Handle our own data_update_record event, as a way to manage approval workflow
// messages within database activity ID = 89
// http://pegasus1.weizmann.ac.il/moodle2/mod/data/view.php?d=89

$observers = array(

    // Handle group events, so that open quiz attempts with group overrides get updated check times.
    array(
        'eventname' => '\mod_data\event\record_updated',
        // TODO: Lets use a class
        //'callback' => '\local_event_automation\observer::record_updated',

        // Lets use a function (library)
        'includefile'     => '/local/event_automation/locallib.php',
        'callback' => 'local_event_automation_database_observer',

        //'internal' => false
    ),
    array(
        'eventname' => '\mod_data\event\record_created',
        // TODO: Lets use a class
        //'callback' => '\local_event_automation\observer::record_updated',

        // Lets use a function (library)
        'includefile'     => '/local/event_automation/locallib.php',
        'callback' => 'local_event_automation_database_observer',

        //'internal' => false
    ),
);