<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>bonjour impots ^^</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" media="screen" href="main.css">
        <script src="main.js"></script>
    </head>

    <body>
        <form method="post">
            <input type="text" name="nom">
            <input type="test" name="argent">
            <input type="submit" name="form_submitted">
        </form>

        <?php
        if (isset($_POST['form_submitted'])){
            $mec = htmlspecialchars($_POST['nom']);
            $thune = htmlspecialchars($_POST['argent']);
            if ($thune < 15000) {
                $thune=($thune*(91/100));
                $lol="9%";
            }else{
                $thune=($thune*(86/100));
                $lol="14%";
            }

            echo "Monsieur ".$mec." n'as plus que ".$thune." argent car votre impots est de ".$lol;
        }
            
        ?>

        <?php
            echo '<h1>hello world gu</h1>';
            echo '';
        ?>

    </body>
</html>