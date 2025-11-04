
<?php
// set default value
$message = '';

// get value from POST array
$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = 'start_app';
}

// process
switch ($action) {
    case 'start_app':

        // set default invoice date 1 month prior to current date
        $interval = new DateInterval('P1M');
        $default_date = new DateTime();
        $default_date->sub($interval);
        $invoice_date_s = $default_date->format('n/j/Y');

        // set default due date 2 months after current date
        $interval = new DateInterval('P2M');
        $default_date = new DateTime();
        $default_date->add($interval);
        $due_date_s = $default_date->format('n/j/Y');

        $message = 'Enter two dates and click on the Submit button.';
        break;

    case 'process_data':
        // get raw user input
        $invoice_date_s = filter_input(INPUT_POST, 'invoice_date');
        $due_date_s = filter_input(INPUT_POST, 'due_date');

        // make sure the user enters both dates
        if (empty($invoice_date_s) || empty($due_date_s)) {
            $message = 'Please enter both an invoice date and a due date.';
            break;
        }

        // convert date strings to DateTime objects
        try {
            $invoice_date = new DateTime($invoice_date_s);
            $due_date = new DateTime($due_date_s);
        } catch (Exception $e) {
            $message = 'Please enter the dates in a valid format.';
            break;
        }

        // make sure the due date is after the invoice date
        if ($due_date <= $invoice_date) {
            $message = 'The due date must be after the invoice date.';
            break;
        }

        // format both dates
        $invoice_date_f = $invoice_date->format('F j, Y');
        $due_date_f = $due_date->format('F j, Y');

        // get the current date and time and format them
        $current_date = new DateTime();
        $current_date_f = $current_date->format('F j, Y');
        $current_time_f = $current_date->format('g:i:s a');

        // get the amount of time between the current date and the due date
        $date_diff = $current_date->diff($due_date);

        if ($current_date < $due_date) {
            $due_date_message = 'This invoice is due in ' .
                $date_diff->y . ' years, ' .
                $date_diff->m . ' months, and ' .
                $date_diff->d . ' days.';
        } else {
            $due_date_message = 'This invoice is ' .
                $date_diff->y . ' years, ' .
                $date_diff->m . ' months, and ' .
                $date_diff->d . ' days overdue.';
        }

        break;
}

include 'date_tester.php';
?>