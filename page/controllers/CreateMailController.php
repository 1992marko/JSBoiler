<?php 

require_once __DIR__."/../classes/Class.Navigacija.php";
require_once __DIR__."/../../Config.php";

class CreateMailController extends BaseController
{ 	

	public function __construct($_page = null){}

	
	public function tourMailRequest($request, $response, $args){

		$vars = $request->getParsedBody();
		$mailHTML = $this->render("./views/MailTemplates/TourRequestMailTemplate.php", [ "vars" => $vars ] );
		
		$mail = new PHPMailer;
		$mail->setFrom('no-reply@atlas.hr', 'Atlas.hr');
		$mail->addAddress('borming@borming.hr', 'Joe User');
		$mail->addAddress('iva.huljic@atlas.hr', 'Iva Huljić');
		$mail->addAddress('putovanja@atlas.hr', 'Putovanja');
		$mail->addAddress('marko.busic@atlas.hr', 'Marko Bušić');
		$mail->CharSet = 'UTF-8';
		$mail->isHTML(true);
		$mail->Subject = 'Upit za turu sa www.atlas.hr';
		$mail->Body    = $mailHTML;

		if(!$mail->send()) {
		    http_response_code(502);
		} else {
			echo json_encode($vars);
		}

	}


	public function objectOnRequest($request, $response, $args){

		$vars = $request->getParsedBody();
		$vars = $vars["data"]["items"][0];

		$mailHTML = $this->render("./views/MailTemplates/ObjectOnRequestTemplate.php", [ "vars" => $vars, "user" => $_SESSION["user"] ] );

		$mail = new PHPMailer;
		$mail->setFrom('no-reply@atlas.hr', 'Atlas.hr');
		$mail->addAddress('borming@borming.hr', 'Joe User');
		$mail->addAddress('iva.huljic@atlas.hr', 'Iva Huljić');
		$mail->addAddress('putovanja@atlas.hr', 'Putovanja');
		$mail->addAddress('marko.busic@atlas.hr', 'Marko Bušić');
		$mail->CharSet = 'UTF-8';
		$mail->isHTML(true);
		$mail->Subject = 'Rezervacija ili upit sa www.atlas.hr';
		$mail->Body    = $mailHTML;

		if(!$mail->send()) {
		    http_response_code(502);
		} else {
			echo json_encode($vars);
		}

	}

	public function contactMail($request, $response, $args){

		$vars = $request->getParsedBody();
		$mailHTML = $this->render("./views/MailTemplates/ContactForm.php", [ "vars" => $vars ] );
		
		$mail = new PHPMailer;
		$mail->setFrom('no-reply@atlas.hr', 'Atlas.hr');
		$mail->addAddress('borming@borming.hr', 'Joe User');
		$mail->addAddress('iva.huljic@atlas.hr', 'Iva Huljić');
		$mail->addAddress('putovanja@atlas.hr', 'Iva Huljić');
		$mail->addAddress('marko.busic@atlas.hr', 'Marko Bušić');
		$mail->CharSet = 'UTF-8';
		$mail->isHTML(true);
		$mail->Subject = 'Kontakt upit sa www.atlas.hr';
		$mail->Body    = $mailHTML;
		
		if(!$mail->send()) {
		    http_response_code(502);
		} else {
			echo json_encode($vars);
		}

	}


	public function partnerMail($request, $response, $args){

		$vars = $request->getParsedBody();
		$mailHTML = $this->render("./views/MailTemplates/PartnerMail.php", [ "vars" => $vars ] );
		
		$mail = new PHPMailer;
		$mail->setFrom('no-reply@atlas.hr', 'Atlas.hr');
		$mail->addAddress('borming@borming.hr', 'Joe User');
		$mail->addAddress('iva.huljic@atlas.hr', 'Iva Huljić');
		$mail->addAddress('putovanja@atlas.hr', 'Putovanja');
		$mail->addAddress('marko.busic@atlas.hr', 'Marko Bušić');
		$mail->CharSet = 'UTF-8';
		$mail->isHTML(true);
		$mail->Subject = 'Partner upit sa www.atlas.hr';
		$mail->Body    = $mailHTML;
		
		if(!$mail->send()) {
		    http_response_code(502);
		} else {
			echo json_encode($vars);
		}

	}


	public function privatniFormularMail($request, $response, $args){

		$vars = $request->getParsedBody();
		$mailHTML = $this->render("./views/MailTemplates/PrivatniForm.php", [ "vars" => $vars ] );
		
		$mail = new PHPMailer;
		$mail->setFrom('no-reply@atlas.hr', 'Atlas.hr');
		$mail->addAddress('borming@borming.hr', 'Joe User');
		$mail->addAddress('iva.huljic@atlas.hr', 'Iva Huljić');
		$mail->addAddress('putovanja@atlas.hr', 'Putovanja');
		$mail->addAddress('marko.busic@atlas.hr', 'Marko Bušić');
		$mail->CharSet = 'UTF-8';
		$mail->isHTML(true);
		$mail->Subject = 'Privatni iznajmljivaći upit sa www.atlas.hr';
		$mail->Body    = $mailHTML;
		
		if(!$mail->send()) {
		    http_response_code(502);
		} else {
			echo json_encode($vars);
		}

	}

	public function putovanjaPoMjeri($request, $response, $args){

		$vars = $request->getParsedBody();
		$mailHTML = $this->render("./views/MailTemplates/PutovanjaPoMjeri.php", [ "vars" => $vars ] );
		
		$mail = new PHPMailer;
		$mail->setFrom('no-reply@atlas.hr', 'Atlas.hr');
		$mail->addAddress('borming@borming.hr', 'Joe User');
		$mail->addAddress('iva.huljic@atlas.hr', 'Iva Huljić');
		$mail->addAddress('putovanja@atlas.hr', 'Putovanja');
		$mail->addAddress('marko.busic@atlas.hr', 'Marko Bušić');
		$mail->CharSet = 'UTF-8';
		$mail->isHTML(true);
		$mail->Subject = 'Putovanja po mjeri upit sa www.atlas.hr';
		$mail->Body    = $mailHTML;

		if(!$mail->send()) {
		    http_response_code(502);
		} else {
			echo json_encode($vars);
		}

	}


} 
?>