<?php

interface Operator
{
    public function accept(OperatorVisitor $oOp);
}