<?php

/**
 * OpenSSH Key Handler
 *
 * PHP version 5
 *
 * Place in $HOME/.ssh/authorized_keys
 *
 * @category  Crypt
 * @package   Common
 * @author    Jim Wigginton <terrafrost@php.net>
 * @copyright 2015 Jim Wigginton
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link      http://phpseclib.sourceforge.net*/

namespace phpseclib\Crypt\Common\Keys;

use ParagonIE\ConstantTime\Base64;
use phpseclib\Common\Functions\Strings;

/**
 * OpenSSH Formatted RSA Key Handler
 *
 * @package Common
 * @author  Jim Wigginton <terrafrost@php.net>
 * @access  public*/
abstract class OpenSSH
{
    /**
     * Default comment
     *
     * @var string
     * @access private
     */
    protected static $comment = 'phpseclib-generated-key';

    /**
     * Binary key flag
     *
     * @var bool
     * @access private
     */
    protected static $binary = false;

    /**
     * Sets the default comment
     *
     * @access public
     * @param string $comment
     */
    public static function setComment($comment)
    {
        self::$comment = str_replace(["\r", "\n"], '', $comment);
    }

    /**
     * Break a public or private key down into its constituent components
     *
     * $type can be either ssh-dss or ssh-rsa
     *
     * @access public
     * @param string $key
     * @param string $type
     * @return array
     */
    public static function load($key, $type)
    {
        if (!is_string($key)) {
            return false;
        }

        $parts = explode(' ', $key, 3);

        if (!isset($parts[1])) {
            $key = Base64::decode($parts[0]);
            $comment = isset($parts[1]) ? $parts[1] : false;
        } else {
            if ($parts[0] != $type) {
                return false;
            }
            $key = Base64::decode($parts[1]);
            $comment = isset($parts[2]) ? $parts[2] : false;
        }
        if ($key === false) {
            return false;
        }

        if (substr($key, 0, 11) != "\0\0\0\7$type") {
            return false;
        }
        Strings::shift($key, 11);
        if (strlen($key) <= 4) {
            return false;
        }

        return $key;
    }

    /**
     * Returns the comment for the key
     *
     * @access public
     * @return mixed
     */
    public static function getComment($key)
    {
        $parts = explode(' ', $key, 3);

        return isset($parts[2]) ? $parts[2] : false;
    }

    /**
     * Toggle between binary and printable keys
     *
     * Printable keys are what are generated by default. These are the ones that go in
     * $HOME/.ssh/authorized_key.
     *
     * @access public
     * @param bool $enabled
     */
    public static function setBinaryOutput($enabled)
    {
        self::$binary = $enabled;
    }

    /**
     * Returns the current binary output value
     *
     * @access public
     * @return bool
     */
    public static function getBinaryOutput()
    {
        return (bool) self::$binary;
    }
}
