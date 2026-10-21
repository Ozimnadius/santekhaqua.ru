<?
global $arTheme, $arRegion;
$logoClass = ($arTheme['COLORED_LOGO']['VALUE'] !== 'Y' ? '' : ' colored');
?>
<div class="mobileheader-v1">
	<div class="burger pull-left">
		<?=CMax::showIconSvg("burger dark", SITE_TEMPLATE_PATH."/images/svg/burger.svg");?>
		<?=CMax::showIconSvg("close dark", SITE_TEMPLATE_PATH."/images/svg/Close.svg");?>
	</div>
	<div class="logo-block pull-left">
		<div class="logo<?=$logoClass?>">
			<?=CMax::ShowBufferedLogo();?>
		</div>
	</div>
	<div class="right-icons pull-right">
		<div class="pull-right">
			<div class="wrap_icon wrap_basket">
				<?=CMax::ShowBasketWithCompareLink('', 'big', false, false, true);?>
			</div>
		</div>
		<div class="pull-right">
			<div class="wrap_icon wrap_cabinet">
				<?=CMax::showCabinetLink(true, false, 'big');?>
			</div>
		</div>
		<div class="pull-right">
			<div class="wrap_icon">
				<button class="top-btn inline-search-show twosmallfont">
					<?=CMax::showIconSvg("search", SITE_TEMPLATE_PATH."/images/svg/Search.svg");?>
				</button>
			</div>
		</div>
		<div class="pull-right">
			<div class="wrap_icon wrap_phones">
				<?CMax::ShowHeaderMobilePhones("big");?>
			</div>
		</div>
		<?// Б24 79227, мобильная шапка по варианту 3: первый номер (768–991) и мессенджеры — левее значков Аспро (pull-right).
		// Данные — local/php_interface/init.php, стили — css/custom.css (.hdr-m)
		$arMobilePhones = santekhaquaHeaderPhones();
		$arMobileMessengers = santekhaquaHeaderMessengers();
		?>
		<?if($arMobilePhones || $arMobileMessengers):?>
			<div class="pull-right hdr-m">
				<?if($arMobilePhones):?>
					<a class="hdr-m__phone" rel="nofollow" href="<?=htmlspecialcharsbx($arMobilePhones[0]['HREF'])?>"><?=$arMobilePhones[0]['PHONE']?></a>
				<?endif;?>
				<?if($arMobileMessengers):?>
					<div class="header-messengers hdr-m__messengers">
						<?foreach($arMobileMessengers as $code => $arMessenger):?>
							<a class="header-messengers__item header-messengers__item--<?=$code?>" href="<?=htmlspecialcharsbx($arMessenger['HREF'])?>" target="_blank" rel="nofollow" title="<?=$arMessenger['TITLE']?>"><?=$arMessenger['TITLE']?></a>
						<?endforeach;?>
					</div>
				<?endif;?>
			</div>
		<?endif;?>
	</div>
	<?=\Aspro\Functions\CAsproMax::showProgressBarBlock();?>
</div>