<pre style="font-size:30px ;">
<?php

// var_dump($arResult);

?>
</pre>

<div class="feedback_block">
<div class="feedback_block__name">
		<div class="mf-text">
			<?=GetMessage("FEEDBACK_NAME")?><?if(empty($arParams["FIELDS_FOR_CHOOSE"]) || in_array("NAME", $arParams["FIELDS_FOR_CHOOSE"])):?><span class="red">*</span><?endif?>
		</div>
		<input type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>">
	</div>
	<div class="feedback_block__email">
		<div class="mf-text">
			<?=GetMessage("FEEDBACK_EMAIL")?><?if(empty($arParams["FIELDS_FOR_CHOOSE"]) || in_array("EMAIL", $arParams["FIELDS_FOR_CHOOSE"])):?><span class="red">*</span><?endif?>
		</div>
		<input type="text" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>">
	</div>
	<div class="feedback_block__textarea">
		<div class="mf-text">
			<?=GetMessage("FEEDBACK_TEXT")?><?if(empty($arParams["FIELDS_FOR_CHOOSE"]) || in_array("MESSAGE", $arParams["FIELDS_FOR_CHOOSE"])):?><span class="red">*</span><?endif?>
		</div>
		<textarea name="MESSAGE" rows="5" cols="40" placeholder="Введите ваш текст"><?=$arResult["MESSAGE"]?></textarea>
	</div>
    <div class="feedback_block__button">
    <input type="submit" name="submit" value="<?=GetMessage("FEEDBACK_SUBMIT")?>">
    </div>
</div>
