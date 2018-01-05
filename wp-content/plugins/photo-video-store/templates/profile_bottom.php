<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["clarifai"] ) {
?>
		<script type="text/javascript" src="https://sdk.clarifai.com/js/clarifai-latest.js"></script>
		<script>

		

		  
		  
		
		
		function get_clarifai(url,field_id,language,default_value) {
			lang_to_lang = {};		
			
			
			
			lang_to_lang["en"]  = "en";
			lang_to_lang["ru"]  = "ru";
			lang_to_lang["de"]  = "de";
			lang_to_lang["fr"]  = "fr";
			lang_to_lang["ar"]  = "ar";
			lang_to_lang["af1"] = "en";
			lang_to_lang["af2"] = "en";
			lang_to_lang["br"]  = "pt";
			lang_to_lang["bg"]  = "en";
			lang_to_lang["zh2"] = "zh";
			lang_to_lang["zh1"] = "zh-TW";
			lang_to_lang["ca"]  = "en";
			lang_to_lang["cs"]  = "en";
			lang_to_lang["da"]  = "da";
			lang_to_lang["nl"]  = "nl";
			lang_to_lang["et"]  = "en";
			lang_to_lang["fi"]  = "fi";
			lang_to_lang["ka"]  = "en";
			lang_to_lang["el"]  = "en";
			lang_to_lang["he"]  = "en";
			lang_to_lang["hu"]  = "hu";
			lang_to_lang["id"]  = "en";
			lang_to_lang["it"]  = "it";
			lang_to_lang["ja"]  = "ja";
			lang_to_lang["lv"]  = "en";
			lang_to_lang["lt"]  = "en";
			lang_to_lang["ms"]  = "en";
			lang_to_lang["no"]  = "no";
			lang_to_lang["fa"]  = "en";
			lang_to_lang["pl"]  = "pl";
			lang_to_lang["pt"]  = "pt";
			lang_to_lang["ro"]  = "en";
			lang_to_lang["sr"]  = "en";
			lang_to_lang["sk"]  = "en";
			lang_to_lang["sl"]  = "en";
			lang_to_lang["es"]  = "es";
			lang_to_lang["sv"]  = "sv";
			lang_to_lang["th"]  = "en";
			lang_to_lang["tr"]  = "tr";
			lang_to_lang["uk"]  = "ru";
			lang_to_lang["hr"]  = "en";
			lang_to_lang["is"]  = "en";
			lang_to_lang["vn"]  = "en";
			lang_to_lang["az"]  = "en";			
			
			if($("#recognition_lang").length>0)
			{
				language = $("#recognition_lang").val();
				if(default_value)
				{
					language = site_lang_symbol[$("#recognition_lang").val()];
				}
			}
			
			const app = new Clarifai.App({
			 apiKey: '<?php echo $pvs_global_settings["clarifai_key"] ?>'
			});
			
			regexp = /mp4$/i;
			
			if (url.match(regexp)) 
			{
				video_flag = true;
			}
			else
			{
				video_flag = false;
			}
			
			app.models.predict(Clarifai.GENERAL_MODEL, url, {video:video_flag}, {language: lang_to_lang[language]})
 			 .then(
				function(response) {
				//document.write(JSON.stringify(response));
				tags = "";
				
				if(default_value)
				{
					tags = $("#"+field_id).val();
				}
				
				tags_obj = {};
				
				if ( ! video_flag) 
				{
					for(i=0;i<response.rawData.outputs[0].data.concepts.length;i++)
					{
						if(tags !=	 "")
						{
							tags += ",";
						}
						tags += response.rawData.outputs[0].data.concepts[i].name;
					}
				}
				else
				{
					for(i=0;i<response.rawData.outputs[0].data.frames.length;i++)
					{
						for(j=0;j<response.rawData.outputs[0].data.frames[i].data.concepts.length;j++)
						{
							if(tags !=	 "")
							{
								tags += ",";
							}
							tags += response.rawData.outputs[0].data.frames[i].data.concepts[j].name;
						}
					}
				}
				
				tags_mass = tags.split(',');
				
				for(i=0;i<tags_mass.length;i++)
				{
					tags_obj[tags_mass[i]] = 1;
				}
				
				tags = "";
				
				for (var key in tags_obj) 
				{
					if(tags !=	 "")
					{
						tags += ", ";
					}
					tags += key;
				}
				
				if($("#"+field_id+"_box"))
				{
					$("#"+field_id+"_box").css("display","block");
				}
				$("#"+field_id).val(tags);
			  },
			  function(err) {
			  	//$("#"+field_id+"_box").css("display","block");
				//$("#"+field_id).val(err);
			  }
			);

		}
		
		function go_clarifai() {
			clarifai_files = {};
			<?php echo ( @$clarifai_files );?>
			for(key in clarifai_files) 
			{
				get_clarifai(clarifai_files[key],key,'<?php echo ( $lang_symbol[$lng_original] );?>',true)
			}
		}
		</script>
		<?php
}

