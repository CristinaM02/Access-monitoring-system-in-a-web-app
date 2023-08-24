<?php
function get_browser_name($user_agent)
{
    if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
    elseif (strpos($user_agent, 'Edge')) return 'Edge';
    elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
    elseif (strpos($user_agent, 'Safari')) return 'Safari';
    elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
    elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
   
    return 'Other';
}

// Usage:
//echo get_browser_name($_SERVER['HTTP_USER_AGENT']);

function operatingSystem()
{
    if (preg_match_all('/windows/i', $UserAgent)) {
        $PlatForm = 'Windows';
    } elseif (preg_match_all('/linux/i', $UserAgent)) {
        $PlatForm = 'Linux';
    } elseif (preg_match('/macintosh|mac os x/i', $UserAgent)) {
        $PlatForm = 'Macintosh';
    } elseif (preg_match_all('/Android/i', $UserAgent)) {
        $PlatForm = 'Android';
    } elseif (preg_match_all('/iPhone/i', $UserAgent)) {
        $PlatForm = 'IOS';
    } elseif (preg_match_all('/ubuntu/i', $UserAgent)) {
        $PlatForm = 'Ubuntu';
    } else {
        $PlatForm = 'Other';
    }

    return $PlatForm;
}

function oSVersion($UserAgent){
    if (preg_match_all('/windows nt 10/i', $UserAgent)) {
        $OsVersion = 'Windows 10';
    } elseif (preg_match_all('/windows nt 6.3/i', $UserAgent)) {
        $OsVersion = 'Windows 8.1';
    } elseif (preg_match_all('/windows nt 6.2/i', $UserAgent)) {
        $OsVersion = 'Windows 8';
    } elseif (preg_match_all('/windows nt 6.1/i', $UserAgent)) {
        $OsVersion = 'Windows 7';
    } elseif (preg_match_all('/windows nt 6.0/i', $UserAgent)) {
        $OsVersion = 'Windows Vista';
    } elseif (preg_match_all('/windows nt 5.1/i', $UserAgent)) {
        $OsVersion = 'Windows Xp';
    } elseif (preg_match_all('/windows xp/i', $UserAgent)) {
        $OsVersion = 'Windows Xp';
    } elseif (preg_match_all('/windows me/i', $UserAgent)) {
        $OsVersion = 'Windows Me';
    } elseif (preg_match_all('/win98/i', $UserAgent)) {
        $OsVersion = 'Windows 98';
    } elseif (preg_match_all('/win95/i', $UserAgent)) {
        $OsVersion = 'Windows 95';
    } elseif (preg_match_all('/Windows Phone +[0-9]/i', $UserAgent, $match)) {
        $OsVersion = $match[0][0];
    } elseif (preg_match_all('/Ubuntu +[0-9]/i', $UserAgent, $match)) {
        $OsVersion = $match[0][0];
    } elseif (preg_match_all('/Android +[0-9]/i', $UserAgent, $match)) {
        $OsVersion = $match[0][0];
    } elseif(preg_match_all('/Linux +x[0-9]+/i', $UserAgent, $match)) {
        $OsVersion = $match[0][0];
    } elseif(preg_match_all('/Macintosh|Mac OS X +\d{0,2}(\.\d{0,2})?+/i', $UserAgent, $match)) {
        $OsVersion = $match[0][0];
    } elseif (preg_match_all('/iPhone OS +[0-9]*/i', $UserAgent, $match)) {
        $OsVersion = $match[0][0];
    }
    else $OsVersion = 'Other';

    return $OsVersion;
}


?>