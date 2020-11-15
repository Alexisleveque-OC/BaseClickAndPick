<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\ConfirmationDeleteType;
use App\Service\User\DeleteService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserDeleteController extends AbstractController
{
    /**
     * @Route("/users/delete/{id}", name="user_delete")
     * @IsGranted("USER_DELETE",subject="user")
     * @param Request $request
     * @param User $user
     * @param DeleteService $deleteService
     */
    public function deleteUser(Request $request,User $user, DeleteService $deleteService)
    {
        $formDelete = $this->createForm(ConfirmationDeleteType::class);
        $formDelete->handleRequest($request);

        if ($formDelete->isSubmitted() && $formDelete->isValid()){
            $deleteService->deleteUser($user);

            if ($this->getUser() == $user){
                $this->addFlash('success','Votre compte à été correctement supprimé.');
                return $this->redirectToRoute('app_logout');
            }
            elseif ($this->getUser()->getRoles() == (["ROLE_ADMIN"])){
                $this->addFlash('success', 'l\'utilisateur a été correctement supprimé');
            }

            return $this->redirectToRoute('user_list');
        }
        $this->addFlash('danger','Vous avez essayer de supprimer un utilisateur sans les droits, c\'est mal!!!');
        return $this->redirectToRoute('home');
    }
}