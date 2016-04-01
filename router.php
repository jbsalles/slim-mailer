<?php
$app->get('/', function () use($app) {
    $app->render('page.php');
});

$app->get('/ecard/:hash',  function ($hash) use($app, $db) {
    global $CONFIG;
    $id=explode('-',$hash);
    $query = "SELECT id,sender,message FROM ecard WHERE id=".$id[0];
    $result = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);

    $token = md5($result[0]['sender'].$CONFIG['hashKey']);

    if($token==$id[1])
      $app->render('ecard.php',['body' => $result[0]['message']]);
    else
        echo "error";
});