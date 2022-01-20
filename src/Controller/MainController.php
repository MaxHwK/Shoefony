<?php 

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
//use App\Mailer\ContactMailer;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class MainController extends AbstractController 
{
    private $em;
    //private ContactMailer $mailer;

    public function __construct(EntityManagerInterface $em /*ContactMailer $mailer*/)
    {
        $this->em = $em;
        //$this->mailer = $mailer;
    }

    /**
     * @Route("/", name="main_homepage", methods={"GET"})
     */
    public function homepage(): Response
    {
        return $this->render('main/homepage.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/presentation", name="main_presentation", methods={"GET"})
     */
    public function presentation(): Response
    {
        return $this->render('main/presentation.html.twig', [
            'controller_name' => 'MainPresentation',
        ]);
    }

     /**
     * @Route("/contact", name="main_contact", methods={"GET", "POST"})
     */
    public function contact(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($contact);
            $this->em->flush();
            $this->addFlash('success', 'Merci pour votre message, celui-ci a bien été pris en compte !');
            //$this->mailer->sendMail($contact);
            return $this->redirectToRoute('main_contact');
        }

        return $this->render('main/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
