<?php

session_start();
//developers.line.me
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}


require "vendor/autoload.php";

if($link_mysql == false) {

$MYSQL_SERVER="127.0.0.1";
$MYSQL_USER="smartschool";
$MYSQL_PASS="smartschool456";
$MYSQL_DB="smartschool";
$link_mysql=mysqli_connect($MYSQL_SERVER,$MYSQL_USER,$MYSQL_PASS,$MYSQL_DB,NULL, '/var/lib/mysql/mysql.sock');

     mysqli_select_db($link_mysql, $MYSQL_DB) or die ("no database");
     mysqli_query($link_mysql,"SET character_set_results=utf8");
    mysqli_query($link_mysql,"SET character_set_client=utf8");
     mysqli_query($link_mysql,"SET character_set_connection=utf8");
}



function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear,เวลา $strHour:$strMinute";
	}



function getuser_profile($a){
  $b=print_r($a,true);
  $text_ex = explode('=>', $b) ;
  $text_ex[2]=str_replace('}', NULL, $text_ex[2]);
  $text_ex[2]=str_replace('{', NULL, $text_ex[2]);
  $user_profle=explode(',', $text_ex[2]) ;
  $a=explode(':', $user_profle[0]) ;
  $a[1]=str_replace('"', NULL, $a[1]);
  $user_profle_data['displayName']=$a[1];
  $a=explode(':', $user_profle[1]) ;
  $a[1]=str_replace('"', NULL, $a[1]);
  $user_profle_data['userId']=$a[1];
  $a=explode(':', $user_profle[2]) ;
  $a[2]=str_replace('"', NULL, $a[2]);
  $a[2]=str_replace('//', NULL, $a[2]);
  $user_profle_data['pictureUrl']='http://'.$a[2];
  $a=explode(':', $user_profle[3]) ;
  $user_profle_data['statusMessage']=$a[1];
  return $user_profle_data;
}




function objectToArray($d)
{
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return array_map(__FUNCTION__, $d);
    } else {
        // Return array
        return $d;
    }
}




