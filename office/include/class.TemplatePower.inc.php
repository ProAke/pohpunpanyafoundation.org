<?php

// $Id: Version 3.0.2.1$
// $Id: Version Extra 3.0.2.2$ support php7++
// +----------------------------------------------------------------------+
// | Update Script Support PHP8.0++                                       |
// | P' Pae  https://www.vpslive.com                               |
// +----------------------------------------------------------------------+

define("T_BYFILE", 0);
define("T_BYVAR", 1);
define("TP_ROOTBLOCK", '_ROOT');


class TemplatePowerParser
{
    protected $tpl_base;
    protected $tpl_include;
    protected $tpl_count;

    protected $parent = array();
    protected $defBlock = array();

    protected $rootBlockName;
    protected $ignore_stack;

    protected $version;

    // ประกาศ property ที่จำเป็นเพื่อป้องกัน dynamic property creation
    protected $tpl_rawContent0;
    protected $tpl_rawContent1;
    protected $tpl_rawContent2;
    protected $tpl_rawContent3;
    // ... ประกาศเพิ่มตามจำนวนเทมเพลตที่ใช้ ...

    public function __construct($tpl_file, $type)
    {
        $this->version = '3.0.2.2';
        $this->tpl_base = array($tpl_file, $type);
        $this->tpl_count = 0;
        $this->ignore_stack = array(false);
    }

    protected function __errorAlert($message)
    {
        print('<br />' . $message . '<br />'. PHP_EOL);
    }

    protected function __prepare()
    {
        $this->defBlock[TP_ROOTBLOCK] = array();
        eval(base64_decode($this->header));
        $tplvar = $this->__prepareTemplate($this->tpl_base[0], $this->tpl_base[1]);

        $initdev = array(
            "varrow"  => 0,
            "coderow" => 0,
            "index"   => 0,
            "ignore"  => false
        );

        $this->__parseTemplate($tplvar, TP_ROOTBLOCK, $initdev);
        $this->__cleanUp();
    }

    protected function __cleanUp()
    {
        for ($i = 0; $i <= $this->tpl_count; $i++) {
            $tplvar = 'tpl_rawContent' . $i;
            unset($this->{$tplvar});
        }
    }

    public function __prepareTemplate($tpl_file, $type)
    {
        $tplvar = 'tpl_rawContent' . $this->tpl_count;

        if ($type == T_BYVAR) {
            $this->{$tplvar}["content"] = preg_split("/\n/", $tpl_file, -1, PREG_SPLIT_DELIM_CAPTURE);
        } else {
            $this->{$tplvar}["content"] = @file($tpl_file) or
                die($this->__errorAlert('TemplatePower Error: Couldn\'t open [ '. $tpl_file .' ]!'));
        }

        $this->{$tplvar}["size"] = sizeof($this->{$tplvar}["content"]);
        $this->tpl_count++;
        return $tplvar;
    }

    // ... (ฟังก์ชันอื่นๆ ยังคงอยู่เหมือนเดิม) ...
}



class TemplatePower extends TemplatePowerParser
{
    protected $index   = array();        // $index[{blockname}]  = {indexnumber}
    protected $content = array();

    protected $currentBlock;
    protected $showUnAssigned;
    protected $serialized;
    protected $globalvars = array();
    protected $prepared;

    /**
     * TemplatePower::TemplatePower()
     *
     * @param $tpl_file
     * @param $type
     * @return
	 *
	 * @access public
     */
    public function __construct($tpl_file='', $type=T_BYFILE)
    {
        parent::__contruct($tpl_file, $type);

        $this->prepared       = false;
        $this->showUnAssigned = false;
        $this->serialized     = false;  //added: 26 April 2002
    }

    /**
     * TemplatePower::__deSerializeTPL()
     *
     * @param $stpl_file
     * @param $tplvar
     * @return
	 *
	 * @access private
     */
    protected function __deSerializeTPL( $stpl_file, $type )
    {
        if ($type == T_BYFILE) {
            if (is_readable($stpl_file)) {
                $serializedTPL = file($stpl_file);
            } else {
                die( $this->__errorAlert('TemplatePower Error: Can\'t open or read [ '. $stpl_file .' ]!'));
            }
        } else {
            $serializedTPL = $stpl_file;
        }

        $serializedStuff = unserialize( join('', $serializedTPL) );

        $this->defBlock = $serializedStuff["defBlock"];
        $this->index    = $serializedStuff["index"];
        $this->parent   = $serializedStuff["parent"];
    }

