<?php

namespace SerieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SerieBundle\Entity\Episode;
use SerieBundle\Form\EpisodeType;

/**
 * Episode controller.
 *
 */
class EpisodeController extends Controller
{

    /**
     * Lists all Episode entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SerieBundle:Episode')->findAll();

        return $this->render('SerieBundle:Episode:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Episode entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Episode();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('episode_show', array('id' => $entity->getId())));
        }

        return $this->render('SerieBundle:Episode:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Episode entity.
     *
     * @param Episode $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Episode $entity)
    {
        $form = $this->createForm(new EpisodeType(), $entity, array(
            'action' => $this->generateUrl('episode_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Episode entity.
     *
     */
    public function newAction()
    {
        $entity = new Episode();
        $form   = $this->createCreateForm($entity);

        return $this->render('SerieBundle:Episode:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Episode entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SerieBundle:Episode')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Episode entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SerieBundle:Episode:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Episode entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SerieBundle:Episode')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Episode entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SerieBundle:Episode:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Episode entity.
    *
    * @param Episode $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Episode $entity)
    {
        $form = $this->createForm(new EpisodeType(), $entity, array(
            'action' => $this->generateUrl('episode_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Episode entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SerieBundle:Episode')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Episode entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('episode_edit', array('id' => $id)));
        }

        return $this->render('SerieBundle:Episode:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Episode entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SerieBundle:Episode')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Episode entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('episode'));
    }

    /**
     * Creates a form to delete a Episode entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('episode_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
