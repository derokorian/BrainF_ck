<?php

class Increment implements Operator
{
    public function accept(OperatorVisitor $oOp)
    {
        $oOp->visit($this);
    }

}