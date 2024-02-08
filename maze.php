<?php
session_start();
// On start notre session

$html = file_get_contents('index.php');
// On récupère le contenu de intex.php
if (!isset($_SESSION["posX"]) || !isset($_SESSION["posY"])) {
    $_SESSION["posX"] = 5;
    $_SESSION["posY"] = 2;
}
//Si posX et posY ne sont pas set dans la session, on les set
if (!isset($_SESSION["mazeNumber"])) {
    $_SESSION["mazeNumber"] = rand(1, 2);
}
// si mazeNumber n'est pas set on genere un nombre entre 1 et 2
function echomaze(array $maze, int $posY, int $posX){
    echo $maze["tableopen"];
    foreach ($maze["rows"] as $y => $row) {
        echo "<tr>";
        echo "<td></td>";
        foreach ($row as $x => $case) {
            if($x >= 2 && $x < (count($row) - 1)){
                if ($x -1 >= $posX - 1 && $x +1<= $posX + 1 && $y >= $posY - 1 && $y <= $posY + 1) {
                    echo $case;
                }else if($x >= $posX - 1 && $x <= $posX + 1 && $y -1 >= $posY - 1 && $y + 1<= $posY + 1) {
                    echo $case;
                }else {
                    echo "<td>☁️</td>";
                }
            }

        }
        echo "</tr>";
    }
    echo $maze["tableclose"];
    echo "Y chat : ", $posY, "<br>";
    echo "X chat : ", $posX;
}

function generateMaze(int $row, int $col, int $gagnanteY, int $gagnanteX, int $wallCount): array {
    $generatedMaze = [];
    $generatedMaze["tableopen"] = "<table id=\"mazetable\">";
    $generatedMaze["rows"] = [];
    $generatedMaze["tableclose"] = "</table>";
    $placedWalls = 0;
    for ($i = 0; $i < $row; $i++) {
        $currentRow = [];
        array_push($currentRow, "<tr>");
        for ($j = 0; $j < $col; $j++) {
            $wallOrNo = rand(0, 1);
            if ($wallOrNo == 1 && $placedWalls <= $wallCount){
                array_push($currentRow, "<td>🧱</td>");
                $placedWalls++;
            }else{
                array_push($currentRow, "<td></td>");
            }
            
        }
        array_push($currentRow, "</tr>");
        array_push($generatedMaze["rows"], $currentRow);
    }
    $generatedMaze["rows"][$_SESSION["posY"]][$_SESSION["posX"]] = "<td>🐱</td>";
    $_SESSION["caseGagnante"] = [$gagnanteY, $gagnanteX];
    $generatedMaze["rows"][$gagnanteY][$gagnanteX] = "<td>🐁</td>";
    return $generatedMaze;
}


if(!isset($_SESSION["maze"])){
    $_SESSION["maze"] = generateMaze(5, 10, rand(0, 4), rand(2, 8), 10);
}




if(isset($_POST["flechehaut"])){
    if($_SESSION['posY'] >= 1){
        if($_SESSION["maze"]["rows"][$_SESSION["posY"] -1][$_SESSION["posX"]] != "<td>🧱</td>"){
            $_SESSION["maze"]["rows"][$_SESSION["posY"]][$_SESSION["posX"]] = "<td></td>";
            $_SESSION["posY"]--;
            $_SESSION["maze"]["rows"][$_SESSION["posY"]][$_SESSION["posX"]] = "<td>🐱</td>";
            $html = preg_replace('/<table[^>]*id="mazetable"[^>]*>.*?<\/table>/s', "", $html);
        }else{
            echo "Il y a un mur !";
        }
    }
}
// Détection d'appui sur bouton haut

if(isset($_POST["flechebas"])){
    if($_SESSION['posY'] < count($_SESSION["maze"]["rows"]) -1){
        if($_SESSION["maze"]["rows"][$_SESSION["posY"] +1][$_SESSION["posX"]] != "<td>🧱</td>"){
            $_SESSION["maze"]["rows"][$_SESSION['posY']][$_SESSION["posX"]] = "<td></td>";
            $_SESSION["posY"]++;
            $_SESSION["maze"]["rows"][$_SESSION["posY"]][$_SESSION["posX"]] = "<td>🐱</td>";
            $html = preg_replace('/<table[^>]*id="mazetable"[^>]*>.*?<\/table>/s', "", $html);
        }else{
            echo "Il y a un mur !";
        }
    }
}
// Détection d'appui sur bouton bas

if(isset($_POST["flechedroite"])){
    if($_SESSION["posX"] < count($_SESSION["maze"]["rows"][0]) -2){
        if($_SESSION["maze"]["rows"][$_SESSION["posY"]][$_SESSION["posX"] +1] != "<td>🧱</td>"){
            $_SESSION["maze"]["rows"][$_SESSION["posY"]][$_SESSION["posX"]] = "<td></td>";
            $_SESSION["posX"]++;
            $_SESSION["maze"]["rows"][$_SESSION["posY"]][$_SESSION["posX"]] = "<td>🐱</td>";
            $html = preg_replace('/<table[^>]*id="mazetable"[^>]*>.*?<\/table>/s', "", $html);
        }else{
            echo "Il y a un mur !";
        }
    }
}
// Détection d'appui sur bouton droit

if(isset($_POST["flechegauche"])){
    if($_SESSION["posX"] > 2){
        if($_SESSION["maze"]["rows"][$_SESSION["posY"]][$_SESSION["posX"] -1] != "<td>🧱</td>"){
            $_SESSION["maze"]["rows"][$_SESSION["posY"]][$_SESSION["posX"]] = "<td></td>";
            $_SESSION["posX"]--;
            $_SESSION["maze"]["rows"][$_SESSION["posY"]][$_SESSION["posX"]] = "<td>🐱</td>";
            $html = preg_replace('/<table[^>]*id="mazetable"[^>]*>.*?<\/table>/s', "", $html);
        }else{
            echo "Il y a un mur !";
        }
    }
}
// Détection d'appui sur bouton gauche

if(isset($_POST["recommencer"])){
    unset($_SESSION["posY"]);
    unset($_SESSION["posX"]);
    session_destroy();
    header("Refresh:0");
}
// Detection d'appui sur le bouton recommencer, change le labyrinthe


if($_SESSION["posY"] == $_SESSION["caseGagnante"][0] && $_SESSION["posX"] == $_SESSION["caseGagnante"][1]){
    $html = preg_replace('/<table[^>]*id="mazetable"[^>]*>.*?<\/table>/s', '', $html);
    echo "<div id='gagnant'>Vous avez gagné !</div>";
    unset($_SESSION["posY"]);
    unset($_SESSION["posX"]);
    session_destroy();
} else {
    echomaze($_SESSION["maze"], $_SESSION["posY"], $_SESSION["posX"]);
}
