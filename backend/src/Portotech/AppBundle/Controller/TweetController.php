<?php

namespace Portotech\AppBundle\Controller;

use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Portotech\AppBundle\Entity\Tweet;
use Portotech\AppBundle\Form\TweetType;
use FOS\RestBundle\Controller\FOSRestController,
    FOS\RestBundle\View\View,
    FOS\RestBundle\View\ViewHandler,
    FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Util\Codes;

/**
 * Tweet controller.
 *
 * @Route("/tweet")
 */
class TweetController extends FOSRestController
{

    /**
     * Lists all Tweet entities.
     *
     * @ApiDoc(
     *     section = "02 - Tweet",
     *     statusCodes={
     *         200="Returned when successful",
     *     }
     * )
     * @Rest\Get("", name="tweet")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PortotechAppBundle:Tweet')->findAll();

        return $this->view($entities);
    }

    /**
     * Lists all Tweet entities by Visualization Id.
     *
     * @ApiDoc(
     *     section = "02 - Tweet",
     *     statusCodes={
     *         200="Returned when successful",
     *     }
     * )
     * @Rest\Get("/visualization/{id}", name="tweets_by_visualization")
     */
    public function tweetsByVisualizationAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PortotechAppBundle:Tweet')->findTweetsByVisualizationId($id);

        $view = $this->view($entities)->setSerializationContext(
            SerializationContext::create()->setGroups(array('Default'))
        );

        return $view;
    }

    /**
     * Creates a new Tweet entity.
     *
     * @ApiDoc(
     *     section = "02 - Tweet",
     *     statusCodes={
     *         200="Returned when successful",
     *     }
     * )
     * @Rest\Post("", name="tweet_create")
     */
    public function createAction(Request $request)
    {
        $entity = new Tweet();
        $form = $this->createCreateForm($entity);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->view(Codes::HTTP_CREATED);
        }

        return $this->view($form);
    }

    /**
     * Creates a form to create a Tweet entity.
     *
     * @param Tweet $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Tweet $entity)
    {
        $form = $this->createForm(new TweetType(), $entity);

        return $form;
    }

    /**
     * Finds and displays a Tweet entity.
     *
     * @ApiDoc(
     *     section = "02 - Tweet",
     *     statusCodes={
     *         200="Returned when successful",
     *     }
     * )
     * @Rest\Get("/{id}", name="tweet_show")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PortotechAppBundle:Tweet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tweet entity.');
        }

        return $this->view($entity);
    }

    /**
     * Edits an existing Tweet entity.
     *
     * @ApiDoc(
     *     section = "02 - Tweet",
     *     statusCodes={
     *         200="Returned when successful",
     *     }
     * )
     * @Rest\Put("/{id}", name="tweet_update")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PortotechAppBundle:Tweet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tweet entity.');
        }

        $editForm = $this->createCreateForm($entity);
        $editForm->submit($request->request->all());

        if ($editForm->isValid()) {
            $em->flush();

            return $this->view(Codes::HTTP_NO_CONTENT);
        }

        return $this->view($editForm);
    }

    /**
     * Deletes a Tweet entity.
     *
     * @ApiDoc(
     *     section = "02 - Tweet",
     *     statusCodes={
     *         200="Returned when successful",
     *     }
     * )
     * @Rest\Delete("/{id}", name="tweet_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createCreateForm($id);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PortotechAppBundle:Tweet')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tweet entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->view(Codes::HTTP_NO_CONTENT);
    }

}
