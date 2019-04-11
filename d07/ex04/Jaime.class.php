<?php

    class Jaime extends Lannister
    {
        function sleepWith($someone)
        {
            if ($someone instanceof Cersei)
                echo "With pleasure, but only in a tower in Winterfell, then.".PHP_EOL;
            else if ($someone instanceof Tyrion)
                echo "Not even if I'm drunk !".PHP_EOL;
            else
                echo "Let's do this.".PHP_EOL;
        }
    }

?>