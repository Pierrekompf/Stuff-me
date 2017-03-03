<?php

namespace AppBundle\Controller;

use AppBundle\Entity\stuff_me_user;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Stuff_me_user controller.
 *
 * @Route("/user")
 */
class stuff_me_userController extends Controller
{
    /**
     * Lists all stuff_me_user entities.
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $stuff_me_users = $em->getRepository('AppBundle:stuff_me_user')->findAll();

        return $this->render('stuff_me_user/index.html.twig', array(
            'stuff_me_users' => $stuff_me_users,
        ));
    }

    /**
     * Creates a new stuff_me_user entity.
     *
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $stuff_me_user = new Stuff_me_user();
        $form = $this->createForm('AppBundle\Form\stuff_me_userType', $stuff_me_user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($stuff_me_user);
            $em->flush($stuff_me_user);

            return $this->redirectToRoute('user_show', array('id' => $stuff_me_user->getId()));
        }

        return $this->render('stuff_me_user/new.html.twig', array(
            'stuff_me_user' => $stuff_me_user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a stuff_me_user entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction(stuff_me_user $stuff_me_user)
    {
        $deleteForm = $this->createDeleteForm($stuff_me_user);

        return $this->render('stuff_me_user/show.html.twig', array(
            'stuff_me_user' => $stuff_me_user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing stuff_me_user entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, stuff_me_user $stuff_me_user)
    {
        $deleteForm = $this->createDeleteForm($stuff_me_user);
        $editForm = $this->createForm('AppBundle\Form\stuff_me_userType', $stuff_me_user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', array('id' => $stuff_me_user->getId()));
        }

        return $this->render('stuff_me_user/edit.html.twig', array(
            'stuff_me_user' => $stuff_me_user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a stuff_me_user entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, stuff_me_user $stuff_me_user)
    {
        $form = $this->createDeleteForm($stuff_me_user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($stuff_me_user);
            $em->flush($stuff_me_user);
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a stuff_me_user entity.
     *
     * @param stuff_me_user $stuff_me_user The stuff_me_user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(stuff_me_user $stuff_me_user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $stuff_me_user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
