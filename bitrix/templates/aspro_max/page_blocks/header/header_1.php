<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
global $arTheme, $arRegion, $bLongHeader, $bColoredHeader;

$arRegions = CMaxRegionality::getRegions();
$bIncludeRegionsList = $arRegions || ($arTheme['USE_REGIONALITY']['VALUE'] !== 'Y' && $arTheme['USE_REGIONALITY']['DEPENDENT_PARAMS']['REGIONALITY_IPCITY_IN_HEADER']['VALUE'] !== 'N');

$logoClass = ($arTheme['COLORED_LOGO']['VALUE'] !== 'Y' ? '' : ' colored');
$bLongHeader = true;
$bColoredHeader = true;

// Б24 79227, шапка по варианту 3 «компактная» (.claude/docs/work/spec-header.md): логотип со слоганом, три телефона в ряд,
// под ними короткий адрес и почта, справа мессенджеры и «Заказать звонок». Данные — local/php_interface/init.php,
// стили — css/custom.css (.hdr-*)
$arHeaderPhones = santekhaquaHeaderPhones();
$arHeaderMessengers = santekhaquaHeaderMessengers();
$callbackExploded = explode(',', $arTheme['SHOW_CALLBACK']['VALUE']);
$bHeaderCallback = in_array('HEADER', $callbackExploded);
?>
<div class="header-wrapper">
	<div class="logo_and_menu-row header__top-part">
		<div class="maxwidth-theme logo-row">
			<div class="header__top-inner hdr">
				<div class="logo-block floated header__top-item no-shrinked hdr-brand">
						<div class="logo<?=$logoClass?>">
							<?=CMax::ShowBufferedLogo();?>
						</div>
						<div class="hdr-brand__slogan">
							<?$APPLICATION->IncludeFile(SITE_DIR."include/top_page/slogan.php", array(), array(
									"MODE" => "html",
									"NAME" => "Text in title",
									"TEMPLATE" => "include_area.php",
								)
							);?>
						</div>
				</div>

				<?// Б24 79227: без заведённых регионов Аспро выводит пустой блок с отступами — показываем только при регионах?>
				<?if($bIncludeRegionsList && $arRegions):?>
					<div class="header__top-item">
						<div class="line-block line-block--8">
							<div class="line-block__item">
								<div class="top-description no-title">
									<?\Aspro\Functions\CAsproMax::showRegionList();?>
								</div>
							</div>
						</div>		
					</div>
				<?endif;?>

				<div class="header__top-item flex1 hdr-contacts">
					<?if($arHeaderPhones):?>
						<div class="hdr-phones">
							<?=CMax::showSpriteIconSvg(SITE_TEMPLATE_PATH."/images/svg/header_icons_srite.svg#phone_black", "svg-inline-phone hdr-phones__icon", ['WIDTH' => 5,'HEIGHT' => 13]);?>
							<?foreach($arHeaderPhones as $arPhone):?>
								<a class="hdr-phones__item" rel="nofollow" href="<?=htmlspecialcharsbx($arPhone['HREF'])?>"><?=$arPhone['PHONE']?></a>
							<?endforeach;?>
						</div>
					<?endif;?>
					<div class="hdr-sub">
						<div class="hdr-sub__addr">
							<?=CMax::showIconSvg("addr", SITE_TEMPLATE_PATH."/images/svg/address.svg");?>
							<?$APPLICATION->IncludeFile(SITE_DIR."include/top_page/header-address.php", array(), array(
									"MODE" => "html",
									"NAME" => "Адрес в шапке",
									"TEMPLATE" => "include_area.php",
								)
							);?>
						</div>
						<?CMax::showEmail('hdr-sub__email');?>
					</div>
				</div>
				<div class="header__top-item hdr-actions">
					<?if($arHeaderMessengers):?>
						<div class="header-messengers">
							<?foreach($arHeaderMessengers as $code => $arMessenger):?>
								<a class="header-messengers__item header-messengers__item--<?=$code?>" href="<?=htmlspecialcharsbx($arMessenger['HREF'])?>" target="_blank" rel="nofollow" title="<?=$arMessenger['TITLE']?>"><?=$arMessenger['TITLE']?></a>
							<?endforeach;?>
						</div>
					<?endif;?>
					<?if($bHeaderCallback):?>
						<span class="callback-block animate-load hdr-callback" data-event="jqm" data-param-form_id="CALLBACK" data-name="callback"><?=GetMessage("CALLBACK")?></span>
					<?endif;?>
				</div>
				<div class="right-icons wb header__top-item">
					<div class="line-block line-block--40 line-block--40-1200">

						<?$arShowSites = \Aspro\Functions\CAsproMax::getShowSites();?>
						<?$countSites = count($arShowSites);?>
						<?if ($countSites > 1) :?>
							<div class="line-block__item no-shrinked">
								<div class="wrap_icon inner-table-block">
									<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
										array(
											"COMPONENT_TEMPLATE" => ".default",
											"PATH" => SITE_DIR."/include/header_include/site.selector.php",
											"SITE_LIST" => $arShowSites,
											"AREA_FILE_SHOW" => "file",
											"AREA_FILE_SUFFIX" => "",
											"AREA_FILE_RECURSIVE" => "Y",
											"EDIT_TEMPLATE" => "include_area.php",
										),
										false, array("HIDE_ICONS" => "Y")
									);?>
								</div>
							</div>
						<?endif;?>	
						<div class="line-block__item no-shrinked">
							<div class="wrap_icon">
								<button class="top-btn inline-search-show">
									<?=CMax::showSpriteIconSvg(SITE_TEMPLATE_PATH."/images/svg/header_icons_srite.svg#search", "svg-inline-search", ['WIDTH' => 17,'HEIGHT' => 17]);?>
									<span class="title"><?=GetMessage("CT_BST_SEARCH_BUTTON")?></span>
								</button>
							</div>
						</div>
						<div class="line-block__item no-shrinked">
							<div class="wrap_icon inner-table-block person">
								<?=CMax::showCabinetLink(true, false, 'big');?>
							</div>
						</div>
						<?if (CMax::GetFrontParametrValue("ORDER_BASKET_VIEW") === "NORMAL"):?>
								<?=CMax::ShowBasketWithCompareLink('', 'big', '', 'wrap_icon wrap_basket baskets line-block__item');?>
						<?endif;?>	
					</div>	
				</div>
			</div>
		</div>
	</div>
	<div class="menu-row middle-block bg<?=strtolower($arTheme["MENU_COLOR"]["VALUE"]);?>">
		<div class="maxwidth-theme">
			<div class="row">
				<div class="col-md-12">
					<div class="menu-only">
						<nav class="mega-menu sliced">
							<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
								array(
									"COMPONENT_TEMPLATE" => ".default",
									"PATH" => SITE_DIR."include/menu/menu.".($arTheme["HEADER_TYPE"]["LIST"][$arTheme["HEADER_TYPE"]["VALUE"]]["ADDITIONAL_OPTIONS"]["MENU_HEADER_TYPE"]["VALUE"] == "Y" ? "top_catalog_wide" : "top").".php",
									"AREA_FILE_SHOW" => "file",
									"AREA_FILE_SUFFIX" => "",
									"AREA_FILE_RECURSIVE" => "Y",
									"EDIT_TEMPLATE" => "include_area.php"
								),
								false, array("HIDE_ICONS" => "Y")
							);?>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="line-row visible-xs"></div>
</div>