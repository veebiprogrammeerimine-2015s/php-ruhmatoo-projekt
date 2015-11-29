<?php
	class AvailableTimes{
		
		function __construct($mysqli){
		
			// selle klassi muutuja andmete saamiseks
			$this->connection = $mysqli;
			
		
		}
		
		
		function getAllFreeTimes($city="", $area="", $desease=""){
			
			
			$table_data = array();
			$html = '';
			$stmt = $this->connection->prepare("
			SELECT  af_doctor_available.id, date_appoitmnt, time_start, time_end, hospidal_name, city, area, desease FROM `af_doctor_available` 
			JOIN af_doctors ON af_doctor_available.af_doctors_id = af_doctors.id
   		    JOIN af_doctors_deseaes ON af_doctors_deseaes.af_doctors_id = af_doctors.id
    		JOIN af_deseases ON af_deseases.id = af_doctors_deseaes.af_deseases_id
    		Join af_doctors_field ON af_doctors_field.id = af_doctors.doctors_field
  			JOIN af_hospidals ON af_hospidals.id = af_doctors.af_hospidals_id
  			JOIN af_persons ON af_persons.id = af_doctors.af_persons_id
			WHERE af_booking_statuses_id = 1  
			AND (city LIKE '%$city%' OR area LIKE '%$area%' OR desease LIKE '%$desease%')
			ORDER BY date_appoitmnt, time_start
			");
			$stmt->bind_result($id, $date_appoitmnt, $time_start, $time_end, $hospidal_name, $city, $area, $desease);
			$stmt->execute();
			
			while($stmt->fetch()){
				
				$table_row = new StdClass();
				//$table_row->id = $id;
				$table_row->date_appoitmnt = $date_appoitmnt;
				$table_row->time_start = $time_start;
				$table_row->hospidal_name = $hospidal_name;
				$table_row->city = $city;
				$table_row->area = $area;
				$table_row->desease = $desease;
				$table_row->book = "<a href=book-now.php?=booking_id=".$id.">Broneeri</a>";
				array_push($table_data, $table_row);
				
				
			}
			
			$stmt->close();
			return $table_data;
		}
		
		// üks funktsioon tabeli printimiseks
		// kood laenatud http://stackoverflow.com/questions/4746079/how-to-create-a-html-table-from-a-php-array
		function build_table($array){
			// start table
   			 $html = '<table>';
    		// header row
    		$html .= '<tr>';
    		foreach($array[0] as $key=>$value){
            	$html .= '<th>' . $key . '</th>';
        	}
    		$html .= '</tr>';

    		// data rows
    		foreach( $array as $key=>$value){
        	$html .= '<tr>';
        	foreach($value as $key2=>$value2){
            	$html .= '<td>' . $value2 . '</td>';
        	}
        	$html .= '</tr>';
    	}

    	// finish table and return it

    	$html .= '</table>';
    	return $html;
		}
		
		function createDropdownCity($data_in){
			$items = array();
			foreach($data_in as $option){
				$item= $option->city;
				array_push($items, $item);
			}
			$data_in = array_unique($items);
			$html = '';
		
			$html .= '<select name="selectcity">';
			foreach($data_in as $option){
			$html .= '<option value="'.$option.'">'.$option.'</option>';
			}
		
		
		
			$html .= '<option value="0" selected>Vali linn</option>';
			$html .= '</select>';
		
			return $html;
		
		}
		//EI OLE KASUTUSEL
		function createDropdownCity212121(){
		
		$html = '';
		// ''
		$html .= '<select name="selectcity">';
		$stmt = $this->connection->prepare("SELECT DISTINCT id, city FROM af_hospidals");
		$stmt->bind_result($id, $city);
		$stmt->execute();
		
		//iga rea kohta teen midagi
		while($stmt->fetch()){
			$html .= '<option value="'.$id.'">'.$city.'</option>';
		}
		
		$stmt->close();
		
		$html .= '<option value="0" selected>Vali linn</option>';
		$html .= '</select>';
		
		return $html;
		
		}
		
		function createDropdownArea(){
		
		$html = '';
		// ''
		$html .= '<select name="selecarea">';
		$stmt = $this->connection->prepare("SELECT DISTINCT id, area FROM af_hospidals");
		$stmt->bind_result($id, $area);
		$stmt->execute();
		
		//iga rea kohta teen midagi
		while($stmt->fetch()){
			$html .= '<option value="'.$id.'">'.$area.'</option>';
		}
		
		$stmt->close();
		
		$html .= '<option value="0" selected>Vali piirkond</option>';
		$html .= '</select>';
		
		return $html;
		
		}
		
		function createDropdownDesease(){
		
		$html = '';
		// ''
		$html .= '<select name="selectdesease">';
		$stmt = $this->connection->prepare("SELECT DISTINCT id, desease FROM af_deseases");
		$stmt->bind_result($id, $desease);
		$stmt->execute();
		
		//iga rea kohta teen midagi
		while($stmt->fetch()){
			$html .= '<option value="'.$id.'">'.$desease.'</option>';
		}
		
		$stmt->close();
		
		$html .= '<option value="0" selected>Vali piirkond</option>';
		$html .= '</select>';
		
		return $html;
		
		}
}
?>