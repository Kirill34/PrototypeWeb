<?php

$json  = file_get_contents("http://localhost:8000/test?paramList=1", false, stream_context_create(array(
    'http' => array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => http_build_query(['paramList'=>'1'])
    )
)));

$obj = json_decode($json);
$obj->return = "Возвращаемое значение";
$counter = 0;
foreach ($obj as $key=>$value)
{
    $value = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
        return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
    }, $value);


    $onchange="$.post('api.php', 'student=1&interaction=5&parameter=$key&type='+this.value, function (data) {
     obj = JSON.parse(data);
     console.log(obj.correct);
     document.getElementById('$key-type-message').innerHTML = obj.message;
     document.getElementById('$key-type-form').style.background = (obj.correct === 'true') ? '#d1e7dd' : '#e9b4b4';
     document.getElementById('$key-type-form').style.color = (obj.correct === 'true') ? '#024f2d' : '#4f0303';
     if (obj.correct == 'true') lockSelect('component-types', $counter);
     document.getElementById('$key-type-message').style.background = document.getElementById('$key-type-form').style.background;
     })";

    echo
    "<form class='row' id='$key-type-form' style='padding-bottom: 50px; padding-top: 50px; font-size: x-large;'>
    <p class='col-sm-3'>$key</p>
    <select class='col-sm-3' onchange=\"$onchange\">
      <option selected disabled>...</option>
      <option value='Type_Int'>int</option>
      <option value='Type_PointerToInt'>int *</option>
      <option value='Type_Float'>float</option>
      <option value='Type_Char'>char</option>
      <option value='Type_UnsignedInt'>unsigned int</option>
      <option value='Type_ArrayInt3'>int [3]</option>
      <option value='Type_StructDate'>struct Date</option>
</select>
</form>
<p class='row' id='$key-type-message'>
</p>
";
    $counter ++;

    //echo $key." ".$value."<br>";
}
?>