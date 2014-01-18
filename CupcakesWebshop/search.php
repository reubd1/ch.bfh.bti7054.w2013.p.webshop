<?php

include "functions.php";
/*
 * get input value of ajax search, search string on database and display the results
 */
if ($_POST["suche"]){
		// Mysql Abfrage mit den Notwendigen Parameter
		$items = ItemQuery::create()
		->where('Item.Name LIKE ?', '%'.mysql_real_escape_string(utf8_decode($_POST["suche"])).'%')
		->find();

		if(count($items)>0){
			foreach ($items as $result) {
					

				$display_url = "main.php?catid=".utf8_encode($result->getCategoryId());
				echo"<div class=\"show\" align=\"left\">
				<span class=\"name\"><a href='$display_url'>".utf8_encode($result->getName())."</a></span>
						</div>";
					
			}
		}
		else
		{
			echo "<div class=\"show\" align=\"left\">
					<span class=\"name\">No result found !</span></div>";
		}
}
?>

