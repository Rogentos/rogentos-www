<?php
class Ccontact{

    var $C;               //main object
    var $LG;
    var $feedback;

    function DISPLAY(){

        $display = '<div style="float:right;"><br/>'.$this->feedback.'</div>';

        $display .= file_get_contents(publicPath.'MODELS/contact/RES/'.$this->LG.'/contact.html');

        $display .= '
            <form action="" method="post" id="form_comp">
                <input type="hidden" name="action" value="contact" />

                <span style="width:140px; float:left;">Full name</span>
                    <input type="text" name="name" size="40" id="name" style="margin-bottom:5px;" value="'.$_POST['name'].'" />
                <br/>
            
                <span style="width:140px; float:left;">E-mail </span>
                    <input type="text" name="email" size="40" id="email" style="margin-bottom:5px;" value="'.$_POST['email'].'" />
                <br/>
                <br/>
            
                <span style="width:140px; float:left;">Subject</span>
                    <input type="text" name="subject" size="40" id="subject" value="'.$_POST['subject'].'" />
                <br/>
            
                <span style="width:140px; float:left;">Message</span>
                    <textarea name="message" cols="35" rows="6" id="message" style="margin-top:5px;" >'.$_POST['message'].'</textarea>
                <br/>
                    <input type="submit" name="Submit" value="Submit" /> 
                        &nbsp;&nbsp;&nbsp;
                    <input type="reset" name="Reset" value="Reset" />
            </form>
        ';

        return  $display;
    }

    function __construct($C){

        $this->C = &$C;
        $this->LG = &$C->lang;

        if(isset($_POST['action'])) {
            $this->processContact();
        }
    }

    private function processContact() {
        $env = new Envelope(array(   'company'  => 'Company name (min 3 characters)'
                                    ,'title'    => 'Title'
                                    ,'name'     => 'Full name (3 to 40 characters)'
                                    ,'position' => 'Job position (min 3 characters)'
                                    ,'address'  => 'Full address  (min 10 characters)'
                                    ,'email'    => 'Email address'
                                    ,'phone'    => 'Phone number (min 10 chars, numbers and punctuation)'
                                    ,'subject'  => 'Message subject (min 3 characters)'
                                    ,'message'  => 'Message (min 3 characters)'
                                ));

        if($env->status == TRUE) {
            $_SESSION['form-feedback'] = 'Your message was sent, thank you!';

        // verifica daca "plicul" a iesit ok
        // daca da, new Mail(plicul), apoi redirect catre referrer
        // daca nu, break;

		$messageContent = "From: ".$env->items['title']['content'].' '.$env->items['name']['content']."\r\n<br/>";
		$messageContent .= $env->items['position']['content']." at ".$env->items['company']['content']."\r\n<br/>";
		$messageContent .= "Address: ".$env->items['address']['content']."\r\n<br/>";
		$messageContent .= "Email: ".$env->items['email']['content']."\r\n<br/>";
		$messageContent .= "Phone: ".$env->items['phone']['content']."\r\n<br/><br/>";
		$messageContent .= "Subject: ".$env->items['subject']['content']."\r\n<br/>";
		$messageContent .= "Message: ".$env->items['message']['content']."\r\n<br/>";

	    $mail = new Mail('mail.serenitymedia.ro');
	    $mail->Username = 'noreply@serenitymedia.ro';
	    $mail->Password = 'donotreply';

	    $mail->SetFrom("noreply@serenitymedia.ro","Serenity Media Mailer");             // Name is optional
	    $mail->AddTo($env->items['email']['content'],$env->items['name']['content']);   // Name is optional
	    $mail->Subject = "Mail trimis din clasa Envelope";
	    $mail->Message = $messageContent;

	    // Chestii optionale
	    $mail->AddCc("ioana@serenitymedia.ro","Puf mic"); 	// Seteaza CC, numele e optional
	    $mail->ContentType = "text/html";        		// Default in "text/plain; charset=iso-8859-1"
	    $mail->ConnectTimeout = 30;		                // Socket timeout (sec)
	    $mail->ResponseTimeout = 8;		                // CMD timeout (sec)

	    $mail->Headers['Reply-To']=$env->items['email']['content'];

	    $success = $mail->Send();

	    unset ($_POST);
	}
        else {
            $this->feedback = 'Please correct the following fields:<br/>';
            foreach ($env->errors as $value) {
                $this->feedback .= $value."\n<br/>";
            }
        }
    }
}
