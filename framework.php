<?php
class framework extends mysqli {
	
	public function __construct($host, $user, $pass, $db) {
        parent::__construct($host, $user, $pass, $db);
		$this->thisClass = get_class($this);
		
        if (mysqli_connect_error()) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
    }
	
	public function rcon($host, $user, $pass, $db) {
        parent::init();
		
        if (!parent::options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) {
            die('Setting MYSQLI_INIT_COMMAND failed');
        }

        if (!parent::options(MYSQLI_OPT_CONNECT_TIMEOUT, 5)) {
            die('Setting MYSQLI_OPT_CONNECT_TIMEOUT failed');
        }

		#$db_connection = new mysqli('localhost', 'root', '', 'brechbuhler');
        if (!parent::real_connect($host, $user, $pass, $db)) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
    }
	
	final private function showClass() {
        
        return $this->thisClass;
        
    }
	
	public function clean_input ( $input ) {
		
		$input = trim( $input );
		$input = $this->real_escape_string( $input );
		$input = htmlspecialchars( $input );
		$input = addcslashes($input, '%_');
		if ( !get_magic_quotes_gpc() ) { $input = addslashes( $input ); }
		if ( $input == "" ) { $input = NULL; }
		return $input;
		
	}
	
	public function clean_output ( $output ) {
		
		$output = str_replace( '\\r\\n', '<br />', $output );
		if ( !get_magic_quotes_gpc() ) { $output = stripslashes( $output ); }
		if ( $output == "NULL" ) { $output = NULL; }
		
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
	
	public function getDate () {
		date_default_timezone_set("America/Fort_Wayne");
		$date = date('m/d/Y') . " @ " . date('h:i:s A');
		return $date;
	}
	
	public function isLoggedIn ( $array ) {
		if ( isset( $array['USER'] ) ) {
			if ( !empty($array['USER']['username']) &&
				 !empty($array['USER']['fullname']) &&
				 !empty($array['USER']['userid']) &&
				 !empty($array['USER']['digest']) && 
				 isset($array['USER']['is_user']) &&
				 isset($array['USER']['is_admin']) &&
				 isset($array['USER']['is_superadmin'])
				 ) {
					 return 1;
		    } else {
				unset( $_SESSION['USER'] );
				session_destroy();
				return 0;
			}
		} else {
			return 0;
		}
	}
	
	public function isValidUser ( $array ) {
		$query = "select * from users where username = '". $array['USER']['username'] ."'";
		$result = $this->query($query);
		
		if ( $result && isset( $array['USER'] ) ) {
			while( $row = $result->fetch_assoc() ) {
				$db_id = $row['id'];
				$db_username = $row['username'];
				$db_pass = $row['password'];
				$db_fullname = $row['fullname'];
				$db_email = $row['email'];
				$db_user = $row['is_user'];
				$db_admin = $row['is_admin'];
				$db_superadmin = $row['is_superadmin'];	
			}
			
			@ $digest = md5( 
				$db_id .
				$db_username .
				$db_fullname .
				$db_pass .
				$db_email .
				$db_user .
				$db_admin .
				$db_superadmin
			);
			
			if ( @ $array['USER']['userid'] == @ $db_id &&
				 @ $array['USER']['username'] == @ $db_username &&
				 @ $array['USER']['fullname'] == @ $db_fullname &&
				 @ $array['USER']['is_user'] == @ $db_user &&
				 @ $array['USER']['is_user'] == 1 && 
				 @ $array['USER']['is_admin'] == @ $db_admin &&
				 @ $array['USER']['is_superadmin'] == @ $db_superadmin &&
				 @ $array['USER']['digest'] == @ $digest ) {
				
				return 1;
			} else {
				#echo "Something went wrong, the array is not defined.";
				return 0;
			}
		} else {
			return 0;
		}
	}
	
	public function isAdmin ( $array ) {
		if ( isset( $array['USER'] ) ) {
			if ( $array['USER']['is_admin'] == 1 ) {
				return 1;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}
	
	public function isSuperAdmin ( $array ) {
		if ( isset( $array['USER'] ) ) {
			if ( $array['USER']['is_superadmin'] == 1 ) {
				return 1;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}		
	
}

class scaleDB extends framework {
	
	public function getScale ( $id ) {
		
		$scale_info;
		$query = "select * from scales where id = $id";
		$result = $this->query($query);
		
		if ( $result ) {
			$num_results = $result->num_rows;
			
			if ( $num_results > 1 || $num_results == 0 ) {
				echo "<br />Your search returned no results.  This ticket does not exist.\n\n";
				return 0;
			} else {
			
				for ($i = 0; $i < $num_results; $i++) {
					$row = $result->fetch_assoc();
					
					$scale_info = array(
						'scale_id' => $this->clean_output( $row['id'] ),
						'status' => $this->clean_output( $row['status'] ),
						'date' => $this->clean_output( $row['date'] ),
						'updated' => $this->clean_output( $row['updated'] ),
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
			}
			
			$result->free();
			
		}
		
		return $scale_info;
	}

	public function getScalePure ( $id ) {
		
		$scale_info;
		$query = "select * from scales where id = $id";
		$result = $this->query($query);
		
		if ( $result ) {
			$num_results = $result->num_rows;
			
			if ( $num_results > 1 || $num_results == 0 ) {
				echo "<br />Your search returned no results.  This ticket does not exist.\n\n";
				return 1;
			}
			
			for ($i = 0; $i < $num_results; $i++) {
				$row = $result->fetch_assoc();
				
				$scale_info = array(
					'scale_id' => $row['id'],
					'status' => $row['status'],
					'date' => $row['date'],
					'updated' => $row['date'],
					'tech_id' => $row['tech_id'],
					'companyname' => $row['companyname'],
					'street' => $row['street'],
					'city' => $row['city'],
					'state' => $row['state'],
					'zipcode' => $row['zipcode'],
					'indicator_tag' => $row['indicator_tag'],
					'indicator_manu' => $row['indicator_manu'],
					'indicator_model' => $row['indicator_model'],
					'indicator_serial' => $row['indicator_serial'],
					'scale_manu' => $row['scale_manu'],
					'scale_model' => $row['scale_model'],
					'scale_serial' => $row['scale_serial'],
					'scale_capacity' => $row['scale_capacity'],
					'scale_divisions' => $row['scale_divisions'],
					'units' => $row['units'],
					);
			}
			
			$result->free();
			
		}
		
		return $scale_info;
	}
	
	public function getTotalTime ( $id ) {
		
		$scale_info;
		$query = "select * from events where scale_id = '" . $id . "'";
		$result = $this->query($query);
		
		if ( $result ) {
			$num_results = $result->num_rows;
			
			if ( $num_results == 0 ) {
				return 0;
			}
		
			$total_time = 0;
			
			for ($i = 0; $i < $num_results; $i++) {
				$row = $result->fetch_assoc();
				
				$total_time += $row['timespent'];
			}
			
			$result->free();
		}
		
		return $total_time;
	}
	
}	
			
?>
