<?php

namespace App\Services;

use App\Models\User;

class FonnteService
{
    private $apiToken;
    private $apiUrl = 'https://api.fonnte.com/send';

    public function __construct()
    {
       
        $this->apiToken = User::where('jabatan', 'Tata Usaha')
                            ->whereNotNull('fonnte_token')
                            ->value('fonnte_token');
        
        if (empty($this->apiToken)) {
            throw new \Exception("Tidak ada token Fonnte yang tersedia untuk Tata Usaha");
        }
    }

    public function sendMessage(array $parameters)
    {
        $curl = curl_init();

        if (isset($parameters['file'])) { 
            $parameters['file'] = new \CURLFile($parameters['file']);
        }

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $parameters,
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . $this->apiToken
            ],
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if ($error) {
            throw new \Exception("cURL Error: " . $error);
        }

        $decodedResponse = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Invalid JSON response: " . $response);
        }

        return $decodedResponse;
    }
}