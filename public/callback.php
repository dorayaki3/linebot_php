<?php
 
$accessToken = 'IPLZVNBSk++TdfiVDGm1eWXBNI45nlOQwUFwwpHa91Co25o9LiB/utwiQeO4ZRwea7AJpF3jlc7Od54XT1dN5DDtc91VBJw2n0TyRqQ6GHXQTf0gu5xUGdFX+k1r/a4iGyFlJMp2RDchtmTpcMmP9QdB04t89/1O/w1cDnyilFU=';

$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);

$replyToken = $json_object->{"events"}[0]->{"replyToken"};        //返信用トークン
$message_type = $json_object->{"events"}[0]->{"message"}->{"type"};    //メッセージタイプ
$message_text = $json_object->{"events"}[0]->{"message"}->{"text"};    //メッセージ内容
 
//返信メッセージ
$return_message_text = "8月中にはなにかしゃべらせたい。以降はメモ。herokuでコードはgithub" ;
$now =  $objDateTime->format('Y-m-d H:i:s') ;

if($text == "\neko"){
    $neko = "にゃーん";
    sending_messages($accessToken, $replyToken, $message_type, $neko);
}

else{
sending_messages($accessToken, $replyToken, $message_type, $return_message_text);
sending_messages($accessToken, $replyToken, $message_type, $now);
}
?>

<?php
//メッセージの送信
function sending_messages($accessToken, $replyToken, $message_type, $return_message_text){
    //レスポンスフォーマット
    $response_format_text = [
        "type" => $message_type,
        "text" => $return_message_text
    ];
 
    //ポストデータ
    $post_data = [
        "replyToken" => $replyToken,
        "messages" => [$response_format_text]
    ];
 
    //curl実行
    $ch = curl_init("https://api.line.me/v2/bot/message/reply");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8',
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    curl_close($ch);
}
?>