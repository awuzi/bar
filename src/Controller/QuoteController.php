<?php

namespace App\Controller;

use App\Entity\Quote;

use App\Form\QuoteType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends AbstractController
{

    /**
     * @Route("/new", name="quote_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $quote = new Quote();
        $form = $this->createForm(QuoteType::class, $quote);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quote);
            $entityManager->flush();

            return $this->redirectToRoute('quotes');
        }

        return $this->render('quote/new.html.twig', [
            'quote_form' => $form->createView(),
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quote::class,
        ]);
    }
}
