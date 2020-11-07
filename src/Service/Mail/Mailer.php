<?php


namespace App\Service\Mail;


use App\Entity\Token;
use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class Mailer
{
    /**
     * @var MailerInterface
     */
    private MailerInterface $mailer;
    /**
     * @var Environment
     */
    private Environment $twig;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {

        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendUserTokenMail(Token $token)
    {

        $body = $this->twig->render("mail/validateToken.html.twig", [
            'token' => $token
        ]);

        $email = (new Email())
            ->from('no-reply@click-and-pick.com')
            ->to($token->getUser()->getEmail())
            ->subject('Valider votre Compte Click & Pick !')
            ->html($body);

        $this->mailer->send($email);
    }
    public function sendUserMailResetPass(User $user)
    {

        $body = $this->twig->render("mail/resetPass.html.twig", [
            'token' => $user->getToken()
        ]);

        $email = (new Email())
            ->from('no-reply@click-and-pick.com')
            ->to($user->getEmail())
            ->subject('Créer un nouveau mot de passe sur Click & Pick !')
            ->html($body);

        $this->mailer->send($email);
    }
}