<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!CModule::IncludeModule("iblock"))
	return;

	$s=0;
	$arResult=array();
	$arSelect 	= Array("ID", "IBLOCK_ID", "NAME", "CODE", "PROPERTY_*", "PREVIEW_TEXT");
	$arFilter 	= Array("IBLOCK_ID"=>$arParams['IBLOCK_ID_HINT'], 
				array(
					"LOGIC" => "OR",
					"PROPERTY_ADDR_PAGE"=>$arParams['page'], 
					"PROPERTY_DATE_SHOU"=>date("Y-m-d"),
					), 
					
					"ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
	
	while($ob = $res->GetNextElement())
	{
		$arResult[$s] = $ob->GetFields();
		$arResult[$s]['prop']=$ob->GetProperties();
		
		if($arResult[$s]['prop']['N_HINT']>0)
		{
			if(!($_SESSION['HINT'][$arResult[$s]['ID']]>=0))
			{
				$_SESSION['HINT'][$arResult[$s]['ID']]=0;
			}
			else
			{
				$_SESSION['HINT'][$arResult[$s]['ID']]++;
				if($_SESSION['HINT'][$arResult[$s]['ID']]>=$arResult[$s]['prop']['N_HINT']['VALUE'])
				{
						unset($arResult[$s]);
				}
			}
		}
		if(isset($arResult[$s]['prop']['WIKI_AUTO_URL']))
		{
			$arSelectWiki 	= Array("ID", "IBLOCK_ID", "NAME",);
			$arFilterWiki 	= Array("IBLOCK_ID"=>$arParams['IBLOCK_ID_WIKI'], "ID"=>$arResult[$s]['prop']['WIKI_AUTO_URL']['VALUE'], "ACTIVE"=>"Y");
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
	//echo '<pre>'; print_r($_SESSION['HINT']);echo '</pre>'; 
	if($s>0) $this->IncludeComponentTemplate();
?>