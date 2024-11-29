<?php

namespace XF\Template\Compiler;
use XF\Template\Compiler\Syntax;

use function array_key_exists, count, in_array, is_array, is_resource;

/* Driver template for the PHP_Parser_rGenerator parser generator. (PHP port of LEMON)
*/

/**
 * This can be used to store both the string representation of
 * a token, and any useful meta-data associated with the token.
 *
 * meta-data should be stored as an array
 */
class Parser_yyToken implements \ArrayAccess
{
    public $string = '';
    public $metadata = array();

    function __construct($s, $m = array())
    {
        if ($s instanceof Parser_yyToken) {
            $this->string = $s->string;
            $this->metadata = $s->metadata;
        } else {
            $this->string = (string) $s;
            if ($m instanceof Parser_yyToken) {
                $this->metadata = $m->metadata;
            } elseif (is_array($m)) {
                $this->metadata = $m;
            }
        }
    }

    function __toString()
    {
        return $this->string;
    }

	#[\ReturnTypeWillChange]
    function offsetExists($offset)
    {
        return isset($this->metadata[$offset]);
    }

	#[\ReturnTypeWillChange]
    function offsetGet($offset)
    {
        return $this->metadata[$offset];
    }

	#[\ReturnTypeWillChange]
    function offsetSet($offset, $value)
    {
        if ($offset === null) {
            if (isset($value[0])) {
                $x = ($value instanceof Parser_yyToken) ?
                    $value->metadata : $value;
                $this->metadata = array_merge($this->metadata, $x);
                return;
            }
            $offset = count($this->metadata);
        }
        if ($value === null) {
            return;
        }
        if ($value instanceof Parser_yyToken) {
            if ($value->metadata) {
                $this->metadata[$offset] = $value->metadata;
            }
        } elseif ($value) {
            $this->metadata[$offset] = $value;
        }
    }

	#[\ReturnTypeWillChange]
    function offsetUnset($offset)
    {
        unset($this->metadata[$offset]);
    }
}

/** The following structure represents a single element of the
 * parser's stack.  Information stored includes:
 *
 *   +  The state number for the parser at this level of the stack.
 *
 *   +  The value of the token stored at this level of the stack.
 *      (In other words, the "major" token.)
 *
 *   +  The semantic value stored at this level of the stack.  This is
 *      the information used by the action routines in the grammar.
 *      It is sometimes called the "minor" token.
 */
class Parser_yyStackEntry
{
    public $stateno;       /* The state-number */
    public $major;         /* The major token value.  This is the code
                     ** number for the token at this stack level */
    public $minor; /* The user-supplied minor token value.  This
                     ** is the value of the token  */
};

// code external to the class is included here
#line  "Parser.y"
#line 100 "Parser.php"

// declare_class is output here
#line 2 "Parser.y"
class Parser #line 105 "Parser.php"
{
/* First off, code is included which follows the "include_class" declaration
** in the input file. */
#line 9 "Parser.y"

	public $line = 1;

	/**
	 * @var Ast|null
	 */
	public $ast;

