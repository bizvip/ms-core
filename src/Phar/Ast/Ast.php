<?php

declare(strict_types=1);


namespace Hyperf\Phar\Ast;

use PhpParser\NodeTraverser;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use PhpParser\PrettyPrinterAbstract;

class Ast
{
    private Parser $astParser;

    private PrettyPrinterAbstract $printer;

    public function __construct()
    {
        $parserFactory = new ParserFactory();
        $this->astParser = $parserFactory->create(ParserFactory::ONLY_PHP7);
        $this->printer = new Standard();
    }

    public function parse(string $code, array $visitors): string
    {
        $traverser = new NodeTraverser();
        foreach ($visitors as $visitor) {
            $traverser->addVisitor($visitor);
        }
        $stmts = $this->astParser->parse($code);
        $stmts = $traverser->traverse($stmts);
        return $this->printer->prettyPrintFile($stmts);
    }
}
