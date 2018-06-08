<?php   error_reporting(0);

	    $page = $_POST["page_name"];   
		 
		$result["status"] = 'ok';   
		
		
//---------------------------------------------  Services ---------------------------------------------
		
		if ( $page == 'Services' ) { 
			
			$result["title"] = 'Services'; 
			$result["page_info"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat !'; 
			
			$items[0]["sub_title"] = "Order <br> Accompanier";  $items[0]["link"] = 'OrderAccompanier'; $items[0]["icon"] = 'app-accomp_order'; 
			$items[1]["sub_title"] = "Cancel <br> Accompanier";  $items[1]["link"] = 'CancelAccompanier'; $items[1]["icon"] = 'app-accomp_cancel'; 
			$items[2]["sub_title"] = "Pharmacy <br/> Pickup";  $items[2]["link"] = 'Pharmacy'; $items[2]["icon"] = 'app-medical'; 
			$items[3]["sub_title"] = "Cancel <br/> Scheduled Visit";  $items[3]["link"] = 'CancelVisit'; $items[3]["icon"] = 'app-cancel_visit'; 
			
			$result["sub_links"] = $items; 	
		}
		
		

		
//---------------------------------------------  AddServices ---------------------------------------------
		
		if ( $page == 'AddServices' ) { 
			
			$result["title"] = 'Additional services'; 
			$result["page_info"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat !'; 
			
			$items[0]["sub_title"] = "Foot care";  $items[0]["link"] = 'FootCare'; $items[0]["icon"] = 'app-footprint'; 
			$items[1]["sub_title"] = "Massage";  $items[1]["link"] = 'Massage'; $items[1]["icon"] = 'app-massage'; 
			$items[2]["sub_title"] = "Watching";  $items[2]["link"] = 'Watching'; $items[2]["icon"] = 'app-care'; 
			$items[3]["sub_title"] = "Pets";  $items[3]["link"] = 'Pets'; $items[3]["icon"] = 'app-dogs'; 
			$items[4]["sub_title"] = "Extra cleaning";  $items[4]["link"] = 'ExtraCleaning'; $items[4]["icon"] = 'app-cleaning'; 
			$items[5]["sub_title"] = "Promenade";  $items[5]["link"] = 'Promenade'; $items[5]["icon"] = 'app-promenad'; 
			$items[6]["sub_title"] = "Snow cleaning";  $items[6]["link"] = 'Snow'; $items[6]["icon"] = 'app-snowman'; 
			$items[7]["sub_title"] = "Gymnastics";  $items[7]["link"] = 'Gymnastics'; $items[7]["icon"] = 'app-sport'; 
			
			$result["sub_links"] = $items; 	
		}
		



//---------------------------------------------  AddServices ---------------------------------------------
		
		if ( $page == 'AboutPatient' ) { 
			
			$result["title"] = 'About Patient'; 
			$result["header"] = ''; 
			$result["news_date"] = ''; 
			$result["big_image"] = './assets/imgs/news-details-image.jpg'; 
			
			$result["page_desc"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat'; 
			
			$items[0]["patient_photo"] = "./assets/imgs/old-man-1.jpg";  
			$items[0]["patient_name"] = 'Karl Johnsson'; 
			$items[0]["address"] =  'Storgatan 14, Nyköpin';
			$items[0]["patient_email"] =  'test@example.com';
			$items[0]["patient_phone"] =  '+1234567890';
			
			$result["patient_info"] = $items; 	
		}		






//---------------------------------------------  Newsletter ---------------------------------------------
		
		if ( $page == 'Newsletter' ) { 
			
			$result["title"] = 'Newsletter'; 
			$result["header"] = ''; 
			$result["page_desc"] = ''; 
			  
			$num = 0; 
			while( $num <= 10 ) {   
				
				$items[ $num ]["doc_title"] = "News Article Lorem ipsum test dolor sit amet...";  
				$items[ $num ]["link"] = 'NewsDetails'; 
				$items[ $num ]["image"] = './assets/imgs/sample-news-pic.jpg';
				$items[ $num ]["date"] =  '2018-02-19'; 
				
			$num++; }
			
			$result["docs_items"] = $items; 	
		}		
		



//---------------------------------------------  Diary ---------------------------------------------
		
		if ( $page == 'Diary' ) { 
			
			$result["title"] = 'Information'; 
			$result["header"] = 'Diary'; 
			$result["page_desc"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo conseq'; 
			  
			$num = 0; 
			while( $num <= 10 ) {   
				
				$items[ $num ]["doc_title"] = "Diary Subtitle Lorem ipsum test dolor sit amet...";  
				$items[ $num ]["link"] = 'DiaryDetails'; 
				$items[ $num ]["image"] = '';
				$items[ $num ]["date"] =  '2018-02-20'; 
				
			$num++; }
			
			$result["docs_items"] = $items; 	
		}		





//---------------------------------------------  Calendar ---------------------------------------------
		
		if ( $page == 'Calendar' ) { 
			
			$result["title"] = 'Information'; 
			$result["header"] = 'Calendar'; 
			$result["page_desc"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat ! <br/><br/>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat ! <br/><br/>'; 
		 
			
			$result["big_image"] = ''; 
			$result["patient_info"] = ''; 	
		}		
		
		



		
//---------------------------------------------  Implementation Details ---------------------------------------------
		
		if ( $page == 'Implementation' ) { 
			
			$result["title"] = 'Implementation Plan'; 
			$result["header"] = ' Lorem ipsum dolor sit amet, consectetur adipiscing elit'; 
			$result["page_desc"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br/> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat '; 
		 
			// patient_info
			$items[0]["patient_photo"] = "./assets/imgs/old-man-1.jpg";  
			$items[0]["patient_name"] = 'Karl Johnsson'; 
			$items[0]["address"] =  'Storgatan 14, Nyköpin';
			$items[0]["patient_email"] =  '';
			$items[0]["patient_phone"] =  '+1234567890';
			
			$result["patient_info"] = $items;
			
			$result["pdf_link"] = 'qqqqqqqqqq'; 	
		}		
		



		
//---------------------------------------------  Help Page Details ---------------------------------------------
		
		if ( $page == 'HelpPage' ) { 
			
			$result["title"] = 'Help'; 
			$result["header"] = ' Lorem ipsum dolor sit amet, consectetur adipiscing elit'; 
			$result["page_desc"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br/> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat '; 
		 
			
			$result["news_date"] = ''; 
			$result["big_image"] = ''; 
			$result["patient_info"] = ''; 
			$result["pdf_link"] = ''; 	
		}	
		
		
		
//---------------------------------------------  About  Page Details ---------------------------------------------
		
		if ( $page == 'AboutPage' ) { 
			
			$result["title"] = 'About'; 
			$result["header"] = ' Lorem ipsum dolor sit amet, consectetur adipiscing elit'; 
			$result["page_desc"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br/> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat '; 
		 
			
			$result["news_date"] = ''; 
			$result["big_image"] = './assets/imgs/sample-news-pic.jpg'; 
			$result["patient_info"] = ''; 
			$result["pdf_link"] = ''; 	
		}	
		
			
	
			


//---------------------------------------------  Example Diary Details ---------------------------------------------
		
		if ( $page == 'DiaryDetails' ) { 
			
			$result["title"] = 'Diary Details'; 
			$result["header"] = ' Diary ipsum dolor sit amet, consectetur adipiscing elit'; 
			$result["page_desc"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br/> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat '; 
		 
			
			$result["news_date"] = '2018-02-17'; 
			$result["big_image"] = ''; 
			$result["patient_info"] = ''; 	
		}
		
 		
		
//---------------------------------------------  Example News Details ---------------------------------------------
		
		if ( $page == 'NewsDetails' ) { 
			
			$result["title"] = 'News Details'; 
			$result["header"] = ' Lorem ipsum dolor sit amet, consectetur adipiscing elit'; 
			$result["page_desc"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br/> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat '; 
		 
			
			$result["news_date"] = '2018-02-17'; 
			$result["big_image"] = './assets/imgs/news-details-image.jpg'; 
			$result["patient_info"] = ''; 	
		}		
		
		
			 
 
 //---------------------------------------------  OrderAccompanier ---------------------------------------------
		
		if ( $page == 'OrderAccompanier' ) { 
			
			$result["title"] = 'Order Accompanier'; 
			$result["page_info"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat '; 
		  
				$items[ 0 ]["visit_date"] =  true;  
				$items[ 0 ]["visit_time"] = true; 
				$items[ 0 ]["comment"] = true;
				$items[ 0 ]["icon"] =  ''; 
				$items[ 0 ]["price"] =  0; 
			 
			$result["fields"] = $items; 
		}		
		
		
		
		
 
 //---------------------------------------------  CancelAccompanier ---------------------------------------------
		
		if ( $page == 'CancelAccompanier' ) { 
			
			$result["title"] = 'Cancel Accompanier'; 
			$result["page_info"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat '; 
		 
				$items[ 0 ]["visit_date"] =  true;  
				$items[ 0 ]["visit_time"] = true; 
				$items[ 0 ]["comment"] = true;
				$items[ 0 ]["icon"] =  ''; 
				$items[ 0 ]["price"] =  0; 
			 
			$result["fields"] = $items; 
		}		
		
		
		 
 //---------------------------------------------  Pharmacy ---------------------------------------------
		
		if ( $page == 'Pharmacy' ) { 
			
			$result["title"] = 'Pharmacy Pickup'; 
			$result["page_info"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat '; 
			
				$items[ 0 ]["visit_date"] =  false;  
				$items[ 0 ]["visit_time"] = false; 
				$items[ 0 ]["comment"] = true;
				$items[ 0 ]["icon"] =  ''; 
				$items[ 0 ]["price"] =  0; 
			 
			$result["fields"] = $items; 
		}	
		
		

//---------------------------------------------  CancelVisit ---------------------------------------------
		
		if ( $page == 'CancelVisit' ) { 
			
			$result["title"] = 'Cancel Scheduled Visit'; 
			$result["page_info"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat '; 
		 
				$items[ 0 ]["visit_date"] =  false;  
				$items[ 0 ]["visit_time"] = false; 
				
				$items[ 0 ]["from_date"] =  true;
				$items[ 0 ]["to_date"] =  true; 
				$items[ 0 ]["from_time"] =  true;
				$items[ 0 ]["to_time"] =  true; 
				
				$items[ 0 ]["comment"] = true;
				$items[ 0 ]["icon"] =  ''; 
				$items[ 0 ]["price"] =  0; 
			 
			$result["fields"] = $items; 
		}		
		
		
//---------------------------------------------  FootCare ---------------------------------------------
		
		if ( $page == 'FootCare' ) { 
			
			$result["title"] = 'Foot Care'; 
			$result["page_info"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat '; 
		 
				$items[ 0 ]["visit_date"] =  true;  
				$items[ 0 ]["visit_time"] = true; 
				$items[ 0 ]["comment"] = true;
				$items[ 0 ]["icon"] =  ''; 
				$items[ 0 ]["price"] =  20; 
			 
			$result["fields"] = $items; 
		}		
		
		
		
//---------------------------------------------  Massage ---------------------------------------------
		
		if ( $page == 'Massage' ) { 
			
			$result["title"] = 'Massage'; 
			$result["page_info"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat '; 
		 
		 
				$items[ 0 ]["visit_date"] =  true;  
				$items[ 0 ]["visit_time"] = true; 
				$items[ 0 ]["comment"] = true;
				$items[ 0 ]["icon"] =  ''; 
				$items[ 0 ]["price"] =  33; 
			 
			$result["fields"] = $items; 
		}		
		
		
		
		
//---------------------------------------------  Watching ---------------------------------------------
		
		if ( $page == 'Watching' ) { 
			
			$result["title"] = 'Watching'; 
			$result["page_info"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat '; 
		 
		 
				$items[ 0 ]["visit_date"] =  true;  
				$items[ 0 ]["visit_time"] = true; 
				$items[ 0 ]["comment"] = true;
				$items[ 0 ]["icon"] =  ''; 
				$items[ 0 ]["price"] =  22; 
			 
			$result["fields"] = $items; 
		}		
		
		
		
//---------------------------------------------  Pets ---------------------------------------------
		
		if ( $page == 'Pets' ) { 
			
			$result["title"] = 'Pets'; 
			$result["page_info"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat  '; 
		 
		 
				$items[ 0 ]["visit_date"] =  true;  
				$items[ 0 ]["visit_time"] = true; 
				$items[ 0 ]["comment"] = true;
				$items[ 0 ]["icon"] =  ''; 
				$items[ 0 ]["price"] =  11; 
			 
			$result["fields"] = $items; 
		}		
		
		
		
		
		
//---------------------------------------------  ExtraCleaning ---------------------------------------------
		
		if ( $page == 'ExtraCleaning' ) { 
			
			$result["title"] = 'Extra Cleaning'; 
			$result["page_info"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat '; 
		 
		 
				$items[ 0 ]["visit_date"] =  true;  
				$items[ 0 ]["visit_time"] = true; 
				$items[ 0 ]["comment"] = true;
				$items[ 0 ]["icon"] =  ''; 
				$items[ 0 ]["price"] =  44; 
			 
			$result["fields"] = $items; 
		}		
		
		
		
		
//---------------------------------------------  Promenade ---------------------------------------------
		
		if ( $page == 'Promenade' ) { 
			
			$result["title"] = 'Snow cleaning'; 
			$result["page_info"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat  '; 
		 
		 
				$items[ 0 ]["visit_date"] =  true;  
				$items[ 0 ]["visit_time"] = true; 
				$items[ 0 ]["comment"] = true;
				$items[ 0 ]["icon"] =  ''; 
				$items[ 0 ]["price"] =  40; 
			 
			$result["fields"] = $items; 
		}		
		


		
		
//---------------------------------------------  Snow ---------------------------------------------
		
		if ( $page == 'Snow' ) { 
			
			$result["title"] = 'Promenade'; 
			$result["page_info"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat  '; 
		 
		 
				$items[ 0 ]["visit_date"] =  true;  
				$items[ 0 ]["visit_time"] = true; 
				$items[ 0 ]["comment"] = true;
				$items[ 0 ]["icon"] =  ''; 
				$items[ 0 ]["price"] =  88; 
			 
			$result["fields"] = $items; 
		}	
		 
		
//---------------------------------------------  Snow ---------------------------------------------
		
		if ( $page == 'Gymnastics' ) { 
			
			$result["title"] = 'Gymnastics'; 
			$result["page_info"] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat  '; 
		 
		 
				$items[ 0 ]["visit_date"] =  true;  
				$items[ 0 ]["visit_time"] = true; 
				$items[ 0 ]["comment"] = true;
				$items[ 0 ]["icon"] =  ''; 
				$items[ 0 ]["price"] =  11; 
			 
			$result["fields"] = $items; 
		}			
 
	 
                      
			 
 //  ------------------------------ OUTPUT DATA ------------------------	 

if (!empty($error)) {   $result["error"] = $error;  }

if (!empty($result)) {
    echo json_encode( $result, JSON_UNESCAPED_UNICODE );
} 		
  
      /* 
	      
	      
	        	//----------------------------------------
	     if ( page_name == 'OrderAccompanier' ) {   
		   
		    page_data = [{
			
			title: 'Order Accompanier',  
	     	page_info: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat !',
	     	fields:  [  
			 	{ visit_date: true, visit_time: true, comment: true, icon: '', price: 0 }, 
	     		] 
	     	}];
		  } // end - OrderAccompanier



	      */  
?>