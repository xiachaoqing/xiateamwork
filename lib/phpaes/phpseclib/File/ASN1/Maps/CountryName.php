<?php

/**
 * CountryName
 *
 * PHP version 5
 *
 * @category  File
 * @package   ASN1
 * @author    Jim Wigginton <terrafrost@php.net>
 * @copyright 2016 Jim Wigginton
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link      http://phpseclib.sourceforge.net*/

namespace phpseclib\File\ASN1\Maps;

use phpseclib\File\ASN1;

/**
 * CountryName
 *
 * @package ASN1
 * @author  Jim Wigginton <terrafrost@php.net>
 * @access  public*/
abstract class CountryName
{
    const MAP = [
        'type'     => ASN1::TYPE_CHOICE,
        // if class isn't present it's assumed to be \phpseclib\File\ASN1::CLASS_UNIVERSAL or
        // (if constant is present) \phpseclib\File\ASN1::CLASS_CONTEXT_SPECIFIC
        'class'    => ASN1::CLASS_APPLICATION,
        'cast'     => 1,
        'children' => [
            'x121-dcc-code'        => ['type' => ASN1::TYPE_NUMERIC_STRING],
            'iso-3166-alpha2-code' => ['type' => ASN1::TYPE_PRINTABLE_STRING]
        ]
    ];
}