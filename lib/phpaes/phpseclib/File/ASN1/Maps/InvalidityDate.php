<?php

/**
 * InvalidityDate
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
 * InvalidityDate
 *
 * @package ASN1
 * @author  Jim Wigginton <terrafrost@php.net>
 * @access  public*/
abstract class InvalidityDate
{
    const MAP = ['type' => ASN1::TYPE_GENERALIZED_TIME];
}
