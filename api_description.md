 
 api/login 
  ---------------
  Method API for check login params and get user level 
    
 <h5> request params: </h5>
  <li>login</li>
   <li>password</li>
 <h5>responce</h5>
    success:
     <li>status ( 'ok' )</li>
     <li>user_role</li>
     2  = 'staff'; 3  = 'relative'; 4 = 'patient'
     <li>result ('valid')</li>
     <li>user_type</li>
     <li>user_id</li>
    <li> authToken</li>
    error:
    <li>result ('error')</li>
    <li>error_message</li>
    <li>error</li>
     
    
   app/login_bankid
   -------------------
  <h5> request GET</h5>
   params:
   <li>grandidsession</li>
  <h5> responce:</h5>
   json responce from bank_id API
      
   api/get_patients_list()
  ------------------------
  Method API for select patients list for Staff or Relative
   <h5> request GET</h5>
     params:
     <li>authToken
     <li>user_id
     responce:
   <li>status ( 'ok' )</li>
   <li>provider_id</li>
   <li>first_name</li>
   <li>last_name"</li>
    <li>phone</li>
    <li>email</li>
    <li>photo</li>
    <li>lang</li>
    <li>patients ([user_id]=>[$patient_info["patient_id"
                              			    	"provider_id"
                              			    	"first_name"
                              			    	"last_name"
                              			    	"phone"
                              			    	"email"
                              			    	"address"
                              			    	"city"
                              			    	"photo"
                              			    	"lang"])
                              			    	
                              			    	
                              			    	
   <li>patients_num</li>
    
    
   api/get_personal_push_list
   ---------------------------
   Method API for select personal notification for users
   <h5> request POST</h5>
  <li>authToken</li>
  <li>user_id</li>
  <li>patient_id</li>
  <h5>responce</h5>
   <li>["mess_list"][ $num ]["push_title"] 
   <li>["mess_list"][ $num ]["push_type"] 
   <li>["mess_list"][ $num ]["created_time"]
   <li>["mess_list"][ $num ]["pid"] 
  					   	 
  api/get_provider_info  	 
  ------------------
  Load generall info about Provider
  <h5>request POST </h5>
  <li>'authToken'
  <li>'provider_id' 
    <h5>reaponce</h5>
    <li>"provider_title"</li>
    <li>"provider_logo"</li>
    <li>"provider_menu_logo"</li>
    <li>"color_model"</li>
    <li>"provider_info"</li>
    <li>"currency"</li>
    <li>"stripe_currency"</li>
    <li>"currency_place"</li>
    
  api/get_pages
  ---------------
  <h5>request POST</h5>
  param: page_name
    <h5>responce</h5>
   <li> title
   <li> page_info
   <li> sub_links
   
   
  api/get_homepage_items
  ---------------------
   Select all Homepage items for this Provider
  <h5>request POST</h5>
    param:<li>'authToken'
   <li> 'provider_id'
     <h5>responce</h5>
     <li>status
      	<li>["menu_items"][ $num ]["menu_title"]
     					   	<li>["menu_items"][ $num ]["menu_icon"]
     					   	<li>["menu_items"][ $num ]["menu_link"] 
     					   	<li>["menu_items"][ $num ]["menu_type"] 
     					   <li>["menu_items"][ $num ]["level"]  
    
   api/get_documents 
   --------------------
  Get documents List and Single view
   <h5>request POST</h5>
      param:
      <li>'authToken'</li>   
    		 <li>'user_id'</li> 
    		 <li>'task'</li> 
    		 <li>'doc_type'</li>
    		 <li>'item_id'</li>
    		 <li>'patient_id'</li>
     <h5>responce</h5>
     	status
     	 <li>item_date</li>
        						   	 <li>item_title</li>
        						   	 <li>image</li>
        						   	 <li>item_content</li> 
        						   	 <li>item_header</li> 
        						     <li>pdf_link</li>	 
 
   api/get_products_list
   -----------------------
   Get page Product List
   <h5>request POST</h5>
     param:	 
	<li>'authToken'</li>   
  <li>'user_id'</li>  
 <li>'parent_page'</li>  
 <h5>responce</h5>
 <li>["menu_items"][ $num ]["menu_title"]
 						   	<li>["menu_items"][ $num ]["menu_icon"]
 						   	<li>["menu_items"][ $num ]["menu_link"]
                                    <li>["menu_items"][ $num ]["sort_id"]
 						   	<li>["menu_items"][ $num ]["menu_type"]
 						   	<li>["menu_items"][ $num ]["level"] 
 						   	<li>"title"  
						   	<li>"page_desc"
						   	

						   	 
  api/get_product
  ---------------
  Get page Product Details
  <h5>request POST</h5>
       param:	
     	<li>'authToken'	</li>   
       			<li>'user_id'	</li>  
       			<li>'page_link'	</li>
     <h5>responce</h5>
     <li>"product_title"
<li>"product_desc"
<li>"sort_id"
<li>["items"][ $'prod_item_id' ]["title"]
<li>["items"][ $'prod_item_id' ]["description"] 
<li>["items"][ $'prod_item_id' ]["price"]
<li>["items"][ $'prod_item_id' ]["mandatory"]
<li>["items"][ $'prod_item_id' ]["item_id"]
<li>["items"][ $'prod_item_id' ]["item_type"];  
<li>["items"][ $'prod_item_id' ]["choices"][ $row3['id'] ]["title"] 
<li>["items"][ $'prod_item_id' ]["choices"][ $row3['id'] ]["description"] 
<li>["items"][ $'prod_item_id' ]["choices"][ $row3['id'] ]["prod_item_id"]
      
                                                      					
 api/save_order
 ---------------
 Save Patients Order
 <h5>request POST</h5>
        param:	
        <li>'authToken'</li>
<li>'user_id'</li>
<li>'patient_id'</li>
<li>'page_link'</li>
<li>'order_title'</li>
<li>'order_data'</li>
<li>'price'</li>
<li>'currency'</li>
    <h5>responce</h5>
   <li> "status" = 'ok'
    <br>or
    <li>"error" = $error;
    
  api/get_orders_history
  -----------------------
  
  Get Orders History for this Patient
<h5>request POST</h5>
        param:
   <li>'authToken'</li>   
<li>'user_id'</li>     
<li>'patient_id'</li>  
<h5>responce</h5>
<li>"status" = 'ok'
<li>['orders'][ $num ]["order_title"]
<li>['orders'][ $num ]["price"]
<li>['orders'][ $num ]["order_status"]
<li>['orders'][ $num ]["create_date"] 
<li>['orders'][ $num ]["selected_items"]

api/get_food_menu
--------------------
Get Food Menu Items
<h5>request POST</h5>
        param:
    <li>'authToken'</li>   
<li>'user_id'</li>   
<li>'page_link'</li>  
   <h5>responce</h5>
   <li>"status"] = 'ok'
      <li>"product_title"]
						<li> "product_desc" </li>
						<li> "visit_date" </li>
						<li> "from_date" </li> 
						<li> "to_date" </li>
						<li> "price" </li> 
						<li> "comment" </li>  
						<li> "icon" </li>
						<li> "sort_id" </li>
						<li> "food_menu" </li>     	
	
