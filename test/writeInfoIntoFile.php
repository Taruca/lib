<?php
$filePath = "../infoFile/test.txt";

$file = fopen($filePath, 'w') or die("can not open file");
$line1 = "#username" ."\t" ."RNAVcfFileName" ."\t" ."DNAVcfFileName" ."\t" ."etArgs" ."\t" ."qcArgs" ."\t"
    ."sjArgs" ."\t" ."drArgs" ."\t" ."lrArgs\n";
$line2 = "1" ."\t" ."BJ22.snvs.hard.filtered.vcf" ."\t" ."null" ."\t" ."AG" ."\t" ."20/6" ."\t" ."2" ."\t" ."AG" ."\t" ."4";
fwrite($file, $line1);
fwrite($file, $line2);

?>
