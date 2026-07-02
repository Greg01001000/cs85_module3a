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
        count of the error. If not empty, remove slashes and trailing & leading
        spaces. Return cleaned field data. */
        function validateInput($data, $fieldName) {
            global $errorCount;
            if (empty($data)) {
                echo "\"$fieldName\" is a required field.<br />\n";
                ++$errorCount;
                $retval = "";
            }
            else {      // Only clean up the input if it isn't empty
                $retval = trim($data);
                $retval = stripslashes($retval);
            }

            return($retval); }
    ?>
</body>
</html>