api/load_patient
----------------

<h5>request POST</h5>
        param:
<li>'authToken' </li>   
	<li>'user_id' </li>  
<li>'patient_id' </li>  
<h5>responce</h5>
   <li>"status" = 'ok'
  <li>[patient_info]["patient_id"]
   			    	 <li> [patient_info]["provider_id"]
   			    	 <li> [patient_info]["first_name"]
   			    	 <li> [patient_info]["last_name"]
   			    	 <li> [patient_info]["phone"] 
   			    	 <li> [patient_info]["email"]
   			    	 <li> [patient_info]["address"] 
   			    	 <li> [patient_info]["city"] 
   			    	 <li> [patient_info]["photo"] 
   			    	 <li> [patient_info]["lang"]

    
api/update_profile
-------------------

<h5>request POST</h5>
        param:
        
<li>'authToken' </li>   
	<li>'user_id' </li>  
<li>'patient_id' </li>  
<li>'first_name' </li> 
		<li>'last_name' </li> 
	<li>'address' </li> 
		<li>'city' </li> 
		<li>'email' </li> 
		<li>'phone' </li> 
	<li>'new_password' </li> 
<li>'old_password' </li> 

<h5>responce</h5>
   <li>"status" = 'ok'
   
api/get_chat
-------------

<h5>request POST</h5>
        param:
