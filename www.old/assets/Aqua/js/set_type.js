function set_type_rate(rate){$.ajax({url:"/main/type_rate",data:"currency="+rate+"",type:"POST",success:function(data){if(data=='success'){location.reload();}}});};function set_type_sort(){sorting_type=$("select#sorting").val();$.ajax({url:"/main/type_sort",data:"sorting="+sorting_type+"",type:"POST",success:function(data){if(data=='success'){location.reload();}}});};