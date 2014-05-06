<?php

class BeginLoop implements Operator
{
    public function accept(OperatorVisitor $oOp)
    {
        $oOp->visit($this);
    }

}