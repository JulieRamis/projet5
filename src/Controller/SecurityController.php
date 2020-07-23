<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\EditPassType;
use App\Form\EditProfileType;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use function Sodium\add;
use Symfony\Component\HttpFoundation\Session\Session;


class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute("app_login");
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/profil", name="profile")
     */
    public function profile()
    {
        $user = $this->getUser();
        return $this->render('profile.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("security/editprofil", name="edit_profile")
     */
    public function editProfile(Request $request)
    {
        $user = $this->getUser();
        $formProfile = $this->createForm(EditProfileType::class, $user);

        $formProfile->handleRequest($request);

        if ($formProfile->isSubmitted() && $formProfile->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'Profil mis à jour');

            return $this->redirectToRoute('profile');
        }

        return $this->render('security/editprofile.html.twig', [
            'form' => $formProfile->createView(),
        ]);
    }

    /**
     * @Route("security/editpass", name="edit_pass")
     */
    public function editPass(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();
            $password = $request->get('pass');

            if ($password == $request->request->get('pass2')) {
                if (strlen($password >= 8)) {

                    $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('pass')));
                    $em->flush();
                    $this->addFlash('message', 'mot de passe bien mis à jour');

                    return $this->redirectToRoute('profile');
                } else {
                    $this->addFlash('error', 'Le mot de passe doit contenir au moins 8 caractères');
                }
            } else {
                $this->addFlash('error', 'Les mots de passe ne sont pas identiques');
            }
        }
        return $this->render('security/editpass.html.twig', [
        ]);
    }


    /**
     * @IsGranted("ROLE_USER")
     * @Route("security/deleteuser/{id}", name="delete_user")
     */
    public function deleteUser(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $currentUser = $this->getUser();
        if ($user !== $currentUser) {
            return $this->redirectToRoute('home');
        }
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('home');

    }

}
