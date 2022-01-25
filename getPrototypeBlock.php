<div id="prototype_block">
    <p class="row">Прототип функции:</p>
    <div class="row">
        <p class="col-sm-6" id="prototype_code" style="height: 128px; font-size: 28pt; border: black solid;">

        </p>
        <button style="background-image: url('delete.png'); width: 128px; height: 128px;" class="col-sm-3" onclick="$.post('api.php', 'student=1&interaction=6&action=pop', function (data) {obj = JSON.parse(data); document.getElementById('prototype_code').innerText = obj.code; document.getElementById('prototype-message').innerText = obj.message; document.getElementById('prototype-message').style.background = (obj.correct === 'true') ? '#d1e7dd' : '#e9b4b4' })">
        </button>
    </div>

    <div class="row" id='prototype-message'>

    </div>
</div>
<?php

class Lexem
{
    public $type;
    public $value;
    public function __construct($type, $value)
    {
        $this->type = $type;
        $this->value = $value;
    }
}

$lexems = [
    new Lexem("IntLexem", "int"),
    new Lexem("OpenBracketLexem","("),
    new Lexem("CloseBracketLexem", ")"),
    new Lexem("FunctionNameLexem", "distance_between_dates"),
    new Lexem("SemicolonLexem", ";"),
    new Lexem("CommaLexem",",")
];

$json  = file_get_contents("http://localhost:8000/test?paramList=1", false, stream_context_create(array(
    'http' => array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => http_build_query(['paramList'=>'1'])
    )
)));

$obj = json_decode($json);

foreach ($obj as $key=>$value)
{
    $lexems[] = new Lexem("ParameterNameLexem",$key);
}

echo "<div id='lexems-select' class='row'>";
foreach ($lexems as $lexem)
{
    $encode_value = urlencode($lexem->value);
    $request = "student=1&interaction=6&action=push&lexemType={$lexem->type}&lexemValue={$encode_value}";
    $onclick = "$.post('api.php', '$request', function(data) {obj = JSON.parse(data); document.getElementById('prototype_code').innerText = obj.code; document.getElementById('prototype-message').innerText = obj.message; document.getElementById('prototype-message').style.background = (obj.correct === 'true') ? '#d1e7dd' : '#e9b4b4' })";
    echo "<button class='col-sm-3' onclick=\"$onclick\">{$lexem->value}</button>";
}

echo "</div>";


?>