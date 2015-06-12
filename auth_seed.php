<?php

class authSeed {
    
    private $key;
    private $key_computation;
    private $key_randomization;
    private $sector;
    private $charset;
    
    public function __construct($charset = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890') {
        $this->charset = $charset;
    }
    
    public function fetchComputation($source_key, $time_sector = null) {
        $this->sector = $time_sector == null ? round(time()/120)*120 : $time_sector;

        foreach(str_split($source_key) as $key => $value) {
            if ($key == 0) continue;
            $this->key_computation .= $this->charKey($value) * $key * round($this->sector / $key);
        }
 
        foreach(str_split($this->key_computation) as $key => $value) {
            $key_val = $key == 0 ? 1 : $key;
            
            $this->key_randomization .= $value * $key_val * round($this->sector / $key_val);
        }
        
        return substr($this->key_randomization, -6);
    }
    
    public function generateKey($length) {
        $rtn_data = null;
        $char_len = strlen($this->charset) - 1;
        
        for($i = 0; $i < $length; $i++) 
            $rtn_data .= $charset{rand(0, $char_len)};
            
        return $rtn_data;
    }
    
    private function charKey($character) {
        return strpos($this->charset, $character);
    }
    
    /*
    private function stringRandomizer($string, $randomize_signature) {
        
    }
    
    public function altMethod() {
        $return_key   = null;
        $current_hash = md5('mykey' . round(time()/120)*120);
        
        foreach(str_split($current_hash) as $value) 
            $return_key = $this->charKey($value);
        
        return $return_key;
    }
    */
}