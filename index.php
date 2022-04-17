<?php
$nameOfInputUpload = "image";
$isPost = $_SERVER['REQUEST_METHOD'] === "POST";
$myImage = isset($_FILES[$nameOfInputUpload]) ? $_FILES[$nameOfInputUpload] : null;

// si il y a un fichier qui a été envoyé sans erreur et qu'il a le name image
if(isset($myImage) && $myImage['error'] == 0){
    // si l'image ne depasse pas les 3mo
    if($myImage['size'] <= 3000000 ){
        $informationImage = pathinfo($myImage['name']);
        $extensionImage = $informationImage['extension'];
        $extensionArray = ['jpg','gif','png','jpeg'];
        // si l'extension de l'image est dans le tableau $extensionArray
        if(in_array($extensionImage, $extensionArray)){
            // on lui dit ou deplacer l'image et on la nomme
            $urlImage  = 'Upload/'.time().rand().'.'.$extensionImage;
            // on déplace l'image dans le dossier Upload
            move_uploaded_file($myImage['tmp_name'],$urlImage );
            $message = "Votre image est prise en compte ! " ;
        } else {
            $message = " Votre fichier n'est pas de type jpeg jpg gif ou png !";
        }
    } else {
        $message = " Votre image depasse les 3mo !";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hébergeur d'Image</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header style="text-align: center;">
        <h1> Bienvenue sur l'Hébergeur d'Image fonctionnant en PHP</h1>
        <div>
            <h3>Comment cela marche ? </h3>
            <p>Vous Choisissez une image sur votre ordinateur (max de 3mo) puis vous cliquer sur envoyer. Ensuite votre image s'affichera en dessous du formulaire.</p>
        </div>
    </header>

    <hr style="width:90%;" />

    <section id="envoiImage">
        <form  method="post" action="index.php" enctype="multipart/form-data">
            <input type="file" name=<?= $nameOfInputUpload ?> required /> <br>
            <button type ="submit"> Envoyer </button> <br> <br/>
            <?= $isPost ? $message : null ?>
        </form>
    </section>

    <hr style="width:90%;" />

    <section id="affichageImage"> 
        <?php if ($isPost && isset($urlImage)): ?>
            <img style='max-width:400px;' src= $urlImage alt='une image chargée' /> 
            <br>
            Lien de votre image : <a href='$urlImage' target='_blank' > cliquez-ici </a>" 
        <?php else : ?>
            <h3 style='text-align:center'> Votre image s'affichera ici </h3>"
        <?php endif ?>
    </section>

</body>
</html>
