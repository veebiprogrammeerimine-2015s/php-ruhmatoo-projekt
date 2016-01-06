<?php
	class AvailableTimeDetails{
		
		function __construct($mysqli){
		
			// selle klassi muutuja andmete saamiseks
			$this->connection = $mysqli;
			
		
		}
		
		
		function getFreeTimesDetails($date_time_id){
			
			$response = new StdClass();
			
			$table_data = array();
			$html = '';
			$stmt = $this->connection->prepare("
			SELECT af_doctor_available.id, date_appoitmnt, time_start, time_end, hospidal_name, dr_name, city, address, area FROM af_doctor_available
			JOIN af_doctors ON af_doctor_available.af_doctors_id = af_doctors.id
			JOIN af_hospidals ON af_hospidals.id = af_doctors.af_hospidals_id
			WHERE af_doctor_available.id = ?
			");
			$stmt->bind_param("i", $date_time_id);
			$stmt->bind_result($id, $date_appoitmnt, $time_start, $time_end, $hospidal_name, $dr_name_fdb, $city_fdb, $address_fdb, $area_fdb);
			$stmt->execute();
			
			while($stmt->fetch()){
				
				$table_row = new StdClass();
				//$table_row->id = $id;
				$table_row->date_appoitmnt = $date_appoitmnt;
				$table_row->time_start = $time_start;
				$table_row->time_end = $time_end;
				$table_row->hospidal_name = $hospidal_name;
				$table_row->dr_name = $dr_name_fdb;
				$table_row->city = $city_fdb;
				$table_row->area = $area_fdb;
				$table_row->address = $address_fdb;
				array_push($table_data, $table_row);
				
				
			}
			$results_count = count($table_data);
			// kui array on 0 siis anname hoopis errori kaasa
			if($results_count == 0){
				$error = new StdClass();
				$error->id =1;
				$error->message = "Midagi läks katki!";
				$response->error = $error;
				$stmt->close();
				return $response;
				
			}
			
			
			$stmt->close();
			return $table_data;
		}
		
		function getDoctorDeseases($date_time_id){
			
			
			
			$table_data = array();
			$html = '';
			$stmt = $this->connection->prepare("
			SELECT af_deseases.id, af_deseases.desease FROM af_doctor_available
			JOIN af_doctors ON af_doctor_available.af_doctors_id = af_doctors.id
			JOIN af_doctors_deseaes ON af_doctors_deseaes.af_doctors_id = af_doctor_available.af_doctors_id
			JOIN af_deseases ON af_deseases.id = af_doctors_deseaes.af_deseases_id
			WHERE af_doctor_available.id = ?
			");
			$stmt->bind_param("i", $date_time_id);
			$stmt->bind_result($id, $desease_fdb);
			$stmt->execute();
			
			while($stmt->fetch()){
				
				$table_row = new StdClass();
				$table_row->id = $id;
				$table_row->desease_fdb = $desease_fdb;
	
				array_push($table_data, $table_row);
				
				
			}
			
			$stmt->close();
			return $table_data;
		}
		
			function getDoctorDayTimes($date_time_id){
			
			
			
			$table_data = array();
			$html = '';
			$stmt = $this->connection->prepare("
			SELECT af_doctor_available.id, date_appoitmnt, time_start, time_end, af_booking_statuses_id FROM af_doctor_available 
			WHERE date_appoitmnt = (SELECT  date_appoitmnt FROM af_doctor_available WHERE ID = ?)
			");
			$stmt->bind_param("i", $date_time_id);
			$stmt->bind_result($id, $date_appoitmnt, $time_start, $time_end, $af_booking_statuses_id);
			$stmt->execute();
			
			while($stmt->fetch()){
				//kontrollime, milline radiobutton on selectitud, kas sissetuleva id ühtib andmebaasi rea id-ga
				$is_radio_selected = 0;
				if ($date_time_id == $id){
					$is_radio_selected = 1;
				}
				$table_row = new StdClass();
				//$table_row->id = $id;
				//$table_row->date = $date_appoitmnt;
				$table_row->time = $time_start."-".$time_end;
				$table_row->choose = $this->createDayTimeRadioBtnOpt($af_booking_statuses_id, $is_radio_selected, $id);
	
				array_push($table_data, $table_row);
				
				
			}
			
			$stmt->close();
			return $table_data;
		}
		
		// üks funktsioon tabeli printimiseks
		// kood laenatud http://stackoverflow.com/questions/4746079/how-to-create-a-html-table-from-a-php-array
		function build_table($array){
			// start table
   			 $html = '<table class="table table-bordered">';
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
		
		
		
		
		
		
		// funktsioon ajatabelis staatuste kuvamiseks
		
		function createDayTimeRadioBtnOpt($status_id_in,$id_selcetd_in=0, $available_time_id){
		
			$statuses = array();
			$html = '';
			
			$html = '';
			if ($status_id_in == 1){
				if ($status_id_in == $id_selcetd_in){
					
					$html .= '<div class="radio">';
  					$html .= '<label><input type="radio" name="selectedavailabletime" value="'.$available_time_id.'" checked="checked"></label>';
  					$html .= '</div>';
  				}
				else{
				$html .= '<div class="radio">';
  				$html .= '<label><input type="radio" name="selectedavailabletime" value="'.$available_time_id.'"></label>';
  				$html .= '</div>';
  				}
  			}
  			else{
		
				
  				$html .= '<label>Broneeritud</label>';
  				
  			}
  			
  			return $html;
		}
		
		function createDropdownDesease($data_in, $selected_in = ""){
			
			
			$html = '';
		
			$html .= '<select name="selectdesease">';
			foreach($data_in as $option){
				if ($selected_in == $option){
					$html .= '<option value="'.$option->id.'"selected>'.$option->desease_fdb.'</option>';
				}
				else{
				$html .= '<option value="'.$option->id.'">'.$option->desease_fdb.'</option>';
				}
			}
		
		
			if ($selected_in == ""){
			
			$html .= '<option value="" selected>Vali haigus</option>';
			}
			else{
				$html .= '<option value="">Vali haigus</option>';
			}
			$html .= '</select>';
		
			return $html;
		}
		
}	
?>