<?php
/**
 * Debug Class used for Debugging.
 *
 */
class wDebug
{
   static function registerTrustedIPs()
    {
        if (!empty($GLOBALS['_SGL']['TRUSTED_IPS'])) {
            return;
        }
        //  Only IPs defined here can access debug sessions and delete config files
        //$GLOBALS['_SGL']['TRUSTED_IPS']     = array('127.0.0.1');
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '10.0.*.*';
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '192.168.*.*';
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '61.11.120.42';
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '61.11.120.43';
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '61.11.120.218';
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '122.160.112.249';
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '124.124.94.133';
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '61.95.144.114';
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '202.78.232.5';
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '127.0.0.1';
        //$GLOBALS['_SGL']['TRUSTED_IPS'][]   = '202.56.207.74';

        // Module 107 at SDF Building, INT
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '117.194.80.45';

        // From Tata Photon + Broadband Connection
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '115.117.210.11';
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '115.117.232.9';
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '115.117.247.154';    // 17th July 2010
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '59.161.190.16';      // 21st August 2010
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '14.96.105.17';       // 3rd October 2010
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '14.96.64.161';       // 9th October 2010
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '115.117.197.39';     // 9th October 2010
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '59.161.188.73';      // 9th October 2010
        $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '14.96.189.103';      // 11th October 2010
         $GLOBALS['_SGL']['TRUSTED_IPS'][]   = '::1';

    }

    static function isTrustedIP($allowCli = false)
    {
        $isTrustedIP = false;
        wDebug::registerTrustedIPs();

        if (empty($_SERVER['REMOTE_ADDR'])) {
            return false;
        }

        if (!empty($GLOBALS['_SGL']['TRUSTED_IPS'])) {
            foreach ($GLOBALS['_SGL']['TRUSTED_IPS'] as $trustedIP) {
                if (@preg_match("/^$trustedIP$/", $_SERVER['REMOTE_ADDR'], $aMatches)) {
                    return true;
                }
            }
        }
        return $isTrustedIP;
    }

   static function  debugObject($obj = null, $header = '', $exit = false)
    {
        $isTrustedIP = wDebug::isTrustedIP();

        if (!$isTrustedIP) {
            return false;
        }

        if (!function_exists('htmlspecialchars_recursive')) {
            function htmlspecialchars_recursive($obj = null)
            {
                if (is_array($obj)) {
                    foreach ($obj as $key => $value) {
                        $obj[$key] = htmlspecialchars_recursive($value);
                    }
                } elseif (is_object($obj)) {
                    $aObjectVars = get_object_vars($obj);
                    foreach ($aObjectVars as $key => $value) {
                        $obj->$key = htmlspecialchars_recursive($value);
                    }
                } elseif (is_scalar($obj)) {
                    $obj = htmlspecialchars($obj);
                }
                return $obj;
            }
        }

        if ($header && strpos($header, '<h2>', 0) === false
                && strpos($header, '<h3', 0) === false) {
            $header = "<h2>{$header}</h2>";
        }

        // Obtain backtrace information, if supported by PHP
        $backtraceInfo = '';
        if (version_compare(phpversion(), '4.3.0') >= 0) {
            $bt = debug_backtrace();
            $backtraceInfo .= 'Fired from ';
            if (isset($bt[1]['class'])
                && $bt[1]['type']
                && isset($bt[1]['function'])) {
                $backtraceInfo .= 'Method::' . $bt[1]['class'] . $bt[1]['type']
                    . $bt[1]['function'];
            } elseif (isset($bt[1]['function'])) {
                $backtraceInfo .= 'Function::' . $bt[1]['function'];
            }
            if (isset($bt[0]['file']) && isset($bt[0]['line'])) {
                $backtraceInfo .= " line " . $bt[0]['line'] . " of \n\"" . $bt[0]['file'] . '"';
            }
            $backtraceInfo = '<h3 style="border-bottom: 1px dashed #805E42;">'
                . $backtraceInfo . '</h3>';
        }
        $header .= $backtraceInfo . "\n";

        echo "\n";
        echo '<pre style="
            background-color: #FFFFFF;
            border: 1px solid #BBBBBB;
            text-align: left;
            font-size: 9pt;
            line-height: 125%;
            margin: 0.5em 1em 1.8em;
            overflow: auto;
            padding: 0.99em;">';
        echo $header;
        // $type = intGetVariableType($obj);
        // echo "<h4>Object Type: $type</h4>";
        $obj = htmlspecialchars_recursive($obj);
        print_r($obj);
        echo "\n</pre>";

        if (is_callable(array('Yii', 'log'))) {
            Yii::log($header);
            Yii::log(print_r($obj, true));
        }

        if ($exit) {
            exit();
        }
    }

