<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;
use Config;

class SendEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * the $validate is validate code or validate url
     *
     * @var string
     */
    protected $validate;
    /**
     * the $mailAddress is email address
     * @var string
     */
    protected $mailAddress;
    /**
     * flag equal false is active link ,true is validate code
     *
     * @var bool
     */
    protected $flag;

    /**
     * SendEmail constructor.
     * @param $mailAddress
     * @param $validateCode
     * @param bool $flag
     */
    public function __construct($mailAddress,$validateCode,$flag = false)
    {
        $this->mailAddress = $mailAddress;
        $this->validate = $validateCode;
        $this->flag = $flag;
    }

    /**
     * Execute the job.
     *
     * @param Mailer $mailer
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        if($this->flag)
            $content = "您好！您的验证码为：【".$this->validate." 】,".Config::get('system.emailExpiry')."分钟内有效！";
        else
            $content = "您好！您的账户专用激活链接为:".$this->validate;
        $mailer->Raw($content, function ($message) {
            $message->to($this->mailAddress)->subject($this->flag==true?'验证码':'账户激活');
        });
        app('mail-log')->info($this->mailAddress.' '.$content." 成功！", compact('time'));
    }
}