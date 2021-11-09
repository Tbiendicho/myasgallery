<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    /**
     * @Route("/email", name="mailer")
     */
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('myasgallerydev@gmail.com')
            ->to('thomas.biendicho@gmail.com')
            ->subject('Test')
            ->text('Sending emails is fun again!');

        $mailer->send($email);

        return $this->render('mailer/index.html.twig', [
            'mail' => $email,
        ]);

    }
}
