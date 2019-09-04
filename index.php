<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>lab16-1</title>
</head>
<body>
    <form action="" method="post">
    <input type="text" name="function" id="function" placeholder="Write function"/>
    <p>Interval:<br><input type="text" name="from" id="interval" placeholder="From" value="-10"/>
    <input type="text" name="to" id="interval" placeholder="To" value="10"/></p>
    <input type="submit" name ="draw" id="draw" value="Draw"/>
</form>
</body>
</html>

<?php
if(isset($_POST['draw']))
{
    create_image();
    print "<img src=image.png?".date("U").">";
}


function  create_image(){
        $im = @imagecreate(1000, 600) or die("Cannot Initialize new GD image stream");
        imageantialias($im, true);
        $background_color = imagecolorallocate($im, 255, 255, 255);
        draw_axes($im);  
       $function = $_POST['function'];
       $start = strpos($function,'(')+1;
        $end = strpos($function,'x')-$start;
        $b = substr($function,$start,$end);
        if($b==0) $b = 1;
       if(strpos($function, 'sin')!==false){      
        $a =floatval(substr($function,0,strpos($function,'s')-1));
        if($b==0) $b = 1;
        if($a==0) $a = 1;
        draw_sin($im,$a,floatval($b));
       } elseif (strpos($function, 'cos')!==false){
        $a =floatval(substr($function,0,strpos($function,'c')-1));
        if($a==0) $a = 1;
        draw_cos($im,$a,floatval($b));
       }  elseif (strpos($function, 'ln')!==false){
        $a =floatval(substr($function,0,strpos($function,'l')-1));
        if($a==0) $a = 1;
        draw_ln($im,$a,floatval($b));
       } elseif (strpos($function, 'exp')!==false){
        $a =floatval(substr($function,0,strpos($function,'e')-1));
        if($a==0) $a = 1;
        draw_exp($im,$a,floatval($b));
       }else echo "false";

        imagepng($im,"image.png");
        imagedestroy($im);
}
// function f($t,$x){
//     return -$t*exp($t*$x)+$x;
// }
function draw_axes($im){
    $black = imagecolorallocate($im, 0, 0, 0); 
    imageline ($im,   1000,  300, 0, 300, $black);
    imageline ($im,   500,  0, 500, 600, $black);
    for($i = 0;$i<60; $i++){
        imageline ($im,   498,  $i*20, 502, $i*20, $black);
        imagestring($im,1,485,$i*20,15-$i,$black);
    }
    for($i = 0;$i<=100; $i++){
        imageline ($im,   $i*20,  298, $i*20, 302, $black);
        imagestring($im,1,$i*20,308,-25+$i,$black);
    }
}
function draw_sin($im,$a=1,$b=1){
    $red = imagecolorallocate($im, 255, 0, 0); 
    for($x = intval($_POST['from'])*2;$x<=intval($_POST['to'])*2; $x+=0.1){
        $x2 = $x+0.1;
    imageline($im,$x*10+500,300-$a*sin($b*$x)*20,$x2*10+500,300-$a*sin($b*$x2)*20,$red);
    }
}
function draw_cos($im,$a=1,$b=1){
    $red = imagecolorallocate($im, 255, 0, 0); 
    $from = intval($_POST['from'])*2;
    $to = intval($_POST['to'])*2;
    for($x = $from;$x<=$to; $x+=0.1){
        $x2 = $x+0.1;
    imageline($im,$x*10+500,300-$a*cos($b*$x)*20,$x2*10+500,300-$a*cos($b*$x2)*20,$red);
    }
}
function draw_exp($im,$a=1,$b=1){
    $red = imagecolorallocate($im, 255, 0, 0); 
    $from = intval($_POST['from'])*2;
    $to = intval($_POST['to'])*2;
    for($x = $from;$x<=$to; $x+=0.1){
        $x2 = $x+0.1;
        if($a*exp($b*$x)<15&&$a*exp($b*$x)>-15)
    imageline($im,$x*10+500,300-$a*exp($b*$x)*20,$x2*10+500,300-$a*exp($b*$x2)*20,$red);
    }
}
function draw_ln($im,$a=1,$b=1){
    $red = imagecolorallocate($im, 255, 0, 0); 
    for($x = intval($_POST['from'])*2;$x<=intval($_POST['to'])*2; $x+=0.1){
        $x2 = $x+0.1;
        if($a*log($b*$x)>-2 && $a*log($b*$x)<2.2)
    imageline($im,$x*10+500,300-$a*log($b*$x)*20,$x2*10+500,300-$a*log($b*$x2)*20,$red);
    }
}
?>