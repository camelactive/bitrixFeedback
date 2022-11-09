<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

    $arComponentParameters = array(
        "GROUPS" => array(
            GetMessage("MAIN_GROUP") =>array(
                "NAME" => GetMessage("FEEDBACK_GROUP_NAME"),
                "SORT" => 10
            ), 
        ),
        "PARAMETERS" => array(
            "USE_CAPTCHA" => array(
                "NAME" => GetMessage("USE_CAPTCHA_NAME"),
                "PARENT" =>  GetMessage("MAIN_GROUP"),
                "TYPE" =>"CHECKBOX",
                "SORT" => 500,
                "DEFAULT" => "Y",
            ),
            "ANSWER_FOR_USER" =>array(
                "NAME" => GetMessage("ANSWER_FOR_USER_NAME"),
                "PARENT" => GetMessage("MAIN_GROUP"),
                "TYPE" =>"STRING",
                "SORT" => 510,
                "DEFAULT" => GetMessage("ANSWER_FOR_USER_DEFAULT"),

            ),
            "EMAIL_USER" =>array(
                "NAME" => GetMessage("EMAIL_USER_NAME"),
                "PARENT" => GetMessage("MAIN_GROUP"),
                "TYPE" =>"STRING",
                "SORT" => 520,
			    "DEFAULT" => htmlspecialcharsbx(COption::GetOptionString("main", "email_from")), 
            ),
            "FIELDS_FOR_CHOOSE" =>array(
                "NAME" => GetMessage("FIELDS_FOR_CHOOSE_NAME"),
                "PARENT" => GetMessage("MAIN_GROUP"),
                "TYPE" =>"LIST",
                "SORT" => 530,
                "SIZE" => 5,
                "MULTIPLE"=>"Y",
                "VALUES" =>array(
                    "NONE" => GetMessage("FIELDS_FOR_CHOOSE_VALUES_NONE"),
                    "NAME" => GetMessage("FIELDS_FOR_CHOOSE_VALUES_NAME"),
                    "EMAIL" => "Email",
                    "MESSAGE" => GetMessage("FIELDS_FOR_CHOOSE_VALUES_MESSAGE"),
                ),
               
            ),
            "EVENT_MESSAGE_TEMPLATE" => array(
                "NAME" => GetMessage("EVENT_MESSAGE_TEMPLATE_NAME"),
                "PARENT" => GetMessage("MAIN_GROUP"),
                "TYPE"=>"LIST", 
                "MULTIPLE"=>"Y", 
                "VALUES" => $arMesTemplates,
            ),
    
        )
        );
?>