<?php
    function checkInteger($x) { // To check if a number is float or integer. true if integer, false if float
        if (is_float($x))
            return false;
        return true;
    }