<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!CModule::IncludeModule("iblock"))
	return;

	$s=0;
	$arResult=array();
	$arSelect 	= Array("ID", "IBLOCK_ID", "NAME", "CODE", "PROPERTY_*", "PREVIEW_TEXT");
	$arFilter 	= Array("IBLOCK_ID"=>28, "PROPERTY_ADDR_PAGE"=>$arParams['page'], "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
	while($ob = $res->GetNextElement())
	{
		$arResult[$s] = $ob->GetFields();
		$arResult[$s]['prop']=$ob->GetProperties();
		
		if(isset($arResult[$s]['prop']['WIKI_AUTO_URL']))
		{
			$arSelectWiki 	= Array("ID", "IBLOCK_ID", "NAME",);
			$arFilterWiki 	= Array("IBLOCK_ID"=>25, "ID"=>$arResult[$s]['prop']['WIKI_AUTO_URL']['VALUE'], "ACTIVE"=>"Y");
			$resWiki = CIBlockElement::GetList(Array(), $arFilterWiki, false, Array(), $arSelectWiki);
			if($obWiki = $resWiki->GetNextElement())
			{
				$arFieldsWiki = $obWiki->GetFields();
				$arResult[$s]['prop']['WIKI_AUTO_URL']['URL']='/services/wiki/'.str_replace('+', ' ', urlencode($arFieldsWiki['NAME']))."/";
				$arResult[$s]['prop']['HINT']['VALUE']=(int)$arResult[$s]['prop']['HINT']['VALUE']*1000;
			}
		}
		$s++;
	}
	if($s>0) $this->IncludeComponentTemplate();
?>