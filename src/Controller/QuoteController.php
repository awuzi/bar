<?php

namespace App\Controller;

use App\Entity\Quote;

use App\Form\QuoteType;
use App\Repository\QuoteRepository;
use App\Services\QuoteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends AbstractController
{

    /**
     * @Route("/quotes", name="quotes")
     * @param QuoteService $quote
     * @return Response
     */
    public function quote(QuoteService $quote): Response
    {
        return $this->render('quote/index.html.twig', [
            'title' => 'Quote Service',
            'quotes' => $quote->getQuotes(),
        ]);
    }

    /**
     * @Route("/new-quote", name="quote_new", methods={"GET","POST"})
     * @Route("/edit-quote/{id}", name="quote_edit", methods={"GET","POST"})
     * @param ?int $id
     * @param Request $request
     * @param QuoteRepository $qr
     * @return Response
     */
    public function new(int $id, Request $request, QuoteRepository $qr): Response
    {
        $quote = $qr->findOneBy(['id' => $id]);

        if (!$quote) {
            if ($request->attributes->get('_route') !== 'quote-edit') {
                throw new NotFoundHttpException('id not exists');
            }
            $quote = new Quote();
        }

        $form = $this->createForm(QuoteType::class, $quote);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quote);
            $entityManager->flush();

            $this->addFlash('success', 'Done !');

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

    /**
     * @Route("/delete/{id}", name="quote_delete")
     * @param int $id
     * @param QuoteRepository $qr
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteQuote(int $id, QuoteRepository $qr, Request $request): RedirectResponse
    {
        $quote = $qr->findOneBy(['id' => $id]);

        if ($this->isCsrfTokenValid('delete'.$quote->getId(), $request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quote);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quotes');
    }
}
