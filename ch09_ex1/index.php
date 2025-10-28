<?php
// Default values
$name = '';
$email = '';
$phone = '';
$message = 'Enter some data and click on the Submit button.';

$action = filter_input(INPUT_POST, 'action');

switch ($action) {
    case 'process_data':
        // Get and trim input
        $name = trim(filter_input(INPUT_POST, 'name'));
        $email = trim(filter_input(INPUT_POST, 'email'));
        $phone = trim(filter_input(INPUT_POST, 'phone'));

        /*************************************************
         * Validate and process the name
         ************************************************/
        if (empty($name)) {
            $message = "You must enter a name.";
            break;
        }

        // Capitalize first letters
        $name = ucwords(strtolower($name));

        // ---- YOUR LOOP APPROACH FOR FIRST NAME ----
        $name_length = strlen($name);
        $breakpoint = $name_length;

        for ($i = 0; $i < $name_length; $i++) {
            if (substr($name, $i, 1) == " ") {
                $breakpoint = $i;
                break;
            }
        }

        $first_name = substr($name, 0, $breakpoint);

        /*************************************************
         * Validate and process the email
         ************************************************/
        if (empty($email)) {
            $message = "You must enter an email address.";
            break;
        } elseif (strpos($email, '@') === false || strpos($email, '.') === false) {
            $message = "The email address must contain at least one @ sign and one dot.";
            break;
        }

        /*************************************************
         * Validate and process the phone number
         ************************************************/
        $phone_length = strlen($phone);
        $formatted_phone = "";

        // ---- YOUR LOOP APPROACH TO CLEAN DIGITS ----
        for ($i = 0; $i < $phone_length; $i++) {
            $char = substr($phone, $i, 1);
            if ($char >= "0" && $char <= "9") {
                $formatted_phone .= $char;
            }
        }

        // Check digit count and format
        if (strlen($formatted_phone) < 7) {
            $message = "The phone number must contain at least seven digits.";
            break;
        } elseif (strlen($formatted_phone) == 7) {
            $formatted_phone = substr($formatted_phone, 0, 3) . '-' .
                substr($formatted_phone, 3);
        } elseif (strlen($formatted_phone) == 10) {
            $formatted_phone = substr($formatted_phone, 0, 3) . '-' .
                substr($formatted_phone, 3, 3) . '-' .
                substr($formatted_phone, 6);
        } else {
            $message = "Please enter a valid phone number.";
            break;
        }

        /*************************************************
         * Build the message output
         ************************************************/
        $message = "Hello $first_name,\n\n";
        $message .= "Thank you for entering this data:\n\n";
        $message .= "Name: $name\n";
        $message .= "Email: $email\n";
        $message .= "Phone: $formatted_phone";
        break;
}

include 'string_tester.php';
?>
