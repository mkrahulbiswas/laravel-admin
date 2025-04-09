<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;
use App\Models\LogSiteVisit;

class LogSiteVisitMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = null;
        $deep_detect = TRUE;

        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
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

            // +"geoplugin_request": "49.47.157.46"
            // +"geoplugin_status": "200"
            // +"geoplugin_delay": "2ms"
            // +"geoplugin_credit": "Some of the returned data includes GeoLite2 data created by MaxMind, available from <a href='https://www.maxmind.com'>https://www.maxmind.com</a>."
            // +"geoplugin_city": "Kharagpur"
            // +"geoplugin_region": "West Bengal"
            // +"geoplugin_regionCode": "WB"
            // +"geoplugin_regionName": "West Bengal"
            // +"geoplugin_areaCode": SimpleXMLElement {#712}
            // +"geoplugin_dmaCode": SimpleXMLElement {#713}
            // +"geoplugin_countryCode": "IN"
            // +"geoplugin_countryName": "India"
            // +"geoplugin_inEU": "0"
            // +"geoplugin_euVATrate": SimpleXMLElement {#714}
            // +"geoplugin_continentCode": "AS"
            // +"geoplugin_continentName": "Asia"
            // +"geoplugin_latitude": "22.3448"
            // +"geoplugin_longitude": "87.33"
            // +"geoplugin_locationAccuracyRadius": "500"
            // +"geoplugin_timezone": "Asia/Kolkata"
            // +"geoplugin_currencyCode": "INR"
            // +"geoplugin_currencySymbol": "&#8377;"
            // +"geoplugin_currencySymbol_UTF8": "₹"
            // +"geoplugin_currencyConverter": "83.0163"
        ];


        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = $platform = $ub = "Unknown";
        $version = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
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
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
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


        $logSiteVisit = new LogSiteVisit;
        $logSiteVisit->country = ($locationInfo['countryName'] == []) ? 'NA' : $locationInfo['countryName'];
        $logSiteVisit->city = ($locationInfo['city'] == []) ? 'NA' : $locationInfo['city'];
        $logSiteVisit->state = ($locationInfo['region'] == []) ? 'NA' : $locationInfo['region'];
        $logSiteVisit->ip = request()->ip();
        $logSiteVisit->url = URL::full();
        $logSiteVisit->platform = $finalBrowserArray['platform'];
        $logSiteVisit->browserName = $finalBrowserArray['name'];
        $logSiteVisit->browserVersion = $finalBrowserArray['version'];
        $logSiteVisit->browserInfo = json_encode($finalBrowserArray);
        $logSiteVisit->locationInfo = json_encode($locationInfo);
        $logSiteVisit->save();

        return $next($request);
    }
}
