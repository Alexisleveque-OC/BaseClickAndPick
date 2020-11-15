<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserAddNoteType;
use App\Service\User\AddNoteService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserAddNote extends AbstractController
{
    /**
     * @Route("/user/add-note/{id}",name="user_add_note")
     * @IsGranted("USER_ADD_NOTE")
     * @param Request $request
     * @param User $user
     * @param AddNoteService $addNoteService
     * @return RedirectResponse
     */
    public function addNoteToUser(Request $request, User $user, AddNoteService $addNoteService)
    {
        $form = $this->createForm(UserAddNoteType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $addNoteService->addNote($form->getData());

            $this->addFlash('success','Votre note a bien été enregistré.');

            return $this->redirectToRoute('user_show',['id'=>$user->getId()]);
        }

        $this->addFlash('warning','Il y a eu un problème lors de l\'enregistrement de la note.');

        return $this->redirectToRoute('user_show',['id'=>$user->getId()]);
    }
}