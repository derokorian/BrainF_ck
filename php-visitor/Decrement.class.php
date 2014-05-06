<?php

class Decrement implements Operator
{
    public function accept(OperatorVisitor $oOp)
    {
        $oOp->visit($this);
    }

}