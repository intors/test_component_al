<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

    <script>
	<?foreach($arResult as $key => $hint)
	{?>
        function showWindow<?=$key?>(){
            var myWindow<?=$key?> = document.getElementById("mywindow<?=$key?>");
       
            myWindow<?=$key?>.style.visibility = "visible";
        }
        function closeWin<?=$key?>(){
            var myWindow<?=$key?> = document.getElementById("mywindow<?=$key?>");
            myWindow<?=$key?>.style.visibility = "hidden";
        }
		function closeW<?=$key?>(){
            var myWindow<?=$key?> = document.getElementById("mywindow<?=$key?>");
            myWindow<?=$key?>.style.visibility = "hidden";
        }
        window.onload = setTimeout(showWindow<?=$key?>,<?echo($arResult[$key]['prop']['HINT']['VALUE']);?>);
		window.onload = setTimeout(closeW<?=$key?>,<?echo($arResult[$key]['prop']['HINT']['VALUE']+20000);?>);
	<?}?>
    </script>
<?	
	foreach($arResult as $key => $hint)
	{	
		echo('<div class="mywindow" id="mywindow'.$key.'"><div id="closewin" onclick="closeWin'.$key.'()">X</div><div id="closew" onclick="closeWin'.$key.'()"><br><table width="95%" border="0px">');
		echo('<tr><td>
		<a href="'.$hint['prop']['WIKI_AUTO_URL']['URL'].'" target="_blank"><div>'.$hint['PREVIEW_TEXT'].'<br></div></a>
		</td></tr>');
		echo('</table></div></div>');
	}
	
	//echo '<pre>'; print_r($arResult['prop']['HINT']['VALUE']);echo '</pre>'; 
?>


