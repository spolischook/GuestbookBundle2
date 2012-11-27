<?php

namespace Serge\GuestbookBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Serge\GuestbookBundle\Entity\Entry;
use Serge\GuestbookBundle\Form\EntryType;

/**
 * Entry controller.
 *
 */
class EntryController extends Controller
{
    /**
     * Lists all Entry entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GuestbookBundle:Entry')->findAll();

        return $this->render('GuestbookBundle:Entry:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Entry entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GuestbookBundle:Entry')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entry entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('GuestbookBundle:Entry:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new Entry entity.
     *
     */
    public function newAction()
    {
        $entity = new Entry();
        $form   = $this->createForm(new EntryType(), $entity);

        return $this->render('GuestbookBundle:Entry:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Entry entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Entry();
        $form = $this->createForm(new EntryType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('entry_show', array('id' => $entity->getId())));
        }

        return $this->render('GuestbookBundle:Entry:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Entry entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GuestbookBundle:Entry')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entry entity.');
        }

        $editForm = $this->createForm(new EntryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('GuestbookBundle:Entry:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Entry entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GuestbookBundle:Entry')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entry entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new EntryType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('entry_edit', array('id' => $id)));
        }

        return $this->render('GuestbookBundle:Entry:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Entry entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('GuestbookBundle:Entry')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Entry entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('entry'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
