<?php

    class NightsWatch
    {
        private $_members = array();

        public function recruit($new_member)
        {
            $this->_members[] = $new_member;
        }

        public function fight()
        {
            foreach ($this->_members as $fighter)
                if ($fighter instanceof IFighter)
                    $fighter->fight();
        }
    }

?>