<?php
$access_token = 'RuHhciFle36XBJXielhR22aO689nyDsFjrzG0mBBDMvlqTsIWxBJgAdBh5LiyedayUBGmHtd0q4bxYJDbmozMr609DXroXmOyKABrJuGzd9iLpbWcKazlbwlMOORJeAxdVcOYSu8yoaAGANJpSUdqQdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			switch ($text) {
				case 'สวัสดี':
					$msg1 = [
						'type' => 'text',
						'text' => 'สวัสดีครับ'
	  			];
					$msg2 = [
						'type' => 'text',
						'text' => 'มีอะไรให้ช่วยไหม?'
	  			];
					$stk = [
						"type" => "sticker",
					  "packageId" => "1",
					  "stickerId" => "106"
					];
					$rep_msg = [
						'reply' => [ $msg1, $msg2, $stk ]
					];
					// $messages = { $msg1, $msg2 };
					break;
				case 'อากาศ':
					$ch1 = curl_init();
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch1, CURLOPT_URL, 'http://api.wunderground.com/api/cf7dc205e34e58be/forecast/lang:TH/q/Thailand/%E0%B8%81%E0%B8%A3%E0%B8%B8%E0%B8%87%E0%B9%80%E0%B8%97%E0%B8%9E%E0%B8%A1%E0%B8%AB%E0%B8%B2%E0%B8%99%E0%B8%84%E0%B8%A3.json');
            $result1 = curl_exec($ch1);
            curl_close($ch1);

            $obj = json_decode($result1, true);
            if(isset($obj['forecast']['txt_forecast']['forecastday'][0]['fcttext_metric'])){
                $result_text = $obj['forecast']['txt_forecast']['forecastday'][0]['fcttext_metric'];
            }else{
                $result_text = 'ไม่พบข้อมูล';
            }
						$msg1 = [
							'type' => 'text',
							'text' => $result_text
						];
						$rep_msg = [
							'reply' => [ $msg1 ]
						];
					break;
				case 'รูป':
					$msg1 = [
						"type" => "image",
				    "originalContentUrl" => "https://www.mangoplug.com/modules/core/client/img/brand/djkhaled.jpg",
				    "previewImageUrl" => "https://www.mangoplug.com/modules/core/client/img/brand/djkhaled.jpg"
					];
					$rep_msg = [
						'reply' => [ $msg1 ]
					];
					break;
				case 'วิดีโอ':
					$msg1 = [
						"type" => "video",
						"originalContentUrl" => "https://www.mangoplug.com/modules/core/client/img/brand/doyoumind.mp4",
						"previewImageUrl" => "https://www.mangoplug.com/modules/core/client/img/brand/djkhaled.jpg"
					];
					$rep_msg = [
						'reply' => [ $msg1 ]
					];
					break;
				case 'เพลง':
					$msg1 = [
						"type" => "audio",
						"originalContentUrl" => "https://www.mangoplug.com/modules/core/client/img/brand/doyoumind.mp3",
						"previewImageUrl" => "https://www.mangoplug.com/modules/core/client/img/brand/djkhaled.jpg"
					];
					$rep_msg = [
						'reply' => [ $msg1 ]
					];
					break;
				default:
				$messages = [
					'type' => 'text',
					'text' => 'out'
				];
					break;
			}

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			// $msg1 = [
			// 	"type" => "text",
			// 	"text" => "สวัสดีครับ2"
			// ];
			$msg2 = [
				"type" => "text",
				"text" => "มีอะไรให้ช่วยไหม?"
			];
			$stk = [
				"type" => "sticker",
			  "packageId" => "1",
			  "stickerId" => "2"
			];
			$reply_msg = [$msg1, $msg2, $stk];
			$data = [
				'replyToken' => $replyToken,
				'messages' => $rep_msg['reply']
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";

?>