if ( $pvs_global_settings["imagga"] ) {
?>
	<script>
	function get_imagga(url,field_id,language,default_value) 
	{
		lang_to_lang = {};	
		
		lang_to_lang["en"]  = "en";
		lang_to_lang["ru"]  = "ru";
		lang_to_lang["de"]  = "de";
		lang_to_lang["fr"]  = "fr";
		lang_to_lang["ar"]  = "ar";
		lang_to_lang["af1"] = "en";
		lang_to_lang["af2"] = "en";
		lang_to_lang["br"]  = "pt";
		lang_to_lang["bg"]  = "bg";
		lang_to_lang["zh2"] = "zh_chs";
		lang_to_lang["zh1"] = "zh_cht";
		lang_to_lang["ca"]  = "ca";
		lang_to_lang["cs"]  = "cs";
		lang_to_lang["da"]  = "da";
		lang_to_lang["nl"]  = "nl";
		lang_to_lang["et"]  = "et";
		lang_to_lang["fi"]  = "fi";
		lang_to_lang["ka"]  = "en";
		lang_to_lang["el"]  = "el";
		lang_to_lang["he"]  = "he";
		lang_to_lang["hu"]  = "hu";
		lang_to_lang["id"]  = "id";
		lang_to_lang["it"]  = "it";
		lang_to_lang["ja"]  = "ja";
		lang_to_lang["lv"]  = "lv";
		lang_to_lang["lt"]  = "lt";
		lang_to_lang["ms"]  = "ms";
		lang_to_lang["no"]  = "no";
		lang_to_lang["fa"]  = "fa";
		lang_to_lang["pl"]  = "pl";
		lang_to_lang["pt"]  = "pt";
		lang_to_lang["ro"]  = "ro";
		lang_to_lang["sr"]  = "sr_cyrl";
		lang_to_lang["sk"]  = "sk";
		lang_to_lang["sl"]  = "sl";
		lang_to_lang["es"]  = "es";
		lang_to_lang["sv"]  = "sv";
		lang_to_lang["th"]  = "th";
		lang_to_lang["tr"]  = "tr";
		lang_to_lang["uk"]  = "ru";
		lang_to_lang["hr"]  = "hr";
		lang_to_lang["is"]  = "en";
		lang_to_lang["vn"]  = "vi";
		lang_to_lang["az"]  = "en";
		
		if($("#recognition_lang").length>0)
		{
			language = $("#recognition_lang").val();
		}
		
		tags = "";
		
	   var req = new JsHttpRequest();
		req.onreadystatechange = function() 
		{
			if (req.readyState == 4) 
			{
				tags = "";
				tags_obj = {};
				
				
				if(default_value) {
					tags = $("#"+field_id).val();
					tags_mass = tags_result.split(',');
					
					for(i=0;i<tags_mass.length;i++) {
						tags_obj[tags_mass[i]] = 1;
					}
				}	
				
				
				tags_result =req.responseText;
				tags_mass = tags_result.split(',');
						
				for(i=0;i<tags_mass.length;i++) {
					tags_obj[tags_mass[i]] = 1;
				}
				
				for (var key in tags_obj) 
				{
					if(tags !=	 "") {
						tags += ", ";
					}
					tags += key;
				}
				
				if($("#"+field_id+"_box")) {
					$("#"+field_id+"_box").css("display","block");
				}
				$("#"+field_id).val(tags);
			}
		}
		req.open(null, '<?php echo (site_url( ) );?>/recognition-imagga/', true);
		req.send( {'url': url,'lang': lang_to_lang[language]} );
	}

	</script>
		
	
	<?php
}
?>
	<script>
	
	
	function apply_keywords(from_field, to_field) {
		if($("#recognition_lang")) {
			language = $("#recognition_lang").val();
		}
		
		keywords = $("#"+from_field).val();
		keywords_mass = keywords.split(',');
		
		keywords2 = $("#"+to_field).val();
		keywords_mass2 = keywords2.split(',');
		
		tags ="";
		tags_obj = {};
		
		for(i=0;i < keywords_mass2.length;i++) {
			tags_obj[keywords_mass2[i]] = 1;
		}
		
		for(i=0;i < keywords_mass.length;i++) {
			tags_obj[keywords_mass[i]] = 1;
		}

		for (var key in tags_obj) 
		{
			if(tags !=	 "")
			{
				tags += ", ";
			}
			tags += key;
		}
		
		$("#"+to_field).val(tags);
		$("#"+from_field+"_box").css("display","none");
		
		change_group('other') ;
		
		$('html, body').animate({
        	scrollTop: $("#"+to_field).offset().top
    	}, 2000);
	}
	
	</script>
</div></div>