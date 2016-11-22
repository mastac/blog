<?php

namespace App\Services;

use App\Repositories\ActivationRepository;
use Carbon\Carbon;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

use App\User;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class ActivationService
 * @package App
 */
class ActivationService
{
    protected $mailer;

    protected $activationRepo;

    protected $resendAfter = 24;

    /**
     * ActivationService constructor.
     * @param Mailer $mailer
     * @param \App\Repositories\ActivationRepository $activationRepo
     */
    public function __construct(Mailer $mailer, ActivationRepository $activationRepo)
    {
        $this->mailer = $mailer;
        $this->activationRepo = $activationRepo;
    }

    /**
     * @param $user
     */
    public function sendActivationMail($user)
    {
        if ($user->activated || !$this->shouldSend($user)) {
            return;
        }

        $token = $this->activationRepo->createActivation($user);

        $link = route('user.activate', $token);

        $message = (new MailMessage)
            ->action('Activate', $link);

        $this->mailer->send($message->view, $message->data(), function (Message $m) use ($user) {
            $m->to($user->email)->subject('Activation mail');
        });
    }

    public function activateUser($token)
    {
        $activation = $this->activationRepo->getActivationByToken($token);

        if ($activation === null) {
            return null;
        }

        $user = User::find($activation->user_id);

        $user->activated = true;

        $user->save();

        $this->activationRepo->deleteActivation($token);

        return $user;
    }

    public function shouldSend($user)
    {
        $activation = $this->activationRepo->getActivation($user);
        return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
    }

}
