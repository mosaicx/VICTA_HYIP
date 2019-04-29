<?php
require_once("../PHPMailer/class.phpmailer.php");

class EmailHandler{
	
	public static $mail;
	public $admin_email;
	public $admin_smtp;
	public $admin_email_password;
	
	public function __construct(){
		self::$mail = new PHPMailer();
		
		$this->admin_email = 'xxxxxxxxxx@gmail.com';
		$this->admin_smtp = 'smtp.gmail.com';
		$this->admin_email_password = '***************!';
		
		self::$mail->IsSMTP();
		self::$mail->Port = 465;
		self::$mail->SMTPAuth = true;
		self::$mail->Host =  $this->admin_smtp;
		self::$mail->SetFrom($this->admin_email);
		self::$mail->Username = $this->admin_email;
		self::$mail->Password =  $this->admin_email_password;
	}
	
	function sendAccountRegister($user_email, $user_name){
		self::$mail->Subject = "VICTA | Account Registration ";
		self::$mail->Body = "Greetings from the VICTA team! Thanks $user_name for joining our investor community. We hope your experience will be a rich one. Account Registration \n
							Our community of young ambitious investment innovators strives to create investment opportunities for our investor community.  \n
							We invest primarily in rental property and facilitate access to incomes generated from those properties.  \n
							By purchasing a Virtual Investment Contract from VICTA, you are investing in the capacities that generate rental incomes.  \n
							So you earn rent from property without having to own property! Now that you have an idea of what you’re signing up to, what is your next step?  \n
							1.	Verify your email (Profile page > Account Information tab) 2.	Verify banking details (Profile page > KYC Information tab)  \n
							3.	Make a deposit to the VICTA account using your assigned reference (your registration email) 4.	Start purchase VICTAs (Transactions page > VICTAS tab)  \n
							5.	Follow the growth of your VICTA investment from the VICTA dashboard. For any issues, reach out to us on the VICTA Facebook page.  \n
							Our small (but growing) team of consultants is available Monday to Friday 08:00 – 16:30 to respond to any queries.  \n
							We are in the early phases of this innovation and have a long term vision of becoming an investment industry disruptor by opening up property investments to the masses.  \n \n
							Thanks for your support! The VICTA Team.";
		self::$mail->SMTPSecure = 'ssl';
		self::$mail->AddAddress($user_email);
		if(self::$mail->Send()){
			return true;
		}else{
			return self::$mail->ErrorInfo;
		}
	}

	function sendNewPassword($user_email, $user_name, $password){
		self::$mail->Subject = "VICTA | Your New Password ";
		self::$mail->Body = "Greetings from the VICTA team! You recently sent a request to reset your VICTA password. Bbelow is your new password.  \n ";
		self::$mail->Body .= "New password code for ".$user_name.": ".$password.".  \n";
		self::$mail->Body .= "Please keep your password secret. In future you can reset your password from your profile tab.  \n \n Regards VICTA Team. ";
		self::$mail->SMTPSecure = 'ssl';
		self::$mail->AddAddress($user_email);
		if(self::$mail->Send()){
			return true;
		}else{
			return self::$mail->ErrorInfo;
		}
	}

	function sendPasswordVerificationCode($user_email, $user_name, $verificationCode){
		self::$mail->Subject = "VICTA | Your Password Verification Code ";
		self::$mail->Body = "Greetings from the VICTA team! You recently tried to reset your VICTA password. Please find herein the verification code for password reset confirmation. ";
		self::$mail->Body .= "Verification code for ".$user_name.": ".$verificationCode." ";
		self::$mail->Body .= "Please note this pin is only valid for the confirmation of the password you have opted to reset. Regards  VICTA Team. ";
		self::$mail->SMTPSecure = 'ssl';
		self::$mail->AddAddress($user_email);
		if(self::$mail->Send()){
			return true;
		}else{
			return self::$mail->ErrorInfo;
		}
	}

	function sendEmailVerificationCode($user_email, $user_name, $verificationCode){
		self::$mail->Subject = "VICTA | Your Password Verification Code ";
		self::$mail->Body = "Greetings from the VICTA team! You recently tried to confirma your VICTA email. Please find herein the verification code for email confirmation. ";
		self::$mail->Body .= "Verification code for ".$user_name.": ".$verificationCode." ";
		self::$mail->Body .= "Please note this pin is only valid for the confirmation of the email you have opted to reset. Regards  VICTA Team. ";
		self::$mail->SMTPSecure = 'ssl';
		self::$mail->AddAddress($user_email);
		if(self::$mail->Send()){
			return true;
		}else{
			return self::$mail->ErrorInfo;
		}
	}

	function sendPasswordVerificationConfirmation($user_email){
		self::$mail->Subject = "VICTA | Your Password Change Confirmation ";
		self::$mail->Body = "Greetings from the VICTA team! You recently reset your VICTA password. This email is a confirmation that your password has been successfully changed. ";
		self::$mail->Body .= "No action is required regarding this email. Regards  VICTA Team. ";
		self::$mail->SMTPSecure = 'ssl';
		self::$mail->AddAddress($user_email);
		if(self::$mail->Send()){
			return true;
		}else{
			return self::$mail->ErrorInfo;
		}
	}
	function sendWithdrawalRequest($user_email, $withdrawal_amount, $bank_details){
		self::$mail->Subject = "VICTA | Withdrawal Request";
		self::$mail->Body = "Greetings from the VICTA team! You recently made a withdrawal request.";
		self::$mail->Body .= "This request is currently being processed, once approved, the requested amount of ".$withdrawal_amount." will be processed and funds will be credited to the account details: ";
		self::$mail->Body .= $bank_details.". Regards  VICTA Team. ";
		self::$mail->SMTPSecure = 'ssl';
		self::$mail->AddAddress($user_email);
		if(self::$mail->Send()){
			return true;
		}else{
			return self::$mail->ErrorInfo;
		}
	}
}
?>
