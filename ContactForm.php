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
                $retval = stripslashes($retval);
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
        
    ?>
</body>
</html>