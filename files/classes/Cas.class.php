<?php
class Cas
{
    const DATUMCAS = 'j.n.Y G:i:s';
    const DATUM = 'j.n.Y';
    const CAS = 'G:i:s';
    const DB_DATUMCAS = 'Y-m-d H:i:s';
    const DB_DATUM = 'Y-m-d';
    const DB_CAS = 'H:i:s';

    public static function DatumCas()
    {
        return Date(self::DATUMCAS);
    }

    public static function Datum()
    {
        return Date(self::DATUM);
    }

    public static function Cass()
    {
        return Date(self::CAS);
    }

    public static function DB_DatumCas()
    {
        return Date(self::DB_DATUMCAS);
    }

    public static function DB_Datum()
    {
        return Date(self::DB_DATUM);
    }

    public static function DB_Cas()
    {
        return Date(self::DB_CAS);
    }
}
