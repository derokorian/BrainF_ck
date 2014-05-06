<?php

class BrainFuck extends OperatorVisitor
{
    /**
     * @var Operator[] $aOps
     */
    private $aOps = [];

    /**
     * @var int[]
     */
    private $aMem = [];

    /**
     * @var int[]
     */
    private $aLoops = [];

    /**
     * @var int
     */
    private $iMemKey = 0;

    /**
     * @var int
     */
    private $iLoopKey = 0;

    /**
     * @var int
     */
    private $iOpKey = 0;

    /**
     * @var int
     */
    private $iCur;

    function __construct($strProgram)
    {
        $this->aOps = str_split(
            preg_replace(
                '/[^[\]+<>,.-]/',
                null,
                $strProgram
            )
        );
        $this->iCur =& $this->aMem[$this->iMemKey];

        $iLength = count($this->aOps);
        for( $this->iOpKey = 0; $this->iOpKey < $iLength; $this->iOpKey++ )
        {
            $this->mapOperator($this->aOps[$this->iOpKey]);
            $this->aOps[$this->iOpKey]->accept($this);
        }
    }

    private function mapOperator(&$el)
    {
        if( !$el instanceof Operator )
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
        }
    }

    public function visitShiftLeft(ShiftLeft $oShiftLeft)
    {
        $this->iMemKey++;
        $this->iCur =& $this->aMem[$this->iMemKey];
    }

    public function visitShiftRight(ShiftRight $oShiftRight)
    {
        $this->iMemKey--;
        $this->iCur =& $this->aMem[$this->iMemKey];
    }

    public function visitIncrement(Increment $oIncrement)
    {
        $this->iCur++;
    }

    public function visitDecrement(Decrement $oDecrement)
    {
        $this->iCur--;
    }

    public function visitInput(Input $oInput)
    {
        $f = fopen("php://stdin", "r");
        $this->iCur = ord(fread($f, 1));
        fclose($f);
    }

    public function visitOutput(Output $oOutput)
    {
        print chr($this->iCur);
    }

    public function visitBeginLoop(BeginLoop $oBeginLoop)
    {
        $this->aLoops[$this->iLoopKey++] = $this->iOpKey;
    }

    public function visitEndLoop(EndLoop $oEndLoop)
    {
        if( $this->iCur === 0 )
        {
            $this->iLoopKey--;
        }
        else
        {
            $this->iOpKey = $this->aLoops[$this->iLoopKey - 1];
        }
    }

}