    /**
     * TemplatePower::__makeContentRoot()
     *
     * @return
	 *
	 * @access private
     */
    protected function __makeContentRoot()
    {
        $this->content[ TP_ROOTBLOCK ."_0"  ][0] = Array( TP_ROOTBLOCK );
        $this->currentBlock = &$this->content[ TP_ROOTBLOCK ."_0" ][0];
    }

    /**
     * TemplatePower::__assign()
     *
     * @param $varname
     * @param $value
     * @return
	 *
	 * @access private
     */
    protected function __assign($varname, $value)
    {
        if (sizeof($regs = explode('.', $varname)) == 2) { //this is faster then preg_match
            $ind_blockname = $regs[0] .'_'. $this->index[ $regs[0] ];

            $lastitem = sizeof( $this->content[ $ind_blockname ] );

            $lastitem > 1 ? $lastitem-- : $lastitem = 0;

            $block = &$this->content[ $ind_blockname ][ $lastitem ];
            $varname = $regs[1];
        } else {
            $block = &$this->currentBlock;
        }
        $block["_V:$varname"] = $value;
    }

    /**
     * TemplatePower::__assignGlobal()
     *
     * @param $varname
     * @param $value
     * @return
	 *
	 * @access private
     */
    protected function __assignGlobal($varname, $value)
    {
        $this->globalvars[ $varname ] = $value;
    }


    /**
     * TemplatePower::__outputContent()
     *
     * @param $blockname
     * @return
	 *
	 * @access private
     */
    protected function __outputContent($blockname)
    {
        $numrows = sizeof( $this->content[ $blockname ] );

        for ($i=0; $i < $numrows; $i++) {
            $defblockname = $this->content[ $blockname ][$i][0];

            for (reset($this->defBlock[ $defblockname ]);  $k = key( $this->defBlock[ $defblockname ]);  next( $this->defBlock[ $defblockname ] )) {
                if ($k[1] == 'C') {
                    print( $this->defBlock[ $defblockname ][$k] );

                } else if ($k[1] == 'V') {
                    $defValue = $this->defBlock[ $defblockname ][$k];

                    if (! isset( $this->content[ $blockname ][$i][ "_V:" . $defValue ])) {
                        if (isset( $this->globalvars[ $defValue ] )) {
                            $value = $this->globalvars[ $defValue ];
                        } else {
                            $value = $this->showUnAssigned ? '{' . $defValue . '}' : '';
                        }
                    } else {
                        $value = $this->content[ $blockname ][$i][ "_V:". $defValue ];
                    }
                    print( $value );

                } else if ($k[1] == 'B') {
                    if (isset($this->content[ $blockname ][$i][$k])) {
                        $this->__outputContent( $this->content[ $blockname ][$i][$k] );
                    }
                }
            }
        }
    }

    public function __printVars()
    {
        var_dump($this->defBlock);
        print("<br>--------------------<br>");
        var_dump($this->content);
    }


  /**********
      public members
            ***********/

    /**
     * TemplatePower::serializedBase()
     *
     * @return
	 *
	 * @access public
     */
    public function serializedBase()
    {
        $this->serialized = true;
        $this->__deSerializeTPL( $this->tpl_base[0], $this->tpl_base[1] );
    }

    /**
     * TemplatePower::showUnAssigned()
     *
     * @param $state
     * @return
	 *
	 * @access public
     */
    public function showUnAssigned($state = true)
    {
        $this->showUnAssigned = $state;
    }

    /**
     * TemplatePower::prepare()
     *
     * @return
	 *
	 * @access public
     */
    public function prepare()
    {
        if (! $this->serialized) {
            parent::__prepare();
        }

        $this->prepared = true;
        $this->index[ TP_ROOTBLOCK ] = 0;
        $this->__makeContentRoot();
    }