	public $placeholders = [];
#line 120 "Parser.php"

/* Next is all token values, as class constants
*/
/* 
** These constants (all generated automatically by the parser generator)
** specify the various kinds of tokens (terminals) that the parser
** understands. 
**
** Each symbol here is a terminal symbol in the grammar.
*/
    const T_OP_OR                          =  1;
    const T_OP_AND                         =  2;
    const T_OP_TERNARY_IF                  =  3;
    const T_OP_TERNARY_ELSE                =  4;
    const T_OP_TERNARY_SHORT               =  5;
    const T_OP_EQ                          =  6;
    const T_OP_NE                          =  7;
    const T_OP_ID                          =  8;
    const T_OP_NID                         =  9;
    const T_OP_GT                          = 10;
    const T_OP_GTEQ                        = 11;
    const T_OP_LT                          = 12;
    const T_OP_LTEQ                        = 13;
    const T_OP_IS                          = 14;
    const T_OP_IS_NOT                      = 15;
    const T_OP_MINUS                       = 16;
    const T_OP_PLUS                        = 17;
    const T_OP_CONCAT                      = 18;
    const T_OP_MULTIPLY                    = 19;
    const T_OP_DIVIDE                      = 20;
    const T_OP_MOD                         = 21;
    const T_OP_U_MINUS                     = 22;
    const T_OP_BANG                        = 23;
    const T_OP_INSTANCEOF                  = 24;
    const T_PLAIN                          = 25;
    const T_VAR_START                      = 26;
    const T_LITERAL                        = 27;
    const T_VAR_END                        = 28;
    const T_VAR_DIM                        = 29;
    const T_VAR_OBJECT                     = 30;
    const T_EXPR_START                     = 31;
    const T_EXPR_END                       = 32;
    const T_TAG_OPEN_START                 = 33;
    const T_TAG_END_CLOSE                  = 34;
    const T_TAG_END                        = 35;
    const T_TAG_CLOSE_START                = 36;
    const T_TAG_ATTRIBUTE_START            = 37;
    const T_BOOLEAN                        = 38;
    const T_NULL                           = 39;
    const T_NUMBER                         = 40;
    const T_STRING                         = 41;
    const T_PAREN_START                    = 42;
    const T_PAREN_END                      = 43;
    const T_PLACEHOLDER                    = 44;
    const T_FILTER                         = 45;
    const T_ARG_SEP                        = 46;
    const T_ARRAY_START                    = 47;
    const T_ARRAY_END                      = 48;
    const T_HASH_START                     = 49;
    const T_HASH_END                       = 50;
    const T_HASH_SEP                       = 51;
    const T_DOUBLE_QUOTE                   = 52;
    const YY_NO_ACTION = 162;
    const YY_ACCEPT_ACTION = 161;
    const YY_ERROR_ACTION = 160;

/* Next are that tables used to determine what action to take based on the
** current state and lookahead token.  These tables are used to implement
** functions that take a state number and lookahead value and return an
** action integer.  
**
** Suppose the action integer is N.  Then the action is determined as
** follows
**
**   0 <= N < self::YYNSTATE                              Shift N.  That is,
**                                                        push the lookahead
**                                                        token onto the stack
**                                                        and goto state N.
**
**   self::YYNSTATE <= N < self::YYNSTATE+self::YYNRULE   Reduce by rule N-YYNSTATE.
**
**   N == self::YYNSTATE+self::YYNRULE                    A syntax error has occurred.
**
**   N == self::YYNSTATE+self::YYNRULE+1                  The parser accepts its
**                                                        input. (and concludes parsing)
**
**   N == self::YYNSTATE+self::YYNRULE+2                  No such action.  Denotes unused
**                                                        slots in the yy_action[] table.
**
** The action table is constructed as a single large static array $yy_action.
** Given state S and lookahead X, the action is computed as
**
**      self::$yy_action[self::$yy_shift_ofst[S] + X ]
**
** If the index value self::$yy_shift_ofst[S]+X is out of range or if the value
** self::$yy_lookahead[self::$yy_shift_ofst[S]+X] is not equal to X or if
** self::$yy_shift_ofst[S] is equal to self::YY_SHIFT_USE_DFLT, it means that
** the action is not in the table and that self::$yy_default[S] should be used instead.  
**
** The formula above is for computing the action when the lookahead is
** a terminal symbol.  If the lookahead is a non-terminal (as occurs after
** a reduce action) then the static $yy_reduce_ofst array is used in place of
** the static $yy_shift_ofst array and self::YY_REDUCE_USE_DFLT is used in place of
** self::YY_SHIFT_USE_DFLT.
**
** The following are the tables generated in this section:
**
**  self::$yy_action        A single table containing all actions.
**  self::$yy_lookahead     A table containing the lookahead for each entry in
**                          yy_action.  Used to detect hash collisions.
**  self::$yy_shift_ofst    For each state, the offset into self::$yy_action for
**                          shifting terminals.
**  self::$yy_reduce_ofst   For each state, the offset into self::$yy_action for
**                          shifting non-terminals after a reduce.
**  self::$yy_default       Default action for each state.
*/
    const YY_SZ_ACTTAB = 370;
static public $yy_action = array(
 /*     0 */     6,    6,   10,   13,    9,    7,    7,    7,    7,    7,
 /*    10 */     7,    7,    7,   53,   54,    8,    8,    8,    8,    8,
 /*    20 */     8,  161,   18,    6,    4,    6,    6,   10,   88,    9,
 /*    30 */     7,    7,    7,    7,    7,    7,    7,    7,   53,   54,
 /*    40 */     8,    8,    8,    8,    8,    8,   73,   15,    6,   91,
 /*    50 */    13,   86,   87,   73,   34,    2,   74,   30,   76,   77,
 /*    60 */    47,   48,   90,   74,   78,   76,   77,   75,   72,    6,
 /*    70 */     6,   10,   11,    9,    7,    7,    7,    7,    7,    7,
 /*    80 */     7,    7,   53,   54,    8,    8,    8,    8,    8,    8,
 /*    90 */    80,   67,    6,   94,    6,    6,   10,   31,    9,    7,
 /*   100 */     7,    7,    7,    7,    7,    7,    7,   53,   54,    8,
 /*   110 */     8,    8,    8,    8,    8,   80,   79,    6,    8,    8,
 /*   120 */     8,    8,    8,    8,  100,   83,    6,    6,    6,   10,
 /*   130 */    25,    9,    7,    7,    7,    7,    7,    7,    7,    7,
 /*   140 */    53,   54,    8,    8,    8,    8,    8,    8,    6,   10,
 /*   150 */     6,    9,    7,    7,    7,    7,    7,    7,    7,    7,
 /*   160 */    53,   54,    8,    8,    8,    8,    8,    8,   80,   81,
 /*   170 */     6,    7,    7,    7,    7,    7,    7,    7,    7,   53,
 /*   180 */    54,    8,    8,    8,    8,    8,    8,   16,   56,    6,
 /*   190 */    66,   73,   80,   97,   12,   95,   96,   51,   26,   38,
 /*   200 */    93,   74,   30,   76,   77,   50,   16,   52,   46,   68,
 /*   210 */    69,   70,   71,    5,   73,   82,   51,   26,    3,   17,
 /*   220 */     1,   20,   35,   31,   74,   30,   76,   77,   68,   69,
 /*   230 */    70,   71,    5,   73,   63,   64,   65,    3,   29,    1,
 /*   240 */    73,   38,   31,   74,   30,   76,   77,   49,   34,   21,
 /*   250 */    74,   30,   76,   77,   73,    6,   89,   22,   51,   27,
 /*   260 */    73,   52,   41,   14,   74,   30,   76,   77,   44,   73,
 /*   270 */    74,   30,   76,   77,   23,   73,   99,   45,   24,   74,
 /*   280 */    30,   76,   77,   42,   73,   74,   30,   76,   77,   32,
 /*   290 */    73,   60,   36,   28,   74,   30,   76,   77,   43,   73,
 /*   300 */    74,   30,   76,   77,  135,   73,  135,   55,  135,   74,
 /*   310 */    30,   76,   77,   39,  135,   74,   30,   76,   77,   73,
 /*   320 */    62,   51,   19,   57,  135,   73,   14,   37,   58,   74,
 /*   330 */    30,   76,   77,   40,  135,   74,   30,   76,   77,   62,
 /*   340 */    51,   92,  135,   51,   15,   14,  135,   58,   14,  135,
 /*   350 */    59,    8,    8,    8,   61,  135,    6,  135,   85,  135,
 /*   360 */   135,   98,   33,  135,  135,  135,  135,  135,  135,   84,
    );
    static public $yy_lookahead = array(
 /*     0 */     1,    2,    3,    4,    5,    6,    7,    8,    9,   10,
 /*    10 */    11,   12,   13,   14,   15,   16,   17,   18,   19,   20,
 /*    20 */    21,   54,   55,   24,   46,    1,    2,    3,   50,    5,
 /*    30 */     6,    7,    8,    9,   10,   11,   12,   13,   14,   15,
 /*    40 */    16,   17,   18,   19,   20,   21,   56,   46,   24,   48,
 /*    50 */    51,   56,   57,   56,   64,   42,   66,   67,   68,   69,
 /*    60 */    60,   71,   72,   66,   67,   68,   69,   43,   62,    1,
 /*    70 */     2,    3,    4,    5,    6,    7,    8,    9,   10,   11,
 /*    80 */    12,   13,   14,   15,   16,   17,   18,   19,   20,   21,
 /*    90 */    62,   63,   24,   62,    1,    2,    3,   52,    5,    6,
 /*   100 */     7,    8,    9,   10,   11,   12,   13,   14,   15,   16,
 /*   110 */    17,   18,   19,   20,   21,   62,   63,   24,   16,   17,
 /*   120 */    18,   19,   20,   21,   66,   32,   24,    1,    2,    3,
 /*   130 */    59,    5,    6,    7,    8,    9,   10,   11,   12,   13,
 /*   140 */    14,   15,   16,   17,   18,   19,   20,   21,    2,    3,
 /*   150 */    24,    5,    6,    7,    8,    9,   10,   11,   12,   13,
 /*   160 */    14,   15,   16,   17,   18,   19,   20,   21,   62,   63,
 /*   170 */    24,    6,    7,    8,    9,   10,   11,   12,   13,   14,
 /*   180 */    15,   16,   17,   18,   19,   20,   21,   16,   60,   24,
 /*   190 */    28,   56,   62,   63,   23,   56,   57,   26,   27,   64,
 /*   200 */    61,   66,   67,   68,   69,   70,   16,   45,   65,   38,
 /*   210 */    39,   40,   41,   42,   56,   44,   26,   27,   47,   55,
 /*   220 */    49,   73,   64,   52,   66,   67,   68,   69,   38,   39,
 /*   230 */    40,   41,   42,   56,   56,   57,   58,   47,   27,   49,
 /*   240 */    56,   64,   52,   66,   67,   68,   69,   70,   64,   27,
 /*   250 */    66,   67,   68,   69,   56,   24,   72,   27,   26,   27,
 /*   260 */    56,   45,   64,   31,   66,   67,   68,   69,   64,   56,
 /*   270 */    66,   67,   68,   69,   27,   56,   35,   64,   27,   66,
 /*   280 */    67,   68,   69,   64,   56,   66,   67,   68,   69,   27,
 /*   290 */    56,   27,   64,   37,   66,   67,   68,   69,   64,   56,
 /*   300 */    66,   67,   68,   69,   74,   56,   74,   64,   74,   66,
 /*   310 */    67,   68,   69,   64,   74,   66,   67,   68,   69,   56,
 /*   320 */    25,   26,   29,   30,   74,   56,   31,   64,   33,   66,
 /*   330 */    67,   68,   69,   64,   74,   66,   67,   68,   69,   25,
 /*   340 */    26,   43,   74,   26,   46,   31,   74,   33,   31,   74,
 /*   350 */    36,   19,   20,   21,   27,   74,   24,   74,   41,   74,
 /*   360 */    74,   34,   35,   74,   74,   74,   74,   74,   74,   52,
);
    const YY_SHIFT_USE_DFLT = -23;
    const YY_SHIFT_MAX = 61;
    static public $yy_shift_ofst = array(
 /*     0 */   -23,  171,  171,  171,  171,  171,  171,  171,  171,  171,
 /*    10 */   171,  171,  171,  171,  171,  171,  190,  314,  295,  232,
 /*    20 */   317,   13,   13,   13,   13,  293,   13,   13,   45,  -23,
 /*    30 */   -23,  -23,  -23,  -23,   -1,   24,   68,   93,  126,  126,
 /*    40 */   126,  146,  165,  165,  102,  332,  327,  162,  -22,    1,
 /*    50 */   298,  211,  222,  230,  247,  231,  216,  251,  262,  264,
 /*    60 */   241,  256,
);
    const YY_REDUCE_USE_DFLT = -34;
    const YY_REDUCE_MAX = 33;
    static public $yy_reduce_ofst = array(
 /*     0 */   -33,  -10,  135,  177,  184,  158,  198,  204,  213,  219,
 /*    10 */   228,  234,  243,  249,  263,  269,   -3,  178,  178,  139,
 /*    20 */    -5,   28,   53,  106,  130,    0,    6,   31,   58,   71,
 /*    30 */   128,  148,  143,  164,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(16, 23, 26, 27, 38, 39, 40, 41, 42, 44, 47, 49, 52, ),
        /* 2 */ array(16, 23, 26, 27, 38, 39, 40, 41, 42, 44, 47, 49, 52, ),
        /* 3 */ array(16, 23, 26, 27, 38, 39, 40, 41, 42, 44, 47, 49, 52, ),
        /* 4 */ array(16, 23, 26, 27, 38, 39, 40, 41, 42, 44, 47, 49, 52, ),
        /* 5 */ array(16, 23, 26, 27, 38, 39, 40, 41, 42, 44, 47, 49, 52, ),
        /* 6 */ array(16, 23, 26, 27, 38, 39, 40, 41, 42, 44, 47, 49, 52, ),
        /* 7 */ array(16, 23, 26, 27, 38, 39, 40, 41, 42, 44, 47, 49, 52, ),
        /* 8 */ array(16, 23, 26, 27, 38, 39, 40, 41, 42, 44, 47, 49, 52, ),
        /* 9 */ array(16, 23, 26, 27, 38, 39, 40, 41, 42, 44, 47, 49, 52, ),
        /* 10 */ array(16, 23, 26, 27, 38, 39, 40, 41, 42, 44, 47, 49, 52, ),
        /* 11 */ array(16, 23, 26, 27, 38, 39, 40, 41, 42, 44, 47, 49, 52, ),
        /* 12 */ array(16, 23, 26, 27, 38, 39, 40, 41, 42, 44, 47, 49, 52, ),
        /* 13 */ array(16, 23, 26, 27, 38, 39, 40, 41, 42, 44, 47, 49, 52, ),
        /* 14 */ array(16, 23, 26, 27, 38, 39, 40, 41, 42, 44, 47, 49, 52, ),
        /* 15 */ array(16, 23, 26, 27, 38, 39, 40, 41, 42, 44, 47, 49, 52, ),
        /* 16 */ array(16, 26, 27, 38, 39, 40, 41, 42, 47, 49, 52, ),
        /* 17 */ array(25, 26, 31, 33, 36, ),
        /* 18 */ array(25, 26, 31, 33, ),
        /* 19 */ array(26, 27, 31, ),
        /* 20 */ array(26, 31, 41, 52, ),
        /* 21 */ array(42, ),
        /* 22 */ array(42, ),
        /* 23 */ array(42, ),
        /* 24 */ array(42, ),
        /* 25 */ array(29, 30, ),
        /* 26 */ array(42, ),
        /* 27 */ array(42, ),
        /* 28 */ array(52, ),
        /* 29 */ array(),
        /* 30 */ array(),
        /* 31 */ array(),
        /* 32 */ array(),
        /* 33 */ array(),
        /* 34 */ array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 24, 51, ),
        /* 35 */ array(1, 2, 3, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 24, 43, ),
        /* 36 */ array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 24, ),
        /* 37 */ array(1, 2, 3, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 24, 32, ),
        /* 38 */ array(1, 2, 3, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 24, ),
        /* 39 */ array(1, 2, 3, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 24, ),
        /* 40 */ array(1, 2, 3, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 24, ),
        /* 41 */ array(2, 3, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 24, ),
        /* 42 */ array(6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 24, ),
        /* 43 */ array(6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 24, ),
        /* 44 */ array(16, 17, 18, 19, 20, 21, 24, ),
        /* 45 */ array(19, 20, 21, 24, ),
        /* 46 */ array(27, 34, 35, ),
        /* 47 */ array(28, 45, ),
        /* 48 */ array(46, 50, ),
        /* 49 */ array(46, 48, ),
        /* 50 */ array(43, 46, ),
        /* 51 */ array(27, ),
        /* 52 */ array(27, ),
        /* 53 */ array(27, ),
        /* 54 */ array(27, ),
        /* 55 */ array(24, ),
        /* 56 */ array(45, ),
        /* 57 */ array(27, ),
        /* 58 */ array(27, ),
        /* 59 */ array(27, ),
        /* 60 */ array(35, ),
        /* 61 */ array(37, ),
        /* 62 */ array(),
        /* 63 */ array(),
        /* 64 */ array(),
        /* 65 */ array(),
        /* 66 */ array(),
        /* 67 */ array(),
        /* 68 */ array(),
        /* 69 */ array(),
        /* 70 */ array(),
        /* 71 */ array(),
        /* 72 */ array(),
        /* 73 */ array(),
        /* 74 */ array(),
        /* 75 */ array(),
        /* 76 */ array(),
        /* 77 */ array(),
        /* 78 */ array(),
        /* 79 */ array(),
        /* 80 */ array(),
        /* 81 */ array(),
        /* 82 */ array(),
        /* 83 */ array(),
        /* 84 */ array(),
        /* 85 */ array(),
        /* 86 */ array(),
        /* 87 */ array(),
        /* 88 */ array(),
        /* 89 */ array(),
        /* 90 */ array(),
        /* 91 */ array(),
        /* 92 */ array(),
        /* 93 */ array(),
        /* 94 */ array(),
        /* 95 */ array(),
        /* 96 */ array(),
        /* 97 */ array(),
        /* 98 */ array(),
        /* 99 */ array(),
        /* 100 */ array(),
);
    static public $yy_default = array(
 /*     0 */   106,  153,  146,  146,  160,  160,  160,  160,  160,  160,
 /*    10 */   160,  160,  160,  160,  160,  160,  160,  160,  101,  160,
 /*    20 */   160,  148,  148,  148,  148,  142,  160,  112,  160,  111,
 /*    30 */   142,  159,  119,  106,  160,  160,  160,  160,  145,  154,
 /*    40 */   144,  131,  137,  138,  132,  135,  160,  160,  160,  160,
 /*    50 */   160,  160,  160,  160,  160,  136,  139,  160,  160,  160,
 /*    60 */   160,  160,  102,  103,  104,  105,  107,  141,  120,  121,
 /*    70 */   122,  123,  124,  125,  126,  127,  128,  129,  130,  133,
 /*    80 */   147,  134,  140,  115,  155,  156,  157,  158,  150,  151,
 /*    90 */   152,  149,  143,  108,  109,  113,  114,  110,  116,  117,
 /*   100 */   118,
);
/* The next thing included is series of defines which control
** various aspects of the generated parser.
**    self::YYNOCODE      is a number which corresponds
**                        to no legal terminal or nonterminal number.  This
**                        number is used to fill in empty slots of the hash 
**                        table.
**    self::YYFALLBACK    If defined, this indicates that one or more tokens
**                        have fall-back values which should be used if the
**                        original value of the token will not parse.
**    self::YYSTACKDEPTH  is the maximum depth of the parser's stack.
**    self::YYNSTATE      the combined number of states.
**    self::YYNRULE       the number of rules in the grammar
**    self::YYERRORSYMBOL is the code number of the error symbol.  If not
**                        defined, then do no error processing.
*/
    const YYNOCODE = 75;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 101;
    const YYNRULE = 59;
    const YYERRORSYMBOL = 53;
    const YYERRSYMDT = 'yy0';
    const YYFALLBACK = 0;
    /** The next table maps tokens into fallback tokens.  If a construct
     * like the following:
     * 
     *      %fallback ID X Y Z.
     *
     * appears in the grammer, then ID becomes a fallback token for X, Y,
     * and Z.  Whenever one of the tokens X, Y, or Z is input to the parser
     * but it does not parse, the type of the token is changed to ID and
     * the parse is retried before an error is thrown.
     */
    static public $yyFallback = array(
    );
    /**
     * Turn parser tracing on by giving a stream to which to write the trace
     * and a prompt to preface each trace message.  Tracing is turned off
     * by making either argument NULL 
     *
     * Inputs:
     * 
     * - A stream resource to which trace output should be written.
     *   If NULL, then tracing is turned off.
     * - A prefix string written at the beginning of every
     *   line of trace output.  If NULL, then tracing is
     *   turned off.
     *
     * Outputs:
     * 
     * - None.
     * @param resource
     * @param string
     */
    static function Trace($TraceFILE, $zTracePrompt)
    {
        if (!$TraceFILE) {
            $zTracePrompt = 0;
        } elseif (!$zTracePrompt) {
            $TraceFILE = 0;
        }
        self::$yyTraceFILE = $TraceFILE;
        self::$yyTracePrompt = $zTracePrompt;
    }

    /**
     * Output debug information to output (php://output stream)
     */
    static function PrintTrace()
    {
        self::$yyTraceFILE = fopen('php://output', 'w');
        self::$yyTracePrompt = '';
    }

    /**
     * @var resource|0
     */
    static public $yyTraceFILE;
    /**
     * String to prepend to debug output
     * @var string|0
     */
    static public $yyTracePrompt;
    /**
     * @var int
     */
    public $yyidx = -1;                    /* Index of top element in stack */
    /**
     * @var int
     */
    public $yyerrcnt;                 /* Shifts left before out of the error */
    /**
     * @var array
     */
    public $yystack = array();  /* The parser's stack */

    /**
     * For tracing shifts, the names of all terminals and nonterminals
     * are required.  The following table supplies these names
     * @var array
     */
    static public $yyTokenName = array( 
  '$',             'OP_OR',         'OP_AND',        'OP_TERNARY_IF',
  'OP_TERNARY_ELSE',  'OP_TERNARY_SHORT',  'OP_EQ',         'OP_NE',       
  'OP_ID',         'OP_NID',        'OP_GT',         'OP_GTEQ',     
  'OP_LT',         'OP_LTEQ',       'OP_IS',         'OP_IS_NOT',   
  'OP_MINUS',      'OP_PLUS',       'OP_CONCAT',     'OP_MULTIPLY', 
  'OP_DIVIDE',     'OP_MOD',        'OP_U_MINUS',    'OP_BANG',     
  'OP_INSTANCEOF',  'PLAIN',         'VAR_START',     'LITERAL',     
  'VAR_END',       'VAR_DIM',       'VAR_OBJECT',    'EXPR_START',  
  'EXPR_END',      'TAG_OPEN_START',  'TAG_END_CLOSE',  'TAG_END',     
  'TAG_CLOSE_START',  'TAG_ATTRIBUTE_START',  'BOOLEAN',       'NULL',        
  'NUMBER',        'STRING',        'PAREN_START',   'PAREN_END',   
  'PLACEHOLDER',   'FILTER',        'ARG_SEP',       'ARRAY_START', 
  'ARRAY_END',     'HASH_START',    'HASH_END',      'HASH_SEP',    
  'DOUBLE_QUOTE',  'error',         'start',         'begin',       
  'var',           'expression_full',  'tag',           'var_extras',  
  'filters',       'var_array_key',  'function_args',  'optional_args',
  'expression',    'tag_attributes',  'double_quoted',  'expression_part',
  'array',         'hash',          'comma_expression_optional',  'hash_parts',  
  'hash_part',     'double_quote_inner',
    );

    /**
     * For tracing reduce actions, the names of all rules are required.
     * @var array
     */
    static public $yyRuleName = array(
 /*   0 */ "start ::= begin",
 /*   1 */ "begin ::= begin PLAIN",
 /*   2 */ "begin ::= begin var",
 /*   3 */ "begin ::= begin expression_full",
 /*   4 */ "begin ::= begin tag",
 /*   5 */ "begin ::=",
 /*   6 */ "var ::= VAR_START LITERAL var_extras filters VAR_END",
 /*   7 */ "var_extras ::= var_extras VAR_DIM var_array_key",
 /*   8 */ "var_extras ::= var_extras VAR_DIM LITERAL function_args",
 /*   9 */ "var_extras ::= var_extras VAR_OBJECT LITERAL optional_args",
 /*  10 */ "var_extras ::=",
 /*  11 */ "var_array_key ::= LITERAL",
 /*  12 */ "var_array_key ::= var",
 /*  13 */ "var_array_key ::= expression_full",
 /*  14 */ "expression_full ::= EXPR_START expression EXPR_END",
 /*  15 */ "tag ::= TAG_OPEN_START LITERAL tag_attributes TAG_END_CLOSE",
 /*  16 */ "tag ::= TAG_OPEN_START LITERAL tag_attributes TAG_END begin TAG_CLOSE_START LITERAL TAG_END",
 /*  17 */ "tag_attributes ::= tag_attributes LITERAL TAG_ATTRIBUTE_START double_quoted",
 /*  18 */ "tag_attributes ::=",
 /*  19 */ "expression_part ::= BOOLEAN",
 /*  20 */ "expression_part ::= NULL",
 /*  21 */ "expression_part ::= NUMBER",
 /*  22 */ "expression_part ::= STRING",
 /*  23 */ "expression_part ::= LITERAL function_args",
 /*  24 */ "expression_part ::= var",
 /*  25 */ "expression_part ::= double_quoted",
 /*  26 */ "expression_part ::= PAREN_START expression PAREN_END",
 /*  27 */ "expression_part ::= array",
 /*  28 */ "expression_part ::= hash",
 /*  29 */ "expression_part ::= OP_MINUS expression_part",
 /*  30 */ "expression ::= expression OP_OR|OP_AND|OP_INSTANCEOF expression",
 /*  31 */ "expression ::= expression OP_EQ|OP_NE|OP_ID|OP_NID|OP_GT|OP_GTEQ|OP_LT|OP_LTEQ expression",
 /*  32 */ "expression ::= expression OP_IS LITERAL optional_args",
 /*  33 */ "expression ::= expression OP_IS_NOT LITERAL optional_args",
 /*  34 */ "expression ::= expression OP_MINUS|OP_PLUS|OP_MULTIPLY|OP_DIVIDE|OP_MOD|OP_CONCAT expression",
 /*  35 */ "expression ::= OP_BANG expression",
 /*  36 */ "expression ::= expression OP_TERNARY_SHORT expression",
 /*  37 */ "expression ::= expression OP_TERNARY_IF expression OP_TERNARY_ELSE expression",
 /*  38 */ "expression ::= expression_part filters",
 /*  39 */ "expression ::= PLACEHOLDER",
 /*  40 */ "filters ::= filters FILTER LITERAL optional_args",
 /*  41 */ "filters ::=",
 /*  42 */ "function_args ::= PAREN_START comma_expression_optional PAREN_END",
 /*  43 */ "comma_expression_optional ::= comma_expression_optional ARG_SEP expression",
 /*  44 */ "comma_expression_optional ::= expression",
 /*  45 */ "comma_expression_optional ::=",
 /*  46 */ "optional_args ::= function_args",
 /*  47 */ "optional_args ::=",
 /*  48 */ "array ::= ARRAY_START comma_expression_optional ARRAY_END",
 /*  49 */ "hash ::= HASH_START hash_parts HASH_END",
 /*  50 */ "hash_parts ::= hash_parts ARG_SEP hash_part",
 /*  51 */ "hash_parts ::= hash_part",
 /*  52 */ "hash_parts ::=",
 /*  53 */ "hash_part ::= expression HASH_SEP|OP_TERNARY_ELSE expression",
 /*  54 */ "double_quoted ::= DOUBLE_QUOTE double_quote_inner DOUBLE_QUOTE",
 /*  55 */ "double_quote_inner ::= double_quote_inner STRING",
 /*  56 */ "double_quote_inner ::= double_quote_inner var",
 /*  57 */ "double_quote_inner ::= double_quote_inner expression_full",
 /*  58 */ "double_quote_inner ::=",
    );

    /**
     * This function returns the symbolic name associated with a token
     * value.
     * @param int
     * @return string
     */
    function tokenName($tokenType)
    {
        if ($tokenType === 0) {
            return 'End of Input';
        }
        if ($tokenType > 0 && $tokenType < count(self::$yyTokenName)) {
            return self::$yyTokenName[$tokenType];
        } else {
            return "Unknown";
        }
    }

    /**
     * The following function deletes the value associated with a
     * symbol.  The symbol can be either a terminal or nonterminal.
     * @param int the symbol code
     * @param mixed the symbol's value
     */
    static function yy_destructor($yymajor, $yypminor)
    {
        switch ($yymajor) {
        /* Here is inserted the actions which take place when a
        ** terminal or non-terminal is destroyed.  This can happen
        ** when the symbol is popped from the stack during a
        ** reduce or during error processing or when a parser is 
        ** being destroyed before it is finished parsing.
        **
        ** Note: during a reduce, the only symbols destroyed are those
        ** which appear on the RHS of the rule, but which are not used
        ** inside the C code.
        */
            default:  break;   /* If no destructor action specified: do nothing */
        }
    }

    /**
     * Pop the parser's stack once.
     *
     * If there is a destructor routine associated with the token which
     * is popped from the stack, then call it.
     *
     * Return the major token number for the symbol popped.
     * @param Parser_yyParser
     * @return int
     */
    function yy_pop_parser_stack()
    {
        if (!count($this->yystack)) {
            return;
        }
        $yytos = array_pop($this->yystack);
        if (self::$yyTraceFILE && $this->yyidx >= 0) {
            fwrite(self::$yyTraceFILE,
                self::$yyTracePrompt . 'Popping ' . self::$yyTokenName[$yytos->major] .
                    "\n");
        }
        $yymajor = $yytos->major;
        self::yy_destructor($yymajor, $yytos->minor);
        $this->yyidx--;
        return $yymajor;
    }

    /**
     * Deallocate and destroy a parser.  Destructors are all called for
     * all stack elements before shutting the parser down.
     */
    function __destruct()
    {
        while ($this->yyidx >= 0) {
            $this->yy_pop_parser_stack();
        }
        if (is_resource(self::$yyTraceFILE)) {
            fclose(self::$yyTraceFILE);
        }
    }

    /**
     * Based on the current state and parser stack, get a list of all
     * possible lookahead tokens
     * @param int
     * @return array
     */
    function yy_get_expected_tokens($token)
    {
        $state = $this->yystack[$this->yyidx]->stateno;
        $expected = self::$yyExpectedTokens[$state];
        if (in_array($token, self::$yyExpectedTokens[$state], true)) {
            return $expected;
        }
        $stack = $this->yystack;
        $yyidx = $this->yyidx;
        do {
            $yyact = $this->yy_find_shift_action($token);
            if ($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
                // reduce action
                $done = 0;
                do {
                    if ($done++ == 100) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // too much recursion prevents proper detection
                        // so give up
                        return array_unique($expected);
                    }
                    $yyruleno = $yyact - self::YYNSTATE;
                    $this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
                    $nextstate = $this->yy_find_reduce_action(
                        $this->yystack[$this->yyidx]->stateno,
                        self::$yyRuleInfo[$yyruleno]['lhs']);
                    if (isset(self::$yyExpectedTokens[$nextstate])) {
                        $expected += self::$yyExpectedTokens[$nextstate];
                            if (in_array($token,
                                  self::$yyExpectedTokens[$nextstate], true)) {
                            $this->yyidx = $yyidx;
                            $this->yystack = $stack;
                            return array_unique($expected);
                        }
                    }
                    if ($nextstate < self::YYNSTATE) {
                        // we need to shift a non-terminal
                        $this->yyidx++;
                        $x = new Parser_yyStackEntry;
                        $x->stateno = $nextstate;
                        $x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
                        $this->yystack[$this->yyidx] = $x;
                        continue 2;
                    } elseif ($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // the last token was just ignored, we can't accept
                        // by ignoring input, this is in essence ignoring a
                        // syntax error!
                        return array_unique($expected);
                    } elseif ($nextstate === self::YY_NO_ACTION) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // input accepted, but not shifted (I guess)
                        return $expected;
                    } else {
                        $yyact = $nextstate;
                    }
                } while (true);
            }
            break;
        } while (true);
        return array_unique($expected);
    }

    /**
     * Based on the parser state and current parser stack, determine whether
     * the lookahead token is possible.
     * 
     * The parser will convert the token value to an error token if not.  This
     * catches some unusual edge cases where the parser would fail.
     * @param int
     * @return bool
     */
    function yy_is_expected_token($token)
    {
        if ($token === 0) {
            return true; // 0 is not part of this
        }
        $state = $this->yystack[$this->yyidx]->stateno;
        if (in_array($token, self::$yyExpectedTokens[$state], true)) {
            return true;
        }
        $stack = $this->yystack;
        $yyidx = $this->yyidx;
        do {
            $yyact = $this->yy_find_shift_action($token);
            if ($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
                // reduce action
                $done = 0;
                do {
                    if ($done++ == 100) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // too much recursion prevents proper detection
                        // so give up
                        return true;
                    }
                    $yyruleno = $yyact - self::YYNSTATE;
                    $this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
                    $nextstate = $this->yy_find_reduce_action(
                        $this->yystack[$this->yyidx]->stateno,
                        self::$yyRuleInfo[$yyruleno]['lhs']);
                    if (isset(self::$yyExpectedTokens[$nextstate]) &&
                          in_array($token, self::$yyExpectedTokens[$nextstate], true)) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        return true;
                    }
                    if ($nextstate < self::YYNSTATE) {
                        // we need to shift a non-terminal
                        $this->yyidx++;
                        $x = new Parser_yyStackEntry;
                        $x->stateno = $nextstate;
                        $x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
                        $this->yystack[$this->yyidx] = $x;
                        continue 2;
                    } elseif ($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        if (!$token) {
                            // end of input: this is valid
                            return true;
                        }
                        // the last token was just ignored, we can't accept
                        // by ignoring input, this is in essence ignoring a
                        // syntax error!
                        return false;
                    } elseif ($nextstate === self::YY_NO_ACTION) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // input accepted, but not shifted (I guess)
                        return true;
                    } else {
                        $yyact = $nextstate;
                    }
                } while (true);
            }
            break;
        } while (true);
        $this->yyidx = $yyidx;
        $this->yystack = $stack;
        return true;
    }

    /**
     * Find the appropriate action for a parser given the terminal
     * look-ahead token iLookAhead.
     *
     * If the look-ahead token is YYNOCODE, then check to see if the action is
     * independent of the look-ahead.  If it is, return the action, otherwise
     * return YY_NO_ACTION.
     * @param int The look-ahead token
     */
    function yy_find_shift_action($iLookAhead)
    {
        $stateno = $this->yystack[$this->yyidx]->stateno;
     
        /* if ($this->yyidx < 0) return self::YY_NO_ACTION;  */
        if (!isset(self::$yy_shift_ofst[$stateno])) {
            // no shift actions
            return self::$yy_default[$stateno];
        }
        $i = self::$yy_shift_ofst[$stateno];
        if ($i === self::YY_SHIFT_USE_DFLT) {
            return self::$yy_default[$stateno];
        }
        if ($iLookAhead == self::YYNOCODE) {
            return self::YY_NO_ACTION;
        }
        $i += $iLookAhead;
        if ($i < 0 || $i >= self::YY_SZ_ACTTAB ||
              self::$yy_lookahead[$i] != $iLookAhead) {
            if (count(self::$yyFallback) && $iLookAhead < count(self::$yyFallback)
                   && ($iFallback = self::$yyFallback[$iLookAhead]) != 0) {
                if (self::$yyTraceFILE) {
                    fwrite(self::$yyTraceFILE, self::$yyTracePrompt . "FALLBACK " .
                        self::$yyTokenName[$iLookAhead] . " => " .
                        self::$yyTokenName[$iFallback] . "\n");
                }
                return $this->yy_find_shift_action($iFallback);
            }
            return self::$yy_default[$stateno];
        } else {
            return self::$yy_action[$i];
        }
    }

    /**
     * Find the appropriate action for a parser given the non-terminal
     * look-ahead token $iLookAhead.
     *
     * If the look-ahead token is self::YYNOCODE, then check to see if the action is
     * independent of the look-ahead.  If it is, return the action, otherwise
     * return self::YY_NO_ACTION.
     * @param int Current state number
     * @param int The look-ahead token
     */
    function yy_find_reduce_action($stateno, $iLookAhead)
    {
        /* $stateno = $this->yystack[$this->yyidx]->stateno; */

        if (!isset(self::$yy_reduce_ofst[$stateno])) {
            return self::$yy_default[$stateno];
        }
        $i = self::$yy_reduce_ofst[$stateno];
        if ($i == self::YY_REDUCE_USE_DFLT) {
            return self::$yy_default[$stateno];
        }
        if ($iLookAhead == self::YYNOCODE) {
            return self::YY_NO_ACTION;
        }
        $i += $iLookAhead;
        if ($i < 0 || $i >= self::YY_SZ_ACTTAB ||
              self::$yy_lookahead[$i] != $iLookAhead) {
            return self::$yy_default[$stateno];
        } else {
            return self::$yy_action[$i];
        }
    }

    /**
     * Perform a shift action.
     * @param int The new state to shift in
     * @param int The major token to shift in
     * @param mixed the minor token to shift in
     */
    function yy_shift($yyNewState, $yyMajor, $yypMinor)
    {
        $this->yyidx++;
        if ($this->yyidx >= self::YYSTACKDEPTH) {
            $this->yyidx--;
            if (self::$yyTraceFILE) {
                fprintf(self::$yyTraceFILE, "%sStack Overflow!\n", self::$yyTracePrompt);
            }
            while ($this->yyidx >= 0) {
                $this->yy_pop_parser_stack();
            }
            /* Here code is inserted which will execute if the parser
            ** stack ever overflows */
#line  "Parser.y"
#line 972 "Parser.php"
            return;
        }
        $yytos = new Parser_yyStackEntry;
        $yytos->stateno = $yyNewState;
        $yytos->major = $yyMajor;
        $yytos->minor = $yypMinor;
        array_push($this->yystack, $yytos);
        if (self::$yyTraceFILE && $this->yyidx > 0) {
            fprintf(self::$yyTraceFILE, "%sShift %d\n", self::$yyTracePrompt,
                $yyNewState);
            fprintf(self::$yyTraceFILE, "%sStack:", self::$yyTracePrompt);
            for ($i = 1; $i <= $this->yyidx; $i++) {
                fprintf(self::$yyTraceFILE, " %s",
                    self::$yyTokenName[$this->yystack[$i]->major]);
            }
            fwrite(self::$yyTraceFILE,"\n");
        }
    }

    /**
     * The following table contains information about every rule that
     * is used during the reduce.
     *
     * <pre>
     * array(
     *  array(
     *   int $lhs;         Symbol on the left-hand side of the rule
     *   int $nrhs;     Number of right-hand side symbols in the rule
     *  ),...
     * );
     * </pre>
     */
    static public $yyRuleInfo = array(
  array( 'lhs' => 54, 'rhs' => 1 ),
  array( 'lhs' => 55, 'rhs' => 2 ),
  array( 'lhs' => 55, 'rhs' => 2 ),
  array( 'lhs' => 55, 'rhs' => 2 ),
  array( 'lhs' => 55, 'rhs' => 2 ),
  array( 'lhs' => 55, 'rhs' => 0 ),
  array( 'lhs' => 56, 'rhs' => 5 ),
  array( 'lhs' => 59, 'rhs' => 3 ),
  array( 'lhs' => 59, 'rhs' => 4 ),
  array( 'lhs' => 59, 'rhs' => 4 ),
  array( 'lhs' => 59, 'rhs' => 0 ),
  array( 'lhs' => 61, 'rhs' => 1 ),
  array( 'lhs' => 61, 'rhs' => 1 ),
  array( 'lhs' => 61, 'rhs' => 1 ),
  array( 'lhs' => 57, 'rhs' => 3 ),
  array( 'lhs' => 58, 'rhs' => 4 ),
  array( 'lhs' => 58, 'rhs' => 8 ),
  array( 'lhs' => 65, 'rhs' => 4 ),
  array( 'lhs' => 65, 'rhs' => 0 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 2 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 2 ),
  array( 'lhs' => 64, 'rhs' => 3 ),
  array( 'lhs' => 64, 'rhs' => 3 ),
  array( 'lhs' => 64, 'rhs' => 4 ),
  array( 'lhs' => 64, 'rhs' => 4 ),
  array( 'lhs' => 64, 'rhs' => 3 ),
  array( 'lhs' => 64, 'rhs' => 2 ),
  array( 'lhs' => 64, 'rhs' => 3 ),
  array( 'lhs' => 64, 'rhs' => 5 ),
  array( 'lhs' => 64, 'rhs' => 2 ),
  array( 'lhs' => 64, 'rhs' => 1 ),
  array( 'lhs' => 60, 'rhs' => 4 ),
  array( 'lhs' => 60, 'rhs' => 0 ),
  array( 'lhs' => 62, 'rhs' => 3 ),
  array( 'lhs' => 70, 'rhs' => 3 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 0 ),
  array( 'lhs' => 63, 'rhs' => 1 ),
  array( 'lhs' => 63, 'rhs' => 0 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 69, 'rhs' => 3 ),
  array( 'lhs' => 71, 'rhs' => 3 ),
  array( 'lhs' => 71, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 0 ),
  array( 'lhs' => 72, 'rhs' => 3 ),
  array( 'lhs' => 66, 'rhs' => 3 ),
  array( 'lhs' => 73, 'rhs' => 2 ),
  array( 'lhs' => 73, 'rhs' => 2 ),
  array( 'lhs' => 73, 'rhs' => 2 ),
  array( 'lhs' => 73, 'rhs' => 0 ),
    );

    /**
     * The following table contains a mapping of reduce action to method name
     * that handles the reduction.
     * 
     * If a rule is not set, it has no handler.
     */
    static public $yyReduceMap = array(
        0 => 0,
        1 => 1,
        55 => 1,
        2 => 2,
        3 => 2,
        4 => 2,
        56 => 2,
        57 => 2,
        6 => 6,
        7 => 7,
        8 => 8,
        9 => 9,
        11 => 11,
        22 => 11,
        12 => 12,
        13 => 12,
        24 => 12,
        27 => 12,
        28 => 12,
        46 => 12,
        14 => 14,
        26 => 14,
        15 => 15,
        16 => 16,
        17 => 17,
        19 => 19,
        20 => 20,
        21 => 21,
        23 => 23,
        25 => 25,
        29 => 29,
        35 => 29,
        30 => 30,
        31 => 30,
        34 => 30,
        32 => 32,
        33 => 33,
        36 => 36,
        37 => 37,
        38 => 38,
        39 => 39,
        40 => 40,
        42 => 42,
        43 => 43,
        50 => 43,
        44 => 44,
        51 => 44,
        48 => 48,
        49 => 49,
        53 => 53,
        54 => 54,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 29 "Parser.y"
    function yy_r0(){
	$this->ast = new Ast($this->yystack[$this->yyidx + 0]->minor ?: []);
    }
#line 1136 "Parser.php"
#line 33 "Parser.y"
    function yy_r1(){
	$this->_retvalue = $this->yystack[$this->yyidx + -1]->minor ?: [];
	$this->_retvalue[] = new Syntax\Str($this->yystack[$this->yyidx + 0]->minor, $this->line);
    }
#line 1142 "Parser.php"
#line 37 "Parser.y"
    function yy_r2(){
	$this->_retvalue = $this->yystack[$this->yyidx + -1]->minor ?: [];
	$this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;
    }
#line 1148 "Parser.php"
#line 51 "Parser.y"
    function yy_r6(){
	$res = new Syntax\Variable($this->yystack[$this->yyidx + -3]->minor, $this->yystack[$this->yyidx + -2]->minor ?: [], $this->yystack[$this->yyidx + -1]->minor ?: [], $this->line);
	$this->_retvalue = $res;
    }
#line 1154 "Parser.php"
#line 56 "Parser.y"
    function yy_r7(){
	$this->_retvalue = $this->yystack[$this->yyidx + -2]->minor ?: [];
	$this->_retvalue[] = ['array', $this->yystack[$this->yyidx + 0]->minor];
    }
#line 1160 "Parser.php"
#line 60 "Parser.y"
    function yy_r8(){
	$this->_retvalue = $this->yystack[$this->yyidx + -3]->minor ?: [];
	$this->_retvalue[] = ['function', new Syntax\Func($this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor ?: [], $this->line)];
    }
#line 1166 "Parser.php"
#line 64 "Parser.y"
    function yy_r9(){
	$this->_retvalue = $this->yystack[$this->yyidx + -3]->minor ?: [];
	if (is_array($this->yystack[$this->yyidx + 0]->minor))
	{
		$this->_retvalue[] = ['function', new Syntax\Func($this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor ?: [], $this->line)];
	}
	else
	{
		$this->_retvalue[] = ['object', new Syntax\Str($this->yystack[$this->yyidx + -1]->minor, $this->line)];
	}
    }
#line 1179 "Parser.php"
#line 77 "Parser.y"
    function yy_r11(){
	$this->_retvalue = new Syntax\Str($this->yystack[$this->yyidx + 0]->minor, $this->line);
    }
#line 1184 "Parser.php"
#line 80 "Parser.y"
    function yy_r12(){
	$this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;
    }
#line 1189 "Parser.php"
#line 87 "Parser.y"
    function yy_r14(){
	$this->_retvalue = new Syntax\Expression($this->yystack[$this->yyidx + -1]->minor, $this->line);
    }
#line 1194 "Parser.php"
#line 92 "Parser.y"
    function yy_r15(){
	$this->_retvalue = new Syntax\Tag($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor ?: [], [], $this->line, true);
    }
#line 1199 "Parser.php"
#line 95 "Parser.y"
    function yy_r16(){
	if ($this->yystack[$this->yyidx + -6]->minor != $this->yystack[$this->yyidx + -1]->minor)
	{
		$closing = $this->yystack[$this->yyidx + -1]->minor;
		$opening = $this->yystack[$this->yyidx + -6]->minor;
		throw new Exception(\XF::string([
			\XF::phrase('line_x', ['line' => $this->line]), ': ', \XF::phrase('template_tags_not_well_formed', ['closing' => $closing, 'opening' => $opening])
		]));
	}
	$this->_retvalue = new Syntax\Tag($this->yystack[$this->yyidx + -6]->minor, $this->yystack[$this->yyidx + -5]->minor ?: [], $this->yystack[$this->yyidx + -3]->minor ?: [], $this->line, false);
    }
#line 1212 "Parser.php"
#line 107 "Parser.y"
    function yy_r17(){
	if (!$this->yystack[$this->yyidx + 0]->minor->parts)
	{
		$attr = new Syntax\Str('', $this->line);
	}
	else if (count($this->yystack[$this->yyidx + 0]->minor->parts) == 1)
	{
		$attr = reset($this->yystack[$this->yyidx + 0]->minor->parts);
	}
	else
	{
		$attr = $this->yystack[$this->yyidx + 0]->minor;
	}
	$this->_retvalue = $this->yystack[$this->yyidx + -3]->minor ?: [];
	$this->_retvalue[$this->yystack[$this->yyidx + -2]->minor] = $attr;
    }
#line 1230 "Parser.php"
#line 125 "Parser.y"
    function yy_r19(){
	$this->_retvalue = new Syntax\Boolean(strtolower($this->yystack[$this->yyidx + 0]->minor) == 'true', $this->line);
    }
#line 1235 "Parser.php"
#line 128 "Parser.y"
    function yy_r20(){
	$this->_retvalue = new Syntax\NullValue($this->line);
    }
#line 1240 "Parser.php"
#line 131 "Parser.y"
    function yy_r21(){
	$this->_retvalue = new Syntax\Number($this->yystack[$this->yyidx + 0]->minor, $this->line);
    }
#line 1245 "Parser.php"
#line 137 "Parser.y"
    function yy_r23(){
	$this->_retvalue = new Syntax\Func($this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor ?: [], $this->line);
    }
#line 1250 "Parser.php"
#line 143 "Parser.y"
    function yy_r25(){
	if (!$this->yystack[$this->yyidx + 0]->minor->parts)
	{
		$this->_retvalue = new Syntax\Str('', $this->line);
	}
	else if (count($this->yystack[$this->yyidx + 0]->minor->parts) == 1)
	{
		$this->_retvalue = reset($this->yystack[$this->yyidx + 0]->minor->parts);
	}
	else
	{
		$this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;
	}
    }
#line 1266 "Parser.php"
#line 166 "Parser.y"
    function yy_r29(){
	$this->_retvalue = new Syntax\UnaryOperator($this->yystack[$this->yyidx + -1]->major, $this->yystack[$this->yyidx + 0]->minor, $this->line);
    }
#line 1271 "Parser.php"
#line 170 "Parser.y"
    function yy_r30(){
	$this->_retvalue = new Syntax\BinaryOperator($this->yystack[$this->yyidx + -1]->major, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor, $this->line);
    }
#line 1276 "Parser.php"
#line 176 "Parser.y"
    function yy_r32(){
	$this->_retvalue = new Syntax\Is($this->yystack[$this->yyidx + -3]->minor, true, $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor ?: [], $this->line);
    }
#line 1281 "Parser.php"
#line 179 "Parser.y"
    function yy_r33(){
	$this->_retvalue = new Syntax\Is($this->yystack[$this->yyidx + -3]->minor, false, $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor ?: [], $this->line);
    }
#line 1286 "Parser.php"
#line 188 "Parser.y"
    function yy_r36(){
	$this->_retvalue = new Syntax\TernaryShortOperator($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor, $this->line);
    }
#line 1291 "Parser.php"
#line 191 "Parser.y"
    function yy_r37(){
	$this->_retvalue = new Syntax\TernaryOperator($this->yystack[$this->yyidx + -4]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor, $this->line);
    }
#line 1296 "Parser.php"
#line 194 "Parser.y"
    function yy_r38(){
	if ($this->yystack[$this->yyidx + 0]->minor)
	{
		$this->_retvalue = new Syntax\FilterChain($this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor, $this->line);
	}
	else
	{
		$this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;
	}
    }
#line 1308 "Parser.php"
#line 204 "Parser.y"
    function yy_r39(){
	if (!isset($this->placeholders[$this->yystack[$this->yyidx + 0]->minor]))
	{
		throw new \Exception("Unknown placeholder used, this should never happen");
	}

	$this->_retvalue = $this->placeholders[$this->yystack[$this->yyidx + 0]->minor];
    }
#line 1318 "Parser.php"
#line 213 "Parser.y"
    function yy_r40(){
	$this->_retvalue = $this->yystack[$this->yyidx + -3]->minor ?: [];
	$this->_retvalue[] = [$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor ?: []];
    }
#line 1324 "Parser.php"
#line 219 "Parser.y"
    function yy_r42(){
	$this->_retvalue = $this->yystack[$this->yyidx + -1]->minor ?: [];
    }
#line 1329 "Parser.php"
#line 223 "Parser.y"
    function yy_r43(){
	$this->_retvalue = $this->yystack[$this->yyidx + -2]->minor ?: [];
	$this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;
    }
#line 1335 "Parser.php"
#line 227 "Parser.y"
    function yy_r44(){
	$this->_retvalue = [$this->yystack[$this->yyidx + 0]->minor];
    }
#line 1340 "Parser.php"
#line 237 "Parser.y"
    function yy_r48(){
	$this->_retvalue = new Syntax\ArrayExpression($this->yystack[$this->yyidx + -1]->minor ?: [], $this->line);
    }
#line 1345 "Parser.php"
#line 241 "Parser.y"
    function yy_r49(){
	$this->_retvalue = new Syntax\Hash($this->yystack[$this->yyidx + -1]->minor ?: [], $this->line);
    }
#line 1350 "Parser.php"
#line 254 "Parser.y"
    function yy_r53(){
	$this->_retvalue = [0 => $this->yystack[$this->yyidx + -2]->minor, 1 => $this->yystack[$this->yyidx + 0]->minor];
    }
#line 1355 "Parser.php"
#line 258 "Parser.y"
    function yy_r54(){
	$this->_retvalue = new Syntax\Quoted($this->yystack[$this->yyidx + -1]->minor ?: [], $this->line);
    }
#line 1360 "Parser.php"

    /**
     * placeholder for the left hand side in a reduce operation.
     * 
     * For a parser with a rule like this:
     * <pre>
     * rule(A) ::= B. { A = 1; }
     * </pre>
     * 
     * The parser will translate to something like:
     * 
     * <code>
     * function yy_r0(){$this->_retvalue = 1;}
     * </code>
     */
    private $_retvalue;

    /**
     * Perform a reduce action and the shift that must immediately
     * follow the reduce.
     * 
     * For a rule such as:
     * 
     * <pre>
     * A ::= B blah C. { dosomething(); }
     * </pre>
     * 
     * This function will first call the action, if any, ("dosomething();" in our
     * example), and then it will pop three states from the stack,
     * one for each entry on the right-hand side of the expression
     * (B, blah, and C in our example rule), and then push the result of the action
     * back on to the stack with the resulting state reduced to (as described in the .out
     * file)
     * @param int Number of the rule by which to reduce
     */
    function yy_reduce($yyruleno)
    {
        //int $yygoto;                     /* The next state */
        //int $yyact;                      /* The next action */
        //mixed $yygotominor;        /* The LHS of the rule reduced */
        //Parser_yyStackEntry $yymsp;            /* The top of the parser's stack */
        //int $yysize;                     /* Amount to pop the stack */
        $yymsp = $this->yystack[$this->yyidx];
        if (self::$yyTraceFILE && $yyruleno >= 0 
              && $yyruleno < count(self::$yyRuleName)) {
            fprintf(self::$yyTraceFILE, "%sReduce (%d) [%s].\n",
                self::$yyTracePrompt, $yyruleno,
                self::$yyRuleName[$yyruleno]);
        }

        $this->_retvalue = $yy_lefthand_side = null;
        if (array_key_exists($yyruleno, self::$yyReduceMap)) {
            // call the action
            $this->_retvalue = null;
            $this->{'yy_r' . self::$yyReduceMap[$yyruleno]}();
            $yy_lefthand_side = $this->_retvalue;
        }
        $yygoto = self::$yyRuleInfo[$yyruleno]['lhs'];
        $yysize = self::$yyRuleInfo[$yyruleno]['rhs'];
        $this->yyidx -= $yysize;
        for ($i = $yysize; $i; $i--) {
            // pop all of the right-hand side parameters
            array_pop($this->yystack);
        }
        $yyact = $this->yy_find_reduce_action($this->yystack[$this->yyidx]->stateno, $yygoto);
        if ($yyact < self::YYNSTATE) {
            /* If we are not debugging and the reduce action popped at least
            ** one element off the stack, then we can push the new element back
            ** onto the stack here, and skip the stack overflow test in yy_shift().
            ** That gives a significant speed improvement. */
            if (!self::$yyTraceFILE && $yysize) {
                $this->yyidx++;
                $x = new Parser_yyStackEntry;
                $x->stateno = $yyact;
                $x->major = $yygoto;
                $x->minor = $yy_lefthand_side;
                $this->yystack[$this->yyidx] = $x;
            } else {
                $this->yy_shift($yyact, $yygoto, $yy_lefthand_side);
            }
        } elseif ($yyact == self::YYNSTATE + self::YYNRULE + 1) {
            $this->yy_accept();
        }
    }

    /**
     * The following code executes when the parse fails
     * 
     * Code from %parse_fail is inserted here
     */
    function yy_parse_failed()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sFail!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $this->yy_pop_parser_stack();
        }
        /* Here code is inserted which will be executed whenever the
        ** parser fails */
