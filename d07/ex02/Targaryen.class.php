<?php

    class Targaryen
    {
        function resistsFire(){
            return FALSE;
        }

        function getBurned()
        {
            if (static::resistsFire() === TRUE)
                return  "emerges naked but unharmed";
            else
                return  "burns alive";
        }
    }
?>