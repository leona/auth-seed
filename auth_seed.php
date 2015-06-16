<?php

class authSeed {
    
    private $key;
    private $key_computation;
    private $key_randomization;
    private $sector;
    private $charset;
    private $time_intervals;
    
    public function __construct($charset = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890') {
        $this->charset = $charset;
    }
    
    public function fetchComputation($source_key, $time_sector = null, $time_intervals = 120) {
        $this->sector         = $time_sector == null ? $this->fetchSector() : $time_sector;
        $this->time_intervals = $time_intervals;
        
        $this->strIterate($source_key, function($key_val, $value) {
            $this->key_computation .= $this->charKey($value) * $this->sector;
        });
 
        $this->strIterate($this->key_computation, function($key_val, $value) {
            $this->key_randomization .= $value * $key_val * $this->sector;
        });

        return substr($this->key_randomization, -6);
    }
    
    public function generateKey($length) {
        $rtn_data = null;
        $char_len = strlen($this->charset) - 1;
        
        for($i = 0; $i < $length; $i++) 
            $rtn_data .= $charset{rand(0, $char_len)};
            
        return $rtn_data;
    }
    
    private function strIterate($string, $callback) {
        foreach(str_split($string) as $key => $value) {
            if ($key == 0) continue;
            $callback($key, $value);
        }
    }
    
    private function fetchSector() {
        return round(time() / $this->time_intervals) * $this->time_intervals;
    }
    
    private function charKey($character) {
        return strpos($this->charset, $character);
    }
    
    /*
    private function stringRandomizer($string, $randomize_signature) {
        
    }
    
    public function altMethod() {
        $return_key   = null;
        $current_hash = md5('mykey' . $this->fetchSector());
        
        foreach(str_split($current_hash) as $value) 
            $return_key = $this->charKey($value);
        
        return $return_key;
    }
    */
}