<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<?php
define("URL", "http://localhost:8000/test");
//$answer = file_get_contents(URL);
//echo $answer;
$url = URL;
$params_array =[ array(
    'student' => "1", // в http://localhost/post.php это будет $_POST['param1'] == '123'
    'session' => "1", // в http://localhost/post.php это будет $_POST['param2'] == 'abc'
    'interaction' => "1",
    'leftBorder' => "1",
    'rightBorder' => "9"
),
    array(
        'student' => "1", // в http://localhost/post.php это будет $_POST['param1'] == '123'
        'session' => "1", // в http://localhost/post.php это будет $_POST['param2'] == 'abc'
        'interaction' => "1",
        'leftBorder' => "6",
        'rightBorder' => "6"
    ),
    array(
        'student' => "1", // в http://localhost/post.php это будет $_POST['param1'] == '123'
        'session' => "1", // в http://localhost/post.php это будет $_POST['param2'] == 'abc'
        'interaction' => "1",
        'leftBorder' => "6",
        'rightBorder' => "7"
    ),
    ];
foreach ($params_array as $params) {
    $result = file_get_contents($url, false, stream_context_create(array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($params)
        )
    )));

    $obj = json_decode($result);
    foreach ($obj as $key=>$value)
    {
        $value = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
        }, $value);
        $obj->$key = urldecode($value);
    }
    $json = json_encode($obj);

    echo $json;
}
?>
</body>
</html>
