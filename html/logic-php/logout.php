<?php
session_unset();
session_destroy();
echo "<script>
        // After successful logout, waits 1 second then refreshes
        setTimeout(function() {
            window.location.href = window.location.href;
        }, 1000);
        </script>";
exit();
?>