   static function debugObjectType($obj = null, $header = '', $exit = false)
    {
        //Build Header
        if ($header) {
            $header = "<h2>{$header}</h2>";
        }

        // Obtain backtrace information, if supported by PHP
        $backtraceInfo = '';
        if (version_compare(phpversion(), '4.3.0') >= 0) {
            $bt = debug_backtrace();
            $backtraceInfo .= 'Fired from ';
            if (isset($bt[1]['class'])
                && $bt[1]['type']
                && isset($bt[1]['function'])) {
                $backtraceInfo .= 'Method::' . $bt[1]['class'] . $bt[1]['type']
                    . $bt[1]['function'];
            } elseif (isset($bt[1]['function'])) {
                $backtraceInfo .= 'Function::' . $bt[1]['function'];
            }
            if (isset($bt[0]['file']) && isset($bt[0]['line'])) {
                $backtraceInfo .= " line " . $bt[0]['line'] . " of \n\"" . $bt[0]['file'] . '"';
            }
            $backtraceInfo = '<h3 style="border-bottom: 1px dashed #805E42;">'
                . $backtraceInfo . '</h3>';
        }
        $header .= $backtraceInfo . "\n";

        wDebug::debugObject(intGetVariableType($obj), $header, $exit);
    }

   static function debugObjectSafe($obj = null, $header = '', $exit = false)
    {
        if (!isTrustedIP()) {
            return false;
        }

        //Build Header
        if ($header) {
            $header = "<h2>{$header}</h2>";
        }

        // Obtain backtrace information, if supported by PHP
        $backtraceInfo = '';
        if (version_compare(phpversion(), '4.3.0') >= 0) {
            $bt = debug_backtrace();
            $backtraceInfo .= 'Fired from ';
            if (isset($bt[1]['class'])
                && $bt[1]['type']
                && isset($bt[1]['function'])) {
                $backtraceInfo .= 'Method::' . $bt[1]['class'] . $bt[1]['type']
                    . $bt[1]['function'];
            } elseif (isset($bt[1]['function'])) {
                $backtraceInfo .= 'Function::' . $bt[1]['function'];
            }
            if (isset($bt[0]['file']) && isset($bt[0]['line'])) {
                $backtraceInfo .= " line " . $bt[0]['line'] . " of \n\"" . $bt[0]['file'] . '"';
            }
            $backtraceInfo = "<h3>$backtraceInfo</h3>";
        }
        $header .= $backtraceInfo . "\n";

        echo "\n";
        echo '<pre style="
            background-color: #000000;
            border: 1px solid #BBBBBB;
            text-align: left;
            font-size: 9pt;
            line-height: 125%;
            margin: 0.5em 1em 1.8em;
            overflow: auto;
            padding: 0.99em;">';
        echo $header;
        print_r($obj);
        echo "\n</pre>";
        if ($exit) {
            exit();
        }
    }

   static function intGetVariableType($obj)
    {
        $type = 'unknown';
        if (is_object($obj)) {
            return get_class($obj);
        } elseif (is_resource($obj)) {
            return get_resource_type($obj);
        } elseif (is_array($obj)) {
            return 'Array';
        } elseif (is_numeric($obj)) {
            return 'Number';
        } elseif (is_string($obj)) {
            return 'String';
        }
        return $type;
    }

    static function debugBacktraceInfo($maxLevel = 90)
    {
        $bt = debug_backtrace();
        $aDebugObject = array();
        $level = 0;
        foreach ($bt as $btInfo) {
            if ($level > $maxLevel) {
                break;
            }
            $aBTInfo = array(
                'file'      => $btInfo['file'],
                'line'      => $btInfo['line'],
                'function'  => @$btInfo['function'],
                'class'     => @$btInfo['class'],
                'type'      => @$btInfo['type'],
            );
            $aDebugObject[] = $aBTInfo;
            $level++;
        }
        wDebug::debugObject($aDebugObject);
    }
}
?>