<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400&display=swap" rel="stylesheet">
    <title>Foto del día</title>
</head>
<body>

<?php
ini_set( 'display_errors', 1 );
error_reporting( E_ALL );

$api_response = file_get_contents( 'https://api.nasa.gov/planetary/apod?api_key=3BsgsikV8JRcoQtimtp7GinKyMBrQhSSwNk2z28u' );

$titulo       = '';
$fecha        = '';
$explicacion  = '';
$tipo         = '';
$urlVideo     = '';
$urlFotoHD    = '';
$urlFotoHD    = '';

if ( $api_response !== false ) {
    $fotoDelDia = json_decode( $api_response, true );

    // convendría guardar cada elemento del array en una variable para trabajar?
    // es un echo por línea?
    // para cambiar el formato de la fecha, podría pasarlo a tiempo unix y de ahi a date eligiendo el formato?
    // hay cosas que no entiendo: https://api.nasa.gov/
    /* el 21/6 se agregó a la descripción un texto que decía:
    APOD in world languages: Arabic, Bulgarian, Catalan, Chinese (Beijing), Chinese (Taiwan),
    Croatian, Czech, Dutch, Farsi, French, German, Hebrew, Indonesian, Japanese, Korean, Montenegrin,
    Polish, Russian, Serbian, Slovenian, Spanish, Taiwanese, Turkish, Turkish, and Ukrainian
    cómo accedo a la opción ponerlo en castellano??
    */

    if  ( !empty ( $fotoDelDia['title'] ) ) {
        $titulo = $fotoDelDia['title'] ;
    }

    if  ( !empty ( $fotoDelDia['date'] ) ) {
        $fecha = $fotoDelDia['date'] ;
    }

    if  ( !empty ( $fotoDelDia['explanation'] ) ) {
        $explicacion = $fotoDelDia['explanation'] ;
    }

    if  ( !empty ( $fotoDelDia['media_type'] ) ) {
        $tipo = $fotoDelDia['media_type'] ;
    }

    if ( $tipo === 'video' && !empty ( $fotoDelDia['url'] ) ) {
        $urlVideo = $fotoDelDia['url'];
    }

    if ( $tipo === 'image' && !empty ( $fotoDelDia['url'] ) ) {
        $urlFoto = $fotoDelDia['url'];
    }

    if ( $tipo === 'image' && !empty ( $fotoDelDia['url'] ) ) {
        $urlFotoHD = $fotoDelDia['hdurl'];
    }

    echo '<main>';

        echo '<h1>';
            echo $titulo;
        echo '</h1>';

        echo '<section id="contenido">';
        
        if ( $tipo === 'video' ) {

            echo '<figure id="video">';
                echo '<iframe class="video" src="' . $urlVideo . '"></iframe>';
            echo '</figure>';

        } else if ( $tipo === 'image') {

            echo '<figure id=imagenChica>';
                echo '<a href="' . $urlFotoHD . '" target=_blank>';
                echo '<img src="' . $urlFoto . '"></img>';
                echo '</a>';
            echo '</figure>';

            echo '<figure id=imagenHD>';
                echo '<img src="' . $urlFotoHD . '"></img>';
            echo '</figure>';

        } 

        echo '<article id="descripcion">';
            echo $fotoDelDia['explanation'];
        echo '</article>';

        echo '<article id="fecha">';
            echo $fotoDelDia['date'];
        echo '</article>';

        echo '</section>';

    echo '</main>';

    } else {
        echo '<section class="mensajeError">Something went wrong.</section>';
    }
    
    // var_dump( $fotoDelDia );

?>

</body>
</html>