<li>'authToken' </li>
<li>'user_from' </li>
<li>'user_to' </li>
<li>'user_type' </li>
<li>'last_message_id' </li>

<h5>responce</h5>
   <li>"status"</li>
   <li>"updated"]</li>
   <li>"last_message_id"]</li>
   <li>"messages"][$num]["id"]</li>
                            <li>"messages"][$num]["messageText"]</li>
                            <li>"messages"][$num]["attachment_url"]</li>
                            <li>"messages"][$num]["user_type"]</li>
                            <li>"messages"][$num]["time"]</li>
                            <li>"messages"][$num]["user_photo"]</li>
                            <li>"messages"][$num]["user_name"]</li>
   
api/send_chat
--------------

<h5>request POST</h5>
        param:
        
<li>'authToken' </li>
<li>'user_id' </li>
<li>'user_to' </li>
<li>'message' </li>
<li>'action' </li>

<h5>responce</h5>
   <li>"status" = 'ok'
    <li>"group_id"
     <li>"updated"
   
   
api/upload_image
-------------------

 <h5>request POST</h5>
         param:
<li>'authToken' </li>   
<li>'user_id' </li>  
<li>'action' </li>
$_FILES['wpua-file']['name'];

<h5>responce</h5>
<li>"updated" = true

api/check_app_version
---------------------

 <h5>request POST</h5>
         param:
    <li>'authToken' </li>    
     		
 <h5>responce</h5>
    <li>"status" = 'ok'
    <li>"app_version"    		          
         

api/load_user
-------------

 <h5>request POST</h5>
         param:
<li>'authToken' </li>   
<li>'user_id' </li>  

 <h5>responce</h5>
    <li>"status" = 'ok'
    <li>["user_info"]["patient_id"]</li>
    <li>["user_info"]["provider_id"]</li>
    <li>["user_info"]["first_name"] </li>
    <li>["user_info"]["last_name"]</li> 
    <li>["user_info"]["phone"]</li> 
    <li>["user_info"]["email"]</li>
    <li>["user_info"]["address"] </li>
     <li>["user_info"]["city"]</li>  
   <li>["user_info"]["photo"]</li> 
    	<li>["user_info"]["lang"]</li>  
    			    	
api/stripe_paymen
--------------------
   	
 <h5>request POST</h5>
         param:
<li>'authToken'</li>
<li>'user_id'</li>
<li>'token'</li>
<li>'amount'</li>
<li>'currency'</li>
<li>'description'</li>
<li>'action'</li>
<li>'order_id'</li>

 <h5>responce</h5>
    <li>"status" = 'ok'
<li>"payment_result"</li>
<li>"transaction_id"</li>
<li>"card_token"</li>

api/cancel_order
-----------------
   	
 <h5>request POST</h5>
         param:
        <li> 'order_id'

 <h5>responce</h5>
    <li>"status" = 'ok'

api/login_bank_id
---------------------
 <h5>request GET</h5>
 <li>' personNumber'
 <li>'sessionId'
 
  <h5>responce</h5>
  <li>redirectURL
   <li> sessionID
   
   
api/check_if_can_order
---------------------
 <h5>request GET</h5>
 <li>user_id 
  <li>product_id 
 <li>patient_id
 
  <h5>responce</h5>
  <li>"status" = 'ok'
   <li> can_order = true/false
   
   
api/get_user_modules
---------------------
 <h5>request POST</h5>
 <li>user_id 

  <h5>responce</h5>
 <li>"status" = 'ok'
 <li> modules = array of modules
   
api/log_log_out
----------------
 <h5>request GET</h5>
 <li>user_id 
 <h5>responce</h5>
 <li>"status" = 'ok'