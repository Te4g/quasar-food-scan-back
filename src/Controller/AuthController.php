<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController extends AbstractController
{
    private $userRepository;
    private $userPasswordEncoder;

    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $password = $data['password'];
        $name = $data['email'];

        $user = (new User())
            ->setEmail($email)
            ->setPassword($this->userPasswordEncoder->encodePassword(new User(), $password))
            ->setName($name)
        ;

        $this->userRepository->save($user);

        return new Response('', 201);
    }
}
