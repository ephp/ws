<?php

namespace Ephp\WsBundle\Controller\Config;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ephp\WsBundle\Entity\Config\Service;
use Ephp\WsBundle\Form\Config\ServiceType;

/**
 * Config\Service controller.
 *
 * @Route("/service")
 */
class ServiceController extends Controller
{
    /**
     * Lists all Config\Service entities.
     *
     * @Route("/", name="admin_service")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('EphpWsBundle:Config\Service')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Config\Service entity.
     *
     * @Route("/{id}/show", name="admin_service_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EphpWsBundle:Config\Service')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Config\Service entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Config\Service entity.
     *
     * @Route("/new", name="admin_service_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Service();
        $form   = $this->createForm(new ServiceType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Config\Service entity.
     *
     * @Route("/create", name="admin_service_create")
     * @Method("post")
     * @Template("EphpWsBundle:Config\Service:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Service();
        $request = $this->getRequest();
        $form    = $this->createForm(new ServiceType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_service'));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Config\Service entity.
     *
     * @Route("/{id}/edit", name="admin_service_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EphpWsBundle:Config\Service')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Config\Service entity.');
        }

        $editForm = $this->createForm(new ServiceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Config\Service entity.
     *
     * @Route("/{id}/update", name="admin_service_update")
     * @Method("post")
     * @Template("EphpWsBundle:Config\Service:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EphpWsBundle:Config\Service')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Config\Service entity.');
        }

        $editForm   = $this->createForm(new ServiceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_service'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Config\Service entity.
     *
     * @Route("/{id}/delete", name="admin_service_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('EphpWsBundle:Config\Service')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Config\Service entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_service'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
