<?php

namespace App\Controller\Api\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/api/v1/contact", name="contact", methods={"POST"})
     */
    public function sendMessage(Request $request, MailerInterface $mailer): Response
    {

        $lastname = $request->request->get('lastName');
        $firstname = $request->request->get('firstName');
        $company = $request->request->get('company');
        $email = $request->request->get('email');
        $phone = $request->request->get('phone');
        $messageObject = $request->request->get('messageObject');
        $message = $request->request->get('message');

        $email = (new Email())
            ->from('myasgallerydev@gmail.com')
            ->to($email, 'myasgallerydev@gmail.com')
            ->subject($messageObject)
            ->text($message);

        $mailer->send($email);


        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
}
