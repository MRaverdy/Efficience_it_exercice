<?php
// src/Controller/ContactSuccessController.php
namespace App\Controller;

use App\Entity\Department;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactSuccessController
{
    /**
     * @Route("/contact_success/{department}", name="contact_success")
     */
    public function contactSuccess(String $department): Response
    {
        if ($department !== "no-department") {
            $message = new Response('<html><body>The contact has been created and an email has been sent to the department '.$department.'</body></html>');
        }

        else {
            $message = new Response('<html><body>The contact has been created but there is no department in the database to send an email</body></html>');
        }

        return $message;
    }
}
