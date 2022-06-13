<?php
    function nvl($val, $replace)
    {
        if( is_null($val) || $val === '' )  {
            return $replace;
        } else {
            return $val;
        }
    }