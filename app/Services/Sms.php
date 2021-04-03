<?php



namespace App\Services;



use App\Http\Core\Models\Setting;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Matrix\Exception;

class Sms

{
    private $username;

    private $password;

    private $from;

    private $url;


    /**

     * Sms constructor.
     * @param string $username
     * @param string $password
     * @param string $from
     * @param string $url

     */

    public function __construct($username = null, $password = null, $from = null, $url = null)

    {

        if ($username)

            $this->username = $username;

        else
            $this->username = config('services.sms.username');

        if ($password)
            $this->password = $password;
        else
            $this->password = config('services.sms.password');

        if ($from)

            $this->from = $from;
        else
            $this->from = config('services.sms.from');

        if ($url)
            $this->url = $url;
        else
            $this->url =  config('services.sms.url');

    }



    /**

     * @param string $message

     * @param array $to

     * @return mixed

     */

    public function send($message, $to)
    {
        $params = [
            'uname' => $this->username,
            'pass' => $this->password,
            'from' => $this->from,
            'message' => $message,
            'to' => json_encode($to),
            'op' => 'send'
        ];

        $handler = curl_init($this->url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($handler, CURLOPT_POSTFIELDS, $params);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handler);

        return json_decode($response);
    }

    /**

     * @param array $message

     * @param $to

     * @param int $pattern

     * @return mixed

     */
    public function sendwithpattern($message, $to,$pattern)

    {

        $username =  $this->username;
        $password = $this->password;
        $from =     $this->from;
        $pattern_code = $pattern;
        $to = array($to);
        $input_data = $message;
        $url = $this->url ."/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
        //$handler = curl_init($url);
//        dd($url);
//        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
//        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
//        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
//        $response = curl_exec($handler);
//        echo $response;
        $client = new Client(['verify' => false]);
        try {
            $sms = $client->get($url);

        }catch (Exception $exception){
            Log::info($exception);
            return null;
        }
        return $sms;

    }

}

