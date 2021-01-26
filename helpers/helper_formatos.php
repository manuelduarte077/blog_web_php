<?php
    /* Formatear fecha */
    function formatearFecha($fecha){
        return date('d M, Y, g:i a', strtotime($fecha));
    }

    /* Recortar texto, texto de introducción */
    function textoCorto($texto, $chars = 30){
        $texto = $texto."";
        $texto = substr($texto, 0, $chars);
        $texto = substr($texto, 0, strrpos($texto, ' '));
        $texto = $texto. "...";
        return $texto;
    }