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
        * @param $username string username of the new user
        * @param $password string password of the new user
        * @param $email string email of the new user
        * @param $fname string first name of the new user
        * @param $lname string last name of the new user
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
        * @param $username string username of the user
        * @param $password string new password for the user
        * @param $conf string confirmation of new password for the user
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
        * @param $email string email of the user requesting a password reset
		*/
		public function resetPassword($email) {
			// Cleanse Email
			$email = stripslashes(trim($email));

			// Check that all required fields have been provided
			if (!isset($email) || $email === "") {
				// Error with input
				// Redirect to login page
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
    	* Function to get list of users
        * @return PDO List of users
		*/
		public function getUsers() {

			// Prepare SQL statement handle
			$sql = $this->connection->prepare("SELECT * FROM tblMembers");
			  
			// Execute the statement
			$sql->execute();
			
			// Count the results
			$count = $sql->rowCount();
			
			if ($count > 0) {
				// Users exist
				return $sql;
				exit();
			} else {
				// No results
	            return null;
	            exit();
			}
		}

		/**
    	* Function to login user
        * @param $username string username to verify
        * @param $password string password to verify
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
    	* @return boolean true user has a valid session
    	* @return boolean false user does not have a valid session
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

		/**
    	* Function to create news item
        * @param $title string title of the new post
        * @param $content string content of the new post
        * @param $date string date of the new post
		*/
		public function addNews($title, $content, $date) {
			// Cleanse Title
			$title = htmlspecialchars(strip_tags(trim($title)));
			
			// Cleanse Content
			$content = htmlspecialchars(stripslashes(trim($content)));

			// Cleanse Date
			$date = htmlspecialchars(stripslashes(trim($date)));

			// Check that all required fields have been provided
			if (!isset($title) || $title === "" || !isset($content) || $content === "" || !isset($date) || $date === "") {
				// Error with input
				// Redirect to admin page
				echo "error";
			    //header("location:../test/admin.php");
			    exit();
			} else {
				// All required inputs provided

				// Create the new news post

				// Prepare SQL statement handle
				$sql = $this->connection->prepare("INSERT INTO tblNews (title, content, post_date) VALUES(:title, :content, :postDate)");
				  
				// Bind variables to the SQL statement
				$sql->bindParam(':title', $title);
				$sql->bindParam(':content', $content);
				$sql->bindParam(':postDate', $date);

				// Execute the statement
				$result = $sql->execute();

				$count = $sql->rowCount();
				// Fetch the results
				if ($count > 0) {
					// Successful
					// Redirect to admin page
		           // header("location:../test/admin.php");
		           echo "worked";
		            exit();
				} else {
					// Error
					// Redirect to admin page
					echo"error";
		            //header("location:../test/admin.php");
		            exit();
				}
			}
		}

		/**
    	* Function to edit news item
    	* @param $id integer id of the post to edit
        * @param $title string title of the post to edit
        * @param $content string content of the post to edit
        * @param $date string date of the post to edit
		*/
		public function editNews($id, $title, $content, $date) {
			// Cleanse ID
			$id = htmlspecialchars(strip_tags(trim($id)));

			// Cleanse Title
			$title = htmlspecialchars(strip_tags(trim($title)));
			
			// Cleanse Content
			$content = htmlspecialchars(stripslashes(trim($content)));

			// Cleanse Date
			$date = htmlspecialchars(stripslashes(trim($date)));

			// Check that all required fields have been provided
			if (!isset($id) || $id === "" || !isset($title) || $title === "" || !isset($content) || $content === "" || !isset($date) || $date === "") {
				// Error with input
				// Redirect to admin page
			    header("location:../test/admin.php");
			    exit();
			} else {
				// All required inputs provided

				// Edit the news post

				// Prepare SQL statement handle
				$sql = $this->connection->prepare("UPDATE tblNews SET title = :title, content = :content, post_date = :postDate WHERE id = :id");
				  
				// Bind variables to the SQL statement
				$sql->bindParam(':id', $id);
				$sql->bindParam(':title', $title);
				$sql->bindParam(':content', $content);
				$sql->bindParam(':postDate', $date);

				// Execute the statement
				$result = $sql->execute();

				$count = $sql->rowCount();
				// Fetch the results
				if ($count > 0) {
					// Successful
					// Redirect to admin page
		            header("location:../test/admin.php");
		            exit();
				} else {
					// Error
					// Redirect to admin page
		            header("location:../test/admin.php");
		            exit();
				}
			}
		}
		
		/**
    	* Function to delete news item
    	* @param $id integer id of the post to delete
		*/
		public function deleteNews($id) {
			// Cleanse ID
			$id = htmlspecialchars(strip_tags(trim($id)));


			// Check that all required fields have been provided
			if (!isset($id) || $id === "") {
				// Error with input
				// Redirect to admin page
			    header("location:../test/admin.php");
			    exit();
			} else {
				// All required inputs provided

				// Delete the news post

				// Prepare SQL statement handle
				$sql = $this->connection->prepare("DELETE FROM tblNews WHERE id = :id LIMIT 1");
				  
				// Bind variables to the SQL statement
				$sql->bindParam(':id', $id);

				// Execute the statement
				$result = $sql->execute();

				$count = $sql->rowCount();
				// Fetch the results
				if ($count > 0) {
					// Successful
					// Redirect to admin page
		            header("location:../test/admin.php");
		            exit();
				} else {
					// Error
					// Redirect to admin page
		            header("location:../test/admin.php");
		            exit();
				}
			}
		}

		/**
    	* Function to get all news
        * @return PDO List of news
		*/
		public function getNews() {

			// Prepare SQL statement handle
			$sql = $this->connection->prepare("SELECT * FROM tblNews");
			  
			// Execute the statement
			$sql->execute();
			
			// Count the results
			$count = $sql->rowCount();
			
			if ($count > 0) {
				// Users exist
				return $sql;
				exit();
			} else {
				// No results
	            return null;
	            exit();
			}
		}

		/**
    	* Function to edit page content
    	* @param $id integer id of the page to edit
        * @param $title string title of the page to edit
        * @param $desc string description of the page to edit
        * @param $content string content of the post to edit
		*/
		public function editPage($id, $title, $desc, $content) {
			// Cleanse ID
			$id = htmlspecialchars(strip_tags(trim($id)));

			// Cleanse Title
			$title = htmlspecialchars(strip_tags(trim($title)));
			
			// Cleanse Description
			$desc = htmlspecialchars(strip_tags(trim($desc)));

			// Cleanse Content
			$content = htmlspecialchars(stripslashes(trim($content)));


			// Check that all required fields have been provided
			if (!isset($id) || $id === "" || !isset($title) || $title === "" || !isset($desc) || $desc === "" || !isset($content) || $content === "") {
				// Error with input
				// Redirect to admin page
			    header("location:../test/admin.php");
			    exit();
			} else {
				// All required inputs provided

				// Edit the news post

				// Prepare SQL statement handle
				$sql = $this->connection->prepare("UPDATE tblPages SET title = :title, description = :description, content = :content WHERE id = :id");
				  
				// Bind variables to the SQL statement
				$sql->bindParam(':id', $id);
				$sql->bindParam(':title', $title);
				$sql->bindParam(':description', $desc);
				$sql->bindParam(':content', $content);

				// Execute the statement
				$result = $sql->execute();

				$count = $sql->rowCount();
				// Fetch the results
				if ($count > 0) {
					// Successful
					// Redirect to admin page
		            header("location:../test/admin.php");
		            exit();
				} else {
					// Error
					// Redirect to admin page
		            header("location:../test/admin.php");
		            exit();
				}
			}
		}

		/**
    	* Function to get list of pages
        * @return PDO List of pages
		*/
		public function getPages() {

			// Prepare SQL statement handle
			$sql = $this->connection->prepare("SELECT * FROM tblPages");
			  
			// Execute the statement
			$sql->execute();
			
			// Count the results
			$count = $sql->rowCount();
			
			if ($count > 0) {
				// Users exist
				return $sql;
				exit();
			} else {
				// No results
	            return null;
	            exit();
			}
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