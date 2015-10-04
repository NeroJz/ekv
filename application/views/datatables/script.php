
$(document).ready(function(){
	var oTable<?=$tableName?> = $("#<?=$tableName?>").dataTable({
		<?php
			if(sizeof($dtConfig) > 0)
			{
				foreach($dtConfig as $name => $val){
					if(substr($name,0,1) == "s")
						$val = '"'.$val.'"';
						
					echo '"'.$name.'" : '.$val.",\n";
				}
			}
		?>
	});
});

function fnCallback(){
	
}
