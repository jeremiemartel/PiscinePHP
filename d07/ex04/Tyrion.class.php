<?php

    class Tyrion extends Lannister
    {
        function sleepWith($someone)
        {
            if ($someone instanceof Lannister)
                echo "Not even if I'm drunk !".PHP_EOL;
            else
                echo "Let's do this.".PHP_EOL;
        }
    }

?>