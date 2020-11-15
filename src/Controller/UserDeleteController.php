<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\ConfirmationDeleteType;
use App\Service\User\DeleteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserDeleteController extends AbstractController
{
    /**
     * @Route("/users/delete/{id}", name="user_delete")
     * @param Request $request
     * @param User $user
     * @param DeleteService $deleteService
     */
    public function deleteUser(Request $request,User $user, DeleteService $deleteService)
    {
        $formDelete = $this->createForm(ConfirmationDeleteType::class);
        $formDelete->handleRequest($request);

        if ($formDelete->isValid() && $formDelete->isSubmitted()){
            $deleteService->deleteUser($user);

            if ($this->getUser() == $user){
                $this->addFlash('success','Votre compte à été correctement supprimé.');
            }
            elseif ($this->getUser()->getRoles() == (["ROLE_ADMIN"])){
                $this->addFlash('success', 'l\'utilisateur a été correctement supprimé');
            }

            return $this->redirectToRoute('app_logout');
        }
    }
}