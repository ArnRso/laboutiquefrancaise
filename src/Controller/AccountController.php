<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/compte", name="account")
     */
    public function index(): Response
    {
        dump(json_encode(array('ROLE_ADMIN')));
        return $this->render('account/index.html.twig');
    }

    /**
     * @Route("/compte/modifier-mot-de-passe", name="account_edit_password")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function edit_password(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $old_password = $form->get('old_password')->getData();

            if ($passwordEncoder->isPasswordValid($user, $old_password)) {
                $user = $form->getData();
                $user->setPassword($passwordEncoder->encodePassword($user, $form->get('new_password')->getData()));

                $this->entityManager->flush();

                $this->addFlash('success', 'Votre mot de passe a bien été mis à jour');
                return $this->redirectToRoute('account');
            } else {
                $this->addFlash('danger', 'Mot de passe actuel incorrect');
            }

        }
        return $this->render('account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
