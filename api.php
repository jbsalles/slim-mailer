<?php

require 'vendor/autoload.php';
include 'db_config.php';

$app = new \Slim\Slim();
$res = $app->response();

$app->config('template.path', './templates');
$res->header('Access-Control-Allow-Origin', '*');
$res->header('Access-Control-Allow-Methods', 'PUT, GET, POST, DELETE, OPTIONS');

$db = new medoo([
		'database_type' => 'mysql',
		'database_name' => $CONFIG['dbname'],
		'server' => 'localhost',
		'username' => $CONFIG['username'],
		'password' => $CONFIG['password'],
		'charset' => 'utf8'
	]);


function sendmail($sender,$receiver, $msg,$id){
	global $CONFIG;

	$msg = htmlentities($msg, ENT_NOQUOTES, "UTF-8");
	$msg = htmlspecialchars_decode($msg);

    $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'ecard/'.$id.'-'.md5($sender.$CONFIG['hashKey']);

	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = $CONFIG['smtp_host'];
	$mail->SMTPAuth = true;
	$mail->Username = $CONFIG['smtp_login'];
	$mail->Password = $CONFIG['smtp_password'];
	$mail->SMTPSecure = 'ssl';
	$mail->Port = $CONFIG['smtp_port'];

	$mail->setFrom($sender, '');
	$mail->addAddress($receiver);
	$mail->addReplyTo($sender, '');

	$mail->AddEmbeddedImage('imgs/border-left.png','border-left.png','border-left.png');
	$mail->AddEmbeddedImage('imgs/border-right.png','border-right.png','border-right.png');
	$mail->AddEmbeddedImage('imgs/header.jpg','header.jpg','header.jpg');
	$mail->AddEmbeddedImage('imgs/footer.png','footer.png','footer.png');
	$mail->AddEmbeddedImage('imgs/border-bottom.png','border-bottom.png','border-bottom.png');

	$mail->isHTML(true);

	$message = '<div style="background:#f2f2f2 "><style type="text/css">';
	$message .= 'table {margin: 0; padding: 20px 0; font-family: Verdana, Helvetica, sans; color:#888; font-size:14px; line-height: 1.5em}.emailContent {width: 100%; max-width:800px;}';
    $message .= '</style>';
	$message .= '<table width="800" height="20"><tr><td width="800">';
    $message .= '<table width="800" style="width: 800px; max-width:800px;" class="emailContent" align="center" cellpadding="0" cellspacing="0" border="0">';
	$message .= '<tr><td valign="top" colspan="3" align="center" style="font-size:11px">';
	$message .= 'Si ce message ne s\'affiche pas correctement, <a href = "http://'.$url.'" > consultez - le en ligne </a >.';
	$message .= '</td></tr>';
	$message .= '<tr   bgcolor="#f2f2f2">';
	$message .= '<td  bgcolor="#f2f2f2" rowspan="3" width="10"><img src="cid:border-left.png" height="500" width="10"></td>';
	$message .= '<td valign="top"  bgcolor="#f2f2f2">';
	$message .= '<img src="cid:header.jpg" width="780">';
	$message .= '</td>';
	$message .= '<td  bgcolor="#f2f2f2" rowspan="3" width="10"><img src="cid:border-right.png"  height="500"></td>';
	$message .= '</tr>';
	$message .= '<tr bgcolor="#ffffff">';
	$message .= '<td  valign="top" style="padding:5%; height:200px" width="780">';
	$message .= '<p style="font-family: Verdana, Helvetica, sans; color:#888; font-size:16px; line-height: 1.5em">';
	$message .= $msg;
	$message .= '</p>';
	$message .= '</td>';
	$message .= '</tr>';
	$message .= '<tr bgcolor="#ffffff">';
	$message .= '<td align="center"  width="780">';
	$message .= '<img src="cid:footer.png" width="523">';
	$message .= '</td>';
	$message .= '</tr>';
	$message .= '<tr bgcolor="#f2f2f2">';
	$message .= '<td width="10"></td><td align="center"  width="780"  bgcolor="#f2f2f2">';
	$message .= '<img src="cid:border-bottom.png" width="780" height="15">';
	$message .= '</td><td width="10"></td>';
	$message .= '</tr>';
	$message .= '</table></td></tr></table></div>';

	$mail->Subject = '[ Ales Groupe ] - Meilleurs voeux 2016 / Best Wishes For 2016';
	$mail->Body = $message;

	$mail->send();
}

function isAjaxCall($app)
{
	return function () use($app) {
		if (!$app->request->isAjax()):
		true; //	$app->halt(403);
		endif;
	};
}

function returnResponse($app, $httpCode = 200, $contentType, $body)
{
	if ($httpCode !== 200):
		$app->response->setStatus($httpCode);
	endif;

	if ($contentType === 'json'):
		$app->response->headers->set('Content-type', 'application/json');	

		return $app->response->write(json_encode($body));
	elseif ($contentType === 'html'):
		$app->response->headers->set('Content-type', 'text/html');
		return $app->response->write($body);
	endif;
}

$app->post('/', isAjaxCall($app), function () use($app, $db) {
	$data = $app->request->post();	$result = array();

	if (empty($data['senderName']) ||
			empty($data['sender']) ||
			empty($data['receiverList']) ||
			empty($data['message'])):

		$result['result'] = 'failed';
		$result['message'] = 'Validation error';
		return returnResponse($app, 200, 'json', $result);
	endif;

   $receiverList = explode(';',$data['receiverList']);

   foreach( $receiverList as $receiver)
   {
	   $dbResult = $db->insert('ecard', [
			   'senderName' => trim($data['senderName']),
			   'sender' => trim($data['sender']),
			   'receiver' => trim($receiver),
			   'message' => urldecode($data['message']),
			'created_at' => 'NOW()'
		]);

	   sendmail(trim($data['sender']),trim($receiver),urldecode($data['message']),intval($dbResult));
   }

	if ($dbResult):
		$result['result'] = 'success';

		return returnResponse($app, 200, 'json', $result);
	else:
		$result['result'] = 'failed';
		$result['message'] = 'Database Error: insert failed';

		return returnResponse($app, 500, 'json', $result);
	endif;
});