#line  "Parser.y"
#line 1463 "Parser.php"
    }

    /**
     * The following code executes when a syntax error first occurs.
     * 
     * %syntax_error code is inserted here
     * @param int The major type of the error token
     * @param mixed The minor type of the error token
     */
    function yy_syntax_error($yymajor, $TOKEN)
    {
#line 4 "Parser.y"

	throw new Exception(\XF::string([
		\XF::phrase('line_x', ['line' => $this->line]), ': ', \XF::phrase('syntax_error')
	]));
#line 1481 "Parser.php"
    }

    /**
     * The following is executed when the parser accepts
     * 
     * %parse_accept code is inserted here
     */
    function yy_accept()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sAccept!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $stack = $this->yy_pop_parser_stack();
        }
        /* Here code is inserted which will be executed whenever the
        ** parser accepts */
#line  "Parser.y"
#line 1501 "Parser.php"
    }

    /**
     * The main parser program.
     * 
     * The first argument is the major token number.  The second is
     * the token value string as scanned from the input.
     *
     * @param int   $yymajor      the token number
     * @param mixed $yytokenvalue the token value
     * @param mixed ...           any extra arguments that should be passed to handlers
     *
     * @return void
     */
    function doParse($yymajor, $yytokenvalue)
    {
//        $yyact;            /* The parser action. */
//        $yyendofinput;     /* True if we are at the end of input */
        $yyerrorhit = 0;   /* True if yymajor has invoked an error */
        
        /* (re)initialize the parser, if necessary */
        if ($this->yyidx === null || $this->yyidx < 0) {
            /* if ($yymajor == 0) return; // not sure why this was here... */
            $this->yyidx = 0;
            $this->yyerrcnt = -1;
            $x = new Parser_yyStackEntry;
            $x->stateno = 0;
            $x->major = 0;
            $this->yystack = array();
            array_push($this->yystack, $x);
        }
        $yyendofinput = ($yymajor==0);
        
        if (self::$yyTraceFILE) {
            fprintf(
                self::$yyTraceFILE,
                "%sInput %s\n",
                self::$yyTracePrompt,
                self::$yyTokenName[$yymajor]
            );
        }
        
        do {
            $yyact = $this->yy_find_shift_action($yymajor);
            if ($yymajor < self::YYERRORSYMBOL
                && !$this->yy_is_expected_token($yymajor)
            ) {
                // force a syntax error
                $yyact = self::YY_ERROR_ACTION;
            }
            if ($yyact < self::YYNSTATE) {
                $this->yy_shift($yyact, $yymajor, $yytokenvalue);
                $this->yyerrcnt--;
                if ($yyendofinput && $this->yyidx >= 0) {
                    $yymajor = 0;
                } else {
                    $yymajor = self::YYNOCODE;
                }
            } elseif ($yyact < self::YYNSTATE + self::YYNRULE) {
                $this->yy_reduce($yyact - self::YYNSTATE);
            } elseif ($yyact == self::YY_ERROR_ACTION) {
                if (self::$yyTraceFILE) {
                    fprintf(
                        self::$yyTraceFILE,
                        "%sSyntax Error!\n",
                        self::$yyTracePrompt
                    );
                }
                if (self::YYERRORSYMBOL) {
                    /* A syntax error has occurred.
                    ** The response to an error depends upon whether or not the
                    ** grammar defines an error token "ERROR".  
                    **
                    ** This is what we do if the grammar does define ERROR:
                    **
                    **  * Call the %syntax_error function.
                    **
                    **  * Begin popping the stack until we enter a state where
                    **    it is legal to shift the error symbol, then shift
                    **    the error symbol.
                    **
                    **  * Set the error count to three.
                    **
                    **  * Begin accepting and shifting new tokens.  No new error
                    **    processing will occur until three tokens have been
                    **    shifted successfully.
                    **
                    */
                    if ($this->yyerrcnt < 0) {
                        $this->yy_syntax_error($yymajor, $yytokenvalue);
                    }
                    $yymx = $this->yystack[$this->yyidx]->major;
                    if ($yymx == self::YYERRORSYMBOL || $yyerrorhit ) {
                        if (self::$yyTraceFILE) {
                            fprintf(
                                self::$yyTraceFILE,
                                "%sDiscard input token %s\n",
                                self::$yyTracePrompt,
                                self::$yyTokenName[$yymajor]
                            );
                        }
                        $this->yy_destructor($yymajor, $yytokenvalue);
                        $yymajor = self::YYNOCODE;
                    } else {
                        while ($this->yyidx >= 0
                            && $yymx != self::YYERRORSYMBOL
                            && ($yyact = $this->yy_find_shift_action(self::YYERRORSYMBOL)) >= self::YYNSTATE
                        ) {
                            $this->yy_pop_parser_stack();
                        }
                        if ($this->yyidx < 0 || $yymajor==0) {
                            $this->yy_destructor($yymajor, $yytokenvalue);
                            $this->yy_parse_failed();
                            $yymajor = self::YYNOCODE;
                        } elseif ($yymx != self::YYERRORSYMBOL) {
                            $u2 = 0;
                            $this->yy_shift($yyact, self::YYERRORSYMBOL, $u2);
                        }
                    }
                    $this->yyerrcnt = 3;
                    $yyerrorhit = 1;
                } else {
                    /* YYERRORSYMBOL is not defined */
                    /* This is what we do if the grammar does not define ERROR:
                    **
                    **  * Report an error message, and throw away the input token.
                    **
                    **  * If the input token is $, then fail the parse.
                    **
                    ** As before, subsequent error messages are suppressed until
                    ** three input tokens have been successfully shifted.
                    */
                    if ($this->yyerrcnt <= 0) {
                        $this->yy_syntax_error($yymajor, $yytokenvalue);
                    }
                    $this->yyerrcnt = 3;
                    $this->yy_destructor($yymajor, $yytokenvalue);
                    if ($yyendofinput) {
                        $this->yy_parse_failed();
                    }
                    $yymajor = self::YYNOCODE;
                }
            } else {
                $this->yy_accept();
                $yymajor = self::YYNOCODE;
            }            
        } while ($yymajor != self::YYNOCODE && $this->yyidx >= 0);
    }
}
#line  "Parser.y"
#line 1653 "Parser.php"