//สร้างการเชื่อมต่อ line api
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('od+PiQERR00IzMSuVMVb+hSYQk5J8QIbcq7+C/S9z16pNDJwgn24hZgCe1CPW/qJBpAeNhG/iodo0Og51WJ9GlhX3vuexXb5NyFCeAOtXfS/vF4Edo8uffYTWXbqbyOsaD3oe56qK6+1fGfw4E7wVQdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => 'd35578662d01550b89fdadc466fa1641']);

// start Log
//log
$file = '/tmp/debug.log';
// Open the file to get existing content
$current = file_get_contents($file)."\r\n";

// รับ input text
$json_string = file_get_contents('php://input');
$jsonObj = json_decode($json_string); //รับ JSON มา decode เป็น StdObj
$json_string2=objectToArray($jsonObj);
$array = json_decode(json_encode($json_string2), True);

//
$to =  $array['events'][0]['source']['userId']; //หาผู้ส่ง
$text = $array['events'][0]['message']['text']; //หาข้อความที่โพสมา
$text=str_replace('  ', ' ', $text);
$text=str_replace("\r", NULL, $text);
$text=str_replace("\n", NULL, $text);


//ดึงชื่อ user
$a=$bot->getProfile($to);
$user_profle=getuser_profile($a);
$displayName=$user_profle['displayName'];
$userId=$user_profle['userId'];
$pictureUrl=$user_profle['pictureUrl'];
$statusMessage=$user_profle['statusMessage'];



$result_text=NULL;

if ($text==NULL) {
     $result_text ='ค่ะ ดีค่ะ '.$user_profle['displayName'];
   }



   if((strstr($text, 'บันทึก') !== false)  and (strstr($text, '@') !== false) and (strstr($text, ' ') !== false)  ) {

     $t_ex1 = explode(' ', $array['events'][0]['message']['text']) ; //เอาข้อความมาแยก : ได้เป็น Array
     $text_ex1 = explode('@', $t_ex1[1]) ; //เอาข้อความมาแยก : ได้เป็น Array
     $data_text=$text_ex1[0];
     $data_text1=$text_ex1[1];
     $SQL_Event_code="insert into ques (que,ans,status,ip_add)value('$data_text','$data_text1','1','$userId') ";
      mysqli_query($link_mysql,$SQL_Event_code)or die(mysqli_error($link_mysql));
      $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('หนูบันทึก คำศัพท์  ไว้แล้วค่ะ ขอบคุณมากน่ะค่ะ ');
      $response = $bot->replyMessage($array['events'][0]['replyToken'], $textMessageBuilder);
      exit();
   }



if(strstr($text, 'ยอดการขายบัตรเน็ต') !== false){
  $result_text="สองล้านบาทค่ะ นายท่าน";
  $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($result_text);
  $response = $bot->replyMessage($array['events'][0]['replyToken'], $textMessageBuilder);
  exit();
}

if(strstr($text, 'มีเพื่อน') !== false and strstr($text, 'กี่คน') !== false ){
  $SQL_Event_code="select  userId as t from msg_data group by userId";
  $result_EVENT = mysqli_query($link_mysql,$SQL_Event_code)or die(mysqli_error($link_mysql));
  $i=1;

 while ($row = mysqli_fetch_assoc($result_EVENT)) {
      $i++;
     }
  $result_text=$user_profle['displayName'].'  ตอนนี้ในระบบของหนู มี เพื่อน ทั้งหมด '.$i.' คนค่ะ';
  $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($result_text);
  $response = $bot->replyMessage($array['events'][0]['replyToken'], $textMessageBuilder);
  exit();

}

if(strstr($text, 'เวลา') !== false){
  $result_text="Time ".date("Y-m-d H:i").' นาทีค่ะ';
  $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($result_text);
  $response = $bot->replyMessage($array['events'][0]['replyToken'], $textMessageBuilder);
  exit();
}

if((strstr($text, 'radius') !== false or  strstr($text, 'ระบบออเทน') or  strstr($text, 'เรเดี้ยน') or  strstr($text, 'ออเทน') or  strstr($text, 'authen')) and $result_text == NULL ) {
    $result_text ='อื่ม '.$user_profle['displayName'].' ค่ะ ถ้าจะหาระบบ ออเทน ดี ๆ ลอง หา  jetradius  หรือ easytik  ดูครับ ราคาถูกใช้งาย ดี';

if( $result_text !=''){
    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($result_text);
    $response = $bot->replyMessage($array['events'][0]['replyToken'], $textMessageBuilder);
}
    //เซฟข้อความที่คุยไว้

     $statusMessage_data=print_r($statusMessage,true)."\r\n";

      $SQL="insert into msg_data (displayName,userId,pictureUrl,statusMessage,quz,ans)
                  value('$displayName','$userId','$pictureUrl','$statusMessage_data','$text','$result_text');";
      mysqli_query($link_mysql,$SQL) ;

      // LOG data
      $current .= $SQL."\r\n";
      $current .=print_r($user_profle,true)."\r\n";
      $current .= print_r($response,true);
       // Write the contents back to the file
      file_put_contents($file, $current);
      exit();
  }


//ถ้ามีคำว่าวันนี้มา ก็แสดง วันที่ปัจุบันไป
if($text=='วันนี้' or $text=='วันนี้วันอ่ะไร' or $text=='วันนี้วันที่' or $text=='อยากรู้วันนี้' or $text=='วันนี้คือ' or $text=='วันที่ ปัจจุบัน' or $text=='วันที่ปัจจุบัน'){
  $result_text="วันนี้วันที่ ".DateThai(date("d-m-Y H:i:s"));
  $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($result_text);
  $response = $bot->replyMessage($array['events'][0]['replyToken'], $textMessageBuilder);
  exit();
}



if($text=='uptime'){
$result_text = system('uptime', $retval);
$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($result_text);
$response = $bot->replyMessage($array['events'][0]['replyToken'], $textMessageBuilder);
exit();
}

if($text=='hostname'){
$result_text = system('hostname', $retval);
$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($result_text);
$response = $bot->replyMessage($array['events'][0]['replyToken'], $textMessageBuilder);
exit();
}

if($text=='disk use'){
$result_text = system('df -h', $retval);
$result_text=str_replace("\r", " ", $result_text);
$result_text=str_replace("\n", " ", $result_text);
$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($result_text);
$response = $bot->replyMessage($array['events'][0]['replyToken'], $textMessageBuilder);
exit();
}

if((strstr($text, 'สภาพอากาศ'))  and $result_text == NULL ) {
  #/api/514b4f52d38c9e81/forecast/lang:TH/q/Thailand/กรุงเทพ.json
//แตก array  หาพื้นที่
$text_ex = explode(' ', $array['events'][0]['message']['text']) ; //เอาข้อความมาแยก : ได้เป็น Array

if($text_ex[1]=='')
{
  $areia=$text_ex[2];
} else {
  $areia=$text_ex[1];
}




if($areia=='โคราช') { $areia='นครราชสีมา'; }
$current .= 'data text  สภาพอากาศ';
$current .= print_r($text_ex,true);

$SQL_Event_code="select * from temperature where StationNameTh ='$areia' limit 0,1";
$result_EVENT = mysqli_query($link_mysql,$SQL_Event_code)or die(mysqli_error($link_mysql));
$Row_EVENT = mysqli_fetch_array($result_EVENT,MYSQLI_ASSOC);

$StationNameTh=$Row_EVENT['StationNameTh'];
$StationNameEng=$Row_EVENT['StationNameEng'];
$Temperature=$Row_EVENT['Temperature'];
$MaxTemperature=$Row_EVENT['MaxTemperature'];

           if($Temperature !=NULL){
                $result_text = $user_profle['displayName']." ค่ะ สภาพอากาศ $StationNameTh ($StationNameEng) อุณหภูมิโดยเฉลี่ย $Temperature celcius  สูงสุด $MaxTemperature celcius";

            }else{//ถ้าไม่เจอกับตอบกลับว่าไม่พบข้อมูล
                $result_text = $user_profle['displayName'].'ไม่พบข้อมูล สภาพอากาศ '.$areia.' เนื่องจากหนูหาในฐานข้อมูลไม่เจอค่ะ';
            }

            if( $result_text !=''){
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($result_text);
                $response = $bot->replyMessage($array['events'][0]['replyToken'], $textMessageBuilder);
            }

            //เซฟข้อความที่คุยไว้
            $statusMessage_data=print_r($statusMessage,true)."\r\n";
              $SQL="insert into msg_data (displayName,userId,pictureUrl,statusMessage,quz,ans)
                          value('$displayName','$userId','$pictureUrl','$statusMessage_data','$text','$result_text');";
               mysqli_query($link_mysql,$SQL) ;
               // LOG data
               $current .= $SQL."\r\n";
               $current .=print_r($user_profle,true)."\r\n";
               $current .= print_r($response,true);
                // Write the contents back to the file
               file_put_contents($file, $current);
            exit();

    }


if((strstr($text, 'ค้นหา') !== false)  and $result_text == NULL  ) {
              //ถ้าข้อความคือ "อยากรู้" ให้ทำการดึงข้อมูลจาก Wikipedia
              //หาจากไทยก่อน //https://en.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro=&explaintext=&titles=PHP
      $text_ex = explode(' ', $text); //เอาข้อความมาแยก : ได้เป็น Array
      $current .= 'data text  search wiki';
      $current .= print_r($text_ex,true);
      if($text_ex[1]=='')
      {
        $areia=$text_ex[2];
      } else {
        $areia=$text_ex[1];
      }
      $ch1 = curl_init();
      curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch1, CURLOPT_URL, 'https://th.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro=&explaintext=&titles='.strtoupper($areia));
      $result1 = curl_exec($ch1);
      curl_close($ch1);

      $obj = json_decode($result1, true);

          foreach($obj['query']['pages'] as $key => $val)
                { $result_text = $val['extract']; }

          if($result_text==''){//ถ้าไม่พบให้หาจาก en $ch1 = curl_init();
            $ch1 = curl_init();
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch1, CURLOPT_URL, 'https://en.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro=&explaintext=&titles='.strtoupper($areia));
            $result1 = curl_exec($ch1);
            curl_close($ch1);

            $obj = json_decode($result1, true);


                   foreach($obj['query']['pages'] as $key => $val)
                          {
                            if($val['extract'] !=''){ $result_text = 'ข้อมูลจากเว็บ WiKi '.$val['extract']; } }}
                              if($result_text==''){//หาจาก en ไม่พบก็บอกว่า ไม่พบข้อมูล ตอบกลับไป
                                $result_text = 'ไม่พบข้อมูล คำค้น "'.$areia.'" เนื่องจากหนูหาในฐานข้อมูลไม่เจอค่ะ'; }

                                if( $result_text !=''){
                                    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($result_text);
                                    $response = $bot->replyMessage($array['events'][0]['replyToken'], $textMessageBuilder);
                                }
                                //เซฟข้อความที่คุยไว้
                                $statusMessage_data=print_r($statusMessage,true)."\r\n";
                                $SQL="insert into msg_data (displayName,userId,pictureUrl,statusMessage,quz,ans)
                                              value('$displayName','$userId','$pictureUrl','$statusMessage_data','$text','$result_text');";
                                mysqli_query($link_mysql,$SQL) ;

                                // LOG data
                                $current .= $SQL."\r\n";
                                $current .=print_r($user_profle,true)."\r\n";
                                $current .= print_r($response,true);
                                 // Write the contents back to the file
                                file_put_contents($file, $current);

                                  exit();

     }






      if( $text !=''   and $result_text == NULL ){





      $SQL_Event_code="select ans from ques where que like '%$text%' and status='1' ";
      $result_EVENT = mysqli_query($link_mysql,$SQL_Event_code)or die(mysqli_error($link_mysql));
      //$row_cnt = mysqli_num_rows($result_EVENT);
       $i=1;
      while ($row = mysqli_fetch_assoc($result_EVENT)) {
         $data[$i]=$row['ans'];
         $i++;
          }
       //random คำตอบมาจะได้ไม่น่าเบื่อ
         if( $i > 1 ){
           $ar=rand(1,$i);
           $result_text=$data[$ar];
         } else{
           $row = mysqli_fetch_assoc($result_EVENT);
           $result_text=$row['ans'];
         }
         if($result_text=='' or $result_text==NULL or $result_text==' '  ){
           $SQL_Event_code="select ans from ques where que like '%$text%' and status='1' limit 0,1";
           $result_EVENT = mysqli_query($link_mysql,$SQL_Event_code)or die(mysqli_error($link_mysql));
           $row = mysqli_fetch_assoc($result_EVENT);
           $result_text=$row['ans'];
         }

           if($result_text=='' ){
             $result_text='ยินดีบริการค่ะ  คุณ '.$displayName ;
                       if($userId=='U01775d5db2200e331a2cac9a648a9731'){
                         $result_text.=' DEBUG=>'.$text.$row['ans'].'  ';
                       }
             //$result_text .=  "\r\nสามารถ สอนหนู ได้โดยสั่ง  'บันทึก  เว้นวรรค  คำถาม@คำตอบ' เช่น บันทึก  แมว@แมวคือสัตว์ชนิดหนึ่ง";
           }

      if( $result_text !=''){
          $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($result_text);
          $response = $bot->replyMessage($array['events'][0]['replyToken'], $textMessageBuilder);
      }


      //เซฟข้อความที่คุยไว้
       $statusMessage_data=print_r($statusMessage,true)."\r\n";
        $SQL="insert into msg_data (displayName,userId,pictureUrl,statusMessage,quz,ans)
                    value('$displayName','$userId','$pictureUrl','$statusMessage_data','$text','$result_text');";
        mysqli_query($link_mysql,$SQL) ;

        // LOG data
        $current .= $SQL."\r\n";
        $current .= print_r($user_profle,true)."\r\n";
        $current .= print_r($response,true);
         // Write the contents back to the file
        file_put_contents($file, $current);
          if($row['ans'] !=''){
                  exit();
          }
    }


            $current .=  "ไม่มีข้อมูลจะส่ง\r\n";
            $current .= print_r($result_text,true);
             // Write the contents back to the file
            file_put_contents($file, $current);
          //  $result_text ="ขอโทษค่ะ $displayName หนูโง่ไม่เข้าใจคำถาม พี่แอดมินสุดหล่อยังไม่สอนหนู ให้รู้จักคำว่า ".'"'.$text.'"';


            if( $result_text ==''){

              $ch1 = curl_init();
              curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
              curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch1, CURLOPT_URL, 'https://en.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro=&explaintext=&titles='.strtoupper($text));
              $result1 = curl_exec($ch1);
              curl_close($ch1);

              $obj = json_decode($result1, true);


                     foreach($obj['query']['pages'] as $key => $val)
                            {
                           if($val['extract'] !=''){ $result_text = 'หนู หาเจอใน ข้อมูลจากเว็บ WiKi '.$val['extract']; }


                             }

                $result_text .="\r\n  \r\n $displayName ค่ะ ถ้าอยากหา ข้อมูล  พิมพ์ ค้นหา เว้นวรรค  คำที่ต้องการ \r\n หรือถามสถาพอากาศ  พิมพ์ สภาพอากาศ เว้นวรรค ชื่อจังหวัด ค่ะ";
                $result_text .=  "\r\n".'สามารถ สอนหนู ได้โดยสั่ง  บันทึก  เว้นวรรค  คำถาม@คำตอบ เช่น บันทึก  แมว@แมวคือสัตว์ชนิดหนึ่ง';
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($result_text);
                $response = $bot->replyMessage($array['events'][0]['replyToken'], $textMessageBuilder);

            }


//คำถามใหนยังไม่มีคำตอบให้แอดรอไว้
if($text !=''  ){
  $SQL_Event_code="select que from ques where que = '$text'  ";
  $result_EVENT = mysqli_query($link_mysql,$SQL_Event_code)or die(mysqli_error($link_mysql));
  $row = mysqli_fetch_assoc($result_EVENT);
        if($row['que']==''){
        $SQL="insert into ques (que,ans)
                    value('$text','-----------');";
        mysqli_query($link_mysql,$SQL) ;
        }
}

            //เซฟข้อความที่คุยไว้
            $statusMessage_data=print_r($statusMessage,true)."\r\n";
            $SQL="insert into msg_data (displayName,userId,pictureUrl,statusMessage,quz,ans)
                          value('$displayName','$userId','$pictureUrl','$statusMessage_data','$text','$result_text');";
            mysqli_query($link_mysql,$SQL) ;

            // LOG data
            $current .= $SQL."\r\n";
            $current .=print_r($user_profle,true)."\r\n";
            $current .= print_r($response,true);
             // Write the contents back to the file
            file_put_contents($file, $current);




              exit();









 ?>
