<?php

$json  = file_get_contents("http://localhost:8000/test?componentList=1", false, stream_context_create(array(
    'http' => array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => http_build_query(['componentList'=>'1'])
    )
)));

$obj = json_decode($json);
$counter = 0;
foreach ($obj as $key=>$value)
{
    $value = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
        return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
    }, $value);

    $element_component = explode('.',$key);
    $key = str_replace('.','point',$key);
    $onchange="$.post('api.php', 'student=1&interaction=4&elementName={$element_component[0]}&componentName={$element_component[1]}&transferMethod='+this.value, function (data) {
     obj = JSON.parse(data);
     console.log(obj.correct);
     document.getElementById('$key-component-organization-message').innerHTML = obj.message;
     document.getElementById('$key-array-component-form').style.background = (obj.correct === 'true') ? '#d1e7dd' : '#e9b4b4';
     document.getElementById('$key-array-component-form').style.color = (obj.correct === 'true') ? '#024f2d' : '#4f0303';
     if (obj.correct == 'true') lockSelect('component-organization', $counter);
     document.getElementById('$key-component-organization-message').style.background = document.getElementById('$key-array-component-form').style.background;
     })";

    echo
    "<form class='row' id='$key-array-component-form' style='padding-bottom: 50px; padding-top: 50px; font-size: x-large;'>
    <p class='col-sm-3'>$value</p>
    <select class='col-sm-3' onchange=\"$onchange\">
      <option selected disabled>...</option>
      <option value='return'>Возвращаемое значение</option>
      <option value='read-only'>Входной параметр</option>
      <option value='write-only'>Выходной параметр</option>
      <option value='read-write'>Обновляемый параметр</option>
</select>
</form>
<p class='row' id='$key-component-organization-message'>
</p>
";
    $counter ++;

    //echo $key." ".$value."<br>";
}
?>