<?php

  $URL = '<url>';
  $TOKEN = '<access_token>';
  $AUDIO = '<audio_file_path>';

  $ch = curl_init();
  curl_setopt_array($ch, [
    CURLOPT_URL => $URL,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => [
      'file' => new CURLFile($AUDIO),
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
      'Content-type: multipart/form-data',
      "Authorization: Bearer $TOKEN"
    ]
  ]);

  $res = curl_exec($ch);
  curl_close($ch);

  $res = json_decode($res, true);

  if ($res['code'] == 200) {
    foreach ($res['results'] as $d) {
      foreach (array_keys($d) as $key){
        print($key . ':'. $d[$key] . "\n");
      }
    }
  } else {
    print($res['code']);
    print($res['error']['message']);
  }
