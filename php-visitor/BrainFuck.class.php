<?php

class BrainFuck {
    public function __construct($strProgram) {
        $aOps = array_map([$this, 'mapOperator'],
            str_split(
                preg_replace(
                    '/[^[\]+<>,.-]/',
                    null,
                    $strProgram
                )
            )
        );
        $oVisitor = new BrainFuckVisitor($aOps);
    }


    private function mapOperator($el)
    {
        switch($el) {
            case '.':
                $el = new Output();
                break;
            case ',':
                $el = new Input();
                break;
            case '<':
                $el = new ShiftLeft();
                break;
            case '>':
                $el = new ShiftRight();
                break;
            case '-':
                $el = new Decrement();
                break;
            case '+':
                $el = new Increment();
                break;
            case '[':
                $el = new BeginLoop();
                break;
            case ']':
                $el = new EndLoop();
                break;
            default:
                throw new UnexpectedValueException("Unexpected operator character ($el)");
        }
        return $el;
    }
}