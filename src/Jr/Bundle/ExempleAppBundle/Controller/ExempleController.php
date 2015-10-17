<?php

namespace Jr\Bundle\ExempleAppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $exemples = $em->getRepository('JrExempleAppBundle:Exemple')->findAll();
        // Form Exemple
        $form = $this->createCreateForm(new Exemple());

        return array(
            'exemples' => $exemples,
            'form' => $form->createView()
        );
    }

    /**
     * Creates a new Exemple entity.
     *
     * @Route("/", name="exemple_create" , options={"expose"= true})
     * @Method("POST")
     * @Template("JrExempleAppBundle:Exemple:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $exemple = new Exemple();
        $form = $this->createCreateForm($exemple);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($exemple);
            $em->flush();
        }
        $errors = iterator_to_array($form->getErrors());

        if (!$request->isXmlHttpRequest())
            if ($errors != null)
                return ['exemple' => $exemple, 'form' => $form->createView()];
            else
                return $this->redirect($this->generateUrl('exemple_show', array('id' => $exemple->getId())));
        else
            return $this->getResponseContent();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    private function getResponseContent()
    {
        $em = $this->getDoctrine()->getManager();
        $exemples = $em->getRepository('JrExempleAppBundle:Exemple')->findAll();
        $params = ['exemples' => $exemples];
        $list = $this->renderView('JrExempleAppBundle:Exemple:list.html.twig', $params);
        //From Exemple 
        $form = $this->createCreateForm(new Exemple());
        $paramsForm = ['form' => $form->createView()];
        $newExemple = $this->renderView('JrExempleAppBundle:Exemple:newAjax.html.twig', $paramsForm);
        $content = ['list' => $list, 'newExemple' => $newExemple];

        return new JsonResponse(['content' => $content]);
    }

    /**
     * Creates a form to create a Exemple entity.
     *
     * @param Exemple $exemple The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Exemple $exemple)
    {
        $form = $this->createForm(new ExempleType(), $exemple, array(
            'action' => $this->generateUrl('exemple_create'),
            'method' => 'POST',
            ));


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
        $exemple = new Exemple();
        $form = $this->createCreateForm($exemple);

        return array(
            'exemple' => $exemple,
            'form' => $form->createView()
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

        return array(
            'exemple' => $exemple
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

        $exemple = $em->getRepository('JrExempleAppBundle:Exemple')->find($id);

        if (!$exemple) {
            throw $this->createNotFoundException('Unable to find Exemple entity.');
        }

        $editForm = $this->createEditForm($exemple);

        return array(
            'exemple' => $exemple,
            'edit_form' => $editForm->createView()
        );
    }

    /**
     * Creates a form to edit a Exemple entity.
     *
     * @param Exemple $exemple The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Exemple $exemple)
    {
        $form = $this->createForm(new ExempleType(), $exemple, array(
            'action' => $this->generateUrl('exemple_update', array('id' => $exemple->getId())),
            'method' => 'POST',
            ));

        return $form;
    }

    /**
     * Edits an existing Exemple entity.
     *
     * @Route("/{id}", name="exemple_update")
     * @Method("POST")
     * @Template("JrExempleAppBundle:Exemple:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $exemple = $em->getRepository('JrExempleAppBundle:Exemple')->find($id);

        if (!$exemple) {
            throw $this->createNotFoundException('Unable to find Exemple entity.');
        }

        $editForm = $this->createEditForm($exemple);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('exemple_edit', array('id' => $id)));
        }

        return array(
            'exemple' => $exemple,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Exemple entity.
     *
     * @Route("/{id}/delete", name="exemple_delete", options={"expose"= true})
     * @Method("POST")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $exemple = $em->getRepository('JrExempleAppBundle:Exemple')->find($id);

        if (!$exemple) {
            throw $this->createNotFoundException('Unable to find Exemple entity.');
        }

        $em->remove($exemple);
        $em->flush();

        $exemples = $em->getRepository('JrExempleAppBundle:Exemple')->findAll();
        $params = ['exemples' => $exemples];
        $content = $this->renderView('JrExempleAppBundle:Exemple:list.html.twig', $params);

        return new JsonResponse(['content' => $content]);
    }

}