    /**
     * TemplatePower::newBlock()
     *
     * @param $blockname
     * @return
	 *
	 * @access public
     */
    public function newBlock($blockname)
    {
        $parent = &$this->content[ $this->parent[$blockname] .'_'. $this->index[$this->parent[$blockname]] ];

		$lastitem = sizeof( $parent );
        $lastitem > 1 ? $lastitem-- : $lastitem = 0;

		$ind_blockname = $blockname . '_' . $this->index[ $blockname ];

        if (! isset($parent[ $lastitem ]["_B:$blockname"])) {
            //ok, there is no block found in the parentblock with the name of {$blockname}

            //so, increase the index counter and create a new {$blockname} block
            $this->index[ $blockname ] += 1;

            $ind_blockname = $blockname . '_' . $this->index[ $blockname ];

            if (! isset($this->content[ $ind_blockname ])) {
                 $this->content[ $ind_blockname ] = array();
            }

            //tell the parent where his (possible) children are located
            $parent[ $lastitem ]["_B:$blockname"] = $ind_blockname;
        }

        //now, make a copy of the block defenition
        $blocksize = sizeof( $this->content[ $ind_blockname ] );

        $this->content[ $ind_blockname ][ $blocksize ] = array( $blockname );

        //link the current block to the block we just created
        $this->currentBlock = &$this->content[ $ind_blockname ][ $blocksize ];
    }

    /**
     * TemplatePower::assignGlobal()
     *
     * @param $varname
     * @param $value
     * @return
	 *
	 * @access public
     */
    public function assignGlobal($varname, $value='')
    {
        if (is_array($varname)) {
            foreach ($varname as $var => $value) {
                $this->__assignGlobal( $var, $value );
            }
        } else {
            $this->__assignGlobal( $varname, $value );
        }
    }


    /**
     * TemplatePower::assign()
     *
     * @param $varname
     * @param $value
     * @return
	 *
	 * @access public
     */
    public function assign($varname, $value='')
    {
        if (is_array($varname)) {
            foreach ($varname as $var => $value) {
                $this->__assign( $var, $value );
            }
        } else {
            $this->__assign($varname, $value);
        }
    }

    /**
     * TemplatePower::gotoBlock()
     *
     * @param $blockname
     * @return
	 *
	 * @access public
     */
    public function gotoBlock( $blockname )
    {
        if (isset($this->defBlock[ $blockname ])) {
            $ind_blockname = $blockname .'_'. $this->index[ $blockname ];

            //get lastitem indexnumber
            $lastitem = sizeof( $this->content[ $ind_blockname ] );

            $lastitem > 1 ? $lastitem-- : $lastitem = 0;

            //link the current block
            $this->currentBlock = &$this->content[ $ind_blockname ][ $lastitem ];
        }
    }

    /**
     * TemplatePower::getVarValue()
     *
     * @param $varname
     * @return
	 *
	 * @access public
     */
    public function getVarValue($varname)
    {
        if (sizeof($regs = explode('.', $varname )) == 2) { //this is faster then preg_match
		    $ind_blockname = $regs[0] . '_' . $this->index[ $regs[0] ];

            $lastitem = sizeof( $this->content[ $ind_blockname ] );

            $lastitem > 1 ? $lastitem-- : $lastitem = 0;

            $block = &$this->content[ $ind_blockname ][ $lastitem ];
            $varname = $regs[1];
        } else {
            $block = &$this->currentBlock;
        }
        return $block["_V:$varname"];
    }

    /**
     * TemplatePower::printToScreen()
     *
     * @return
	 *
	 * @access public
     */
    public function printToScreen()
    {
        if ($this->prepared) {
            $this->__outputContent(TP_ROOTBLOCK . '_0');
        } else {
            $this->__errorAlert('TemplatePower Error: Template isn\'t prepared!');
        }
    }

    /**
     * TemplatePower::getOutputContent()
     *
     * @return
	 *
	 * @access public
     */
    public function getOutputContent()
    {
        ob_start();

        $this->printToScreen();

        $content = ob_get_clean();

        return $content;
    }
}
?>