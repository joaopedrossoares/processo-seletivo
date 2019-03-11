<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Basic PHP Calculator</title>
</head>
<body>
<?php
$a = 0.0;
$b = 0.0;
$c = 0.0;

if(!isset($_POST['a'])){
    $_POST['a'] = $a;
}

if(!isset($_POST['b'])) {
    $_POST['b'] = $b;
}

if(!isset($_POST['c'])){
    $_POST['c'] = $c;
}

// Função que retorna as raízes.

function baskhara ($a, $b, $c) {
    $delta = pow($b,2) - 4 * $a * $c;

    if($a != 0){
        $x1 = (-($b) + sqrt($delta))/(2*$a);
        $x2 = (-($b) - sqrt($delta))/(2*$a);
        $msg = "X' : $x1 <br> X'': $x2";
    } else {
        $msg = "Nao ha divisao por zero";
    }

    return $msg;
}

$display = baskhara($_POST['a'], $_POST['b'], $_POST['c']);

echo "<br>";
    echo "<form action=\"\" method=\"POST\">";
        echo "a <input type=\"text\" name  = \"a\" value = \"$a\"> <br>";
        echo "b <input type=\"text\" name  = \"b\" value = \"$b\"> <br>";
        echo "c <input type=\"text\" name  = \"c\" value = \"$c\"> <br>";
        echo "<input type=\"submit\" name=\"enviar\">";
        echo "<p>$display</p";

        echo "</form>";
         
?>
</body>
</html>