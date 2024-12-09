<?php
$lockFile = '/tmp/get_public_holidays.lock';
if (file_exists($lockFile)) {
    echo "Script already running. Exiting...\n";
    exit;
}
file_put_contents($lockFile, getmypid());
$current_dir = __DIR__;

while ($current_dir != '/' && !file_exists($current_dir . '/index.php')) {
    $current_dir = dirname($current_dir);
}
require_once $current_dir . '/vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable($current_dir);
$dotenv->load();
require('/var/www/html/presence.dev-hub.ro/goAPI/config.php');
$db = new Database();

$apiKey = $_ENV['holidays_key'];
$country = "RO";
$year = 2025;
$apiUrl = "https://calendarific.com/api/v2/holidays?api_key=$apiKey&country=$country&year=$year";
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPGET => true,
]);
$response = curl_exec($curl);
if (curl_errno($curl)) {
    echo "cURL Error: " . curl_error($curl);
    curl_close($curl);
    exit;
}

curl_close($curl);
$data = json_decode($response, true);

$translation_map = [
    "New Year's Day" => "Anul Nou",
    "Day after New Year's Day" => "A doua zi de Anul Nou",
    "Epiphany" => "Boboteaza",
    "Synaxis of St. John the Baptist" => "Sinaxa Sfântului Ioan Botezătorul",
    "Unification Day" => "Ziua Unirii Principatelor Române",
    "Constantin Brancusi Day" => "Ziua Constantin Brâncuși",
    "Dragobete" => "Dragobetele",
    "Mărțișor" => "Mărțișor",
    "International Women's Day" => "Ziua Internațională a Femeii",
    "March Equinox" => "Echinoctiul de primăvară",
    "Labor Day / May Day" => "Ziua Muncii",
    "Orthodox Good Friday" => "Vinerea Mare",
    "Orthodox Easter Day" => "Paștele Ortodox",
    "Mothers' Day" => "Ziua Mamei",
    "Orthodox Easter Monday" => "A doua zi de Paște",
    "Monarchy Day" => "Ziua Monarhiei",
    "National Independence Day" => "Ziua Independenței Naționale",
    "Fathers' Day" => "Ziua Tatălui",
    "Children's Day" => "Ziua Copilului",
    "Orthodox Ascension Day" => "Înălțarea Domnului",
    "June Solstice" => "Solstițiul de vară",
    "Orthodox Pentecost" => "Rusaliile",
    "Orthodox Pentecost Monday" => "A doua zi de Rusalii",
    "Flag Day" => "Ziua Drapelului",
    "National Anthem Day" => "Ziua Imnului Național",
    "St Mary's Day" => "Adormirea Maicii Domnului",
    "September Equinox" => "Echinoctiul de toamnă",
    "Halloween" => "Halloween",
    "St Andrew's Day" => "Sfântul Andrei",
    "National Day" => "Ziua Națională a României",
    "Constitution Day" => "Ziua Constituției",
    "December Solstice" => "Solstițiul de iarnă",
    "Christmas Eve" => "Ajunul Crăciunului",
    "Christmas Day" => "Crăciunul",
    "Second day of Christmas" => "A doua zi de Crăciun",
    "New Year's Eve" => "Revelion"
];


if (isset($data['response']['holidays'])) {
    $delete_holidays = "DELETE FROM public_holidays WHERE date LIKE '$year%'";
    $db->query($delete_holidays);
    foreach ($data['response']['holidays'] as $holiday) {
        if(in_array("National holiday", $holiday['type']) || in_array("Public holiday", $holiday['type'])) {
            $holiday_name = $holiday['name'];

            if (isset($translation_map[$holiday_name])) {
                $translated_name = $translation_map[$holiday_name];
            } else {
                $translated_name = $holiday_name;
            }
            $translated_name = addslashes($translated_name);

            $date = new DateTime($holiday['date']['iso']);
            $holiday_date = $date->format('Y-n-j');
            $insert_holiday = "INSERT INTO public_holidays (name, date) VALUES ('$translated_name', '$holiday_date')";
            $db->query($insert_holiday);
        }
    }
} else {
    echo "Error: Could not fetch holidays. Please check your API key and parameters.\n";
}
unlink($lockFile);
?>