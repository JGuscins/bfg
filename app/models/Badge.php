<?php
 
class Badge extends Eloquent {
 
    public function user()
    {
        return $this->belongsTo('User');
    }
}