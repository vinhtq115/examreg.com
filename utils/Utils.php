<?php
    /**
     * Kiểm tra một số xem là float hay int.
     * @param $x: Float hoặc int
     * @return bool: True nếu int, false nếu float
     */
    function checkInteger($x) {
        if (is_float($x))
            return false;
        return true;
    }