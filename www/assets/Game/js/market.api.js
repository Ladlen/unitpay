function LoadList(pg,base_url,game)
{
	$.get(
		base_url+api_url,
		{
			a_id: 'Items',
			ipp: IPP,
			page: pg,
			seller: seller
		},
		function(data)
		{
			var array = JSON.parse(data);
			if(array['success'] == true)
			{
				var html_data = "";
				var item_count = array['item_count'];
				var item_data = array['item_data'];
				for(var i=0;i<item_data.length;i++)
				{
					var itd = item_data[i];
					var entry = baseEntryHtml;
					entry = entry.replace("%NAME%",itd['name']);
					entry = entry.replace("%ICON%",itd['icon']);
					entry = entry.replace("%PRICE%",itd['price']);
					entry = entry.replace("%BUY_URL%",base_url+"?id="+itd['offer_id']+"&s="+itd['seller']);
					html_data+=entry;
				}
				document.getElementById(game+"_hdata").innerHTML = html_data;
				document.getElementById(game+"_overall_cnt").innerHTML = item_count;
				
				//make page navigation
				var pg_cnt = item_count / IPP;
				var nav = "";
				for(var i = 0;i< pg_cnt;i++)
				{
					var iz = i + 1;
					var ent = baseNavHtml;
					ent = ent.replace("%ID%",iz).replace("%ONCLICK%","LoadList('"+i+"','"+base_url+"','"+game+"')");
					nav += ent;
				}
				document.getElementById(game+"_hnav").innerHTML = nav;
			}
		}
	);
}