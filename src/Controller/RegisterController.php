<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use function Sodium\add;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $registerform = $this->createFormBuilder()
            ->add('username', TextType::class, [
                'label' => 'Username',
            ])
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'required' => true,
            'first_options'  => ['label' => 'Password'],
            'second_options' => ['label' => 'Repeat Password'],

    ])
            ->add('Register', SubmitType::class,  [
                'attr' => ['class' => 'btn btn-info']])
            ->getForm();
        $registerform->handleRequest($request);
        if ($registerform->isSubmitted() && $registerform->isValid()) {
            $data = $registerform->getData();
            $user = new User();
            $user->setUsername($data['username']);
            $user->setPassword($passwordHasher->hashPassword($user, $data['password']));
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('app_main_home'));

        }

        return $this->render('register/index.html.twig', [
            'registerform' => $registerform->createView(),

        ]);
    }
}
