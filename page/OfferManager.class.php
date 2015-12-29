<?php

class OfferManager {
	
	private $connection;
    private $user_id;
    
    function __construct($mysqli, $user_id){
        
        $this->connection = $mysqli;
        $this->user_id = $user_id;
	
	}
	
	function createNewOrder($text_type, $subject, $target_group, $description, $source, $length, $offer_deadline, $work_deadline, $output){
		
		$stmt = $this->connection->prepare("INSERT INTO requests(company_ID, text_type, subject, description, target_group, source, length, offer_deadline, work_deadline, output, created) VALUES(?,?,?,?,?,?,?,?,?,?, NOW())");
		$stmt->bind_param("issssssiss", $_SESSION['logged_in_user_id'], $text_type, $subject, $description, $target_group, $source, $length, $offer_deadline, $work_deadline, $output);
		
		$message = "";
		
		if($stmt->execute()){
            $message = "Edukalt andmebaasi salvestatud!";
		}
		
		$stmt->close();
		
		return $message;
	}
	
	function getAllData($keyword = ""){
		
		if($keyword == ""){
			$search = "%%";	
		}else{
			$search = "%".$keyword."%";
		}
		
		$stmt = $this->connection->prepare("SELECT request_ID, company_ID, company_name, text_type, subject, description, target_group, source, length, offer_deadline, work_deadline, output, status, requests.created FROM requests JOIN users ON users.user_id=requests.company_id WHERE requests.deleted IS NULL AND (request_ID LIKE ? OR company_ID LIKE ? OR company_name LIKE ? OR text_type LIKE ? OR subject LIKE ? OR description LIKE ? OR target_group LIKE ? OR source LIKE ? OR length LIKE ? OR offer_deadline LIKE ? OR work_deadline LIKE ? OR output LIKE ? OR status LIKE ? OR requests.created LIKE ?)");
		$stmt->bind_param("iissssssssssss", $id_from_db, $company_id_from_db, $search, $search, $search, $search, $search, $search, $search, $search, $search, $search, $search, $search);
		$stmt->bind_result($id_from_db, $company_id_from_db, $company_name_from_db, $text_type_from_db, $subject_from_db, $description_from_db, $target_group_from_db, $source_from_db, $length_from_db, $offer_deadline_from_db, $work_deadline_from_db, $output_from_db, $status_from_db, $created_from_db);
		$stmt->execute();
		
		$array = array();
		
		while($stmt->fetch()){
			
			$order = new Stdclass();
			
			$order->request_ID = $id_from_db;
			$order->company_id = $company_id_from_db;
			$order->company_name = $company_name_from_db;
			$order->text_type = $text_type_from_db;
			$order->subject = $subject_from_db;
			$order->target_group = $target_group_from_db;
			$order->description = $description_from_db;
			$order->source = $source_from_db;
			$order->length = $length_from_db;
			$order->offer_deadline = $offer_deadline_from_db;
			$order->work_deadline = $work_deadline_from_db;
			$order->output = $output_from_db;
			$order->status = $status_from_db;
			$order->created = $created_from_db;
			
			array_push($array, $order);
		}
		
		return $array;
		
		$stmt->close();
	}
	
	function getSingleOrderData($id){
		
		$stmt = $this->connection->prepare("SELECT text_type, subject, description, target_group, source, length, offer_deadline, work_deadline, output FROM requests WHERE request_ID=? AND company_ID=? AND deleted IS NULL");
		$stmt->bind_param("ii", $id, $_SESSION["logged_in_user_id"]);
		$stmt->bind_result($text_type_from_db, $subject_from_db, $description_from_db, $target_group_from_db, $source_from_db, $length_from_db, $offer_deadline_from_db, $work_deadline_from_db, $output_from_db);
		$stmt->execute();
		
		$order = new Stdclass();
		
		if($stmt->fetch()){
			$order->text_type = $text_type_from_db;
			$order->subject = $subject_from_db;
			$order->target_group = $target_group_from_db;
			$order->description = $description_from_db;
			$order->source = $source_from_db;
			$order->length = $length_from_db;
			$order->offer_deadline = $offer_deadline_from_db;
			$order->work_deadline = $work_deadline_from_db;
			$order->output = $output_from_db;
		}else{
			header("Location: requests.php");
		}
		
		$stmt->close();
        
        return $order;
	}
	
