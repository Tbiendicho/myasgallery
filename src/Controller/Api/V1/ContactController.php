<?php

namespace App\Controller\Api\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ContactController extends AbstractController
{

    // this route will send an email to a user who sent a message with the contact form

    /**
     * @Route("/api/v1/contact", name="contact", methods={"POST"})
     */
    public function sendMessage(Request $request, MailerInterface $mailer): Response
    {
        $requestDatasArray = json_decode($request->getContent(), true);

        $lastname = $requestDatasArray['lastname'];
        $firstname = $requestDatasArray['firstname'];
        $company = $requestDatasArray['company'];
        $mail = $requestDatasArray['email'];
        $phone = $requestDatasArray['phone'];
        $messageObject = $requestDatasArray['messageObject'];
        $message = $requestDatasArray['message'];

        $email = (new TemplatedEmail())
            ->from('myasgallerydev@gmail.com')
            ->to($mail, 'thomas.biendicho@gmail.com')
            ->subject($messageObject)
            ->text($message)
            ->htmlTemplate('contact/index.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'messageObject' => $messageObject,
                'message' => $message,
                'company' => $company,
                'phone' => $phone,
                'mail' => $mail
            ]);

        $mailer->send($email);

        return $this->json('all data sent successfully', 200);
    }
}
