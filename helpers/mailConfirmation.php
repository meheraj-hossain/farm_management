<?php
	function redirect() {
		header('Location: ../registration.php');
		exit();
	}

	if (!isset($_GET['email']) || !isset($_GET['verification_key'])) {
		redirect();
	}else {
		$con = new mysqli('localhost', 'root', '', 'farm_management');

		$email = $con->real_escape_string($_GET['email']);
		$verification_key = $con->real_escape_string($_GET['verification_key']);

		$sql = mysqli_query($con,"SELECT id FROM users WHERE email='$email' AND verification_key='$verification_key' AND verified=0");

		if (mysqli_num_rows($sql) > 0) {
			mysqli_query($con,"UPDATE users SET verified=1, verification_key='' WHERE email='$email'");
			// echo "Your email has been verified! You can log in now! <a type='button' class='btn btn-primary' href='http://localhost/running/disaster_management/login'>Login</a>";
		?>
		<!DOCTYPE html>
		<html>
			<head>

			  <meta charset="utf-8">
			  <meta http-equiv="x-ua-compatible" content="ie=edge">
			  <title>Email Confirmation</title>
			  <meta name="viewport" content="width=device-width, initial-scale=1">
			  <style type="text/css">
			  
			  @media screen {
			    @font-face {
			      font-family: 'Source Sans Pro';
			      font-style: normal;
			      font-weight: 400;
			      src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
			    }
			    @font-face {
			      font-family: 'Source Sans Pro';
			      font-style: normal;
			      font-weight: 700;
			      src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
			    }
			  }
			  body,
			  table,
			  td,
			  a {
			    -ms-text-size-adjust: 100%; /* 1 */
			    -webkit-text-size-adjust: 100%; /* 2 */
			  }
			  
			  table,
			  td {
			    mso-table-rspace: 0pt;
			    mso-table-lspace: 0pt;
			  }
			  
			  img {
			    -ms-interpolation-mode: bicubic;
			  }
			  
			  a[x-apple-data-detectors] {
			    font-family: inherit !important;
			    font-size: inherit !important;
			    font-weight: inherit !important;
			    line-height: inherit !important;
			    color: inherit !important;
			    text-decoration: none !important;
			  }
			  
			  div[style*="margin: 16px 0;"] {
			    margin: 0 !important;
			  }
			  body {
			    width: 100% !important;
			    height: 100% !important;
			    padding: 0 !important;
			    margin: 0 !important;
			  }
			  
			  table {
			    border-collapse: collapse !important;
			  }
			  a {
			    color: #1a82e2;
			  }
			  img {
			    height: auto;
			    line-height: 100%;
			    text-decoration: none;
			    border: 0;
			    outline: none;
			  }
			  </style>

			</head>
			<body style="background-color: #e9ecef;">

			  <!-- start preheader -->
			  <div class="preheader" style="display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0;">
			    A preheader is the short summary text that follows the subject line when an email is viewed in the inbox.
			  </div>
			  <!-- end preheader -->

			  <!-- start body -->
			  <table border="0" cellpadding="0" cellspacing="0" width="100%">

			    <!-- start hero -->
			    <tr>
			      <td align="center" bgcolor="#e9ecef">
			        
			        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
			          <tr>
			            <td align="left" bgcolor="#ffffff" style="padding: 36px 24px 0; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;">
			              <h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">Your Email Address Has Been Confirmed</h1>
			            </td>
			          </tr>
			        </table>
			        
			      </td>
			    </tr>
			    <!-- end hero -->

			    <!-- start copy block -->
			    <tr>
			      <td align="center" bgcolor="#e9ecef">
			       
			        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">

			          <!-- start copy -->
			          <tr>
			            <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
			              <h4 style="margin: 0;">Now you can login </h4>
			            </td>
			          </tr>
			          <!-- end copy -->

			          <!-- start button -->
			          <tr>
			            <td align="left" bgcolor="#ffffff">
			              <table border="0" cellpadding="0" cellspacing="0" width="100%">
			                <tr>
			                  <td align="center" bgcolor="#ffffff" style="padding: 12px;">
			                    <table border="0" cellpadding="0" cellspacing="0">
			                      <tr>
			                        <td align="center" bgcolor="#1a82e2" style="border-radius: 6px;">
			                          <a href="http://localhost/farm_management/login.php" target="_blank" style="display: inline-block; padding: 16px 36px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 6px;">Login</a>
			                        </td>
			                      </tr>
			                    </table>
			                  </td>
			                </tr>
			              </table>
			            </td>
			          </tr>
			          <!-- end button -->

			          

			          <!-- start copy -->
			          <tr>
			            <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-bottom: 3px solid #d4dadf">
			              <p style="margin: 0;">Thanks,<br> Farm Management System</p>
			            </td>
			          </tr>
			          <!-- end copy -->

			        </table>
			        
			      </td>
			    </tr>
			    <!-- end copy block -->

			   

			  </table>
			  <!-- end body -->

			</body>
		</html>
		<?php
		}else{
			echo 'something went wrong';
		}
	}
?>

