<?php
echo "SHODAN ACCOUNT CREATOR - IdiotPeople69\n";
echo "Edit on this file, if you want to change the password\n";
echo "Username : ";
$username = trim(fgets(STDIN));
echo "Email : ";
$email = trim(fgets(STDIN));
$header = array (
"accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
"Sec-Ch-Ua-Mobile" => "?0",
"Sec-Ch-Ua-Platform" => "Windows",
"Content-type" => "application/x-www-form-urlencoded",
"Origin" => "https://account.shodan.io",
"Referer" => "https://account.shodan.io/login",
"User-Agent" => "Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Mobile Safari/537.36"
);
$password = "Qazxsw123@";
$cookie = "cookie.txt";
$url = "https://account.shodan.io/register";
$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__).$cookie);
curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__).$cookie);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$csrf = curl_exec($curl);
$res = curl_getinfo($curl, CURLINFO_HTTP_CODE);
if($res == 200){
echo "Sukses Generate CSRF Token\n";
sleep(1);
};
$dom = new domDocument();
@$dom->loadHTML($csrf);
$tokens = $dom->getElementsByTagName("input");
for ($i = 0; $i < $tokens->length; $i++)
{
    $meta = $tokens->item($i);
    if($meta->getAttribute('name') == 'csrf_token')
    $token = $meta->getAttribute('value');
}
$data = array (
"username" => "$username",
"password" => "$password",
"password_confirm" => "$password",
"email" => "$email",
"csrf_token" => "$token",
);

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__).$cookie);
curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__).$cookie);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, ($data));
$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$result = curl_exec($curl);

echo "[+] Process Register account "."\n";
sleep(1);
if(preg_match_all('/<p class="warn">That username already exists.<\/p>/', $result)) {
echo "Register Failed!, Maybe Username is Already Used\n";
}else{
echo "Register Success! - Saved to saved.txt\n";
echo "Check Your Email To Verify the Account\n";
$fp = fopen("saved.txt", 'a');
$x = fwrite($fp, "Email : ".$email."\n"."Username : ".$username."\n"."Password : ".$password."\n\n");
}
?>
