<?php

    function parseConfirmation($confirmed) {
        if ($confirmed == 0) return "Accepted";
        else if (($confirmed == 2) || ($confirmed == 3)) return "Rejected";

        return "Rejected";
    }

?>