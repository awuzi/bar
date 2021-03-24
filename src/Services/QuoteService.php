<?php


namespace App\Services;


use App\Repository\QuoteRepository;
use cebe\markdown\Markdown;

class QuoteService
{

    private Markdown $parser;
    private QuoteRepository $quoteRepository;

    public function __construct(
        QuoteRepository $quoteRepository,
        Markdown $parser
    ) {
        $this->parser = $parser;
        $this->quoteRepository = $quoteRepository;
        $this->parser = $parser;
    }

    public function getQuotes(): array
    {
        $quotes = [
            ...$this->quoteRepository->findBy(['position' => 'important']),
            ...$this->quoteRepository->findBy(['position' => 'none']),
        ];

        $parsedQuotes = [];

        foreach ($quotes as $quote) {
            $parsedQuotes[] = [
                'id' => $quote->getId(),
                'title' => $quote->getTitle(),
                'content' => $this->parser->parse($quote->getContent()),
                'position' => $quote->getPosition(),
                'created_at' => $quote->getCreatedAt(),
            ];
        }

        return $parsedQuotes;
    }

}

