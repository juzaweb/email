<?php

namespace Juzaweb\Email;

use Juzaweb\Email\Models\EmailList;
use Illuminate\Support\Facades\Mail;

class SendEmailService
{
    protected $mail;

    public function __construct(EmailList $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Send email by row email_lists table
     *
     * @return bool
     * */
    public function send()
    {
        $validate = $this->validate();
        if ($validate !== true) {
            $this->updateError($validate);
            return false;
        }
        
        $this->updateStatus('processing');
    
        try {
            Mail::send('emailtemplate::layouts.default', [
                'body' => $this->getBody(),
            ], function ($message) {
                $message->to([$this->mail->email])
                    ->subject($this->getSubject());
            });
        
            if (Mail::failures()) {
                $this->updateError(array_merge([
                    'title' => 'Mail failures',
                ], Mail::failures()));
                return false;
            }
        
            $this->updateStatus('success');
            return true;
        } catch (\Exception $e) {
            $this->updateError([
                'title' => 'Send mail exception',
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
    
            return false;
        }
    }
    
    protected function getSubject()
    {
        if (@$this->mail->data['subject']) {
            $subject = $this->mail->data['subject'];
        } else {
            $subject = $this->mail->template->subject;
        }
        
        return $this->mapParams($subject);
    }
    
    protected function getBody()
    {
        if (@$this->mail->data['body']) {
            $body = $this->mail->data['body'];
        } else {
            $body = $this->mail->template->body;
        }
    
        return $this->mapParams($body);
    }
    
    protected function updateStatus(string $status)
    {
        return $this->mail->update([
            'status' => $status,
        ]);
    }
    
    protected function updateError(array $error = [])
    {
        return $this->mail->update([
            'error' => $error,
            'status' => 'error',
        ]);
    }
    
    protected function mapParams($string)
    {
        foreach ($this->mail->params as $key => $param) {
            $string = str_replace('{'. $key .'}', $param, $string);
        }
        
        return $string;
    }
    
    protected function validate()
    {
        return true;
    }
}