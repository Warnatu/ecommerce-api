<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private EntityManagerInterface $entityManager;

    // Inyección de dependencias
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Crear usuario
    public function createUser(string $email, string $password): array
    {
        $user = new User();
        $user->setEmail($email);
        //encriptar la clave
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return [
            'id' => $user->getId(),
            'email' => $user->getEmail()
        ];
    }

    //function loggin
    public function login(string $email, string $password): array
    {
        // Buscar usuario por email
        $user = $this->entityManager
            ->getRepository(\App\Entity\User::class)
            ->findOneBy(['email' => $email]);

        // Si no existe
        if (!$user) {
            return ['error' => 'Usuario no encontrado'];
        }

        // Verificar password
        if (!password_verify($password, $user->getPassword())) {
            return ['error' => 'Contraseña incorrecta'];
        }

        // Login correcto
        return [
            'message' => 'Login exitoso',
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail()
            ]
        ];
    }
}