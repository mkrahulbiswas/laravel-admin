<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;
use App\Models\LogSiteVisit;

class LogSiteVisitMiddleware
{
    public function handle(Request $request, Closure $next, $visitTo = null): Response
    {
        $ip = $request->header('currentIp');
        $deep_detect = TRUE;
        if ($ip != null) {
            if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
                $ip = $_SERVER["REMOTE_ADDR"];
                if ($deep_detect) {
                    if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                        $ip = $_SERVER['HTTP_CLIENT_IP'];
                }
            }
        }
        $xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);
        $xml = json_decode(json_encode((array)$xml), TRUE);
        $locationInfo = [
            'request' => $xml['geoplugin_request'],
            'status' => $xml['geoplugin_status'],
            'delay' => $xml['geoplugin_delay'],
            'credit' => $xml['geoplugin_credit'],
            'city' => $xml['geoplugin_city'],
            'region' => $xml['geoplugin_region'],
            'regionCode' => $xml['geoplugin_regionCode'],
            'regionName' => $xml['geoplugin_regionName'],
            'areaCode' => $xml['geoplugin_areaCode'],
            'dmaCode' => $xml['geoplugin_dmaCode'],
            'countryCode' => $xml['geoplugin_countryCode'],
            'countryName' => $xml['geoplugin_countryName'],
            'inEU' => $xml['geoplugin_inEU'],
            'euVATrate' => $xml['geoplugin_euVATrate'],
            'continentCode' => $xml['geoplugin_continentCode'],
            'continentName' => $xml['geoplugin_continentName'],
            'latitude' => $xml['geoplugin_latitude'],
            'longitude' => $xml['geoplugin_longitude'],
            'locationAccuracyRadius' => $xml['geoplugin_locationAccuracyRadius'],
            'timezone' => $xml['geoplugin_timezone'],
            'currencyCode' => $xml['geoplugin_currencyCode'],
            'currencySymbol' => $xml['geoplugin_currencySymbol'],
            'currencySymbol_UTF8' => $xml['geoplugin_currencySymbol_UTF8'],
            'currencyConverter' => $xml['geoplugin_currencyConverter'],
        ];

        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = $platform = $ub = "Unknown";
        $version = "";

        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        } elseif (preg_match('/PostmanRuntime/i', $u_agent)) {
            $platform = 'postman';
        }

        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        } elseif (preg_match('/PostmanRuntime/i', $u_agent)) {
            $bname = 'Postman Runtime';
            $ub = "Postman";
        }

        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (preg_match_all($pattern, $u_agent, $matches)) {
            $i = count($matches['browser']);
            if ($i != 1) {
                if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                    $version = $matches['version'][0];
                } else {
                    $version = $matches['version'][1];
                }
            } else {
                $version = $matches['version'][0];
            }
        }

        if ($version == null || $version == "") {
            $version = "?";
        }

        $finalBrowserArray = array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );

        $logSiteVisit = new LogSiteVisit();
        $logSiteVisit->country = ($locationInfo['countryName'] == []) ? 'Unknown' : $locationInfo['countryName'];
        $logSiteVisit->city = ($locationInfo['city'] == []) ? 'Unknown' : $locationInfo['city'];
        $logSiteVisit->state = ($locationInfo['region'] == []) ? 'Unknown' : $locationInfo['region'];
        $logSiteVisit->ip = ($locationInfo['request'] == '') ? request()->ip() : $locationInfo['request'];
        $logSiteVisit->url = URL::full();
        $logSiteVisit->platform = $finalBrowserArray['platform'];
        $logSiteVisit->browserName = $finalBrowserArray['name'];
        $logSiteVisit->browserVersion = $finalBrowserArray['version'];
        $logSiteVisit->visitTo = ($request->header('platform') == null) ? $visitTo : $request->header('platform');
        $logSiteVisit->browserInfo = json_encode($finalBrowserArray);
        $logSiteVisit->locationInfo = json_encode($locationInfo);
        $logSiteVisit->save();

        return $next($request);
    }
}
