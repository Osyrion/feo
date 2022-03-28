<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserTransactionsController extends AbstractController
{
    #[Route('/czk', name: 'czk')]
    public function renderCzkTransactionList(UserRepository $user): Response
    {
        $usersTransactions = $user->findAllUserTransactions(UserRepository::CURRENCY_CZK);

        return $this->render('lastMonthTransactions/index.html.twig', [
            'controller_name' => 'UserTransactionsController',
            'currency' => UserRepository::CURRENCY_CZK,
            'records' => $usersTransactions,
        ]);
    }

    #[Route('/eur', name: 'eur')]
    public function renderEurTransactionList(UserRepository $user): Response
    {
        $usersTransactions = $user->findAllUserTransactions(UserRepository::CURRENCY_EUR);

        return $this->render('lastMonthTransactions/index.html.twig', [
            'controller_name' => 'UserTransactionsController',
            'currency' => UserRepository::CURRENCY_EUR,
            'records' => $usersTransactions,
        ]);
    }
}
