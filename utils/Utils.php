<?php
    function checkInteger($x) { // To check if a number is float or integer. 1 if integer, 0 if float
        if (is_float($x))
            return 0;
        return 1;
    }