<?php

    class UnholyFactory
    {
        private $_absorbed = array();
        private $_army = array();

        public function absorb($new)
        {
            if (!($new instanceof Fighter))
                echo "(Factory can't absorb this, it's not a fighter)".PHP_EOL;
            else if (array_key_exists($new->type, $this->_absorbed))
                echo "(Factory already absorbed a fighter of type ".$new->type.")".PHP_EOL;
            else
            {
                $this->_absorbed[$new->type] = $new;
                echo "(Factory absorbed a fighter of type ".$new->type.")".PHP_EOL;
            }
        }

        public function fabricate($request)
        {
            if (array_key_exists($request, $this->_absorbed))
            {
                echo "(Factory fabricates a fighter of type ".$request.")".PHP_EOL;
                return new $this->_absorbed[$request];
            }
            else
            {
                echo "(Factory hasn't absorbed any fighter of type ".$request.")".PHP_EOL;
                return NULL;
            }
        }
    }

?>