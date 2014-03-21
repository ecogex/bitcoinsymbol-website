<?php

class Mailer {
  private $mailer;
  private $render_email;

  function __construct($transport, $render_email) {
    $this->render_email = $render_email;
    $this->mailer = Swift_Mailer::newInstance($transport);
  }

  function send($subject, $to_emails, $template_name, $data) {
    $output = call_user_func($this->render_email, $template_name, $data);
    $message = Swift_Message::newInstance($subject);
    $message->setFrom([ADMIN_FROM_EMAIL => ADMIN_FROM_NAME]);
    $message->setTo(is_array($to_emails)? $to_emails : [$to_emails]);
    $message->setBody($output);

    if (defined('DEBUG') && DEBUG) {
      if (is_array($to_emails)) $to_emails = implode(',', $to_emails);
      $debug_content = "Subject: $subject";
      $debug_content .= "\nFrom: ".ADMIN_FROM_EMAIL;
      $debug_content .= "\nTo: $to_emails";
      $debug_content .= "\nBody:\n\n\n$output";
      $filename = __DIR__ . '/../' . uniqid() .'-'. date('Ymd-H.i.s') . '.txt';
      file_put_contents($filename, $debug_content);
      return;
    }

    $this->mailer->send($message);
  }
}
