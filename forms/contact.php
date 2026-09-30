<?php

  
  // Replace contact@example.com with your real receiving email address
  $receiving_email_address = 'info@estebanhuaraya.com';

  // Create a simple replacement class for PHP_Email_Form
  class PHP_Email_Form {
    public $ajax = false;
    public $to;
    public $from_name;
    public $from_email;
    public $subject;
    private $messages = [];
  
    public function add_message($value, $label, $length = 0) {
      $this->messages[] = ["value" => $value, "label" => $label, "length" => $length];
    }
  
    public function send() {
      $message_body = "";
      foreach ($this->messages as $message) {
        $message_body .= $message["label"] . ": " . $message["value"] . "\r\n";
      }
      
      $headers = "From: {$this->from_name} <{$this->from_email}>\r\n";
      $headers .= "Reply-To: {$this->from_email}\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
      
      if (mail($this->to, $this->subject, $message_body, $headers)) {
        // Cambiamos el mensaje de éxito para que sea exactamente "OK"
        echo "OK";
        return true;
      } else {
        echo "El mensaje no pudo ser enviado. Por favor, inténtalo de nuevo.";
        return false;
      }
    }
  }
  
  $contact = new PHP_Email_Form;
  $contact->ajax = true;
  $contact->to = $receiving_email_address;
  $contact->from_name = $_POST['name'];
  $contact->from_email = $_POST['email'];
  $contact->subject = $_POST['subject'];

  // Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
  /*
  $contact->smtp = array(
    'host' => 'example.com',
    'username' => 'example',
    'password' => 'pass',
    'port' => '587'
  );
  */

  $contact->add_message( $_POST['name'], 'From');
  $contact->add_message( $_POST['email'], 'Email');
  $contact->add_message( $_POST['message'], 'Message', 10);

  $contact->send();
?>