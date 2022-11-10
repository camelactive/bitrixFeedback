<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

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
$arResult["PARAMS_HASH"] = md5(serialize($arParams).$this->GetTemplateName());
// $arResult["ANSWER_FOR_USER"] = $arParams["ANSWER_FOR_USER"];
// $arResult["EMAIL_USER"] = $arParams["EMAIL_USER"];
$arParams["EMAIL_USER"] = trim($arParams["EMAIL_USER"]);
if ($arParams["EMAIL_USER"] == '')
    $arParams["EMAIL_USER"] = COption::GetOptionString("main", "email_from");
$arParams["ANSWER_FOR_USER"] = trim($arParams["ANSWER_FOR_USER"]);
if ($arParams["ANSWER_FOR_USER"] == '')
    $arResult["ANSWER_FOR_USER"] = GetMessage("ANSWER_FOR_USER");

if ($ssss=="ssdd")
    $arResult["ANSWER_FOR_USER"]= "sucsess";

$arResult["FIELDS_FOR_CHOOSE"] = $arParams["FIELDS_FOR_CHOOSE"];
$arResult["EVENT_MESSAGE_TEMPLATE"] = $arParams["EVENT_MESSAGE_TEMPLATE"];

// $arResult["MESSAGE"] = 

if ($USER->IsAuthorized()) {
    $arResult["AUTHOR_NAME"] = $USER->GetFormattedName(false);
    $arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($USER->GetEmail());
};


$this->includeComponentTemplate();
?>

'