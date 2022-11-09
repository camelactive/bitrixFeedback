<?php
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
$arResult["USE_CAPTCHA"] = $arParams["USE_CAPTCHA"];
$arResult["ANSWER_FOR_USER"] = $arParams["ANSWER_FOR_USER"];
$arResult["EMAIL_USER"] = $arParams["EMAIL_USER"];
$arResult["FIELDS_FOR_CHOOSE"] = $arParams["FIELDS_FOR_CHOOSE"];
$arResult["EVENT_MESSAGE_TEMPLATE"] = $arParams["EVENT_MESSAGE_TEMPLATE"];
$arResult["AUTHOR_NAME"] = 
$arResult["AUTHOR_EMAIL"] = 
$arResult["MESSAGE"] = 


    $this->includeComponentTemplate();
?>

'