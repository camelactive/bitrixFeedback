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

use \Bitrix\Main\Config\Option;
use Bitrix\Main\Mail\Event;
use Bitrix\Main;
use Bitrix\Main\UserTable;
use \Bitrix\Main\Application;
use \Bitrix\Main\Data;
class Test3ComponentClass extends CBitrixComponent
{
    
    public function onPrepareComponentParams($arParams)
    {
        global $USER;
        $arParams["USE_CAPTCHA"] = (($arParams["USE_CAPTCHA"] != "N" && !$USER->IsAuthorized()) ? "Y" : "N");
        $arParams["EVENT_NAME"] = trim($arParams["EVENT_NAME"]);
        if ($arParams["EVENT_NAME"] == '')
            $arParams["EVENT_NAME"] = "FEEDBACK_FORM";
        $arParams["EMAIL_TO"] = trim($arParams["EMAIL_TO"]);
        if ($arParams["EMAIL_TO"] == '')
            $arParams["EMAIL_TO"] = COption::GetOptionString("main", "email_from");
        $arParams["OK_TEXT"] = trim($arParams["OK_TEXT"]);
        if ($arParams["OK_TEXT"] == '')
            $arParams["OK_TEXT"] = GetMessage("MF_OK_MESSAGE");

        return $arParams;
    }
    protected function myResults()
    {
        global $USER;
        $result = [];
        $result["PARAMS_HASH"] = md5(serialize($this->arParams).$this->GetTemplateName());
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"] <> '' && (!isset($_POST["PARAMS_HASH"]) || $result["PARAMS_HASH"] === $_POST["PARAMS_HASH"])) {
            $result["ERROR_MESSAGE"] = array();
            if (check_bitrix_sessid()) {
                if (empty($arParams["REQUIRED_FIELDS"]) || !in_array("NONE", $arParams["REQUIRED_FIELDS"])) {
                    if ((empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])) && mb_strlen($_POST["user_name"]) <= 1)
                        $result["ERROR_MESSAGE"][] = GetMessage("MF_REQ_NAME");
                    if ((empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])) && mb_strlen($_POST["user_email"]) <= 1)
                        $result["ERROR_MESSAGE"][] = GetMessage("MF_REQ_EMAIL");
                    if ((empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])) && mb_strlen($_POST["MESSAGE"]) <= 3)
                        $result["ERROR_MESSAGE"][] = GetMessage("MF_REQ_MESSAGE");
                }
                if (mb_strlen($_POST["user_email"]) > 1 && !check_email($_POST["user_email"]))
                    $result["ERROR_MESSAGE"][] = GetMessage("MF_EMAIL_NOT_VALID");
                if ($this->arParams["USE_CAPTCHA"] == "Y") {
                    $captcha_code = $_POST["captcha_sid"];
                    $captcha_word = $_POST["captcha_word"];
                    $cpt = new CCaptcha();
                    $captchaPass = COption::GetOptionString("main", "captcha_password", "");
                    if ($captcha_word <> '' && $captcha_code <> '') {
                        if (!$cpt->CheckCodeCrypt($captcha_word, $captcha_code, $captchaPass))
                            $result["ERROR_MESSAGE"][] = GetMessage("MF_CAPTCHA_WRONG");
                    } else
                        $result["ERROR_MESSAGE"][] = GetMessage("MF_CAPTHCA_EMPTY");
                }
                if (empty($result["ERROR_MESSAGE"])) {
                    $arFields = array(
                        "AUTHOR" => $_POST["user_name"],
                        "AUTHOR_EMAIL" => $_POST["user_email"],
                        "EMAIL_TO" => $this->arParams["EMAIL_TO"],
                        "TEXT" => $_POST["MESSAGE"],
                    );
                    if (!empty($arParams["EVENT_MESSAGE_ID"])) {
                        foreach ($arParams["EVENT_MESSAGE_ID"] as $v)
                            if (intval($v) > 0)
                                CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields, "N", intval($v));
                    } else
                        CEvent::Send($this->arParams["EVENT_NAME"], SITE_ID, $arFields);
                    $_SESSION["MF_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
                    $_SESSION["MF_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
                    $event = new \Bitrix\Main\Event('main', 'onFeedbackFormSubmit', $arFields);
                    $event->send();
                    global $APPLICATION;
                    LocalRedirect($APPLICATION->GetCurPageParam("success=" . $result["PARAMS_HASH"], array("success")));
                }

                $result["MESSAGE"] = htmlspecialcharsbx($_POST["MESSAGE"]);
                $result["AUTHOR_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
                $result["AUTHOR_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
            } else
                $result["ERROR_MESSAGE"][] = GetMessage("MF_SESS_EXP");
        } elseif ($_REQUEST["success"] == $result["PARAMS_HASH"]) {
            $result["OK_MESSAGE"] = $this->arParams["OK_TEXT"];
        }

        if (empty($result["ERROR_MESSAGE"])) {
            if ($USER->IsAuthorized()) {
                $result["AUTHOR_NAME"] = $USER->GetFormattedName(false);
                $result["AUTHOR_EMAIL"] = htmlspecialcharsbx($USER->GetEmail());
            } else {
                if ($_SESSION["MF_NAME"] <> '')
                    $result["AUTHOR_NAME"] = htmlspecialcharsbx($_SESSION["MF_NAME"]);
                if ($_SESSION["MF_EMAIL"] <> '')
                    $result["AUTHOR_EMAIL"] = htmlspecialcharsbx($_SESSION["MF_EMAIL"]);
            }
        }

        if ($this->arParams["USE_CAPTCHA"] == "Y")
        
            $result["capCode"] =  htmlspecialcharsbx($this->APPLICATION->CaptchaGetCode());
        $this->arResult = $result;
        return  true;
    }
    function executeComponent()
    {
        $this->myResults();
        $this->includeComponentTemplate();
    }
}
