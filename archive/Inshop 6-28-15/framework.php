<?php
class framework {
   
    public function __construct() {
		
        $this->thisClass = get_class($this);
		
    }
	
	final private function showClass() {
        
        return $this->thisClass;
        
    }

	public function db_connect () {
		
		$db_connection = new mysqli('localhost', 'root', '', 'brechbuhler');
		
		if (mysqli_connect_errno()) {
			echo 'Connection to database failed:' . mysqli_connect_error();
			return 0;
		} else {
			return $db_connection;
		}
		
	}
	
	public function clean_input ( $input ) {
		
		$input = trim( $input );
		#$input = mysql_real_escape_string( $input );
		if ( !get_magic_quotes_gpc() ) { $input = addslashes( $input ); }
		if ( $input == "" ) { $input = "NULL"; }
		return $input;
		
	}
	
	public function clean_output ( $output ) {
		
		if ( !get_magic_quotes_gpc() ) { $output = stripslashes( $output ); }
		
		if ( $output == "NULL" ) { $output = ""; }
		if ( $output == "0" ) { $output = ""; }
		
		return $output;
	
	}
		
	public function valid_email ( $address ) {
		// check an email address is possibly valid
		if ( ereg('^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$', $address)) {
			return true;
		} else {
			return false;
		}
	}
	
}

class scaleDB extends framework {
	
	public function getScale ( $id ) {
		
		$scale_info;
		
		@ $db = new mysqli('localhost', 'root', '', 'brechbuhler');
			
		if (mysqli_connect_error()) {
			$errnum = mysqli_connect_errno();
			echo "Error($errnum): Could not connect to database. Please try again later.";
			return 1;
		}
		
		$query = "select * from scales where id like '%" . $id . "%'";
		$result = $db->query($query);
		
		if ( $result ) {
			$num_results = $result->num_rows;
			
			if ( $num_results > 1 || $num_results == 0 ) {
				echo "Your search either returned multiple results or no matches were found.\n\n";
				return 1;
			}
			
			for ($i = 0; $i < $num_results; $i++) {
				$row = $result->fetch_assoc();
				
				$scale_info = array(
					'scale_id' => $this->clean_output( $row['id'] ),
					'status' => $this->clean_output( $row['status'] ),
					'date' => $this->clean_output( $row['date'] ),
					'tech_id' => $this->clean_output( $row['tech_id'] ),
					'companyname' => $this->clean_output( $row['companyname'] ),
					'street' => $this->clean_output( $row['street'] ),
					'city' => $this->clean_output( $row['city'] ),
					'state' => $this->clean_output( $row['state'] ),
					'zipcode' => $this->clean_output( $row['zipcode'] ),
					'indicator_tag' => $this->clean_output( $row['indicator_tag'] ),
					'indicator_manu' => $this->clean_output( $row['indicator_manu'] ),
					'indicator_model' => $this->clean_output( $row['indicator_model'] ),
					'indicator_serial' => $this->clean_output( $row['indicator_serial'] ),
					'scale_manu' => $this->clean_output( $row['scale_manu'] ),
					'scale_model' => $this->clean_output( $row['scale_model'] ),
					'scale_serial' => $this->clean_output( $row['scale_serial'] ),
					'scale_capacity' => $this->clean_output( $row['scale_capacity'] ),
					'scale_divisions' => $this->clean_output( $row['scale_divisions'] ),
					'units' => $this->clean_output( $row['units'] ),
					);
			}
			
			$result->free();
			
		}
		
		$db->close();
		return $scale_info;
	}	

}	
			
?>
