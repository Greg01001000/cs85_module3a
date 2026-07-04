<!--CS 85 Module 3, Assignment 3A, by Gregory Hagen, 7/2/26-->
<!DOCTYPE HTML>
<html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title>Contact Me</title>
    </head>
<body>
    <?php
        /* If user-supplied field is empty, notify that it's required and keep
        count of the error. If not empty, remove slashes and leading & trailing
        spaces. Return cleaned field data. */
        function validateInput($data, $fieldName) {
            global $errorCount;
            if (empty($data)) {
                echo "\"$fieldName\" is a required field.<br />\n"; //Tell user
                ++$errorCount;  // Keep track of the error
                $retval = "";   // Set the data value this function will return
            }
            else {      // Only clean up the input if it isn't empty
                $retval = trim($data);  // Remove leading & trailing spaces
                $retval = stripslashes($retval);    // Remove slashes
            }

            return($retval); }  // Return the cleaned or empty data

        /* If user-supplied email address is empty, notify that it's required 
        and keep count of the error. If not empty, remove extra characters and 
        check for valid email address format. Return cleaned field data. */
        function validateEmail($data, $fieldName) {
            global $errorCount;

            if (empty($data)) {
                echo "\"$fieldName\" is a required field.<br />\n"; //Tell user
                // Keep track of the error and set the data value to return
                ++$errorCount; $retval = "";
            }
            else {      // Only clean and validate the input if it isn't empty
                // Remove characters not allowed in email adddresses
                $retval = filter_var($data, FILTER_SANITIZE_EMAIL);

                // Is the user-supplied data in a valid email address format?
                if (!filter_var($retval, FILTER_VALIDATE_EMAIL)) {
                    // If not, tell the user it's invalid
                    echo "\"$fieldName\" is not a valid e-mail address.<br />\n";
                }
            }
        return($retval);  // Return the cleaned or empty data
        }
        
        /* This function takes one parameter for each form field (placeholder text) and
        displays the form with buttons to clear the form and to submit the form */
        function displayForm($Sender, $Email, $Subject, $Message) {
            ?> <h2 style = "text-align:center">Contact Me</h2> <!-- Center form title -->
            <form name="contact" action="ContactForm.php" method="post">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <p>Your Name:
                    <input type="text" name="Sender" value="<?php echo $Sender; ?>" /></p>
                <p>Your E-mail:
                    <input type="text" name="Email" value="<?php echo $Email; ?>" /></p>
                <p>Subject:
                    <input type="text" name="Subject" value="<?php echo $Subject; ?>" /></p>
                <p>Message:<br />
                    <textarea name="Message"><?php echo $Message; ?></textarea></p>
                <!-- Button to clear form -->
                <p><input type="reset" value="Clear Form" />&nbsp; &nbsp;
                    <!-- Button to submit form -->
                    <input type="submit" name="Submit" value="Send Form" /></p>
            </form>

        <?php }

        // Initialize variables
        $ShowForm = TRUE;
        // Without this line here (global $errorCount), $errorCount inside and outside
        // the user-defined functions above are different variables when Laravel Herd
        // runs this code
        global $errorCount; 
        $errorCount = 0;
        $Sender = '';
        $Email = '';
        $Subject = '';
        $Message = '';

        /* If user submitted form, check each field for missing or invalid data
        using the custom functions defined above. Email address has its own validation
        function. If no errors are found, get ready to show the form. */
        if (isset($_POST['Submit'])) {
            $Sender = validateInput($_POST['Sender'],'Your Name');
            $Email = validateEmail($_POST['Email'],'Your E-mail');
            $Subject = validateInput($_POST['Subject'],'Subject');
            $Message = validateInput($_POST['Message'],'Message');
            // If user submitted form and an error was found, get ready to show form
            if ($errorCount==0)
                $ShowForm = FALSE;
            else
                $ShowForm = TRUE;
        }

        /* If the form hasn't been displayed, or if the user submitted unsatisfactory
        input, display the form. If the user submitted unsatisfactory input, tell the 
        user. Else (if the user submitted satisfactory input), prepare to email the
        input, and tell the user whether the message is able to be sent. */
        if ($ShowForm == TRUE) {
            if ($errorCount>0)
                echo "<p>Please re-enter the form information below.</p>\n";
            displayForm($Sender, $Email, $Subject, $Message);
        }
        else {  // The user submitted satisfactory input. Prepare to email it.
            $SenderAddress = "$Sender <$Email>";
            $Headers = "From: $SenderAddress\nCC: $SenderAddress\n"; // User gets a copy

            // Send the email
            $result = mail('recipient@example.com', $Subject, $Message, $Headers);

            if ($result)    // Show the user a status message
                echo "<p>Your message has been sent. Thank you, " . $Sender . ".</p>\n";
            else
                echo "<p>There was an error sending your message, " . $Sender . ".</p>\n";
        }
    ?>
</body>
</html>