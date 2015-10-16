<?php

namespace Jr\Bundle\ExempleAppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Jr\Bundle\ExempleAppBundle\Entity\Exemple;
use Jr\Bundle\ExempleAppBundle\Form\ExempleType;

/**
 * Exemple controller.
 *
 * @Route("/exemple")
 */
class ExempleController extends Controller
{

    /**
     * Lists all Exemple entities.
     *
     * @Route("/", name="exemple", options={"expose"= true})
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $exemples= $em->getRepository('JrExempleAppBundle:Exemple')->findAll();

        return array(
            'exemples' => $exemples
        );
    }

    /**
     * Creates a new Exemple entity.
     *
     * @Route("/", name="exemple_create")
     * @Method("POST")
     * @Template("JrExempleAppBundle:Exemple:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Exemple();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('exemple_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Exemple entity.
     *
     * @param Exemple $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Exemple $entity)
    {
        $form = $this->createForm(new ExempleType(), $entity, array(
            'action' => $this->generateUrl('exemple_create'),
            'method' => 'POST',
            ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Exemple entity.
     *
     * @Route("/new", name="exemple_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Exemple();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Exemple entity.
     *
     * @Route("/{id}", requirements={"companyId" = "\d+"}, name="exemple_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $exemple = $em->getRepository('JrExempleAppBundle:Exemple')->find($id);

        if (!$exemple) {
            throw $this->createNotFoundException('Unable to find Exemple entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'exemple' => $exemple,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Exemple entity.
     *
     * @Route("/{id}/edit", name="exemple_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JrExempleAppBundle:Exemple')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Exemple entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Exemple entity.
     *
     * @param Exemple $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Exemple $entity)
    {
        $form = $this->createForm(new ExempleType(), $entity, array(
            'action' => $this->generateUrl('exemple_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Exemple entity.
     *
     * @Route("/{id}", name="exemple_update")
     * @Method("PUT")
     * @Template("JrExempleAppBundle:Exemple:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JrExempleAppBundle:Exemple')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Exemple entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('exemple_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Exemple entity.
     *
     * @Route("/{id}", name="exemple_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JrExempleAppBundle:Exemple')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Exemple entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('exemple'));
    }

    /**
     * Creates a form to delete a Exemple entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
                ->setAction($this->generateUrl('exemple_delete', array('id' => $id)))
                ->setMethod('DELETE')
                ->add('submit', 'submit', array('label' => 'Delete'))
                ->getForm()
        ;
    }

}
