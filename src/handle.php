<?php
//converse obj to array
function objectToArray($d)
{
    if (is_object($d)) {
        $d = get_object_vars($d);
    }
    if (is_array($d)) {
        return array_map(__FUNCTION__, $d);
    } else {
        return $d;
    }
}

//get user profile with UID
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

 ?>
