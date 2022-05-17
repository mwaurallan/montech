<?php

namespace App\Jobs;

//use App\Models\Sms;
use App\Models\CustomerMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use infobip;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $_sms;
    public $tries = 2;
    protected  $password;
    protected $username ;
    protected $_message;
    protected $to;
    protected $message_id;
    protected $mf;
    public function __construct($m)
    {
        $this->_message = $m;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {

        $client = new infobip\api\client\SendMultipleTextualSmsAdvanced(new infobip\api\configuration\BasicAuthConfiguration('Hentrans', 'Thika12!@'));
        $destination = new infobip\api\model\Destination();
//
        $destination->setTo($this->_message->phone_number);

        $message = new infobip\api\model\sms\mt\send\Message();
        $message->setFrom("VOOMSMS");
        $message->setDestinations([$destination]);
        $message->setText($this->_message->message);
        $message->setNotifyUrl(url('infoBipCallback'));


        $message->setCallbackData($this->_message->id);

        $requestBody = new infobip\api\model\sms\mt\send\textual\SMSAdvancedTextualRequest();
        $requestBody->setMessages([$message]);

        $response = $client->execute($requestBody);



    }

}
