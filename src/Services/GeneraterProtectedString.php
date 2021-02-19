<?php


namespace App\Services;


class GeneraterProtectedString
{

    static public function escapeAccent($string): string
    {
        $accentE = array("é","è","ê","ë","È","É","Ê","Ë");
        $accentU = array("ù","ú","û","ü","Ù","Ú","Û","Ü");
        $accentO = array("ð","ò","ó","ô","õ","ö","Ò","Ó","Ô","Õ","Ö");
        $accentA = array("à","á","â","ã","ä","å","À","Á","Â","Ã","Ä","Å");
        $accentI = array("ì","í","î","ï","Ì","Í","Î","Ï");
        $accentY = array("ý","ÿ","Ý");


        $string = str_replace($accentE,"e",$string);
        $string = str_replace($accentA,"a",$string);
        $string = str_replace($accentU,"u",$string);
        $string = str_replace($accentO,"o",$string);
        $string = str_replace($accentI,"i",$string);
        $string = str_replace($accentY,"y",$string);

        return $string;
    }

    static public function generateProtectedFileName($string):String
    {

        $retour = GeneraterProtectedString::escapeAccent($string);

        $retour = str_replace("/"," ",$retour);

        $retour = str_replace("."," ",$retour);

        $retour = preg_replace("/[ ]+/","-",trim($retour));

        $retour = strtolower($retour);

        return substr(md5(uniqid()),0,20)."-".$retour;
    }

    static public function generateProtectedFolderName($string):String
    {

        $retour = GeneraterProtectedString::escapeAccent($string);

        $retour = str_replace("."," ",$retour);

        $retour = str_replace("/"," ",$retour);

        $retour = preg_replace("/[ ]+/","_",trim($retour));

        $retour = str_replace("-"," ",$retour);

        return strtolower($retour);
    }

}