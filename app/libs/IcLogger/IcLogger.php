<?php
/**
 * Version 0.1
 */


namespace Libs;

use BaseModule\Presenters\UtilsPresenter;
use Nette\Application\LinkGenerator;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;
use Tracy\Helpers;
use Tracy\Logger;

class IcLogger extends Logger{

    /** @var LinkGenerator @inject */
    public $link_generator;

    public function defaultMailer($message, $email, $exceptionFile = null)
    {
        $link = $this->link_generator->link('Base:Utils:deleteEmailSent', ['hash' => UtilsPresenter::HASH]);
        $link_delete_email_sent = '<br><br><a href="' . $link . '" target="_blank">' . $link . '</a>';

        $host = preg_replace('#[^\w.-]+#', '', isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : php_uname('n'));
        $parts = str_replace(
            array("\r\n", "\n"),
            array("\n", PHP_EOL),
            array(
                'headers' => implode("\n", array(
                        'From: ' . ($this->fromEmail ?: "noreply@$host"),
                        'X-Mailer: Tracy',
                        'Content-Type: text/plain; charset=UTF-8',
                        'Content-Transfer-Encoding: 8bit',
                    )) . "\n",
                'subject' => "PHP: An error occurred on the server $host",
                'body' => $this->formatMessage($message) . "<br><br>" .
                    " source: <a href='" . Helpers::getSource() . "'>" . Helpers::getSource() . "</a>" . $link_delete_email_sent,
            )
        );


        $message = new Message;
        $message->addTo($email)
            ->setFrom('eflyax42@gmail.com')
            ->setSubject($parts['subject'])
            ->setHtmlBody($parts['body'])
            ->addAttachment('exception.html', file_get_contents($exceptionFile));

        $mailer = new SendmailMailer;
        $mailer->send($message);

        //mail($email, $parts['subject'], $parts['body'], $parts['headers']);
    }



    public function log($message, $priority = self::INFO)
    {
        if (!$this->directory) {
            throw new \LogicException('Directory is not specified.');
        } elseif (!is_dir($this->directory)) {
            throw new \RuntimeException("Directory '$this->directory' is not found or is not directory.");
        }

        $exceptionFile = $message instanceof \Exception || $message instanceof \Throwable
            ? $this->getExceptionFile($message)
            : NULL;
        $line = $this->formatLogLine($message, $exceptionFile);
        $file = $this->directory . '/' . strtolower($priority ?: self::INFO) . '.log';

        if (!@file_put_contents($file, $line . PHP_EOL, FILE_APPEND | LOCK_EX)) { // @ is escalated to exception
            throw new \RuntimeException("Unable to write to log file '$file'. Is directory writable?");
        }

        if ($exceptionFile) {
            $this->logException($message, $exceptionFile);
        }

        if (in_array($priority, array(self::ERROR, self::EXCEPTION, self::CRITICAL), TRUE)) {
            $this->sendEmail($message, $exceptionFile);
        }

        return $exceptionFile;
    }

    protected function sendEmail($message, $exceptionFile = null)
    {
        $snooze = is_numeric($this->emailSnooze)
            ? $this->emailSnooze
            : @strtotime($this->emailSnooze) - time(); // @ timezone may not be set

        if ($this->email && $this->mailer
            && @filemtime($this->directory . '/email-sent') + $snooze < time() // @ file may not exist
            && @file_put_contents($this->directory . '/email-sent', 'sent') // @ file may not be writable
        ) {
            //call_user_func($this->mailer, $message, implode(', ', (array) $this->email));
            call_user_func($this->mailer, $message, implode(', ', (array) $this->email), $exceptionFile);
        }
        // fiksme odkomentovat pri ladeni odesilani emailu
        //call_user_func($this->mailer, $message, implode(', ', (array) $this->email), $exceptionFile);
    }

}