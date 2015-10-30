<?php

define("MINIMUM_ISLANDS",   "1");
define("MAXIMUM_ISLANDS",   "3");
define("ISLAND_1",   "1");
define("ISLAND_2",   "2");
define("ISLAND_3",   "999");
/* Nastavením hodnoty 999 u ISLAND_cislo se funkce tohoto ostrova vypne
 * , jelikož uživatel nemá jak dojít k tomuto vysokému počtu ostrovů. Po-
 * kud je vypnut jeden ostrov tak druhý se vypne menším číslem než 999
 * ovšem vyšším než 10. Protože by to dávalo chybu ve SWITCHI
 */

define("COST_ISLAND_1",     "4000000");
define("COST_ISLAND_2",     "15000000");
define("COST_ISLAND_3",     "500000000");
define("COST_ISLAND_MAX",   "0");
?>