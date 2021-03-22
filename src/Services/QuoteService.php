<?php


namespace App\Services;


use App\Repository\QuoteRepository;
use cebe\markdown\Markdown;

class QuoteService
{

    private $parser;
    private $quoteRepository;

    public function __construct(
        QuoteRepository $quoteRepository,
        Markdown $parser
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->parser = $parser;
    }

    public function getQuotes(): array
    {
        $quotes = $this->quoteRepository->findAll();

        $parsedQuotes = [];

        foreach ($quotes as $quote) {
            $parsedQuotes[] = [
                'title' => $quote->getTitle(),
                'content' => $this->parser->parse($quote->getContent()),
            ];
        }

        return $parsedQuotes;
    }

}

