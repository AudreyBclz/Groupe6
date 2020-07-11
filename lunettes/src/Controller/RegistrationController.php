<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use App\Security\RegistrationAuthenticator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, RegistrationAuthenticator $authenticator): Response
    {
        $msg='';
        $user = new User();
        $session= new Session();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if($user->getEmail()!== NULL)
        {
            $email=$this->getDoctrine()->getRepository(User::class)->findOneBy(['email'=>$user->getEmail()]);
            dump($email);
           /* if($email->getId()!==NULL)
            {
                $msg='Adresse mail déjà utilisée';
            }*/



            $f_address=$user->getAddress()->getFirstAddress();
            $s_address=$user->getAddress()->getSecondAddress();
            $zip=$user->getAddress()->getZipcodeAddress();
            $town=$user->getAddress()->getTownAddress();
            $country=$user->getAddress()->getCountryAddress();

            $adress=$this->getDoctrine()->getRepository(Address::class)->findOneBy(['firstAddress'=>$f_address,'secondAddress'=>$s_address,'zipcodeAddress'=>$zip,'townAddress'=>$town,'countryAddress'=>$country]);
            $user->setAddress($adress);

        }



        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setRoles(["ROLE_USER"]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();



            // generate a signed url and email it to the user
            /*$this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('alohaha638@gmail.com', 'Alo'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );*/
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'msgError'=>$msg,
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('/register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
       // $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('/register');
    }
}
