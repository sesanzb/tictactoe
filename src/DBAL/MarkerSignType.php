<?php

namespace App\DBAL;

class MarkerSignType extends EnumType
{
    protected $name = 'marker_sign';
    protected $values = array('x', 'o');
    const CROSS_SIGN = 'x';
    const CIRCLE_SIGN = 'o';
}
