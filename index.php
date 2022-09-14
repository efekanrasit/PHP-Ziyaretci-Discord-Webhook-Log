<?php
ini_set('display_errors','off');
// Discord Webhook Ayarlayınız.
$webhook = "-----Discord Webhook-----";
$user_agent     =   $_SERVER['HTTP_USER_AGENT'];
function getOS() { 
    global $user_agent;
    $os_platform    =   "İşletim Sistemi Bulunamadı";
    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
							'/kalilinux/i'          =>  'KaliLinux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile',
							'/Windows Phone/i'      =>  'Windows Phone'
                        );
    foreach ($os_array as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }
    }   
    return $os_platform;
}
function getBrowser() {
    global $user_agent;
    $browser        =   "Tarayıcı Bulunamadı";
    $browser_array  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
							'/Mozilla/i'	=>	'Mozila',
							'/Mozilla/5.0/i'=>	'Mozila',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/edge/i'       =>  'Edge',
                            '/opera/i'      =>  'Opera',
							'/OPR/i'        =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
							'/Bot/i'		=>	'BOT Browser',
							'/Valve Steam GameOverlay/i'  =>  'Steam',
                            '/mobile/i'     =>  'Handheld Browser'
                        );
    foreach ($browser_array as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }
    }
    return $browser;
}
$user_os        =   getOS();
$user_browser   =   getBrowser();
$time = date('Y-m-d H:i:s');
require_once('script.php');
$geoplugin = new geoPlugin();
$geoplugin->locate();
$sayfa_url = $_SERVER['SCRIPT_NAME'];


//<------------- Gönderilecek Webhook ayarlarıdır, istediğiniz şekilde ayarlayabilirsiniz.
$make_json = json_encode(array ('embeds'=> [                             
        [
            "title" => "MinecraftAFKBot.com",
            "type" => "rich",
            "description" => "Kullanıcı `$sayfa_url` sayfasına giriş yaptı.",
            "url" => "https://minecraftafkbot.com/$sayfa_url",
            "color" => hexdec( "FFFFFF" ),
            "footer" => [
                "text" => "Minecraft AFK Bot Hizmetleri",
                "icon_url" => "https://minecraftafkbot.com/assets/img/icon.png"
            ],
            "image" => [
                "url" => "https://minecraftafkbot.com/assets/img/textlogo-white.png"
            ],
            "thumbnail" => [
                "url" => "https://minecraftafkbot.com/assets/img/textlogo-white.png"
            ],
            "fields" => [
                [
                    "name" => "IP Adresi",
                    "value" => "{$geoplugin->ip}",
                    "inline" => false
                ],
                [
                    "name" => "İşletim Sistemi",
                    "value" => "$user_os",
                    "inline" => true
                ],
                [
                    "name" => "Tarayıcı",
                    "value" => "$user_browser",
                    "inline" => false
                ],
                [
                    "name" => "Ülke",
                    "value" => "{$geoplugin->countryName}",
                    "inline" => true
                ],
                [
                    "name" => "Tarih",
                    "value" => "$time",
                    "inline" => false
                ]
            ]
        ]
    ]
));

$exec = curl_init("$webhook"); 
curl_setopt( $exec, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt( $exec, CURLOPT_POST, 1);
curl_setopt( $exec, CURLOPT_POSTFIELDS, $make_json);
curl_setopt( $exec, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $exec, CURLOPT_HEADER, 0);
curl_setopt( $exec, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec( $exec );
?>
