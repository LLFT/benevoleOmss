<?php
header('Cache-Control:public');
header('Pragma:');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//header("Content-type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=\"".$this->sFileName."\"");
header('Content-Transfer-Encoding:binary');
header("Content-Type: application/".$this->sExtension.";name=\"".$this->sFileName."\"");

flush();

echo"\xEF\xBB\xBF"; //Permet à Excel de reconnaitre que le fichier est en UTF-8
echo $this->load('main');

