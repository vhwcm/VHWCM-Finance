<?php

    // Function to display an apology message to the user
    function apologize($message)
    {
        // Include the apology template
        require_once("apology.php");

        // Exit the script immediately since we're apologizing
        exit;
    }

    // Function to dump a variable for debugging purposes
    function dump($variable)
    {
        // Include the dump template with some quick and dirty HTML
        require("dump.php");

        // Exit the script
        exit;
    }

    // Function to log out the user
    function logout()
    {
        // Unset any session variables
        $_SESSION = array();

        // Expire the session cookie
        if (isset($_COOKIE[session_name()]))
        {
            if (preg_match("{^(/~[^/]+/pset7/)}", $_SERVER["REQUEST_URI"], $matches))
                setcookie(session_name(), "", time() - 42000, $matches[1]);
            else
                setcookie(session_name(), "", time() - 42000);
        }

        // Destroy the session
        session_destroy();
    }

    // Function to look up a stock symbol
    function lookup($symbol)
    {
        // If the symbol starts with a caret, return NULL
        if (preg_match("/^\^/", $symbol))
            return NULL;

        // Open a connection to the Yahoo Finance API
        if (($fp = @fopen(YAHOO . $symbol , "r")) === FALSE)
            return NULL;

        // Skip the first line of the CSV file
        fgetcsv($fp);

        // Get the data from the second line of the CSV file
        if (($data = fgetcsv($fp)) === FALSE || count($data) == 1)
            return NULL;

        // Close the connection to the API
        fclose($fp);

        // If the stock price is 0.00, return NULL
        if ($data[2] == 0.00)
            return NULL;

        // Create a new Stock object
        $stock = new Stock();

        // Set the properties of the Stock object
        $stock->name = strtoupper($symbol);
        $stock->price = number_format($data[4],2);
        $stock->day = $data[0];
        $stock->open = number_format($data[1],2);
        $stock->high = number_format($data[2],2);
        $stock->low = number_format($data[3],2);

        // Return the Stock object
        return $stock;
    }

    // Function to redirect the user to a different page
    function redirect($destination)
    {
        // If the destination starts with "http://", redirect to that URL
        if (preg_match("/^http:\/\//", $destination))
            header("Location: " . $destination);

        // If the destination starts with a slash, redirect to that path on the current host
        else if (preg_match("/^\//", $destination))
        {
            $protocol = (@$_SERVER["HTTPS"]) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            header("Location: $protocol://$host$destination");
        }

        // Otherwise, redirect to the destination relative to the current script
        else
        {
            $protocol = (@$_SERVER["HTTPS"]) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            header("Location: $protocol://$host$path/$destination");
        }

        // Exit the script
        exit;
    }

?>