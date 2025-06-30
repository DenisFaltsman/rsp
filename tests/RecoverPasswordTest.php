<?php

use PHPUnit\Framework\TestCase;

class RecoverPasswordTest extends TestCase
{
    public function testRecoverSuccessResponse()
    {
        // К черту guzzlehttp, просто курлом запрос сделаем
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://www.rusprofile.ru/auth.php?action=recover&cacheKey=0.23846219583307393',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('login' => 'letore2252@ofacer.com'),
            CURLOPT_HTTPHEADER => array(
                'accept: application/json, text/plain, */*',
                'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7,uk;q=0.6',
                'cache-control: no-cache',
                'origin: https://www.rusprofile.ru',
                'pragma: no-cache',
                'priority: u=1, i',
                'referer: https://www.rusprofile.ru/',
                'sec-ch-ua: "Not(A:Brand";v="99", "Google Chrome";v="133", "Chromium";v="133"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Linux"',
                'sec-fetch-dest: empty',
                'sec-fetch-mode: cors',
                'sec-fetch-site: same-origin',
                'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36',
                'x-csrf-token: d68bb38bb639f3f93499e31fcc2d6cec::7c54b1b0e77d3581b322f61fe3ef3ca59da18b3221870f22c60d7d55d0b186da',
                'Cookie: sp=afc644cd-f887-49a8-a188-a8fe4b8e525e; _gb_id=5027363042247543447; email=letore2252%40ofacer.com; _gb_ab_rpf-9052=OUT_OF_EXP; _gb_ab_rpf-9856_pro_plus=B1; _gb_ab_rpf-10317=A; sessid=80d7b5136c00ee69cdf3d30ccc1a48ac; fbb_s=1; _ym_uid=1749143958134787984; _ym_d=1749143958; _clck=5bzqzt%7C2%7Cfwz%7C0%7C1982; fbb_u=1751316606; isTouchDevice=0; screenWidth=3440; activeNow=2025-06-30; _sp_ses.6279=*; activeLast=1749493882; __Host-csrf-token=d68bb38bb639f3f93499e31fcc2d6cec::7c54b1b0e77d3581b322f61fe3ef3ca59da18b3221870f22c60d7d55d0b186da; _sp_id.6279=f0310f11-0cc7-41d7-b239-9408c536d895.1749040447.15.1751318999.1750592255.41b48b33-8f44-478d-ad4e-05de86ff7064.fa597f07-db9a-428f-ab83-d4b9c912bbf9.0028490e-23ba-46db-97d3-274156ed8d53.1751316609493.43; _gb_id=6473270741563194343'
            ),
        ));

        $response = curl_exec($curl);

        $data = json_decode($response, true);
        $this->assertIsArray($data, 'Response must be JSON');
        $this->assertArrayHasKey('success', $data, 'Response must contain "success" key');
        $this->assertTrue($data['success'], 'Success is true! Yes!');
        // На мыло приходит
        curl_close($curl);
    }
}
