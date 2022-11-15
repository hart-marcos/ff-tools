<?php


		
		
		function final_ ($type_,$new){
			
			$old = json_decode(file_get_contents("calendar/". $type_. ".json"));
			
			$myfile = fopen("calendar/" . $type_ . ".json", "w") or die("Unable to open file!");
        
            $final_urls = array_merge($new,$old);
			
			fwrite($myfile, json_encode($final_urls));
		
			fclose($myfile);
			
			print_r($old);
			
		}
		
	
	final_("yellow",["555","yhyhh"]);
	


?>