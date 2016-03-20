<?php

class NumberFormat{
    /**
     * @param int $money částka k vypsání
     * @return String naformátovaný výpisový tvar obnosu
    **/
    public static function moneyOutput($money){
        return number_format($money, 2, ',', ' ');
    }
}