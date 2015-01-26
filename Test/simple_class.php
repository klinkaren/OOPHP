<?php
class SimpleClass {
 
    // property declaration
    public $var = 'a default value ';
    public $val = 0;
 
    // method declaration
    public function DisplayVar() {
        $this->val++;
        echo $this->var . $this->val;
    }
}