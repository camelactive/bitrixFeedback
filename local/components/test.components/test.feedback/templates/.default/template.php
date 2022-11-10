<pre style="font-size:16px ;">
<?php

// var_dump($arResult);
// $arResult["ERROR_MESSAGE"] =array (
// 	"1"=>"2",
// );
var_dump($_REQUEST);
br;
var_dump($arResult["PARAMS_HASH"]);
br;
var_dump($_POST["PARAMS_HASH"]);
?>
</pre>

<? if (!empty($arResult["ERROR_MESSAGE"])) : ?>
	<?php foreach ($arResult["ERROR_MESSAGE"] as $error)
		ShowError($error); ?>
<?php endif ?>
<? if (empty($arResult["ERROR_MESSAGE"]) && $arResult["ANSWER_FOR_USER"] <> '') : ?>
	<div class="text-line sucsess"> <?= $arResult["ANSWER_FOR_USER"] ?></div>
<?php endif ?>
<div class="feedback_block">
	<form action="<?= POST_FORM_ACTION_URI ?>" method="POST">
		<div class="feedback_block__name">
			<div class="text-line">
				<?= GetMessage("FEEDBACK_NAME") ?><? if (empty($arParams["FIELDS_FOR_CHOOSE"]) || in_array("NAME", $arParams["FIELDS_FOR_CHOOSE"])) : ?><span class="red">*</span><? endif ?>
			</div>
			<input type="text-text" name="user_name" value="<?= $arResult["AUTHOR_NAME"] ?>">
		</div>
		<div class="feedback_block__email">
			<div class="text-line">
				<?= GetMessage("FEEDBACK_EMAIL") ?><? if (empty($arParams["FIELDS_FOR_CHOOSE"]) || in_array("EMAIL", $arParams["FIELDS_FOR_CHOOSE"])) : ?><span class="red">*</span><? endif ?>
			</div>
			<input type="text" name="user_email" value="<?= $arResult["AUTHOR_EMAIL"] ?>">
		</div>
		<div class="feedback_block__textarea">
			<div class="text-line">
				<?= GetMessage("FEEDBACK_TEXT") ?><? if (empty($arParams["FIELDS_FOR_CHOOSE"]) || in_array("MESSAGE", $arParams["FIELDS_FOR_CHOOSE"])) : ?><span class="red">*</span><? endif ?>
			</div>
			<textarea name="MESSAGE" rows="5" cols="40" placeholder="Введите ваш текст"><?= $arResult["MESSAGE"] ?></textarea>
		</div>
		<div class="feedback_block__button">
			<input type="submit" name="submit" value="<?= GetMessage("FEEDBACK_SUBMIT") ?>">
		</div>
	</form>
</div>