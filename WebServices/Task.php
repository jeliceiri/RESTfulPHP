<?php
    class Task
    {
        private $id;
        private $desc;

        // Get/Set
        public function __get($ivar)
        {
            return $this->$ivar;
        }
        public function __set($ivar, $value)
        {
            $this->$ivar = $value;
        }

        // Serialize
        public function __toString()
        {
            $format = "<hr/>Id: %s<br/>Description: %s<br/><hr/>";

            return sprintf($format, $this->__get("id"), $this->__get("desc"));
        }
    }
?>
