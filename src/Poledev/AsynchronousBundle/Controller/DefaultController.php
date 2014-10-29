<?php

namespace Poledev\AsynchronousBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/send-mail", name="poledev_asynchronous_download")
     */
    public function downloadAction()
    {
        $mailer = $this->container->get('poledev.mailer');

        $mailer->sendEmail('mkhalil.sarah@gmail.com', 'Subject Of my email', 'my-email', 'PoledevAsynchronousBundle:Mail:example.html.twig');

        return $this->render('PoledevAsynchronousBundle:Default:index.html.twig');
    }
}
