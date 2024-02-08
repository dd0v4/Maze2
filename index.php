<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <title>The Ultimate F*cking Greatest Maze</title>
</head>
<body>
    <header>
        <h1>The Ultimate F*cking Greatest Maze</h1>
    </header>
    <main>
        <div class="jeu">
            <div class="maze">
                <?php require("maze.php"); ?>
            </div>
            
            <form action="" method="POST">
                
                    <div class="fleches">
                        <input type="submit" value="⬆" id="flechehaut" name="flechehaut">
                        <div class="droitegauche">
                            <input type="submit" value="⬅" id="flechegauche" name="flechegauche">
                            <input type="submit" value="⮕" id="flechedroite" name="flechedroite">
                        </div>
                        <input type="submit" value="⬇" id="flechebas" name="flechebas">
                        <div id="reponse"></div>
                    </div>
            
        </div>
        <div class="reco">
            <input type="submit" value="Recommencer" id="recommencer" name="recommencer">
        </div>
        
        </form>
    </main>
</body>
</html>
