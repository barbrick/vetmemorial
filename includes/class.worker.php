<?php

	class Worker {

		//------------------------------------------------------------ private variables
		private $connection;

		//------------------------------------------------------------ constructor method
		public function __construct() {
			// Require DB congifuration and connect to DB
			require_once('config/config.php');
			try {
				// Open connection to the database
				$this->connection = new PDO("mysql:host=". DB_HOST .";dbname=" . DB, DB_USER, DB_PASS);
				// Set error mode
				$this->connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	        } catch (PDOException $e) {
	        	// Print error
	            die($e->getMessage());
	        }
		}

		//------------------------------------------------------------ public methods
		
		/**
    	* Function to create user
        * @arg $username username of the new user
        * @arg $password password of the new user
        * @arg $email email of the new user
        * @arg $fname first name of the new user
        * @arg $lname last name of the new user
		*/
		public function createUser($username, $password, $email, $fname, $lname) {
			// Cleanse Username
			$username = stripslashes(trim($username));
			
			// Cleanse Password
			$password = stripslashes(trim($password));

			// Cleanse Email
			$email = stripslashes(trim($email));

			// Cleanse First Name
			$fname = stripslashes(trim($fname));
			
			// Cleanse Last Name
			$lname = stripslashes(trim($lname));

			// Check that all required fields have been provided
			if (!isset($username) || $username === "" || !isset($password) || $password === "" || !isset($email) || $email === "") {
				// Error with input
				// Redirect to register page
			    header("location:../test/admin.php");
			    exit();
			} else {
				// All required inputs provided

				// Check if user already exists

				// Prepare SQL statement handle
				$sql = $this->connection->prepare("SELECT * FROM tblMembers WHERE username = :user");
				  
				// Bind variables to the SQL statement
				$sql->bindParam(':user', $username);
				  
				// Execute the statement
			    $sql->execute();
				
				$count = $sql->rowCount();
				// Fetch the results
				if ($count > 0) {
					// User aready exists
					// Redirect to register page
		            header("location:../test/admin.php");
		            exit();
				} else {
					// Create the new user

					// Salt and Hash the password
					$password = crypt($password, SALT);

					// Prepare SQL statement handle
					$sql = $this->connection->prepare("INSERT INTO tblMembers (username, password, email, f_name, l_name) VALUES(:user, :pass, :email, :fname, :lname)");
					  
					// Bind variables to the SQL statement
					$sql->bindParam(':user', $username);
					$sql->bindParam(':pass', $password);
					$sql->bindParam(':email', $email);
					$sql->bindParam(':fname', $fname);
					$sql->bindParam(':lname', $lname);

					// Execute the statement
					$result = $sql->execute();

					$count = $sql->rowCount();
    				// Fetch the results
    				if ($count > 0) {
						// Successful
						// Redirect to login page
			            header("location:../test/login.php");
			            exit();
					} else {
						// Error
						// Redirect to register page
			            header("location:../test/admin.php");
			            exit();
					}
				}
			}
		}

        /**
    	* Function to edit password
        * @arg $username username of the user
        * @arg $password new password for the user
        * @arg $conf confirmation of new password for the user
		*/
		public function editUser($username, $password, $conf) {
			// Cleanse Username
			$username = stripslashes(trim($username));
			// Cleanse Password
			$password = stripslashes(trim($password));
			// Cleanse Confirmation Password
			$conf = stripslashes(trim($conf));

			// Check that all required fields have been provided
			if (!isset($username) || $username === "" || !isset($password) || $password === "" || !isset($conf) || $conf === "") {
				// Error with input
				// Redirect to register page
			    header("location:../test/admin.php");
			    exit();
			} else {
				// All required inputs provided
                
                // Check that passwords match
                if ($password !== $conf) {
                    // Passwords do not match
                    header("location:../test/admin.php");
    			    exit();
                } else {
                    // Salt and Hash the password
    				$password = crypt($password, SALT);
    
    				// Prepare SQL statement handle
    				$sql = $this->connection->prepare("UPDATE tblMembers SET password = :pass WHERE username = :user");
    				  
    				// Bind variables to the SQL statement
    				$sql->bindParam(':user', $username);
    				$sql->bindParam(':pass', $password);
    
    				// Execute the statement
    				$result = $sql->execute();
    
    				$count = $sql->rowCount();
    				// Fetch the results
    				if ($count > 0) {
    					// Successful
    					// Redirect to login page
    					$this->logout();
    		            exit();
    				} else {
    					// Error
    					// Redirect to register page
    		            header("location:../test/admin.php");
    		            exit();
    				}
                }
			}
		}
		
		/**
    	* Function to reset users password
        * @arg $email email of the user requesting a password reset
		*/
		public function resetPassword($email) {
			// Cleanse Email
			$email = stripslashes(trim($email));

			// Check that all required fields have been provided
			if (!isset($email) || $email === "") {
				// Error with input
				// Redirect to register page
			    header("location:../test/login.php");
			    exit();
			} else {
				// All required inputs provided

				// Check if user exists

				// Prepare SQL statement handle
				$sql = $this->connection->prepare("SELECT * FROM tblMembers WHERE email = :email");
				  
				// Bind variables to the SQL statement
				$sql->bindParam(':email', $email);
				  
				// Execute the statement
			    $sql->execute();
				
				$count = $sql->rowCount();
				// Fetch the results
				if ($count >= 0) {
					// User exists
					
					// Create the new password
                    $password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 12);
                    
                    // SMTP Mail Password Reset
                    require 'mailer/class.phpmailer.php';
                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->SMTPDebug  = 0;
                    $mail->Host       = SMTP_HOST;
                    $mail->Port       = SMTP_PORT;
                    if (SMTP_PORT == 465) {
                        $mail->SMTPSecure = 'ssl';
                        $mail->SMTPAuth   = true;
                    }
                    $mail->Username   = SMTP_EMAIL;
                    $mail->Password   = SMTP_PASS;
                    $mail->SetFrom(SMTP_EMAIL, 'No-Reply');
                    $mail->AddReplyTo(SMTP_EMAIL, 'No-Reply');
                    $mail->AddAddress($email, $toName);
                    $mail->Subject = 'Veteransmemorial.com Password Reset';
                    $mail->IsHTML(true);
                    $mail->Body = "<body style=\"text-align: center\"><h1>You have requested a new password.</h1><p>Here's a new one for you, I suggest you change it immediately.</p><p><i>" . $password . "</i></p><a href=\"http://veteransmemorial.com/admin/login.php\">Login</a></body>";
                    $mail->AltBody = "You have requested a new password.\r\nHere's a new one for you, I suggest you change it immediately.\r\n" . $password . "\r\nhttp://veteransmemorial.com/admin/login.php";
                    $mail->WordWrap = 70;
                    $mail->Send();
            
					// Salt and Hash the password
					$password = crypt($password, SALT);

					// Prepare SQL statement handle
					$sql = $this->connection->prepare("UPDATE tblMembers SET password = :pass WHERE email = :email");
					  
					// Bind variables to the SQL statement
					$sql->bindParam(':pass', $password);
					$sql->bindParam(':email', $email);

					// Execute the statement
					$result = $sql->execute();

					$count = $sql->rowCount();
    				// Fetch the results
    				if ($count > 0) {
						// Successful
						// Redirect to login page
			            header("location:../test/login.php");
			            exit();
					} else {
						// Error
						// Redirect to login page
			            header("location:../test/login.php");
			            exit();
					}
				} else {
				    // Email does not exist
				    // Redirect to login page
		            header("location:../test/login.php");
		            exit();
				}
			}
		}
		
		/**
    	* Function to login user
        * @arg $username username to verify
        * @arg $password password to verify
		*/
		public function login($username, $password) {
			// Cleanse Username
			$username = stripslashes(trim($username));
			
			// Cleanse Password
			$password = stripslashes(trim($password));

			// Prepare SQL statement handle
			$sql = $this->connection->prepare("SELECT * FROM tblMembers WHERE username = :user");
			  
			// Bind variables to the SQL statement
			$sql->bindParam(':user', $username);
			  
			// Execute the statement
			$result = $sql->execute();
			
			// Count the results
			$count = $sql->rowCount();
			
			if ($count > 0) {
				// User exists
				while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
					if (crypt($password, $row['password']) === $row['password']) {	
						// User is authenticated
                        
						// Detect the user id
		            	$uid = $row['id'];
		            
		            	// Detect the users email address
			            $email = $row['email'];

			            // Detect the users display name
			            $name = $row['f_name'] . " " . $row['l_name'];
			            
			            // Save users session
			            $_SESSION['username'] = $username;
			            $_SESSION['uid'] = $uid;
			            $_SESSION['email'] = $email;
			            $_SESSION['name'] = $name;
		            
			            // Redirect to admin page
			            header("location:../test/admin.php");
			            
			            exit();

					} else {
						// User not authenticated
						// Redirect to login page
			            header("location:../test/login.php");
			            exit();
					} 
	        	}
			} else {
				// User doesn't exist
				// Redirect to login page
	            header("location:../test/login.php");
	            exit();
			}
		}

		/**
    	* Function to check if user has a current session
		*/
		public function checkSession() {
			// Check if user has a session registered
			if(isset($_SESSION["username"])) {
				// Session exists return true
			    return true;
			    exit();
			} else {
				// No session exists return false
				return false;
				exit();
			}
		}

		/**
    	* Function to logout user
		*/
		public function logout() {
		    // Destroy session
			session_destroy();
			header("location:../test/login.php");
			exit();
		}
		
		//---------------------------------------------------------- deconstructor method
		public function __destruct() {
			
			try {
				// Close the connection to the database
				$this->connection = null;
			} catch (PDOException $e) {
				// Print error
				die($e->getMessage());
			}
		}
	}

?>