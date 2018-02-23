<?php

// Functions
function bDec($base58){
	$base58ch='123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';
	$bdec='0';
	for($i=0;$i<strlen($base58);$i++)
	{
		$temp=(string)strpos($base58ch,$base58[$i]);
		$bdec=(string)bcmul($bdec,'58',0);
		$bdec=(string)bcadd($bdec,$temp,0);
	}
	return $bdec;
}
function ecHex($dec){
	$ch='0123456789ABCDEF';
	$echex='';
	while(bccomp($dec,0)==1)
	{
		$bdv=(string)bcdiv($dec,'16',0);
		$bmd=(integer)bcmod($dec,'16',0);
		$dec=$bdv;
		$echex.=$ch[$bmd];
	}
	$echex = strrev($echex);
	if (strlen($echex)%2!=0)
		$echex='0'.$echex;
	return $echex;
}
function isYENTENvalid($addr)
{
	if (($addr[0]!='Y' && $addr[0]!='5')||strlen($addr)!=34)
		return false;
	$a = ecHex(bDec($addr));
	if (substr($a, -8) == substr(strtoupper(hash("sha256",hash("sha256",pack("H*",substr($a,0,strlen($a)-8)),true))),0,8))
		return true;
	return false;
}

// Address to be verified
$addr = "5EP7YKFeNdLL8hHeD4NzFxSAwbEc2FDVza";

if(!isYENTENvalid($addr))
{
	echo '<span style="color:red;">'.$addr.' is <strong>not</strong> valid</span>';
	exit;
}
	echo '<span style="color:green;"><strong>'.$addr.'</strong> is valid</span>';