	function updateOrdersData($request_id, $text_type, $subject, $description, $target_group, $source, $length, $deadline, $output){
		
		$stmt = $this->connection->prepare("UPDATE requests SET text_type=?, subject=?, target_group=?, description=?, source=?, length=?, offer_deadline=?, work_deadline=?, output=?, modified=NOW() WHERE request_ID=? AND company_ID=?");
		$stmt->bind_param("sssssssssii", $text_type, $subject, $description, $target_group, $source, $length, $offer_deadline, $work_deadline, $output, $request_id, $_SESSION["logged_in_user_id"]);
		$stmt->execute();
		
		header("Location:requests.php");
		
		$stmt->close();
	}
	
	function deleteOrdersData($request_id){
		
		$stmt = $this->connection->prepare("UPDATE requests SET deleted=NOW() WHERE request_ID=? AND company_ID=?");
		$stmt->bind_param("ii", $request_id, $_SESSION["logged_in_user_id"]);
		$stmt->execute();
		
		header("Location:requests.php");
		
		$stmt->close();
	}
	
	function addNewOffer($request_id, $journalist_id, $price, $comment){
		
		$stmt = $this->connection->prepare("INSERT INTO offers(request_ID, journalist_ID, date, price, comment) VALUES(?,?,NOW(),?,?)");
		$stmt->bind_param("iiis", $request_id, $journalist_id, $price, $comment);
		
		$message = "";
		
		if($stmt->execute()){
            $message = "Edukalt andmebaasi salvestatud!";
		}
		
		$stmt->close();
		
		return $message;
		
	}
	
	function getOffersData(){
		
		if($_SESSION["logged_in_user_group_id"] == "3"){
			$stmt = $this->connection->prepare("SELECT subject, company_name, company_ID, offer_ID, requests.request_ID, journalist_ID, date, price, comment, accepted FROM offers JOIN requests ON requests.request_ID=offers.request_ID JOIN users ON users.user_ID=requests.company_ID WHERE company_ID=?");	
		}else if($_SESSION["logged_in_user_group_id"] == "2"){
			$stmt = $this->connection->prepare("SELECT subject, company_name, company_ID, offer_ID, requests.request_ID, journalist_ID, date, price, comment, accepted FROM offers JOIN requests ON requests.request_ID=offers.request_ID JOIN users ON users.user_ID=requests.company_ID WHERE journalist_ID=?");	
		}else{
			$stmt = $this->connection->prepare("SELECT subject, company_name, company_ID, offer_ID, requests.request_ID, journalist_ID, date, price, comment, accepted FROM offers JOIN requests ON requests.request_ID=offers.request_ID JOIN users ON users.user_ID=requests.company_ID");
		}
		
		$stmt->bind_param("i", $_SESSION["logged_in_user_id"]);
		$stmt->bind_result($subject_from_db, $company_name_from_db, $company_id_from_db, $offer_ID_from_db, $request_ID_from_db, $journalist_ID_from_db, $offer_date_from_db, $price_from_db, $comment_from_db, $accepted_from_db);
		$stmt->execute();
		
		$array = array();
		
		while($stmt->fetch()){
			
			$offer = new Stdclass();
			
			
			$offer->subject = $subject_from_db;
			$offer->company_name = $company_name_from_db;
			$offer->company_id = $company_id_from_db;
			$offer->offer_id = $offer_ID_from_db;
			$offer->request_id = $request_ID_from_db;
			$offer->journalist_id = $journalist_ID_from_db;
			$offer->offer_date = $offer_date_from_db;
			$offer->price = $price_from_db;
			$offer->comment = $comment_from_db;
			$offer->accepted = $accepted_from_db;
			
			array_push($array, $offer);
		}
		
		return $array;
		
		$stmt->close();
	}
	
	function updateOffersData($offer_id, $request_id){
		
		$stmt = $this->connection->prepare("UPDATE offers SET accepted=1 WHERE offer_ID =?");
		$stmt->bind_param("i", $offer_id);
		$stmt->execute();
		
		$stmt = $this->connection->prepare("UPDATE offers SET accepted=0 WHERE accepted IS NULL AND request_ID=?");
		$stmt->bind_param("i", $request_id);
		$stmt->execute();
		
		header("Location:offers.php");
		
		$stmt->close();
	}

	function addNewFeedback($from_user, $to_user, $offer_ID, $feedback){
		
		$stmt = $this->connection->prepare("INSERT INTO feedback(from_user, to_user, offer_ID, feedback, date) VALUES(?,?,?,?, NOW())");
		$stmt->bind_param("iiis", $from_user, $to_user, $offer_ID, $feedback);
		
		$message = "";
		
		if($stmt->execute()){
			$message = "Edukalt andmebaasi salvestatud!";
		}
		
		$stmt->close();
		
		return $message;

	}
	
	function getFeedbackData(){}
}

?>