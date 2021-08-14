<?php
// src/Controller/ContactController.php
namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Department;
use App\Form\Type\ContactType;
use Swift_Mailer;
use Swift_SmtpTransport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
    * @Route("/contact", name="contact")
    */
    public function contactForm(Request $request): Response
    {
        $contact = new Contact();

        $departmentRepository = $this->getDoctrine()->getRepository(Department::class);
        $departments = $departmentRepository->findAll();

        $form = $this->createForm(ContactType::class, $contact, [
            'departments' => $departments,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            if ($department = $form['department']->getData()) {
                $departmentName = $department->getName();

                //PARTIE MAIL CI-DESSOUS EN COMMENTAIRE CAR J'AI LAISSE DES VALEURS ARBITRAIRES
                //$transport = (new Swift_SmtpTransport('smtp.example.org', 25))
                //    ->setUsername('sender')
                //    ->setPassword('password')
                //;
                //$this->sendEmail($contact, $department->getMail(), new Swift_Mailer($transport));
            }

            else {
                $departmentName = "no-department";
            }

            return $this->redirectToRoute('contact_success', ['department' => $departmentName]);
        }

        return $this->render('contact/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function sendEmail(Contact $contact, string $departmentMail, Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('New Contact'))
            ->setFrom('send@example.com')
            ->setTo($departmentMail)
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/registration.html.twig', [
                        'lastName' => $contact->getLastName(),
                        'firstName' => $contact->getfirstName(),
                        'mail' => $contact->getMail(),
                        'message' => $contact->getMessage()
                        ]),
                'text/html'
            );

        $mailer->send($message);
    }
}