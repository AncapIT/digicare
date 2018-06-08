// check and define $ as jQuery
if (typeof jQuery != "undefined") jQuery(function ($) {
       
  					
   /* $("a.fancybox").fancybox({
        openEffect: "none",
        width: "500",
        closeEffect: "none"
    });  
       
    $("textarea.form-control").ckeditor(); */
      
    // ------------------------- change select providers list -------------- 
  
    $('select.provider_select').change( function() {  
	   var provider = $( this ).val();
	   if( provider > 0 ) {  window.location.href = '/documents/index?&pid=' + provider ; }
    });
  
  
	// ------------------------- redirect to links from row -------------- 
	
  	 $('button.index_btns').click(function() {    
	 			var link = $(this).attr("data-link");
	 			window.location.href = link;
     });
     
      // ------------------------- change select providers list -------------- 
      
      $('div.message_row').click(function() {    
	 			var link = $(this).attr("data-link");
	 			window.location.href = link;
     }); 
     
      
     function show_hide_connections( role ) { 
	     $('div#binded_groups_area').hide();  $('div#binded_users_area').hide();
         $('.field-user-food').hide(); $('.field-user-consent').hide();
	 	 if ( role == 1 || role == 2 || role == 3 || role == 4 ) {  $('div#binded_groups_area').show(); }
	 	 if (  role == 1 || role == 2 || role == 3 ) {  $('div#binded_users_area').show(); }
         if (role == 4) { $('.field-user-food').show(); $('.field-user-consent').show();}

	 	 //if ( role == 1 || role == 4 ) {    $('div#binded_users_area').hide();   $('div#binded_groups_area').hide();    }
     }
     
     var role = $("select#user-user_role").val();
     show_hide_connections( role );
	 
	 $('select#user-user_role').change(function() {    
	 			var role = $(this).val();  console.log( "role: "+ role ); 
	 			show_hide_connections( role );
	 });
	   
	  
	 var add_item_counter = 1;  
	 
	 // add_product_item ------------------------------
	  $('a#add_product_item').click(function() {   
		  console.log('add item #'+add_item_counter);
		  var proto_item =  $('div#add_item_prototype').html();
	 	  $( proto_item ).appendTo('div#new_product_items_block');
	 	  
	 	  // change array key for added item
	 	  var last_item = $('div#new_product_items_block div.product_item').eq(-1);

	 	  last_item.css("border", "#F00 1px solid");
	 	  
	 	  last_item.find("input.prod_item_id").val( add_item_counter );
	 	  last_item.find("input.item_title").attr("name", "item_title[" + add_item_counter + "]" );
	 	  last_item.find("textarea.item_description").attr("name", "item_description[" + add_item_counter + "]" ); 
	 	  last_item.find("input.item_mandatory").attr("name", "item_mandatory[" + add_item_counter + "]" );
	 	  last_item.find("input.item_price").attr("name", "item_price[" + add_item_counter + "]" );
          last_item.find(".sit_price").addClass("sit_text_"+ add_item_counter + " sit_datetime_"+ add_item_counter + " sit_items_"+add_item_counter);
          last_item.find("select.select_item_type").attr("name", "item_type[" + add_item_counter + "]" );
          last_item.find("select.select_item_type").attr("item_id",  add_item_counter );
	 	  last_item.find("select.sort_items").attr("name", "sort_items[" + add_item_counter + "]" );
	 	  last_item.find(".sit_single_multi").addClass("sit_single_choice_"+ add_item_counter + " sit_multi_choice_"+ add_item_counter + " sit_items_"+add_item_counter);
	 	  
	 	  $( '<input type="hidden" name="new_item['+ add_item_counter +']" value="1">' ).appendTo( last_item );

	 	  bind_delete_actions();
	 	  bind_select_item_type();
	 	  add_choice_link();
	 	  add_item_counter++; 
		 
     }); 
     
     
     
     function bind_delete_actions() { 
	 
		 $('a.red_close_icon').unbind( "click" );
		     
	     // delete product item ------------------------------
		  $('a.red_close_icon').click(function() {    
		 	  var del_item =  $( this ).parent().parent();  
		 	  del_item.hide();
		 	  var prod_item_id = $( del_item ).find("input.prod_item_id").val();  
		 	  $( '<input type="hidden" name="del_item['+ prod_item_id +']" value="1">' ).appendTo( del_item );   
		  });  
	 }
	 bind_delete_actions(); 
	   
	 
	 
	 
	// add_choice_link------------------------------ // .css("border","#F00 1px solid");
	function add_choice_link() { 
		
		$('a.add_choice_link').unbind( "click" );  
		$('a.add_choice_link').click(function() {    
			
			var proto = $("div#item_choice_prototype").html();
			var place = $( this ).parent().parent().parent().parent();
			
			var prod_item_id = place.find(".prod_item_id").val();   console.log("prod_item_id: " + prod_item_id ); 
			 
			$( proto ).appendTo( place.find("div.choice_proto_placeholder") );  
			
			place.find( "table.choice_proto" ).find(".ic_sort").attr("name", "ic_sort[" + prod_item_id + "][]"); 
			place.find( "table.choice_proto" ).find(".ic_title").attr("name", "ic_title[" + prod_item_id + "][]"); 
			place.find( "table.choice_proto" ).find(".ic_desc").attr("name", "ic_desc[" + prod_item_id + "][]"); 
			place.find( "table.choice_proto" ).find(".ic_price").attr("name", "ic_price[" + prod_item_id + "][]"); 
			 
			bind_delete_choice();
		});  
	}
	add_choice_link();
	
	
	
 	// delete choice link ------------------------------
    
    function bind_delete_choice() { 
	 	
		$('span.delete_choice').unbind( "click" );
		 
		$('span.delete_choice').click(function() {    
		 	$( this ).parent().parent().parent().parent().remove();
		});  
	 }
	 bind_delete_choice();  
	   
	 
	 
	 
	 
	 // change type items ------------------------------  
	 
	function bind_select_item_type() {
		
		$('select.select_item_type').unbind( "change" );
	 
		$('select.select_item_type').change(function() {  
				var sel_type = $(this).val();
            var selected = $(this).val();
            var id = $(this).attr('item_id');
				var row = $(this).parent().parent(); // console.log( sel_type ); 
				if( sel_type == "single_choice" || sel_type == "multi_choice"  ) { row.find("a.add_choice_link").show(); } 
				else { row.find("a.add_choice_link").hide(); }
            organizeInputs(selected,id)

		}); // end click 
		 
	} 
	bind_select_item_type();
		   
	
	   
	 	 
}); // end -------- PAGE READY 





// ..........................................  Functions

function isset( vvv ){  
     if( typeof( vvv ) === 'undefined' || typeof( vvv ) == 'undefined' || typeof( vvv ) === undefined ||  vvv == null ||  vvv == 'null' || vvv == '' || !vvv ){  return false; }
     else { return true }
 }  
 
 
 
 
 
 
 
 
 
