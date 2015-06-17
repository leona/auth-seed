<?php

class authSeed {
    
    private $key_computation = null;
    private $sector;
    private $time_intervals;
    private $charset = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890';
    
    public function fetchComputation($source_key, $time_sector = null, $time_intervals = 120) {
        $this->sector         = $time_sector == null ? $this->fetchSector() : $time_sector;
        $this->time_intervals = $time_intervals;
        
        foreach(str_split(md5($this->sector . $source_key)) as $value) 
            $this->key_computation .= $this->charKey($value);
        
        return substr($this->key_computation, -6);
    }
    
    public function generateKey($length) {
        $rtn_data = null;
        $char_len = strlen($this->charset) - 1;
        
        for($i = 0; $i < $length; $i++) 
            $rtn_data .= $charset{rand(0, $char_len)};
            
        return $rtn_data;
    }

    private function fetchSector() {
        return round(time() / $this->time_intervals) * $this->time_intervals;
    }
    
    private function charKey($character) {
        $pos = strpos($this->charset, $character);
    
        return strlen($pos) > 1 ? substr($pos, -1) : $pos;
    }
}